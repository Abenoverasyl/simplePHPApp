<?php 

include 'dbconn.php';
include 'functions.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: /../index.php');
}
  $user = get_user_data($_SESSION['user_id']);
  $sites = get_sites();

  if (isset($_POST["add_url"])) { // если нажато кнопка submit

    // получение данных 
    $site_key = $_POST['site_key'];
    $site_url = $_POST['site_url'];

    $errorLogin = set_site($site_key, $site_url);
    
  }
  if(isset($_POST['delete_site'])) {
    $result = delete_site($_POST['site_id']);
  }

?>



<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Smart security - мой кабинет</title>
	 <link rel="icon" type="image/png" href="images/logo.png" />
	
	<!-- Google Webfonts -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,600,700,300,800" rel="stylesheet" type="text/css" />
	
	<!-- Stylesheets -->
	<link href="css/reset.css" rel="stylesheet" />
	<link href="css/main.css" rel="stylesheet" />
	<link href="css/asyncslider_body.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="js/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
	
	<!-- JavaScripts -->
	<script src="js/jquery-1.7.1.min.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<script src="js/jquery.asyncslider.min.js"></script>
	<script src="js/hover.zoom.js"></script>
	<script src="js/jquery.flip.min.js"></script>
	<script src="js/main.js"></script>	
	<script type="text/javascript" src="js/fancybox/jquery.fancybox.pack.js?v=2.0.4"></script>

</head>
<body>
	<div class="background_overlay">
		<div class="background">
		
			<!--Wrapper -->
			<div class="wrapper">
			
				<!--Header -->
				<header>
					<a href="#" class="logo">
					S.Security
					</a>
					<div class="description">Мы за безопасность вашего сайта!</div>
					
					<div class="contact">
					
						<!-- Order -->
						
						<!-- END OF: Order -->
						
						<!-- Telephone -->
						<div class="telephone">тел. +7 701 381 2939</div>
						<!-- END OF: Telephone -->
						
						<a class="social" href="https://vk.com/abigail_t25">v</a>
						<a class="social" href="https://www.instagram.com/abigail_t25/">i</a>
						<a class="order" href="logout.php">Выйти</a>
						
					</div>
					<div class="clear"></div>
				</header>
				<!-- END OF: Header -->
				
				<div class="line"></div>
				<div class="clear"></div>
			</div>
			
			<!-- END OF: Wrapper -->
			<div class="slider_container">
			
				<ul class="async_slider">
					
					<!-- Slide Item 1 -->
					<li id="slide-01">
						<div class="slider_text">
							<h1>Приложения для смартфонов будет готово в ближайшее время</h1>
							<p>Ссылки для скачивания: </p>
							<a class="button" href="#">Android</a> 
							<div class="or">или</div>
							<a class="button" href="#">AppStore</a>
						</div>
						<div class="slider_image">
							<img src="images/mac2.png" width="420" height="250" />
						</div>
						<div class="clear"></div>
					</li>
					<!-- End of: Slide Item 1 -->
					
					<!-- Slide Item 1 -->
					<li id="slide-02">
						<div class="slider_text">
							<h1>Мы проверим сайт во всех браузерах.</h1>
							<p>Chrome, Yandex, Opera, FireFox и тд.</p>
							<p>Откройте сайт на всех браузерах и проверьте!</p>
						</div>
						<div class="slider_image browsers">
							<div> <img src="images/op.png" width="48" height="54" /></div>
							<div> <img src="images/firefox.png" width="87" height="86" /></div>
							<div> <img src="images/chrome.png" width="128" height="126" /></div>
							<div> <img src="images/safari.png" width="78" height="82" /></div>
							<div> <img src="images/ie.png" width="53" height="54" /></div>
						</div>
						<div class="clear"></div>
					</li>
					<!-- End of: Slide Item 1 -->
					
					
					<!-- Slide Item 1 -->
					<li id="slide-03">
						<div class="slider_text">
							<h1>Выйграйте призы от Smart Security</h1>
							<p>Стань частью нашей команды!.
								<br />
								Победители получит ценные призы. Присоединяйтесь к нам
							</p>
							<a class="button" href="https://www.vk.com/">ВК</a> 
							<div class="or">или</div>
							<a class="button" href="https://www.facebook.com/">Facebook</a>
						</div>
						<div class="slider_image">
							<img src="images/macimg.png" width="420" height="250" />
						</div>
						<div class="clear"></div>
					</li>
					<!-- End of: Slide Item 1 -->
					
				</ul>
				
				<div class="sliderNav"></div>
				<div class="slides_nav_container"></div>
				
			</div>
			<!-- END OF: Slider Container -->

			<!-- Input sites form -->
			<div class="wrapper">

				<section>
					<h1><?php echo $_SESSION['user_email']; ?></h1>
					<p>Добавьте свой сайт для проверки</p>
					<div class="content">
                    	<form action="mycabinet.php" method="post">
							<input type="text" name="site_key" placeholder="Введите ключевое слово" class="url" required /> <br>
							<input type="text" placeholder="Введите адрес сайта (пример: https://www.tutorialspoint.com)" name="site_url" class="url" required /> 
							<br> <br>
							<input type="submit" value="Добавить" name="add_url" class="subscribe" />
							<div class="clear"></div>
						</form>
                    	<div class="clear"></div>
                    </div>
                    <div class="clear"></div>
				</section>
			</div>

			<table>
				<tr>
					<td></td>
					<td></td>
				</tr>
			</table>


			<?php
			$ind = 0;
			if (!empty($sites)) {
				$sites = array_reverse($sites);
				foreach ($sites as $site) {
	              	$ind++;
	              	$status_site = "Сайт доступен";
	              	
	              		
					echo "<div class='wrapper'>
						<section>";
							if (!isSiteAvailable('http://'. $site['url'])) {
								echo "<table>
									<tr>
										<td><img src='images/erricon.jpg' style='width:20px;height:20px;'></td>
										<td><h1><font color='red'> Сайт не доступен!</font></h1></td>
									</tr>
								</table>";
							}
							echo "<h1><font color='#1E90FF'>".$ind.". Ключевое слово: ".$site['keyword']." </font></h1>
							<table style='width:100%'>
							  <tr>
							    <td>
									<h2><font color='#1E90FF'>Адрес сайта (URL):</font> 
									<a href='http://".$site['url']."'><font color='#87CEFA'>http://".$site['url']."</a>
									</font></h2>
								</td>
								<td align='right'>
									<form role='form' method='post' action='mycabinet.php'>
										<input type='hidden' name='site_id' value='". $site["id"] ."' />
						                <input type='submit' value='Удалить' name='delete_site' class='delete' />
						             </form>
						        </td>
							  </tr>
							</table>
						</section>
					</div>";
				}
			}

			?>



			<!--WRAPPER -->
			<div class="wrapper">
				
				<section>
					<center><h1><font color="#20B2AA"><b>Что мы предлагаем?</b></font></h1></center>
					<div class="content">
                    
                    	<div class="column">
                            <h1>Надежность</h1>
                            <img src="images/http.jpg" />
                            <p>Инструмент используемый непосредственно из вашего браузера, служит для массовой проверки ответных кодов HTTP,полученных с веб-серверов (код статуса HTTP и код ответа HTTP)
                            </p>
                        </div>
                        
                    	<div class="column">
                            <h1>Полезноcть</h1>
                            <img src="images/polezn.jpg" />
                            <p>Это полезно как для тех, кто практикует SEO, и хочет таким образом фильтровать список веб-страниц по кодам ответов, так и для веб-мастеров, которые выполняют обычную рутинную проверку состояния сайта.</p>
                        </div>
                        
                    	<div class="column">
                            <h1>Конкурентоспособность</h1>
                            <img src="images/verevka.jpg" />
                            <p>Также - вы с его помощью можете проверить конкурентные сайты или использовать его для «построения нерабочих ссылок».</p>
                        </div>
                    	<div class="clear"></div>
                    </div>
                    
					<ul class="features">
                            <li class="feature">
                                <a href="downloads/authoravatar.rar">
                                <div class="networking ca-icon"></div>
                                <div class="ca-content">
                                    <h1 class="ca-main">Приложения для копьютера</h1>
                                    <p class="ca-sub">
                                        Скачайте и просто не волнуйтесь о безопаности вашего сайта.
                                    </p>
                                </div>	
                                <div class="clear"></div>
                                </a>
                            </li><!-- end of: FEATURE  -->
                       
    
                            <li class="feature">
                                <a href="#">
                                <div class="applications ca-icon"></div>
                                <div class="ca-content">
                                    <h1 class="ca-main">Приложения для телефона</h1>
                                    <p class="ca-sub">
                                        Мы всегда и везде будем отпралять вам данные о сайтах.
                                    </p>
                                </div>
                                <div class="clear"></div>
                                </a>
                            </li><!-- end of: FEATURE  -->

                        <div class="clear"></div>
                       
                    </ul><!--end of Features -->
					
					
				</section>
				
				<div class="blocks">
				
					<div class="blocks_inner">
					
						<div class="block_1">
							<h1>Весь мир</h1>
							<p>
								Наши приложения используют везде. 
							</p>
						</div>
						
						<div class="block_2">
							<h1>Лучшие</h1>
							<p>
								У на самые лучшие сотрудники. 
							</p>
						</div>
						
						<div class="block_3">
							<h1>Весь день</h1>
							<p>
								24 часа в день мы свами. 
							</p>
						</div>
						
						<div class="clear"></div>
					</div>
					
				</div>
				
				<div class="first_column" id="subscribe_box">
				
					<div class="column_content">
						<h1>Задать вопрос</h1>
						<p>
							Если есть вопросы напишите к нам,
							мывсегда рады ответить:
						</p>
					</div>
					
					<div class="bottom_content">
						<form action="#" method="post" id="subscribe_form">
							<textarea rows="4" cols="50" name="comment" placeholder="Введите вопрос.." form="usrform"></textarea> <br>
							<input type="button" value="Отправить" class="questButton" />
							<div class="clear"></div>
						</form>
					</div>
					
				</div>
				
				<div class="second_column">
				
					<div class="column_content">
						<h1>Комментарий</h1>
						
						<ul class="testimonals">
							<li data-name="Канат Ислам" data-url="http://Andr.com/1">Один из самых лучших сайтов когда-либо я видел.</li>
							<li data-name="Генади Головкин" data-url="http://GGG.com/2">Огромное спасибо!</li>
							<li data-name="Димаш Кудайбергенов" data-url="http://dimash.com/3">Спасибо за сервис, мне очень понравилась!</li>
							<li data-name="Турсынбек Кабатов" data-url="http://Tursinbek.com/4">Оте керекмет программа.</li>
						</ul>
					</div>
					
					<div class="bottom_content">
					
						<div class="bubble"></div>
						<div class="name">
							<h3 id="tm_name">&nbsp;</h3>
							<span id="tm_web" class="website">&nbsp;</span>
						</div>
						
					</div>
					
				</div>
				<div class="clear"></div>
				
				<ul class="clients">
                    <li><a href="#"><img src="images/clouds.png" width="122" height="34"></a></li>
                    <li><a href="#"><img src="images/thelaw.png" width="113" height="39"></a></li>
                    <li><a href="#"><img src="images/cakeapp.png" width="131" height="40"></a></li>
                    <li><a href="#"><img src="images/thephish.png" width="94" height="43"></a></li>
				</ul>
				
				<footer>
				
					Copyright © All Rights Reserved 2012. Akniet Tolegen.  
					<div class="right_icons">
						<a class="facebook" href="#">Facebook</a>
						<a class="twitter" href="#">Twitter</a>
						<a class="dribbble" href="#">Dribbble</a>
					</div>
					
					<div class="clear"></div>
					
				</footer>
				
			</div>
			<!-- END OF: Wrapper -->
		</div>
	</div>
</body>
</html>