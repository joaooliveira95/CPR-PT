  
  <?php
        $con = mysqli_connect("127.0.0.1","root","","cpr");

        $sql="SELECT * FROM exercise_sensors_data WHERE idExercise='".$_REQUEST["exercise"]."' ORDER BY timestep DESC LIMIT 1";
        $res = mysqli_query($con, $sql); 

            while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
                echo "<p> Exercise: " .$row["idExercise"]. "</p>";
                echo "<p> Sensor1: ".$row["valueSensor1"]." Sensor2: ".$row["valueSensor2"]." Sensor3: ".$row["valueSensor3"]." Timestep: ".$row["timestep"]."s </p>";
            }
      
      //  mysqli_close($con);
?>