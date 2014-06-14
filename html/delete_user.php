<?php session_start(); error_reporting(E_ALL); ?>


<?php
$login = $_SESSION['login'];
$pass_hash = $_SESSION['pass_hash'];
$con_str = "host=labdb dbname=mrbd user=pb305049 password=Pb_1111111";
$query_str = "SELECT * from User_  WHERE login = '$login' AND pass_hash = '$pass_hash'";

$con = pg_connect($con_str);
$res = pg_exec($con, $query_str);
$nrows = pg_num_rows($res); 
$delete_id = $_GET['user_id'];

if ($nrows == 0) {
 echo "<center><strong>Błędny login lub hasło </center>";
 echo "<a href = 'login.php'>Logowanie </a>";

}
elseif ($delete_id != $_SESSION['user_id']) {
$query_str = "DELETE FROM user_ WHERE iduser_ = $delete_id";
$res = pg_exec($con, $query_str);
}

header("Location: show_user.php");
?>