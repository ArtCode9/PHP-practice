
<?php
      // files below to this section:
      // about.php - footer.html - header.html - location.php

      // include = copies the content of a file and includes it in your php file.
      //     sections of our website become reusable changes only need to be made in one place. 

      include("header.html");
       
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>include()</title>
</head>
<body>
         <h2>This is the home page</h2><br>
         <h2>Stuff about your home page can go here</h2>
</body>
</html>
<?php 
      include("footer.html");

?>