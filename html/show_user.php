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

if ($nrows == 0) {
 echo "<center><strong>Błędny login lub hasło </center>";
 echo "<a href = 'login.php'>Logowanie </a>";

}
else {
echo "<p align = right><a href = logoff.php>Wyloguj</a>";
echo "<h2>Użytkownicy systemu</h2>  <br><br>";

echo "<form action='show_user.php' method='get'>";

echo "Login: <input type=text name='login'><br>";
echo "Typ użytkownika: <br>";
echo "<input type=checkbox name='user_type1' value = 1 checked>Wyborca<br>";
echo "<input type=checkbox name='user_type2' value = 2 checked>Członek komisji<br>";

echo "<input type=submit value='Szukaj'>";
echo "</form><br><br>";


$query_str = "
SELECT t.iduser_, t.login, s.name FROM 
user_ t INNER JOIN usertype s ON t.idusertype = s.idusertype
WHERE 1=1
";


$filter_login = $_GET['login'];
if(!empty($filter_login)) {
$query_str = $query_str." AND t.login like '%$filter_login%'";
} 

if(isset($_GET['user_type1']) || isset($_GET['user_type2'])) {
$filter_type1 = $_GET['user_type1'];
$filter_type2 = $_GET['user_type2'];
if(empty($filter_type1)) $filter_type1 = $filter_type2;
if(empty($filter_type2)) $filter_type2 = $filter_type1;
$query_str = $query_str." AND t.idusertype in ($filter_type1, $filter_type2)";
} 



$res = pg_exec($con, $query_str);

$nrows = pg_num_rows($res); 


echo "
<table border=1 align=center>
<tr>
<th>Użytkownik</th>
<th>Typ</th>
<th> </th>
</tr> ";


for($ri = 0; $ri < $nrows; $ri++) {
echo "<tr>\n";
$row = pg_fetch_array($res, $ri);
echo " <td>" . $row["login"] . "</td>
<td>" . $row["name"] . "</td>
<td><a href = delete_user.php?user_id=".$row['iduser_'].">Usuń użytkownika</a> </td>
</tr>
";
}


echo "</table>";

if($nrows == 0) echo "Nic nie znaleziono!";
if(!$res) echo pg_last_error($con);


}

pg_close($con);

echo "<br><a href = admin.php>Powrót</a>";
?>

</body>
</html>		
