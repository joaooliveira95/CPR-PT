<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Exercise;

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

   private function compressoes($ts, $sensor1, $sensor2){
      $compressoes_corretas = $compressoes_incorretas = 0;

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

      return ["compressoes_corretas"=>$compressoes_corretas, "compressoes_incorretas"=>$compressoes_incorretas];
   }

   private function pos_maos($ts, $sensor1, $sensor2){
      $posicao_maos_corretas = $posicao_maos_incorretas = 0;

      if ($sensor2[$ts]>TRESHOLD_SENSOR2_COMPRESSOES && $sensor2[$ts]-$sensor2[$ts-1]>=0 && $sensor2[$ts-1]-$sensor2[$ts-2]>=0 && $sensor2[$ts]-$sensor2[$ts+1]>=0 && $sensor2[$ts+1]-$sensor2[$ts+2]>=0){
            if(max($sensor1[$ts-1],$sensor1[$ts],$sensor1[$ts+1])>TRESHOLD_SENSOR1_POSICAO_MAOS){
               $posicao_maos_corretas=1; //CORRETO
            }else{
               $posicao_maos_incorretas=1; //INCORRETO
            }

      }else{
         $posicao_maos_corretas=0; //N DETETOU
         $posicao_maos_incorretas=0;
      }

      return ["posicao_maos_corretas"=>$posicao_maos_corretas, "posicao_maos_incorretas"=>$posicao_maos_incorretas];
   }

   public function pausas($ts, $sensor1, $sensor2, $sensor3){
      $pausas = $picos_sensor3 = $ninsuflacoes = 0;

      if ($sensor1[$ts+2]<TRESHOLD_SENSOR1_BASELINE && $sensor1[$ts+1]<TRESHOLD_SENSOR1_BASELINE && $sensor1[$ts]<TRESHOLD_SENSOR1_BASELINE && $sensor1[$ts-1]<TRESHOLD_SENSOR1_BASELINE &&
$sensor1[$ts-2]<TRESHOLD_SENSOR1_BASELINE && $sensor1[$ts-3]<TRESHOLD_SENSOR1_BASELINE && $sensor2[$ts+2]<TRESHOLD_SENSOR2_BASELINE && $sensor2[$ts+1]<TRESHOLD_SENSOR2_BASELINE &&
$sensor2[$ts]<TRESHOLD_SENSOR2_BASELINE && $sensor2[$ts-1]<TRESHOLD_SENSOR2_BASELINE && $sensor2[$ts-2]<TRESHOLD_SENSOR2_BASELINE && $sensor2[$ts-3]<TRESHOLD_SENSOR2_BASELINE ){

        $pausas=1000;

          if($sensor3[$ts]>TRESHOLD_SENSOR3_INSUFLACOES){

             if($sensor3[$ts]-$sensor3[$ts-1]>=0 && $sensor3[$ts-1]-$sensor3[$ts-2]>=0 &&
                  $sensor3[$ts]-$sensor3[$ts+1]>=0 && $sensor3[$ts+1]-$sensor3[$ts+2]>=0){

                    $picos_sensor3=$sensor3[$ts];
                    //$ninsuflacoes+=1;
                    $ninsuflacoes=1;
                  }else{
                    $picos_sensor3=0;
                  }
          }else{
             $picos_sensor3=0;
          }
     }else{
            $pausas=0;
         $picos_sensor3=0;

         return ["pausas"=>$pausas, "picos_sensor3"=>$picos_sensor3, "ninsuflacoes"=>$ninsuflacoes];
     }//ACABA
   }

    private function processa_sinal($time, $sensor1, $sensor2, $sensor3){
        $picos_sensor1 = $picos_sensor2 = $picos_sensor3 = 0;
        $compressoes_corretas = $compressoes_incorretas = 0;
        $recoil = 0;
        $recoil_ts = 0;
        $posicao_maos_corretas = $posicao_maos_incorretas = 0;
        $ninsuflacoes = 0;
        $pausas = 1000;

         // Limpa os sinais com media deslizante de 5 pontos
         //$treino->cleanSignal(); RESOLVER DEPOIS!!!!

         // Duracao total do sinal em segundos
         // $duracao=($time[sizeof($time)-2]-$time[0])/1000;

         $ts = 2;

         $res_pausas = $this->pausas($ts, $sensor1, $sensor2, $sensor3);
         $pausas = $res_pausas["pausas"];
         $ninsuflacoes += $res_pausas["ninsuflacoes"];
         $picos_sensor3 = $res_pausas["picos_sensor3"];

         $res_compressoes = $this->compressoes($ts, $sensor1, $sensor2);
         $compressoes_corretas=$res_compressoes["compressoes_corretas"];
         $compressoes_incorretas=$res_compressoes["compressoes_incorretas"];

         $res_pos_maos = $this->pos_maos($ts, $sensor1, $sensor2);
         $posicao_maos_corretas=$res_pos_maos["posicao_maos_corretas"];
         $posicao_maos_incorretas=$res_pos_maos["posicao_maos_incorretas"];

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
    return array("time"=>$time[2], "picos_sensor1"=>$picos_sensor1, "picosSensor2"=>$picos_sensor2, "ponto_sensor1"=>$sensor1[2], "ponto_sensor2"=>$sensor2[2],
     "posicao_maos_corretas"=>$posicao_maos_corretas, "compressoes"=>$compressoes_corretas+$compressoes_incorretas, "pausas"=>$pausas,"maos_corretas"=>0, "frequencia"=>0, "rcc"=>0);
 }

   public static function calculos($dp, $compressoes, $posicao_maos_corretas){
      $dps=$dp/1000;
      $fcc=0;

      if($dps!=0)
        $fcc=round(($compressoes)/$dps*60,0);

      if(($compressoes)>0){
          $mc=round($posicao_maos_corretas/($compressoes)*100,0);
      }else{
          $mc=0;
      }
      /*if($rec>0){
          $rc=round($rec_correto/$rec*100,0);
      }else{
          $rc=0;
      }*/

      return ["maos_corretas"=>$mc, "frequencia"=>$fcc];
   }

   public static function calculos_tempos($pausas, $time){
            $started_band = $start_point=0;
            $last_event=1;
            $intervalo_pausa = $pausa_ini = $pausa_fim = 0;
            $ti = $tf = $dp = 0;

          for($i=0;$i<(sizeof($time)-3);$i++){
               if($pausas[$i]==1000){
           			if($intervalo_pausa==0){
              				$pausa_ini=$time[$i];
              				$tf=$time[$i];
              				$dp=$dp+($tf-$ti);
           			}
        			   $intervalo_pausa=1;
           		}else{
           			if($intervalo_pausa==1){
                     $pausa_fim=$time[$i];
                     $intervalo_pausa=0;
                     $ti=$time[$i];
              		}
              	}
           	}

           	if($intervalo_pausa==1 && $pausas[$i-1]==1000){
           		$pausa_fim=$time[$i-1];
           	}elseif($intervalo_pausa==0 && $pausas[$i-1]!=1000){
           		$tf=$time[$i-1];
           		$dp=$dp+($tf-$ti);
            }

         return ["dp"=>$dp];
   }

    public function live_info($idExercise){
        ini_set('memory_limit', '-1');
        $con = mysqli_connect("127.0.0.1","root","","cpr");
        $sql="SELECT * FROM exercise_sensor_datas WHERE idExercise=$idExercise  ORDER BY timestep ASC LIMIT 5000";
        $res = mysqli_query($con, $sql);
        $n_rows = mysqli_num_rows($res);

        $time = $sensor1 = $sensor2 = $sensor3 = $pausas = $data = array();

        $compressoes = $pos_maos_corretas=0;
         array_push($time, 0);

        while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
                array_push($time, $row["timestep"]);
                array_push($sensor1, $row["valueSensor1"]);
                array_push($sensor2, $row["valueSensor2"]);
                array_push($pausas, 0); //!!!!!!!!!!!!!!!
               // array_push($sensor3, $row["valueSensor3"]);
        }
         $mao_tmp = 0;
         $compress_tmp = 0;

        for($i = 3; $i < $n_rows-2; $i++){
            $time_temp = $sensor1_temp = $sensor2_temp = array();

            for($j = $i-2 ; $j <= $i+2; $j++){
               array_push($time_temp, $time[$j]);
               array_push($sensor1_temp, $sensor1[$j]);
               array_push($sensor2_temp, $sensor2[$j]);
            }

            $data_tmp = $this->processa_sinal($time_temp, $sensor1_temp, $sensor2_temp, $sensor3);

            $compressoes+=$data_tmp["compressoes"];
            $pos_maos_corretas+=$data_tmp["posicao_maos_corretas"];
            $pausas[$i]=$data_tmp["pausas"];

            $calculos_tempos = $this->calculos_tempos($pausas, $time);

            $dp = $calculos_tempos["dp"];

            $calculos = $this->calculos($dp, $compressoes, $pos_maos_corretas);

            $data_tmp["maos_corretas"]=$calculos["maos_corretas"];
            $data_tmp["frequencia"]=$calculos["frequencia"];
            $mao_tmp = $calculos["maos_corretas"];
            $compress_tmp= $calculos["frequencia"];
            array_push($data, $data_tmp);

            unset($time_temp);
            unset($sensor1_temp);
            unset($sensor2_temp);
        }

        Exercise::where('id', $idExercise)
         ->update(['hand_position' => $mao_tmp, 'compressions' => $compress_tmp, 'time'=>max($time)]);


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
