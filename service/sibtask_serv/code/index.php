<?php require_once $_SERVER['DOCUMENT_ROOT'].'/security.php'; ?>
<html>
 <?php require_once $_SERVER['DOCUMENT_ROOT'].'/head.php'; ?>
 <body>
 <header> 
 <?php require_once $_SERVER['DOCUMENT_ROOT'].'/top.php'; ?> 
 </header>
 
  <main role="main">
	<div class="container">	
		<table class="table table-striped table-light">
		  <thead>
			<tr>
			  <th scope="col">Раздел</th>
			  <th scope="col">Описание</th>
			  <th scope="col">Количество тредов</th>
			</tr>
		  </thead>
		<tbody>
<?php
	$dbconn = pg_connect("host=sibt_db dbname=service user=postgres password=mem");
	$query = "SELECT id, name, description FROM sections";
	$result = pg_query($query);
	while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
		$line_id = $line['id'];
		$query = "SELECT count(id) FROM threads WHERE id_section = '$line_id'";
		$count_id = pg_fetch_result(pg_query($query),0);
		echo "
			<tr>
			  <td><a href=\"/threads.php?section={$line['name']}\">{$line['name']}</a></td>
			  <td>{$line['description']}</td>
			  <td>{$count_id}</td>
			</tr>
		  ";
	}
?>
		</tbody>		
		</table>
	</div>
 </main>
 </body>
</html>
