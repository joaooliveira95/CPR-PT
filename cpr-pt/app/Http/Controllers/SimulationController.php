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

   private function min_val($valores,$ini,$fim){
      $pmin=$ini;
      $vmin=$valores[$ini];

      //print_r("INI:".$ini." FIM:".$fim."  ");
      //print_r($valores);

      for($i=$ini+1;$i<=$fim;$i++){
            if($valores[$i]<$vmin){
               $pmin=$i;
               $vmin=$valores[$i];
            }
      }
      return $pmin;
   }

   private function processa_compressoes($ts, $sensor1, $sensor2, $compressoes){
      $compressoes_corretas = $compressoes_incorretas = 0;

      if ($sensor2[$ts]>TRESHOLD_SENSOR2_COMPRESSOES && $sensor2[$ts]-$sensor2[$ts-1]>=0 && $sensor2[$ts-1]-$sensor2[$ts-2]>=0 && $sensor2[$ts]-$sensor2[$ts+1]>=0 && $sensor2[$ts+1]-$sensor2[$ts+2]>=0){
            if($sensor1[$ts]>TRESHOLD_SENSOR1_COMPRESSOES){
               $compressoes[]=1000;
               $compressoes_corretas=1;
            }else{
               $compressoes[]=900;
               $compressoes_incorretas=1;
            }
      }else{
           $compressoes[]=0;
           $compressoes_corretas=$compressoes_incorretas=0;
      }

      return ["compressoes_corretas"=>$compressoes_corretas, "compressoes_incorretas"=>$compressoes_incorretas, "compressoes"=>$compressoes];
   }

   private function processa_pos_maos($ts, $sensor1, $sensor2){
      $posicao_maos_corretas = $posicao_maos_incorretas = 0;

      if ($sensor2[$ts]>TRESHOLD_SENSOR2_COMPRESSOES && $sensor2[$ts]-$sensor2[$ts-1]>=0 && $sensor2[$ts-1]-$sensor2[$ts-2]>=0 && $sensor2[$ts]-$sensor2[$ts+1]>=0 && $sensor2[$ts+1]-$sensor2[$ts+2]>=0){
            if(max($sensor1[$ts-1],$sensor1[$ts],$sensor1[$ts+1])>TRESHOLD_SENSOR1_POSICAO_MAOS){
               $posicao_maos_corretas=1; //CORRETO
            }else{
               $posicao_maos_incorretas=1; //INCORRETO
            }
      }else{
         $posicao_maos_corretas=$posicao_maos_incorretas=0;
      }

      return ["posicao_maos_corretas"=>$posicao_maos_corretas, "posicao_maos_incorretas"=>$posicao_maos_incorretas];
   }

   private function processa_recoil($ts, $sensor1, $sensor2, $compressoes){ //!!!!!!!!!!!!!!!!!!!!!!!!!1111
         $pos_pico_ini = $pos_pico_fim = 0;
         $found_first_peak=0;
         $p=0;

         while($found_first_peak==0 && $p<sizeof($compressoes)){

           if($compressoes[$p]==1000){
             $found_first_peak=1;
             $pos_pico_ini=$p;
           }
           $p++;
         }

          $rec=0;
          $rec_incorreto = $rec_correto=0;

          for($i=$pos_pico_ini+1;$i<sizeof($compressoes);$i++){
               if($compressoes[$i]==1000 || $compressoes[$i]==900 ){
              $pos_pico_fim=$i;

              $min_pos=$this->min_val($sensor1,$pos_pico_ini,$pos_pico_fim);
              $rec++;

              $ratio=$sensor1[$pos_pico_ini]/$sensor1[$min_pos];
              $dif=$sensor1[$pos_pico_ini]-$sensor1[$min_pos];
              $ratio_norm=$dif/$sensor1[$pos_pico_ini];

      // SE posicao das maos incorreta no pico anterior e a diferenca entre  max do sensor de cima e o max do sensor de baixo <1000 = no recoil
              if($ratio_norm>RATIO_RECOIL_NORM){
                  $recoil[$ts[$min_pos]]=1000;
                  $rec_correto++;
              }else{
                  $recoil[$ts[$min_pos]]=900;
                  $rec_incorreto++;
              }
              $pos_pico_ini=$pos_pico_fim;
            }
          }
      return ["recoil_correto"=>$rec_correto, "recoil_incorreto"=>$rec_incorreto, "rec"=>$rec];
   }

   public function processa_pausas($ts, $sensor1, $sensor2, $sensor3){
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

      private function calcula_picos_sensor($ts, $sensor){
         $picos_sensor=0;

         if ($sensor[$ts]-$sensor[$ts-1]>=0 && $sensor[$ts-1]-$sensor[$ts-2]>=0 && $sensor[$ts]-$sensor[$ts+1]>=0 && $sensor[$ts+1]-$sensor[$ts+2]>=0){
            $picos_sensor=$sensor[$ts];
         }else{
            $picos_sensor=0;
         }
         return $picos_sensor;
      }

    private function processa_sinal($time, $sensor1, $sensor2, $sensor3, $compressoes, $sensor1_full){
        $picos_sensor1 = $picos_sensor2 = $picos_sensor3 = 0;
        $compressoes_corretas = $compressoes_incorretas = 0;
        $recoil = 0;
        $posicao_maos_corretas = $posicao_maos_incorretas = 0;
        $ninsuflacoes = 0;
        $pausas = 1000;

         // Limpa os sinais com media deslizante de 5 pontos
         //$treino->cleanSignal(); RESOLVER DEPOIS!!!!
         $ts = 2;

         $res_pausas = $this->processa_pausas($ts, $sensor1, $sensor2, $sensor3);
         $pausas = $res_pausas["pausas"];
         $ninsuflacoes += $res_pausas["ninsuflacoes"];
         $picos_sensor3 = $res_pausas["picos_sensor3"];

         $res_compressoes = $this->processa_compressoes($ts, $sensor1, $sensor2, $compressoes);
         $compressoes_corretas=$res_compressoes["compressoes_corretas"];
         $compressoes_incorretas=$res_compressoes["compressoes_incorretas"];
         $compressoes=$res_compressoes["compressoes"];
         //POR CONCLUIR
         $res_compressoes = $this->processa_recoil($ts, $sensor1_full, $sensor2, $compressoes);
         $recoil_correto=$res_compressoes["recoil_correto"];
         $recoil_incorreto=$res_compressoes["recoil_incorreto"];
         $rec=$res_compressoes["rec"];


         $res_pos_maos = $this->processa_pos_maos($ts, $sensor1, $sensor2);
         $posicao_maos_corretas=$res_pos_maos["posicao_maos_corretas"];
         $posicao_maos_incorretas=$res_pos_maos["posicao_maos_incorretas"];

         //PICOS SENSOR
         $picos_sensor1=$this->calcula_picos_sensor($ts, $sensor1);
         $picos_sensor2=$this->calcula_picos_sensor($ts, $sensor2);

    return array(
      "time"=>$time[2], "picos_sensor1"=>$picos_sensor1, "picosSensor2"=>$picos_sensor2, "ponto_sensor1"=>$sensor1[2], "ponto_sensor2"=>$sensor2[2],
     "posicao_maos_corretas"=>$posicao_maos_corretas, "compressoes_soma"=>$compressoes_corretas+$compressoes_incorretas, "compressoes"=>$compressoes,
     "recoil_correto"=>$recoil_correto, "rec"=>$rec, "pausas"=>$pausas,
     "maos_corretas"=>0, "frequencia"=>0, "recoil"=>0);
 }

 public static function calcula_pausas($pausas, $time){
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

   public static function calcula_info($dp, $compressoes_soma, $posicao_maos_corretas, $recoil_correto, $rec){
      $dps=$dp/1000;
      $fcc=0;

      if($dps!=0)
        $fcc=round(($compressoes_soma)/$dps*60,0);

      if(($compressoes_soma)>0){
          $mc=round($posicao_maos_corretas/($compressoes_soma)*100,0);
      }else{
          $mc=0;
      }
      if($rec>0){
          $rc=round($recoil_correto/$rec*100,0);
      }else{
          $rc=0;
      }

      return ["maos_corretas"=>$mc, "frequencia"=>$fcc, "recoil"=>$rc];
   }


    public function live_info($idExercise){
        $con = mysqli_connect("127.0.0.1","root","","cpr");
        $sql="SELECT * FROM exercise_sensors_data WHERE idExercise=$idExercise  ORDER BY timestep ASC";
        $res = mysqli_query($con, $sql);
        $n_rows = mysqli_num_rows($res);

        $time = $sensor1 = $sensor2 = $sensor3 = $pausas = $data = array();
         $compressoes[]=0;
        $compressoes_soma = $pos_maos_corretas= $recoil_correto = 0;
         array_push($time, 0);

        while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
                array_push($time, $row["timestep"]);
                array_push($sensor1, $row["valueSensor1"]);//Compressoes
                array_push($sensor2, $row["valueSensor2"]);//Pos_maos
                // array_push($sensor3, $row["valueSensor3"]);
                array_push($pausas, 0); //!!!!!!!!!!!!!!!

        }
         $mao_tmp = $compress_tmp = $recoil_tmp= 0;

        for($i = 3; $i < $n_rows-2; $i++){
            $time_temp = $sensor1_temp = $sensor2_temp = array();

            for($j = $i-2 ; $j <= $i+2; $j++){
               array_push($time_temp, $time[$j]);
               array_push($sensor1_temp, $sensor1[$j]);
               array_push($sensor2_temp, $sensor2[$j]);
            }

            //PROCESSAMENTO dos valores dos sensores
            $data_tmp = $this->processa_sinal($time_temp, $sensor1_temp, $sensor2_temp, $sensor3, $compressoes, $sensor1);

            //Dados processados sobre os sensores
            $compressoes_soma += $data_tmp["compressoes_soma"];
            $compressoes = $data_tmp["compressoes"];
            $pos_maos_corretas += $data_tmp["posicao_maos_corretas"];
            $recoil_correto = $data_tmp["recoil_correto"];

            //Calculo do tempo de pausaW
            $calculos_tempos = $this->calcula_pausas($data_tmp["pausas"], $time);

            //A partir dos dados processados calcula a informação que o utilizador irá visualizar
            $calculos = $this->calcula_info($calculos_tempos["dp"], $compressoes_soma, $pos_maos_corretas, $recoil_correto, $data_tmp["rec"]);

            $data_tmp["maos_corretas"] = $calculos["maos_corretas"];
            $data_tmp["frequencia"] = $calculos["frequencia"];
            $data_tmp["recoil"] = $calculos["recoil"];

            $mao_tmp = $calculos["maos_corretas"];
            $compress_tmp = $calculos["frequencia"];
            $recoil_tmp = $calculos["recoil"];

            array_push($data, $data_tmp);
        }

       //Atualiza o Exercicio com as informações finais resultantes da simulação
        Exercise::where('id', $idExercise)
         ->update(['hand_position' => $mao_tmp, 'compressions' => $compress_tmp, 'recoil' => $recoil_tmp,'time'=>max($time)]);

        return json_encode($data);
    }

    public function script($idExercise, $simular){
        global $db;
        $data = array();
        $cmd='python "'.public_path().'/start.py" '.$idExercise." ".$simular;

        if (substr(php_uname(), 0, 7) == "Windows"){

            $cmd='python "'.public_path().'/start.py" '.$idExercise.' '.$simular;
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
