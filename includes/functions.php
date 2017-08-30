<?php 
include ("includes/config.php");

function check_user($username,$password) {
	global $conn;
	$stmt=$conn->prepare("SELECT * FROM user WHERE username=? AND password=?");
	$stmt->bind_param("ss",$username,$password);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0)
   {
       return 1;
   }
   else
   {
       return 0;
   }
   $stmt->close();
}
function dodaj_radnika($ime) {
	global $conn;
	$stmt=$conn->prepare("INSERT INTO radnik (ime) VALUES (?)");
	$stmt->bind_param("s", $ime);
	$stmt->execute();
	$stmt->close();
    $conn->close();

    echo "<script>window.location = 'radnik.php'</script>";
}


function prikazi( )
{

    global $conn;
    $stmt = $conn->prepare("SELECT id,ime FROM radnik");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$ime);
    echo "<div id='div_tab'>";
    echo "<table id='tabela1' border='0'>";
    echo "<th> ID</th>";
    echo "<th> IME</th>";
    echo "<form method=\"post\">";
    echo "<tr>"."<td>"." "."</td>"."<td><input type=\"text\" name=\"ime\">"."</td>"."<td>"."<input type=\"submit\"value=\"Dodaj\" name=\"submit\">";
    echo "</form>";
    while ($stmt->fetch()) {

        echo "<tr>"."<td>".$id . "</td>"."<td>" .$ime."</td>". "<td>"."<a href ='del.php?id=$id'> <img src=\"delete.png\" width=\"20\" height=\"20\"></a>"."</td>"."</tr>";

    }
    echo "</table>";
    echo "</div>";
    if (isset($_POST["submit"])){
        $ime=$_REQUEST["ime"];
        dodaj_radnika($ime);
    }
}
function brisi($id){
    global $conn;
$stmt=$conn->prepare("DELETE FROM radnik WHERE id=?");
$stmt->bind_param("s",$id);
$stmt->execute();
$stmt->close();
$conn->close();

    echo "<script>window.location = 'main.php'</script>";
}
function izmeni($id,$ime){
    global $conn;
    $stmt=$conn->prepare("UPDATE  radnik SET ime=? WHERE id=?");
    $stmt->bind_param("ss",$ime,$id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    echo "<script>window.location = 'main.php'</script>";
}
function prikaz($id){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM radnik WHERE id=?");
    $stmt->bind_param("s",$id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$ime);
    while ($stmt->fetch()) {
        echo "<form method=\"post\">";
        echo "<table>" . "<tr>" . "<td>ID:</td>" . "<td>".$id."</td>" ."</tr>"."<tr>". "<td>IME</td>" . "<td><input type=\"text\" name=\"author\" value=$ime></td>" . "</tr>" . "</table>";
        echo "</form>";

    }
}
function evidencija(){


    $dan=date("j");
    $mesec=date("n");
    $godina=date("Y");

a:
        global $conn;
        $n = 1;
        $stmt = $conn->prepare("SELECT DISTINCT  id_radnika,ime,podatak FROM pogled1 WHERE dan=? and mesec=? and godina=?");

        $stmt->bind_param("iis", $dan, $mesec, $godina);
        $stmt->execute();
        $stmt->store_result();

        $stmt->bind_result($id_radnika, $ime, $podatak);


    if ($stmt->num_rows ==0) {
        $dan = "0";
        $mesec = "0";
        $godina = "0";


        goto a;

    }
    echo "<div id='div_tab'>";
    echo "<table id='tabela1' border='0'>";
    echo "<th style=\"display:none;\" id='th0'> ID</th>";
    echo "<th id='th1'> RB</th>";
    echo "<th id='th2'> IME I PREZIME</th>";
    echo "<th id='th3'>ST</th>";
    echo "<form method=\"post\" name='forma'>";
        while ($stmt->fetch()) {


            echo "<tr>" . "<td style=\"display:none;\">" . $id_radnika . "<td>" . $n . "</td>" . "</td>" . "<td>" . $ime . "</td>" . "<td>" . "<input type=\"text\"  class='podatak' value='$podatak' name=\"podatak[]\" >" . "</td>" . "<td>" . "<input type=\"hidden\" name=\"id1[]\" value=$id_radnika >" . "</tr>";
            $n++;


        }



    echo "<input type=\"submit\"value=\"Dodaj\"   name=\"submit\" id='dodaj'>";
    echo "</form>";
    echo "</table>";
    echo "</div>";
    if(isset($_POST["submit"])){

        global $conn;
        $dan=date("d");
        $mesec=date("m");
        $godina=date("Y");
        foreach(array_combine($_POST['id1'], $_POST['podatak']) as $id_radnika => $podatak)
        {
            $stmt = $conn->prepare("SELECT DISTINCT  ime FROM pogled1 WHERE id_radnika=? and dan=? and mesec=? and godina=?");

            $stmt->bind_param("siis",$id_radnika, $dan, $mesec, $godina);
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($id_radnika);
            if($stmt->num_rows < 1){



                $stmt=$conn->prepare("INSERT   INTO pogled1 (id_radnika,podatak,dan,mesec,godina) VALUES (?,?,?,?,?)");
                $stmt->bind_param("sssss",$id_radnika,$podatak,$dan,$mesec,$godina);
                $stmt->execute();
            } else {

                $stmt = $conn->prepare("UPDATE pogled1 SET podatak=? WHERE id_radnika=? and  dan=? and  mesec=? and godina=?");
                $stmt->bind_param("sssss", $podatak, $id_radnika, $dan, $mesec, $godina);
                $stmt->execute();

            }








        }
        $stmt->close();
        $conn->close();
        echo "<script>window.location = 'main.php'</script>";
    }
}
function izvestaj($godina,$mesec) {
    global $conn;
    //$mesec="7";
   //echo "<div id='div_tab2'>";
    echo "<table style='width: 900px; height: 10px; margin: 0 auto;text-align:center' id='tabela2' border='1'>";
    echo "<tr><th width='150px'>Ime i prezime</th>";
    for ($j=1; $j<=cal_days_in_month(CAL_GREGORIAN,$mesec,$godina); $j++)
    {
        echo "<th>$j</th>";
    }
    echo "</tr>";

    for ($i=0; $i<sizeof(imena($mesec,$godina)); $i++)
    {
        $ime1 = imena($mesec,$godina);



        $stmt = $conn->prepare("SELECT podatak, dan FROM pogled1 WHERE mesec=? AND godina=? AND ime=?");
        $stmt->bind_param("sss", $mesec, $godina, $ime1[$i]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($podatak, $dan);
        $dani = array();
        $podaci = array();



        echo "<tr ><td style='text-align:left'>$ime1[$i]</td>";
        while($stmt->fetch())  {

            array_push($dani, $dan);
            array_push($podaci, $podatak);

        }

        $komb = array_combine($dani, $podaci);

        for ($j=1; $j<=cal_days_in_month(CAL_GREGORIAN,$mesec,$godina); $j++)
        {
            if (array_key_exists($j, $komb))
            {
                echo "<td>$komb[$j]</td>";
            } else
            {
                echo "<td>■</td>";
            }

        }

        echo "</tr>";


    }


echo"</table>";

echo "</div>";

}


function imena($mesec,$godina)
{
    global $conn;

    $stmt = $conn->prepare("SELECT DISTINCT ime FROM pogled1 WHERE mesec=? AND godina=?");
    $stmt->bind_param("ss", $mesec, $godina);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($ime);
    $imena = array();

    while($stmt->fetch())  {

        array_push($imena, $ime);

    }


    return $imena;

}


?>