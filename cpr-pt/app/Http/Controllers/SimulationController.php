<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

define("TRESHOLD_SENSOR1_BASELINE",300);
define("TRESHOLD_SENSOR2_BASELINE",300);
define("TRESHOLD_SENSOR1_POSICAO_MAOS",3000);
define("TRESHOLD_SENSOR1_COMPRESSOES",2000);
define("TRESHOLD_SENSOR2_COMPRESSOES",300);
define("TRESHOLD_SENSOR3_INSUFLACOES",20);

define("TRESHOLD_SENSOR1_RECOIL",1500);
define("DIF_RECOIL",6000);
define("RATIO_RECOIL",2.5);
define("RATIO_RECOIL_NORM",0.7);

define("SIMULAR",0);

class SimulationController extends Controller{
    private function processa_sinal($time, $sensor1, $sensor2, $sensor3){
        $pausas = 0;
        $picos_sensor1 = 0;
        $picos_sensor2 = 0;
        $picos_sensor3 = 0;
        $compressoes_corretas = 0;
        $compressoes_incorretas = 0;
        $recoil = 0;
        $recoil_ts = 0;
        $posicao_maos_corretas = 0;
        $posicao_maos_incorretas = 0;
        $insuflacoes = 0;


         //print_r($treino);

         // Limpa os sinais com media deslizante de 5 pontos
         //$treino->cleanSignal(); RESOLVER DEPOIS!!!!

         // Duracao total do sinal em segundos
         // $duracao=($treino->valoresTimeStamp[sizeof($treino->valoresTimeStamp)-2]-$treino->valoresTimeStamp[0])/1000;

         $ts = 2;

         if ($sensor2[$ts]>TRESHOLD_SENSOR2_COMPRESSOES && $sensor2[$ts]-$sensor2[$ts-1]>=0 && $sensor2[$ts-1]-$sensor2[$ts-2]>=0 && $sensor2[$ts]-$sensor2[$ts+1]>=0 && $sensor2[$ts+1]-$sensor2[$ts+2]>=0){
               if($sensor1[$ts]>TRESHOLD_SENSOR1_COMPRESSOES){
                  // Se compressao correta valor 1
                  $compressoes_corretas=1;
               }else{
                  // Se compressao incorreta valor -1
                  $compressoes_incorretas=1;
               }
         }else{
           // $compressoes=0;
         }

         if ( $sensor2[$ts]>TRESHOLD_SENSOR2_COMPRESSOES && $sensor2[$ts]-$sensor2[$ts-1]>=0 && $sensor2[$ts-1]-$sensor2[$ts-2]>=0 && $sensor2[$ts]-$sensor2[$ts+1]>=0 && $sensor2[$ts+1]-$sensor2[$ts+2]>=0){
               if(max($sensor1[$ts-1],$sensor1[$ts],$sensor1[$ts+1])>TRESHOLD_SENSOR1_POSICAO_MAOS){
                  $posicao_maos_corretas=1; //CORRETO
               }else{
                  $posicao_maos_incorretas=1; //INCORRETO
               }

         }else{
            $posicao_maos_corretas=0; //N DETETOU
            $posicao_maos_incorretas=0;
         }

         if ($sensor1[$ts]-$sensor1[$ts-1]>=0 && $sensor1[$ts-1]-$sensor1[$ts-2]>=0 && $sensor1[$ts]-$sensor1[$ts+1]>=0 && $sensor1[$ts+1]-$sensor1[$ts+2]>=0){
            $picos_sensor1=$sensor1[$ts];
         }else{
            $picos_sensor1=0;
         }

         if ($sensor2[$ts]-$sensor2[$ts-1]>=0 && $sensor2[$ts-1]-$sensor2[$ts-2]>=0 && $sensor2[$ts]-$sensor2[$ts+1]>=0 && $sensor2[$ts+1]-$sensor2[$ts+2]>=0){
            $picos_sensor2=$sensor2[$ts];
         }else{
            $picos_sensor2=0;
         }
    return array("time"=>$time[2], "picos_sensor1"=>$picos_sensor1, "picosSensor2"=>$picos_sensor2, "ponto_sensor1"=>$sensor1[2], "ponto_sensor2"=>$sensor2[2], "posicao_maos_corretas"=>$posicao_maos_corretas, "compressoes"=>$compressoes_corretas+$compressoes_incorretas, "mc"=>0, "fcc"=>0, "rcc"=>0);
 }


    public function live_info($idExercise){
             ini_set('memory_limit', '-1');
        $con = mysqli_connect("127.0.0.1","root","","cpr");
        $sql="SELECT * FROM exercise_sensor_datas WHERE idExercise=$idExercise  ORDER BY timestep ASC LIMIT 5000";
        $res = mysqli_query($con, $sql);
        $n_rows = mysqli_num_rows($res);


        $time = array();
        $sensor1 = array();
        $sensor2 = array();
        $sensor3 = array();

        $data = array();

        $compressoes=0;
        $pos_maos_corretas=0;
        $mc=0;

        while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
                array_push($time, $row["timestep"]);
                array_push($sensor1, $row["valueSensor1"]);
                array_push($sensor2, $row["valueSensor2"]);
               // array_push($sensor3, $row["valueSensor3"]);
        }

        for($i = 3; $i < $n_rows-2; $i++){
            $time_temp = array();
            $sensor1_temp = array();
            $sensor2_temp = array();

            for($j = $i-2 ; $j <= $i+2; $j++){
                array_push($time_temp, $time[$j]);
                array_push($sensor1_temp, $sensor1[$j]);
                array_push($sensor2_temp, $sensor2[$j]);
            }

            $data_tmp = $this->processa_sinal($time_temp, $sensor1_temp, $sensor2_temp, $sensor3);
             //RECEBE SINAL PROCESSADO

            $compressoes+=$data_tmp["compressoes"];
            $pos_maos_corretas+=$data_tmp["posicao_maos_corretas"];

            $dps=12000/1000;
            $fcc=0;

            if($dps!=0)
              $fcc=round(($compressoes)/$dps*60,0);

            if(($compressoes)>0){
                $mc=round($pos_maos_corretas/($compressoes)*100,0);
            }else{
                $mc=0;
            }
            /*if($rec>0){
                $rc=round($rec_correto/$rec*100,0);
            }else{
                $rc=0;
            }*/
            $data_tmp["mc"]=$mc;
            $data_tmp["fcc"]=$fcc;
            array_push($data, $data_tmp);

            unset($time_temp);
            unset($sensor1_temp);
            unset($sensor2_temp);
        }

        return json_encode($data);
    }

    public function feedback_info($idExercise){
            ini_set('memory_limit', '-1');
        $con = mysqli_connect("127.0.0.1","root","","cpr");
        $sql="SELECT * FROM exercise_sensor_datas WHERE idExercise=$idExercise ORDER BY timestep ASC";
        $res = mysqli_query($con, $sql);
        $n_rows = mysqli_num_rows($res);

        $time = array();
        $sensor1 = array();
        $sensor2 = array();
        $sensor3 = array();

        $data = array();

        $compressoes=0;
        $pos_maos=0;
        $mc=0;

        while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
                array_push($time, $row["timestep"]);
                array_push($sensor1, $row["valueSensor1"]);
                array_push($sensor2, $row["valueSensor2"]);
               // array_push($sensor3, $row["valueSensor3"]);
        }

        for($i = 3; $i < $n_rows-2; $i++){
            $time_temp = array();
            $sensor1_temp = array();
            $sensor2_temp = array();

            for($j = $i-2 ; $j <= $i+2; $j++){
                array_push($time_temp, $time[$j]);
                array_push($sensor1_temp, $sensor1[$j]);
                array_push($sensor2_temp, $sensor2[$j]);
            }

            $data_tmp = $this->processa_sinal($time_temp, $sensor1_temp, $sensor2_temp, $sensor3);

             //RECEBE SINAL PROCESSADO

            $compressoes+=$data_tmp["compressoes"];
            $pos_maos+=$data_tmp["posicao_maos_corretas"];

            //FAAAALTA DPPPPPPPPPPPPPPPPPPPPP
            $dps=12000/1000;
            $fcc=0;

            if($dps!=0)
              $fcc=round(($compressoes)/$dps*60,0);

            if(($compressoes)>0){
                $mc=round($pos_maos/($compressoes)*100,0);
            }else{
                $mc=0;
            }
            /*if($rec>0){
                $rc=round($rec_correto/$rec*100,0);
            }else{
                $rc=0;
            }*/
            $data_tmp["mc"]=$mc;
            $data_tmp["fcc"]=$fcc;
            array_push($data, $data_tmp);


            unset($time_temp);
            unset($sensor1_temp);
            unset($sensor2_temp);

        }

        return json_encode($data);
    }

    public function script($idExercise, $simular){

        global $db;
        $data = array();
        $cmd="python C:\Users\ASUS\Documents\cpr-pt-fmup\cpr-pt\public\start.py ".$idExercise." ".$simular;

        if (substr(php_uname(), 0, 7) == "Windows"){

            $cmd="python C:\Users\ASUS\Documents\cpr-pt-fmup\cpr-pt\public\start.py ".$idExercise." ".$simular;
            $handle = popen("start /B ". $cmd, "r");
            pclose($handle);

        }else{

          $cmd = "python ../pyScript/start.py ".$idExercise." ".$simular." >/dev/null &";
          $outputfile = "startPy.out";
          $pidfile = "startPy.pid";
          exec($cmd);
        }
         return json_encode($data);
    }
}
