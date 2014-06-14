<?php session_start(); ?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<title>Nowe wybory</title>
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
 echo "<h2>Nowe wybory</h2>  <br><br>";
 
echo "<form action='add_election.php' method='get'>";

echo "Nazwa wyborów: <input type=text name='name'><br>";
echo "Liczba stanowisk: <input type='number' name='no_pos'><br>";
echo "Termin zgłaszania kandydatów: <input type='datetime' name='reg_deadline'><br>";
echo "Termin rozpoczęcia wyborów: <input type='datetime' name='start_date'><br>";
echo "Termin zakończenia wyborów: <input type='datetime' name='end_date'><br>";

echo "<input type=submit value='Dodaj'>";
echo "</form><br><br>";

echo "Uwaga: daty proszę podawać w formacie <i>yyyy-mm-dd hh:mm</i>, np. 2011-11-24 15:26 <br><br>";

if(isset($_GET['name']) && isset($_GET['no_pos'])  && isset($_GET['reg_deadline'])
&& isset($_GET['start_date']) && isset($_GET['end_date']))   {
 $new_name = $_GET['name'];
 $new_no_pos = $_GET['no_pos'];
 $new_reg_deadline = $_GET['reg_deadline'];
 $new_start_date = $_GET['start_date'];
 $new_end_date = $_GET['end_date'];

 $query_str = "
 INSERT INTO election 
VALUES (DEFAULT, '$new_name', $new_no_pos, '$new_reg_deadline', '$new_start_date', '$new_end_date', 'FALSE')
";
 $res = pg_exec($con, $query_str);

 if(!$res) {
 echo pg_last_error($con);
 }
 else
 {
 echo "Wybory dodane!";	
 }


}

}

pg_close($con);

echo "<br><a href = main.php>Powrót</a>";
?>

</body>
</html>		
