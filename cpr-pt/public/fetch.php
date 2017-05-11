  
  <?php
  		$min_BPM = 100;
  		$max_BPM = 120;

        $con = mysqli_connect("127.0.0.1","root","","cpr");

        $sql="SELECT * FROM exercise_sensors_data WHERE idExercise='".$_REQUEST["exercise"]."' ORDER BY timestep DESC LIMIT 1";
        $res = mysqli_query($con, $sql); 

            while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){

                 echo "<table class=table style='text-align: center;'>";
      			 echo "<tr>
      			 	<th style='text-align: center;'><h4> Compressions (BPM)</h4></th>
      			 	<th style='text-align: center;'><h4> Recoil </h4></th>
      			 	<th style='text-align: center;'><h4> Hand Position </h4></th>
      			 	<th style='text-align: center;'><h4> Time (s)</h4></th>
      			 	</tr>";
      			 echo "<tr>";
      			 if($row["valueSensor1"]>=$min_BPM && $row["valueSensor1"]<=$max_BPM){
      			 	echo "<td><h1  style='color: green;'>".$row["valueSensor1"]."</h1></td>";
      			 }else{
      			 	echo "<td><h1 style='color: red;'>".$row["valueSensor1"]."</h1><h4 style='color: red;'> Compressões fora de ritmo! </h4></td>";
      			 }
      			 echo "<td><h1>".$row["valueSensor3"]." </h1></td>
      			 	<td><h1>".$row["valueSensor3"]."</h1></td>
      			 	<td><h1>".$row["timestep"]."</h1></td>
      			 	</tr>";
      			 echo "</table>";
            }
      
      //  mysqli_close($con);
?>