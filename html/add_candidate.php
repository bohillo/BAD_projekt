<?php session_start(); ?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<title>Nowy kandydat</title>
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

 
echo "<h2>".$row['name']." - Nowy kandydat</h2>  <br><br>";
 
echo "<form action='add_candidate.php?id_election=".$_GET['election_id']."' method='get'>";

echo "Imię: <input type=text name='name'><br>";
echo "Nazwisko: <input type='text' name='surname'><br>";
echo "<input type=hidden name='election_id' value='".$_GET['election_id']."'>";
echo "<input type=submit value='Zgłoś'>";
echo "</form><br><br>";

if(isset($_GET['name']) && isset($_GET['surname']))   {
 $new_name = $_GET['name'];
 $new_surname = $_GET['surname'];
 
 $query_str = "INSERT INTO candidate VALUES (DEFAULT, 1, '$new_name', '$new_surname')";
 
 $res = pg_exec($con, $query_str);

 if(!$res) {
 echo pg_last_error($con);
 }
 else
 {
 echo "Kandydat zgłoszony!";	
 }


}

}

pg_close($con);

echo "<br><a href = main.php>Powrót</a>";
?>

</body>
</html>		
