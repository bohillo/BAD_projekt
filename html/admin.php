<?php session_start(); ?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<title>Strona główna</title>
<body>

<?php
$login = $_SESSION['login'];
$pass_hash = $_SESSION['pass_hash'];

$con_str = "host=labdb dbname=mrbd user=pb305049 password=Pb_1111111";
$query_str = "SELECT * from User_  WHERE login = '$login' AND pass_hash = '$pass_hash'";

$con = pg_connect($con_str);
$res = pg_exec($con, $query_str);
$nrows = pg_num_rows($res);

if ($nrows == 0) {
 echo "<center><strong>Błędny login lub hasło </center>";
 echo "<a href = 'login.php'>Logowanie </a>";

}
else {
echo "<p align = right><a href = logoff.php>Wyloguj</a>";
 echo "<h2>Witaj $login</h2> <br><br>";
 echo "<a href = 'add_user.php'>Zarejestruj użytkownika</a> <br>";
 echo "<a href = 'show_user.php'>Użytkownicy</a> <br>";
 echo "<a href = 'add_election.php'>Nowe wybory</a><br><br>";


 $query_str = "SELECT * FROM election ORDER BY end_time DESC";
 $res = pg_exec($con, $query_str);
 $nrows = pg_num_rows($res);

echo "Dostępne wybory: <br>";
 for($ri = 0; $ri < $nrows; $ri++) {
  $row = pg_fetch_array($res, $ri);
  echo "<a href = show_election.php?election_id=".$row['idelection'].">".$row['name']."</a><br>";
 }

}

pg_close($con);
?>

</body>
</html>		
