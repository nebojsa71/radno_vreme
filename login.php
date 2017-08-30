<?php
   session_start();
   
    if (isset($_POST["submit"]))
        {     
include ("includes/functions.php");


    $username=$_POST["username"];
    $password=$_POST["password"];
  
 

  if (check_user($username,$password)) {
	    $_SESSION["login_user"]=$username;
      echo "<script>window.location = 'main.php'</script>";;
  } else {
      echo "<script>window.location = 'index.php'</script>";
  }
		} 
	
    ?>