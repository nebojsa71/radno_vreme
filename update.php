<?php
include ("includes/functions.php");
$id=$_REQUEST["id"];
session_start();

if (isset($_SESSION["login_user"])) {


} else {
    echo "<script>window.location = 'index.php'</script>";
}
prikaz($id);
//izmeni($id);
?>