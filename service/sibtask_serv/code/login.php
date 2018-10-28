<?php require_once $_SERVER['DOCUMENT_ROOT'].'/security.php'; ?>
<?php
	$dbconn = pg_connect("host=sibt_db dbname=service user=postgres password=mem");
	if (isset($_POST["signin"]))
	{
		$emailorlogin = $_POST['inputEmailorLogin'];
		$password = $_POST['inputPassword'];
		if (($emailorlogin != "") || ($password != ""))
		{
			$query = "SELECT login from users WHERE email = '$emailorlogin' order by id desc limit 1";
			$result = pg_fetch_result(pg_query($query),0);
			if ($result == '')
			{
				$query = "SELECT login from users WHERE login = '$emailorlogin' order by id desc limit 1";
				$result = pg_fetch_result(pg_query($query),0);
				if ($result == '')
				{
					echo "<div class='alert alert-info'>Заполните все поля коррекно</div>";				
				}
				else
				{
					session_start();
					$_SESSION["login"] = $result;
					$_SESSION["password"] = $password;
			
				}
			}
			else
			{
				session_start();
				$_SESSION["login"] = $result;
				$_SESSION["password"] = $password;
			
			}
		
		}
		else
		{
			echo "<div class='alert alert-info'>Заполните все поля коррекно</div>";				
		}
	}
	pg_close();
?>
<html>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/head.php'; ?>
<body>
<link href="css/login.css" rel="stylesheet">
<header> 
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/top.php'; ?> 
</header>

<form class="form-signin bg-light" method="post">
	<h1 class="h3 mb-3 font-weight-normal text-center">Вход</h1>
	<label for="inputEmail" class="sr-only">Email или логин</label>
	<input type="text" name="inputEmailorLogin" class="form-control" placeholder="Email или логин" required autofocus>

	<label for="inputPassword" class="sr-only">Пароль</label>
	<input type="password" name="inputPassword" class="form-control" placeholder="Пароль" required>

	<button class="btn btn-outline-primary btn-block" name="signin" type="submit">Войти</button>
</form>

</bogy>
</html>
