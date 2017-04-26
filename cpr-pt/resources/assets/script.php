  
  <?php
        $con = mysqli_connect("localhost","root","cpr");

        $segs = 10;
        $time = new Date();
        $curTime = new Date();

        while(curTime<time+segs*1000){ //Millis

            button.disabled=true;

            $val1 = Math.floor((Math.random() * 5000) + 1);
            $val2 = Math.floor((Math.random() * 500) + 1);
            $val3 = Math.floor((Math.random() * 50) + 1);

            $sql="'".$_POST["sql"]."'";

            mysqli_query($con,$sql); 
            curTime = new Date();
        }

        mysqli_close($con);
?>