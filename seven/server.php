<?php
echo"Server SECTION::<br>";
echo"<hr style='border:3px solid orangered'>";
echo"<pre>";
var_dump($_SERVER);
echo"</pre>";
echo"<hr style='border:3px solid orangered'>";

echo $_SERVER["PHP_SELF"]. "<br>";
echo $_SERVER["SERVER_NAME"]. "<br>";
echo $_SERVER["SCRIPT_NAME"]. "<br>";
echo $_SERVER["REMOTE_ADDR"]. "<br>";
echo $_SERVER["SERVER_ADDR"]. "<br>";
echo $_SERVER["HTTP_USER_AGENT"]. "<br>";

?>