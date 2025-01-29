<?php
      echo"RetrieveData<br>";
      echo"<hr style='border:4px solid black'>";

      // Database connection
      $servername = "localhost";
      $username = "artcode";
      $password = "1";
      $dbname = "artdb";

      $conn = new mysqli($servername, $username, $password, $dbname);

      // Check connection
      if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
      }


      $sql = "SELECT id, name, nickname, password, phone_number FROM batman";
      $result = $conn->query($sql);

      
      if ($result->num_rows > 0) {
         // Output data of each row
         while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. " - Name: " . $row["name"]. 
            "- nickname: " . $row["nickname"]. "- password: " . $row["password"].
            "- phone_number: ". $row["phone_number"]."<hr style='border: 2px solid orange'>";
         }
      } else {
         echo "0 results";
      }


$conn->close();

?>