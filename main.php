

<?php 
include ("includes/functions.php");
session_start();

if (isset($_SESSION["login_user"])) {
	
	echo "<a href='logout.php'>" ."Odjavi se" ."</a>";
} else {
    echo "<script>window.location = 'index.php'</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div id="btn-group">
    <button><a href="main.php">Evidencija dolaska</a></button>
    <button><a href="radnik.php">Dodavanje/brisanje radnika</a></button>
    <button><a href="izvestaj.php">Izveštaji</a></button>
</div>

 <p><?php echo  evidencija(); ?></p>


<script>
    $( document ).ready(function() {

        $("#dodaj").click(function(event){

            $( ".podatak" ).each(function() {
                var podatak = $(this).val();
                if (podatak!="8" && podatak!="ks")
                {
                    event.preventDefault();
                    $(this).css("background-color", "red");
                }
            });
        });

        $( ".podatak").focus(function() {

            $(this).css("background-color", "white");
          $(this).val("");
        });

    });

</script>

</body>
</html>
