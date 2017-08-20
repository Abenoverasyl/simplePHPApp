<?php 
  
  include 'mycabinet/dbconn.php';
  include 'mycabinet/functions.php';

  session_start();
  if (isset($_SESSION['user_id'])) {
    header('Location: mycabinet/mycabinet.php');
  }

  if (isset($_POST["register"])) { // если нажато кнопка 
    // получение данных 
    $user_name = $_POST['user_name']; 
    $user_email = $_POST['user_email'];
    // $user_telegram = "123456";
    $user_telegram = $_POST['user_telegram'];
    $user_phone = $_POST['user_phone'];
    $user_password = $_POST['user_password'];
    $user_password_again = $_POST['user_password_again'];

    if ($user_password != $user_password_again) {
      $errPasswordAgain = 'Пароли не совпадают';
    }

    $exist_user = set_user($user_name, $user_email, $user_phone, $user_telegram, $user_password);
  } 

  ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Smart Security | Регистрация</title>
	<link rel="stylesheet" href="css2/style.css" media="screen" type="text/css" />
    <link rel="icon" type="image/png" href="mycabinet/images/logo.png" />
</head>
<body>

<!-- vladmaxi top bar -->
    <div class="vladmaxi-top">
        <h1><a href="http://diplom.loc/">Вернуться назад</a></h1>
        <span class="right">
        <a href="http://vladmaxi.net/web-developer/css/22-luchshix-formy-vxoda-i-registracii-na-sajte-v-html-css.html">
                <strong></strong>
            </a>
        </span>
    <div class="clr"></div>
    </div>
<!--/ vladmaxi top bar -->

    <div id="login-form">
        <h1>Регистрация на сайте</h1>

        <fieldset>
            <form action="register.php" method="post">
                <input type="text" name="user_name" placeholder="Введите имя" required>
                <input type="email" name="user_email" placeholder="Введите e-mail" required>
                <input type="text" name="user_phone" placeholder="Введите телефон" required>
                <input type="text" name="user_telegram" placeholder="Введите телеграм" required>
                <input type="password" name="user_password" placeholder="Введите пароль" required>
                <input type="password" name="user_password_again" placeholder="Повторите пароль" required>
                <input type="submit" name="register" value="Зарегистрироваться">
                <footer class="clearfix">
                    <p><span class="info">!</span><a href="login.php">Вход</a></p>
                </footer>
            </form>
        </fieldset>

    </div>
</body>
</html>