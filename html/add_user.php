<?php session_start(); ?>

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

if ($nrows == 0) {
 echo "<center><strong>B��dny login lub has�o </center>";
 echo "<a href = 'login.php'>Logowanie </a>";

}
else {
echo "<p align = right><a href = logoff.php>Wyloguj</a>";
 echo "<h2>Nowy u�ytkownik</h2>  <br><br>";
 
echo "<form action='add_user.php' method='get'>";

echo "Login: <input type=text name='login'><br>";
echo "Typ u�ytkownika: <br>";
echo "<input type=radio name='user_type' value = 1 checked>Wyborca<br>";
echo "<input type=radio name='user_type' value = 2>Cz�onek komisji<br>";

echo "<input type=submit value='Dodaj'>";
echo "</form><br><br>";

if(isset($_GET['login']) && isset($_GET['user_type'])) {
 $new_login = $_GET['login'];
 $new_type = $_GET['user_type'];

 $query_str = "INSERT INTO user_ VALUES (DEFAULT, $new_type, '$new_login', NULL)";
 $res = pg_exec($con, $query_str);

 if(!$res) {
 echo pg_last_error($con);
 }
 else
 {
 echo "U�ytkownik dodany!";	
 }


}

}

pg_close($con);

echo "<br><a href = admin.php>Powr�t</a>";
?>

</body>
</html>		
