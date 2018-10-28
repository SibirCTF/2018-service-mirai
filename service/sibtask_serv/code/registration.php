<?php require_once $_SERVER['DOCUMENT_ROOT'].'/security.php'; ?>
<?php
	$dbconn = pg_connect("host=sibt_db dbname=service user=postgres password=mem");
	if (isset($_POST["register"]))
		{
			$login = $_POST['inputLogin'];
	   		$email = $_POST['inputEmail'];
	   		$public_name = $_POST['inputPublicName'];
			$password = $_POST['inputPassword1'];
			$path = __DIR__."/avatars/";

			$query = "SELECT login from users WHERE login = '$login' order by id desc limit 1";
			$result = pg_fetch_result(pg_query($query),0);

		   	if (($login == "") || ($email == "") || ($public_name == "") || ($password == "") || ($password != $_POST['inputPassword2']) || $result != '')
				{
					echo "<div class='alert alert-info'>Заполните все поля коррекно</div>";
				}	
			else
				{
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				if (($_FILES["picture"]["error"] == UPLOAD_ERR_OK) && ($_FILES["picture"]["size"] <= 1048576) && ($_FILES["picture"]["type"] == "image/png") && (finfo_file($finfo, $_FILES["picture"]["tmp_name"]) == "image/png"))
					{
						
						$filename = $_FILES["picture"]["name"];
						$filename = explode('.', $filename);
						$filename[0] = md5(microtime());
						$filename = implode('.', $filename);
						move_uploaded_file($_FILES["picture"]["tmp_name"], $path.$filename);
						$file = str_replace("/var/www/html/", "",$path.$filename); 
						$password = hash('sha256', $password, false);
						$query = "INSERT INTO users(login, email, name, pass_hash, avatar) VALUES ('$login', '$email', '$public_name', '$password', '$file')";
						$result = pg_query($query);
					}
					else
					{
						echo "<div class='alert alert-info'>Необходимо загрузить аватарку в формате png размером до 1Мб</div>";
					}
				finfo_close($finfo);
				}
		}
	pg_close();
?>

<html>
 <?php require_once $_SERVER['DOCUMENT_ROOT'].'/head.php'; ?>
 <body>
<link href="css/registration.css" rel="stylesheet">
 <header> 
 <?php require_once $_SERVER['DOCUMENT_ROOT'].'/top.php'; ?> 
 </header>
 
<form class="form-registration bg-light" method="post" enctype="multipart/form-data">
	<h1 class="h3 mb-3 font-weight-normal text-center">Регистрация</h1>

	<label for="inputLogin">Логин</label>
	<input type="text" name="inputLogin" class="form-control" placeholder="Логин" required autofocus>

	<label for="inputEmail">Email</label>
	<input type="email" name="inputEmail" class="form-control" placeholder="Email" required autofocus>	


	<label for="inputPublicName">Публичное имя</label>
	<input type="text" name="inputPublicName" class="form-control" placeholder="Ваше публичное имя" required autofocus>

	<label for="inputPassword1">Пароль</label>
	<input type="password" name="inputPassword1" class="form-control" placeholder="Пароль" required autofocus>

	<label for="inputPassword2">Повторите пароль</label>
	<input type="password" name="inputPassword2" class="form-control" placeholder="Повторите пароль" required autofocus>

	<label for="picture"> Аватар в формате png размером до 1Мб </label>
	<input type="file" name="picture">

	<button class="btn btn-outline-primary btn-block" type="submit" name="register" value="True">Зарегистрироваться</button>
</form>
</html>
