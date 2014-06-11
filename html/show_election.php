<?php session_start(); error_reporting(E_ALL); ?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<title>Nowy u�ytkownik</title>
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
 echo "<center><strong>B��dny login lub has�o </center>";
 echo "<a href = 'login.php'>Logowanie </a>";

}
elseif (!empty($election_id)) {

$query_str = "SELECT *,
case
when  current_timestamp < reg_deadline then 0
when current_timestamp < start_time  then 1
when current_timestamp < end_time  then 2
else 3 
end as election_status
from election WHERE idelection = $election_id";

$res = pg_exec($con, $query_str);
$row = pg_fetch_array($res, 0);

echo "<p align = right><a href = logoff.php>Wyloguj</a>";

echo "<h2>".$row['name']."</h2>  <br><br>";


echo "
<table border=1 align=center>
<tr>
<th>Nazwa wybor�w:</th>
<td>".$row['name']."</td>
</tr> 
<tr>
<th>Liczba stanowisk:</th>
<td>".$row['no_pos']."</td>
</tr> 
<tr>
<th>Termin rejestracji kandydat�w</th>
<td>".$row['reg_deadline']."</td>
</tr> 
<tr>
<th>Termin rozpocz�cia wybor�w:</th>
<td>".$row['start_time']."</td>
</tr> 
<tr>
<th>Termin zako�czenia wybor�w:</th>
<td>".$row['end_time']."</td>
</tr> 
<th>Status:</th>
<td>";
if ($row['election_status'] == 0) {
echo "Trwa rejestracja kandydat�w";
 if ($_SESSION['user_type'] == 1) {
  echo "<br><a href = add_candidate.php?election_id=$election_id>Zg�o� kandydata</a><br>";
 }

}
elseif ($row['election_status'] == 1) {
echo "Nierozpocz�te";
}
elseif ($row['election_status'] == 2) {
echo "Rozpocz�te";
 if ($_SESSION['user_type'] == 1) {
  echo "<br><a href = vote.php?election_id=$election_id>G�osuj</a><br>";
 }
}
else
{
echo "Zako�czone. ";
 if ($row['results_published'] == "t") {
  echo "<br><a href=show_results?election_id=$election_id>Zobacz wyniki</a>";
  }
 elseif ($_SESSION['user_type'] == 2)
  {
  echo "<br><a href = publish_results.php?election_id=$election_id>Publikuj wyniki</a>";
  }
 elseif ($_SESSION['user_type'] == 1)
  {
  echo "<br>Oczekiwanie na publikacj� wynik�w";
  }
    

}
echo "</td> </tr> ";

echo "</table>";




}

pg_close($con);

if ($_SESSION['user_type'] == 2) {
 echo "<br><a href = delete_election.php?election_id=$election_id>Usu� wybory</a><br>";
}

echo "<br><a href = main.php>Powr�t</a>";
?>

</body>
</html>		
