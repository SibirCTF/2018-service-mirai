<?php require_once $_SERVER['DOCUMENT_ROOT'].'/security.php'; ?>
<html>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/head.php'; ?>
	<body>
	<header> 
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/top.php'; ?> 
	</header>

	<?php
	$dbconn = pg_connect("host=sibt_db dbname=service user=postgres password=mem");
	$query = 'SELECT * FROM users';
	$result = pg_query($query);

	echo "<table>\n";
	while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
		echo "\t<tr>\n";
		foreach ($line as $col_value) {
		    echo "\t\t<td>$col_value</td>\n";
		}
		echo "\t</tr>\n";
	}
	echo "</table>\n";
	pg_free_result($result);
	pg_close($dbconn);
	?>
</html>
