<?php session_start(); error_reporting(E_ALL); ?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<title>Wyniki wyborów</title>
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

$query_str = "SELECT * election WHERE idelection = ".$election_id;
$res = pg_exec($con, $query_str);
$row = pg_fetch_array($res, 0);


if ($nrows == 0) {
 echo "<center><strong>Błędny login lub hasło </center>";
 echo "<a href = 'login.php'>Logowanie </a>";

}
elseif (!empty($election_id) && $row['results_published'] = 't') {

$query_str = "

SELECT 
	tc.name,
	tc.surname,
	te.name as el_name,
	coalesce(t1.no_votes, 0) as no_votes,
	CASE
	WHEN t1.rank <= te.no_pos THEN 1
	ELSE 0
	END AS got_pos,
	te.no_pos
FROM
candidate t0
LEFT JOIN
(
	SELECT 
		idcandidate, 
		idelection,
		COUNT(*) AS no_votes, 
		ROW_NUMBER() OVER (ORDER BY COUNT(*) DESC) AS rank 
	FROM
		vote 
	WHERE 
		idelection = ".$election_id."
	GROUP BY
		idcandidate, idelection
) t1 ON t0.idcandidate = t1.idcandidate 
INNER JOIN 
	candidate tc ON t0.idcandidate = tc.idcandidate AND t0.idelection = ".$election_id."
INNER JOIN
	election te ON te.idelection = tc.idelection
ORDER BY 
	no_votes DESC

";

$res = pg_exec($con, $query_str);
$row = pg_fetch_array($res, 0);
$nrows = pg_num_rows($res); 

echo "<p align = right><a href = logoff.php>Wyloguj</a>";

echo "<h2>Wyniki wybrów - ".$row['el_name']."</h2>  <br>";
echo "Liczba stanowisk do obsadzenia: ".$row['no_pos']."<br>";

echo "
<table border=1 align=center>
<tr>
<th>Miejsce</th>
<th>Imię</th>
<th>Nazwisko</th>
<th>Liczba głosów</th>
</tr> ";

$bold_ind = '';

for($ri = 0; $ri < $nrows; $ri++) {
$row = pg_fetch_array($res, $ri);
echo "<tr ";
if ($row['got_pos'] == 1) echo "bgcolor='gray'";
echo ">\n";
echo " <td>" . ($ri + 1) . "</td>
<td>" . $row["name"] . "</td>
<td>" . $row["surname"] . "</td>
<td>" . $row["no_votes"] . " </td>
</tr>
";
}


echo "</table>";


}

pg_close($con);


echo "<br><a href = main.php>Powrót</a>";
?>

</body>
</html>		
