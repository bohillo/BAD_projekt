<html>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<title>Logowanie</title>
<body>

<?php
$login = $_POST["login"];
$pass = $_POST["pass"];
$pass_hash = md5($pass);

$con_str = "host=labdb dbname=mrbd user=pb305049 password=Pb_1111111";
$query_str = "SELECT * from User_  WHERE login = '$login' AND pass_hash = '$pass_hash'";
$con = pg_connect($con_str);

$res = pg_exec($con, $query_str);
$nrows = pg_num_rows($res);

if ($nrows == 0) {
 echo "<center><strong>Błędny login lub hasło </center>";
}
else {
  //$res = pg_fetch_array($wynik, 0);
 echo "<center><strong>Witaj ".$login." </center>";

}

?>

<form action="login.php" method="post">

<?php
echo "Login: <input type=text name='login' value='$login'><br><br>";
echo "Hasło: <input type=password name='pass' value='$pass'><br><br>";
pg_close($con);
?>

<input type=submit value="Zaloguj">
</form>
</body>
</html>		
