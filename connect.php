<!-- 

$con=new mysqli('localhost','root','','crudoperation');

if(!$con){
    die(mysqli_error($con));
} 
 -->




<?php
// connect.php
$host = 'localhost';
$dbname = 'crudoperation';
$username = 'root';
$password = '';

try {
    $con = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
