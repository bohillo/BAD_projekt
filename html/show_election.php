<?php session_start(); error_reporting(E_ALL); ?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<title>Nowy użytkownik</title>
<body>

<?php
$login = $_SESSION['login'];
$pass_hash = $_SESSION['pass_hash'];
$con_str = "host=labdb dbname=mrbd user=pb305049 password=Pb_1111111";
$query_str = "SELECT * from User_  WHERE login = '$login' AND pass_hash = '$pass_hash'";

$con = pg_connect($con_str);
$res = pg_exec($con, $query_str);
$nrows = pg_num_rows($res); 
$election_id = $_GET['election_id'];

if ($nrows == 0) {
 echo "<center><strong>Błędny login lub hasło </center>";
 echo "<a href = 'login.php'>Logowanie </a>";

}
elseif (!empty($election_id)) {

$query_str = "SELECT * from election WHERE idelection = $election_id";
$res = pg_exec($con, $query_str);
$row = pg_fetch_array($res, 0);

echo "<p align = right><a href = logoff.php>Wyloguj</a>";

echo "<h2>".$row['name']."</h2>  <br><br>";


echo "
<table border=1 align=center>
<tr>
<th>Nazwa wyborów:</th>
<td>".$row['name']."</td>
</tr> 
<tr>
<th>Liczba stanowisk:</th>
<td>".$row['no_pos']."</td>
</tr> 
<tr>
<th>Termin rejestracji kandydatów</th>
<td>".$row['reg_deadline']."</td>
</tr> 
<tr>
<th>Termin rozpoczęcia wyborów:</th>
<td>".$row['start_time']."</td>
</tr> 
<tr>
<th>Termin zakończenia wyborów:</th>
<td>".$row['end_time']."</td>
</tr> 
<th>Status:</th>
<td>".$row['results_published']."</td>
</tr> 

";

echo "</table>";




}

pg_close($con);

echo "<br><a href = publish_results.php>Publikuj wyniki</a><br>";
echo "<br><a href = delete_election.php>Usuń wybory</a><br>";

echo "<br><a href = admin.php>Powrót</a>";
?>

</body>
</html>		
