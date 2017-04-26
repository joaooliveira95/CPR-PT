  
  <?php
        define("DB_HOST", "localhost");
        define("DB_USER", "root");
        define("DB_PASSWORD", null);
        define("DB_DATABASE", "cpr");
        echo '<p> SEEEEEEEEEEEEEEEEEEE BEEEEEEM </p>';
        $con = mysqli_connect(DB_SERVER , DB_USER, DB_PASSWORD, DB_DATABASE);

        $sql="SELECT * FROM exercise_sensors_data ORDER BY created_at DESC LIMIT 1";
        $res = mysqli_query($con,$sql); 
           alert("IM HERE");

        if(mysli_num_rows($res)>0){
            while($row = mysqli_fetch_array($res)){
                echo '<p>' .$row["valueSensor1"]. '</p>';

            }
        }
      
      //  mysqli_close($con);
?>