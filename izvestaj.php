<?php
include ("includes/functions.php");
session_start();

if (isset($_SESSION["login_user"])) {

    echo "<a href='logout.php'>" ."Odjavi se" ."</a>";
    echo "<a  style='float:right' href='#' onclick='printdiv()'>Štampaj</a>";
} else {

    echo "<script>window.location = 'index.php'</script>";
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta  http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div id="btn-group">
    <button><a href="main.php">Evidencija dolaska</a></button>
    <button><a href="radnik.php">Dodavanje/brisanje radnika</a></button>
    <button><a href="izvestaj.php">Izveštaji</a></button>
</div>
<?php
echo "<div id='div_tab1'>";
echo "<form method=\"post\" name='forma'>";
$currently_selected = date('Y');

$earliest_year = 2010;

$latest_year = date('Y');
echo "Odaberite godinu i mesec za izveštaj: ";
echo '<select name="godina">';

    foreach ( range( $latest_year, $earliest_year ) as $i ) {

   echo '<option value="'.$i.'"'.($i === $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
    }
    echo'</select>';
    echo "&nbsp";
    $month=array("januar","februar","mart","april","maj","jun","jul","avgust","septembar","oktobar","novembar","decembar");
echo '<select name="mesec">';
    $mn=date("n");

for ($i=0; $i < count($month); $i++)
{
    $k = $i+1;
   // $mn = 1 + $i;
    if ($mn-1 == $i)
    {
        echo '<option selected value="' . $k . '">' . $month[$i] . '</option> \n';
    } else{
        echo '<option value="' . $k . '">' . $month[$i] . '</option> \n';
    }






}
echo'</select>';

echo "</p><input type=\"submit\"value=\"Izaberi\"   name=\"submit\" id='dodaj'>";
echo "</form>";
echo "</div>";
if (isset($_POST["submit"])) {
    $godina = $_REQUEST["godina"];
    $mesec = $_REQUEST["mesec"];
    $mesecn = array("1"=>"JANUAR","2"=>"FEBRUAR","3"=>"MART","4"=>"APRIL","5"=>"MAJ","6"=>"JUN","7"=>"JUL", "8"=>"AVGUST","9"=>"SEPTEMBAR","10"=>"OKTOBAR","11"=>"NOVEMBAR","12"=>"DECEMBAR");
    echo "<div  id='div_tab2'>";

    echo "<h3 align='center'>IZVEŠTAJ ZA MESEC $mesecn[$mesec] $godina. GODINE</h3><br>";

   echo izvestaj($godina,$mesec);
    echo "</div>";
}
?>




<script>
function printdiv(){



var newstr=document.getElementById("div_tab2").innerHTML;

    var datum = new Date();
    var dd = datum.getDate();

    var mm = datum.getMonth()+1;
    var yyyy = datum.getFullYear();
    if(dd<10)
    {
        dd='0'+dd;
    }

    if(mm<10)
    {
        mm='0'+mm;
    }
    datum = dd+'.'+mm+'.'+yyyy+'.';




var popupWin = window.open('', '_blank', 'width=1100,height=600');

    popupWin.document.open();

    popupWin.document.write('<html> <body  onload="window.print()">'+ newstr +  '</html>' + '<br> '+ '<br> '+ datum );
    popupWin.document.write('<p align="right">Direktor &nbsp;&nbsp;</p><p align="right">___________</p>');
    popupWin.document.close();
return false;
}

</script>
</body>
</html>