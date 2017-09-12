function recomendation(id, rec_id, color, recomendation){
   //VALORES DO SENSOR
  document.getElementById(id).style = "color: "+color+"; text-align: center; font-size: 25px;";
  //RECOMENDACAO DO SENSOR
  document.getElementById(rec_id).style = "color: "+color+"; text-align: center; border: none; font-size: 20px;";
  document.getElementById(rec_id).textContent = recomendation;
}

function simulation_live_info(maos_corretas, recoil, frequencia){
     //MAOS CORRETAS
    document.getElementById("pos_maos").textContent =maos_corretas+"%";
    if(parseInt(maos_corretas)<90){
        recomendation("pos_maos", "recomend_pos_maos", "red", "Melhorar o posicionamento das mãos!");
    }else{
         recomendation("pos_maos", "recomend_pos_maos", "green", "Posicionamento das mãos correto.");
    }

    //RECOIL
    document.getElementById("recoil").textContent = recoil+"%";
    if(parseInt(recoil)<90){
        recomendation("recoil", "recomend_recoil", "red", "Melhorar o recoil das compressões!");
    }else{
         recomendation("recoil", "recomend_recoil", "green", "Recoil feito de forma correta.");
    }

    //Frquencia Compressoes
    document.getElementById("frequencia").textContent = frequencia+" BPM";
    if(parseInt(frequencia)<=95){
        recomendation("frequencia", "recomend_frequencia", "red", "Aumentar o ritmo das compressões!");
    }else if( parseInt(frequencia)>95&& parseInt(frequencia)<100){
         recomendation("frequencia", "recomend_frequencia", "yellow", "Aumentar ligeiramente o ritmo das compressões!");
    }else if( parseInt(frequencia)>=100&& parseInt(frequencia)<=120){
         recomendation("frequencia", "recomend_frequencia", "green", "Bom ritmo das compressões.");
    }else if( parseInt(frequencia)>120&& parseInt(frequencia)<=125){
         recomendation("frequencia", "recomend_frequencia", "yellow", "Diminuir ligeiramente o ritmo das compressões!");
    }else if( parseInt(frequencia)>125){
         recomendation("frequencia", "recomend_frequencia", "red", "Diminuir o ritmo das compressões!");
    }
}

function simulation_feedback(maos_corretas, recoil, frequencia, time){
      simulation_live_info(maos_corretas, recoil, frequencia);
      document.getElementById("tempo").style = "font-size: 20px; text-align: center;";
      document.getElementById("tempo").textContent =time+"s";
}
