<?php 
  
  include 'mycabinet/dbconn.php';
  include 'mycabinet/functions.php';

  session_start();
  if (isset($_SESSION['user_id'])) {
    header('Location: mycabinet/mycabinet.php');
  }

  if (isset($_SESSION['recover'])) {
    if ($_SESSION['recover'] == 'yes') {
        echo '<script language="javascript">';
        echo 'alert("Пароль отправлен на ваш e-mail")';
        echo '</script>';
    } else {

    }
    session_destroy();
  }

  else if (isset($_POST["login"])) { // если нажато кнопка submit

    // получение данных 
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $errorLogin = get_user($user_email, $user_password);
  }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Smart Secrity - Вход</title>
	<link rel="stylesheet" href="css2/style.css" media="screen" type="text/css" />
	<link rel="icon" type="image/png" href="mycabinet/images/logo.png" />
</head>
<body>

<!--  top bar -->
    <div class="vladmaxi-top">
        <h1><a href="http://diplom.loc/">Вернуться назад</a></h1>
        <span class="right">
        <a href="http://vladmaxi.net/web-developer/css/22-luchshix-formy-vxoda-i-registracii-na-sajte-v-html-css.html">
                <strong></strong>
            </a>
        </span>
    <div class="clr"></div>
    </div>
<!-- top bar -->

    <div id="login-form">
        <h1>Авторизация на сайте</h1>

        <fieldset>
            <form action="login.php" method="post">
                <input type="email" name="user_email" placeholder="Введите e-mail" required>
                <input type="password" name="user_password" placeholder="Введите пароль" required>
                <input type="submit" name="login" value="ВОЙТИ">
                <footer class="clearfix">
                    <p><span class="info">?</span><a href="recover.php">Забыли пароль?</a></p>
                </footer>
                <center><h4><a href="register.php">Зарегистрироваться</a></h4></center>
            </form>
        </fieldset>

    </div>
</body>
</html>