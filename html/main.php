<?php 
session_start(); 
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<title>Logowanie</title>
<body>

<?php
$login = $_POST["login"];
$pass = $_POST["pass"];
$pass_hash = md5($pass);

$con_str = "host=labdb dbname=mrbd user=pb305049 password=Pb_1111111";
$query_str = "SELECT * from User_ WHERE login = '$login' AND pass_hash = '$pass_hash'";
$con = pg_connect($con_str);

$res = pg_exec($con, $query_str);
$nrows = pg_num_rows($res);
$row = pg_fetch_array($res, 0);
pg_close($con);

if ($nrows == 0) {
 echo "<center><strong>Błędny login lub hasło </center>";
} else {

 $_SESSION['login'] = $login;
 $_SESSION['pass_hash'] = $pass_hash;
 $_SESSION['user_id'] = $row['iduser_'];
 header('Location: admin.php');
 

}

?>

</body>
</html>