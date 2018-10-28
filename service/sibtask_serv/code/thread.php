<?php require_once $_SERVER['DOCUMENT_ROOT'].'/security.php'; ?>

<?php
	$dbconn = pg_connect("host=sibt_db dbname=service user=postgres password=mem");
	if (!isset($_GET["id"]) || $_GET["id"] == '' || is_int($_GET["id"]))
	{
		echo 'Неверный id треда!';	
		exit;
	}
	if (isset($_GET["id"]))
	{
		$id_thread = $_GET["id"];
		$query = "SELECT id, title FROM threads WHERE id = '$id_thread'";
		$result = pg_query($query);
		$thread_info = pg_fetch_array($result, null, PGSQL_ASSOC);
		if ($thread_info['id'] == '')
		{
			echo 'Неверный id треда!';	
			exit;
		}
	}
	if (isset($_POST["save"]))
	{
		if ($_SESSION["login"] != '')
		{
			$authorname = $_SESSION["login"];
			$message = $_POST['message'];
			$path = __DIR__."/images/";

			if (($_FILES["picture"]["error"] == UPLOAD_ERR_OK) && ($_FILES["picture"]["size"] <= 1048576))
			{
				$filename = $_FILES["picture"]["name"];
				$filename = explode('.', $filename);
				$filename[0] = md5(microtime());
				$filename = implode('.', $filename);
				move_uploaded_file($_FILES["picture"]["tmp_name"], $path.$filename);
				$file = str_replace("/var/www/html/", "",$path.$filename);
				$query = "INSERT INTO messages(id_user, id_thread, message, image) VALUES ((SELECT id FROM users WHERE login = '$authorname'), '$id_thread', '$message', '$file') RETURNING id";
				$result = pg_fetch_result(pg_query($query),0);
				echo "<div class='alert alert-info' hidden='true'>Message created successfully. \"{$result}\"</div>";
			} elseif ($_FILES["picture"]["name"] == "") {
				$file = ''; 
				$query = "INSERT INTO messages(id_user, id_thread, message, image) VALUES ((SELECT id FROM users WHERE login = '$authorname'), '$id_thread', '$message', '$file') RETURNING id";
				$result = pg_fetch_result(pg_query($query),0);
				echo "<div class='alert alert-info' hidden='true'>Message created successfully. \"{$result}\"</div>";
			} else {
				echo "<div class='alert alert-info'>Картинка слишком большая!</div>";
			}
		} else {
			echo "<div class='alert alert-info'>Необходимо войти на сайт!</div>";		
		}
	}
?>

<html>
 <?php require_once $_SERVER['DOCUMENT_ROOT'].'/head.php'; ?>
 <body>
 <header> 
 <?php require_once $_SERVER['DOCUMENT_ROOT'].'/top.php'; ?> 
 </header>
<link href="css/thread.css" rel="stylesheet">


<?php
if ($_SESSION["login"] != '') {
	echo "<div class=\"row justify-content-center\">
    <div class=\"panel-body message\">
      <h4 class=\"text-center\">Новое сообщение</h4>
			<form class=\"form-horizontal\" role=\"new_thread\" method=\"post\" enctype=\"multipart/form-data\">

				<div class=\"form-group\">
					<div class=\"col-sm-12\">
						<textarea class=\"form-control\" name=\"message\" rows=\"4\"></textarea>
					</div>
				</div>

				<div>
					<label for=\"picture\" class=\"col-lg-3 col-sm-3 control-label\"> Картинка  размером до 1Мб</label>
			    		<input type=\"file\" name=\"picture\">
				</div>

				<div class=\"form-group\">
					<div class=\"col-sm-12\">	
						<button type=\"submit\" class=\"btn btn-outline-primary\" name=\"save\" value=\"True\">Отправить</button>
					</div>
				</div>

			</form>	
		</div>
</div>";
}
?>

<?php	
	echo "<h2 class=\"text-center\">{$thread_info['title']}</h2>";
	$query = "SELECT id_user, message, image FROM messages WHERE id_thread = '{$id_thread}'";
	$result = pg_query($query);
	while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
		$query = "SELECT avatar, name, email from users WHERE id = '{$line['id_user']}'";
		$user_info = pg_fetch_array(pg_query($query), null, PGSQL_ASSOC);
		echo " <hr> <div class=\"row justify-content-center\">   
	<div class=\"col-lg-10 col-sm-10 rounded brd bg-light\">
        <div class=\"row justify-content-center\">
    		    <div class=\"col-lg-2 col-sm-4\">
    			    <p></p>
    			    <p class=\"border-bottom border-gray\"></p>
    	            <img src=\"{$line['image']}\" width=\"160\" class=\"rounded\">
                </div>		       
    			<div class=\"col-lg-8 col-sm-4 brdl\">
    			        <p class=\"border-bottom border-gray\"></p>
				<p>{$line['message']}</p>
    			</div>	
    			<div class=\"col-lg-2 col-sm-4 brdl\">   
    				<p></p>
    				<p class=\"border-bottom border-gray\"></p>
        			   <figure>
        			   		<img src=\"{$user_info['avatar']}\" width=\"160\" class=\"rounded\">
    
        					<figcaption>
        					    <p>Имя автора: {$user_info['name']}</p>
        					    <p>Email: {$user_info['email']}</p>
        					 </figcaption>
        				</figure>
                	</div>    
    		</div>
    	</div>
</div>";
	}

?>
 </body>
</html>
