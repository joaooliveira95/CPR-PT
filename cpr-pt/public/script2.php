  
  <?php
        $con = mysqli_connect("127.0.0.1","root","","cpr");
         if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                //you need to exit the script, if there is an error
                exit();
            }

            $time = microtime(true) - $_REQUEST["time"];
            $val1 = rand(80,100) * sin(10*$time)+90;
            $val2 = rand(1,100);
            $val3 = rand(1,100);
            

            $sql="INSERT INTO exercise_sensors_data (idExercise, idSensor1, idSensor2, idSensor3, valueSensor1, valueSensor2, valueSensor3, timestep) VALUES ('".$_POST["exercise"]."', 1, 2, 3, '$val1', '$val2', '$val3', '$time')";
            mysqli_query($con,$sql); 
            echo(mysqli_error($con));

            $sql="UPDATE exercises set time='$time' where id='".$_POST["exercise"]."'";
                        mysqli_query($con,$sql); 
            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!111
            $sql="UPDATE exercises set compressions='$val1' where id='".$_POST["exercise"]."'";
                        mysqli_query($con,$sql); 
            $sql="UPDATE exercises set recoil='$val2' where id='".$_POST["exercise"]."'";
                        mysqli_query($con,$sql); 
            $sql="UPDATE exercises set hand_position='$val3' where id='".$_POST["exercise"]."'";
            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!11
                        mysqli_query($con,$sql); 
            echo(mysqli_error($con));


        

        mysqli_close($con);
?>