<?php 
$servername="localhost";
$username="root";
$password="";
$database="zaposleni";
$conn=new mysqli($servername,$username,$password,$database);
if ($conn->connect_error) {
	die("konekcija nije uspela: " .$conn_>connect_error);
}

?>