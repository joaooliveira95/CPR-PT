  
  <?php
        $con = mysqli_connect("127.0.0.1","root","","cpr");

        $sql="SELECT * FROM exercise_sensors_data WHERE idExercise='".$_REQUEST["exercise"]."' ORDER BY timestep DESC LIMIT 1";
        $res = mysqli_query($con, $sql); 

            while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){

                 echo "<table class=table style='text-align: center;'>";
      			 echo "<tr>
      			 	<th style='text-align: center;'><h4> Sensor1 </h4></th>
      			 	<th style='text-align: center;'><h4> Sensor2 </h4></th>
      			 	<th style='text-align: center;'><h4> Sensor3 </h4></th>
      			 	<th style='text-align: center;'><h4> Time </h4></th>
      			 	</tr>";
      			 echo "<tr>
      			 	<td><h1>".$row["valueSensor1"]."</h1></td>
      			 	<td><h1>".$row["valueSensor3"]." </h1></td>
      			 	<td><h1>".$row["valueSensor3"]."</h1></td>
      			 	<td><h1>".$row["timestep"]."</h1></td>
      			 	</tr>";
      			 echo "</table>";
            }
      
      //  mysqli_close($con);
?>