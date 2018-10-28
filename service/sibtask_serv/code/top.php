<link href="/css/top.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <a class="navbar-brand" href="index.php">
        <img src="/static/kissxsis.jpg" width = "40" class = "rounded-circle">
        Форум анимедевочек
    </a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           Треды
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="threads.php?section=anime">Аниме</a>
          <a class="dropdown-item" href="threads.php?section=cosplay">Косплей</a>
          <a class="dropdown-item" href="threads.php?section=manga">Манга</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="threads.php?section=bullshit">Свободное общение</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="registration.php">Регистрация</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Вход на сайт</a>
      </li>
    </ul>
	<?php
		if($_SESSION["login"] != '')
		{    
		    echo "<a class=\"nav-link disabled\" href=\"user_info.php\">{$_SESSION["login"]}</a>
		    <form class=\"form-inline my-2 my-lg-0\" method=\"POST\">
		      <button class=\"btn btn-outline-primary my-2 my-sm-0\" type=\"submit\" name=\"out\">Выйти</button>
		    </form>";
		}
	?>
  </div>
</nav>
<script type="text/javascript" src="/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
