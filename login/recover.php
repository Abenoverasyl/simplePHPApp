<?php 

  include 'mycabinet/dbconn.php';
  include 'mycabinet/functions.php';

  session_start();
  if (isset($_SESSION['user_id'])) {
    header('Location: mycabinet/mycabinet.php');
  }
  
  if (isset($_POST["recover"])) { // если нажато кнопка 

    // получение данных 
    $user_email = $_POST['user_email'];
    recover_password($user_email);
  }

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Smart Security | Восстановления</title>
	<link rel="stylesheet" href="css2/style.css" media="screen" type="text/css" />
  <link rel="icon" type="image/png" href="mycabinet/images/logo.png" />
</head>
<body>

<!--  top bar -->
    <div class="vladmaxi-top">
        <h1><a href="http://diplom.loc/">На главную</a></h1>
        <span class="right">
        <a href="http://vladmaxi.net/web-developer/css/22-luchshix-formy-vxoda-i-registracii-na-sajte-v-html-css.html">
                <strong></strong>
            </a>
        </span>
    <div class="clr"></div>
    </div>
<!-- top bar -->

    <div id="login-form">
        <h1>Восстановления пароля</h1>

        <fieldset>
            <form action="recover.php" method="post">
                <input type="email" name="user_email" placeholder="Введите e-mail" required>
                <input type="submit" name="recover" value="Восстановить">
                <footer class="clearfix">
                    <p><span class="info">!</span><a href="login.php">На вход</a></p>
                </footer>
            </form>
        </fieldset>

    </div>
</body>
</html>