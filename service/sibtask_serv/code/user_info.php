<?php require_once $_SERVER['DOCUMENT_ROOT'].'/security.php'; ?>
<?php
	if ($_SESSION["login"] != '')
	{
		$dbconn = pg_connect("host=sibt_db dbname=service user=postgres password=mem");
		$query = "SELECT login, email, name, avatar from users WHERE login = '$login' order by id desc limit 1";
		$result = pg_fetch_array(pg_query($query), null, PGSQL_ASSOC);
		if ($result['login'] == ''){
			header("Location: http://".$_SERVER['HTTP_HOST']."/index.php");
			exit;
		}
	}
	else
	{
		header("Location: http://".$_SERVER['HTTP_HOST']."/index.php");
		exit;
	}
	pg_close();
?>

<html>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/head.php'; ?>
	<body>
	<link href="css/user_info.css" rel="stylesheet">
	<header> 
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/top.php'; ?> 
	</header>	
			<div class="my-3 p-3 bg-white rounded box-shadow">
       	 		<h6 class="border-bottom border-gray pb-2 mb-0"></h6>
       			 <div class="media text-muted pt-3">
	    		<?php echo "<img class=\"mr-2 rounded\" src=\"/{$result['avatar']}\" width=\"200\">";?>
 			<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
			<?php echo "<strong class=\"d-block text-gray-dark\">Name: {$result['name']}</strong>";?>
			<?php echo "<strong class=\"d-block text-gray-dark\">Login: {$result['login']}</strong>";?>
			<?php echo "<strong class=\"d-block text-gray-dark\">Email: {$result['email']}</strong>";?>
          </p>
        </div>
      </div>

</html>
