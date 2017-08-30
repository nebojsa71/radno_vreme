
<?php
session_start();

if (isset($_SESSION["login_user"])) {
    echo "<script>window.location = 'main.php'</script>";
} 

 ?>
<!DOCTYPE html>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<div id="login_div">
    <h1>PRIJAVA</h1>
    <form action="login.php" method="post">
        <input type="text" name="username" onfocus="this.placeholder = ''" onblur="this.placeholder='username'" placeholder="username"><br>
        <input type="password" name="password" onfocus="this.placeholder = ''" onblur="this.placeholder='password'" placeholder="password"><br>
        <input type="submit" name="submit">
    </form>
</div>

</body>
</html>