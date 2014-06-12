<?php session_start(); ?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<title>Głosowanie</title>
<body>

<?php
$login = $_SESSION['login'];
$pass_hash = $_SESSION['pass_hash'];
$con_str = "host=labdb dbname=mrbd user=pb305049 password=Pb_1111111";
$query_str = "SELECT * from User_  WHERE login = '$login' AND pass_hash = '$pass_hash'";

$con = pg_connect($con_str);
$res = pg_exec($con, $query_str);
$nrows = pg_num_rows($res); 
$row = pg_fetch_array($res, 0);

if ($nrows == 0 or $row['idusertype'] != 1) {
 echo "<center><strong>Błędny login lub hasło </center>";
 echo "<a href = 'login.php'>Logowanie </a>";
}
elseif (isset($_GET['election_id'])) {
echo "<p align = right><a href = logoff.php>Wyloguj</a>";

$query_str = "SELECT * from election  WHERE idelection = ".$_GET['election_id']."";
$res = pg_exec($con, $query_str);
$nrows = pg_num_rows($res); 
$row = pg_fetch_array($res, 0);

 
echo "<h2>".$row['name']." - Głosowanie</h2>  <br><br>";
 
echo "<form action='vote.php' method='get'>";

$query_str = "SELECT * from candidate  WHERE idelection = ".$_GET['election_id']."";
$res = pg_exec($con, $query_str);
$nrows = pg_num_rows($res); 
$row = pg_fetch_array($res, 0);

echo "
<table border=1 align=center>
<tr>
<th>Imię</th>
<th>Nazwisko</th>
<th>Głos</th>
</tr> ";

for($ri = 0; $ri < $nrows; $ri++) {
echo "<tr>\n";
$row = pg_fetch_array($res, $ri);
echo " <td>" . $row["name"] . "</td>
<td>" . $row["surname"] . "</td>
<td><input type = 'radio' name = 'vote' value = ".$row['idcandidate']."></input></td>
</tr>
";
}

echo "</table>";
echo "<input type=hidden name='election_id' value='".$_GET['election_id']."'>";
echo "<input type=submit value='Głosuj'>";
echo "</form><br><br>";


if(isset($_GET['vote']))   {

  $query_str = "INSERT INTO vote VALUES (DEFAULT, ".$_SESSION['user_id'].", ".$_GET['election_id'].", 
 ".$_GET['vote'].", current_timestamp)";


 $res = pg_exec($con, $query_str);

 if(!$res) {
 echo pg_last_error($con);
 }
 else
 {
 echo "Glos oddany!";	
 }



}

}

pg_close($con);

echo "<br><a href = main.php>Powrót</a>";
?>

</body>
</html>		
