<?php
$testConnection = mysqli_connect('localhost:/home/mariadb/mysql.sock', 'vnnxuser', 'aGri@media@123');
if (!$testConnection) {
die('Error: ' . mysql_error());
}
echo 'Database connection working!';
mysql_close($testConnection);
?>
