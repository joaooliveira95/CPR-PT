  <?php

  //	echo "<br>Starting process";

  //$cmd="python c:\Apache2.2\htdocs\start.py ".$_POST["exercise"]." 1";



  if (substr(php_uname(), 0, 7) == "Windows"){

    $time = $_POST['time'];
       
    $cmd="python C:\Users\ASUS\Documents\cpr-pt-fmup\cpr-pt\public\start.py ".$_POST["exercise"]." 1 ".$time."";

  
    $handle = popen("start /B ". $cmd, "r");
    echo $handle;
    pclose($handle);


  }else{

    $cmd = "python ../pyScript/start.py ".$_POST["exercise"]." 1 >/dev/null &";
    $outputfile = "startPy.out";
    $pidfile = "startPy.pid";



    exec($cmd);

  }

?>