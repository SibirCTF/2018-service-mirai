<?php
	
	session_start();
	if (isset($_POST["out"]) && $_SESSION["login"] != '')
	{
		$_SESSION = array();
		session_destroy();
	}
	if ($_SESSION["login"] != '')
	{
		$dbconn = pg_connect("host=sibt_db dbname=service user=postgres password=mem");
		$login = $_SESSION["login"];
		$query = "SELECT login from users WHERE login = '$login' order by id desc limit 1";
		$result = pg_fetch_result(pg_query($query),0);
		if ($result == '')
		{
			$_SESSION = array();
			session_destroy();
		}
		pg_close();
	}
?>
