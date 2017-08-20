<?php 
	session_start();

	function set_user($user_name, $user_email, $user_phone, $user_telegram, $user_password) {

		if (strlen(exist_user($user_email)) != 0) {
			global $PDOdb;
			$InsertUser_sql_str = "INSERT INTO users (name, email, phone, telegram, password) 
										VALUES (:name, :email, :phone, :telegram, :password)";

			$InsertUser_sql =  $PDOdb->prepare($InsertUser_sql_str);

			$InsertUser_sql->bindParam(':name', $user_name, PDO::PARAM_STR);
			$InsertUser_sql->bindParam(':email', $user_email, PDO::PARAM_STR);
			$InsertUser_sql->bindParam(':phone', $user_phone, PDO::PARAM_STR);
			$InsertUser_sql->bindParam(':telegram', $user_telegram, PDO::PARAM_STR);
			$InsertUser_sql->bindParam(':password', md5($user_password), PDO::PARAM_STR);

			$InsertUser_sql->execute();

		    if ($InsertUser_sql->errorCode() != 0000) {
		        echo "Error: " . $error_array[2];
				exit;
		    } else {
		    	$_SESSION['user_id'] = get_user_id($user_email);
		    	$_SESSION['user_email'] = $user_email;
		    	header('Location: mycabinet/mycabinet.php');
		    }
		} else {
			return "Пользователь с таким E-mail адресом уже существует!";
		}
	}

	function get_user($user_email, $user_password) {
		global $PDOdb;

	    $ShowUser_sql_str = "SELECT * FROM `users` 
	    					WHERE `email` = :email
	    					AND `password`= :password 
	    					LIMIT 1";

		$ShowUser_sql =  $PDOdb->prepare($ShowUser_sql_str);

		$ShowUser_sql->bindParam(':password', MD5($user_password), PDO::PARAM_STR);
		$ShowUser_sql->bindParam(':email', $user_email, PDO::PARAM_STR);

		$ShowUser_sql->execute();
		$user = $ShowUser_sql->fetch(PDO::FETCH_BOTH);
		
		if (!empty($user['id'])) {
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['user_email'] = $user_email;
			return "ok&" .$user['id'] ."&". $user['name'] ."&". $user['phone'] ."&". $user['telegram'];
		} else {
			return "no";
		}
	}

	function get_user_id($user_email) {
		global $PDOdb;

	    $ShowUser_sql_str = "SELECT * FROM `users` 
	    					WHERE `email` = :email
	    					LIMIT 1";

		$ShowUser_sql =  $PDOdb->prepare($ShowUser_sql_str);

		$ShowUser_sql->bindParam(':email', $user_email, PDO::PARAM_STR);

		$ShowUser_sql->execute();
		$user = $ShowUser_sql->fetch(PDO::FETCH_BOTH);
		
		if (!empty($user['id'])) {
			return $user['id'];
		} else {
			return "null";
		}
	}

	function recover_password($user_email) {
		global $PDOdb;

	    $ShowUser_sql_str = "SELECT * FROM `users` 
	    					WHERE `email` = :email
	    					LIMIT 1";

		$ShowUser_sql =  $PDOdb->prepare($ShowUser_sql_str);

		$ShowUser_sql->bindParam(':email', $user_email, PDO::PARAM_STR);

		$ShowUser_sql->execute();
		$user = $ShowUser_sql->fetch(PDO::FETCH_BOTH);

		update_user_password($user_email);

		if (!empty($user['password'])) {

			$user_pass = $user['password'];
			$to = $user_email;
			$subject = "Восстановления пароля";
			$txt = $user_pass;
			$headers = "From: smart_security.com" . "\r\n" .
			"CC: ". $user_email;
			mail($to, $subject, $txt, $headers);
			$_SESSION['recover'] = 'yes';
			header('Location: http://diplom.loc/login/login.php');
		} else {
			$_SESSION['recover'] = 'no';
		}
	}

	function update_user_password($user_email) {
		global $PDOdb;

	    $ShowUser_sql_str = "SELECT * FROM `users` 
	    					WHERE `email` = :email
	    					LIMIT 1";

	   	// $new_pass = generateRandomString();
	   	$new_pass = "1";
	    $rundom_generated_pass = MD5($new_pass);
	    $ShowUser_sql_str = "UPDATE `users` SET `password`= '" . $rundom_generated_pass . "' WHERE `email`= '" . $user_email . "'";

		$ShowUser_sql =  $PDOdb->prepare($ShowUser_sql_str);
		$ShowUser_sql->bindParam(':email', $user_email, PDO::PARAM_STR);
		$ShowUser_sql->execute();
		
		$user = $ShowUser_sql->fetch(PDO::FETCH_BOTH);

		if (!empty($user['password'])) {
			$user_pass = $user['password'];
			$to = $user_email;
			$subject = "My subject";
			$txt = $user_pass;
			$headers = "From: ps@info.com" . "\r\n" .
			"CC: somebodyelse@example.com";
			mail($to, $subject, $txt, $headers);
		} else {
			return "Неправильный логин";
		}
	}

	function generateRandomString() {
		$length = 6;
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	function exist_user($user_email) {
		global $PDOdb;

	    $ShowUser_sql_str = "SELECT * FROM `users` 
	    					WHERE `email` = :email
	    					LIMIT 1";

		$ShowUser_sql =  $PDOdb->prepare($ShowUser_sql_str);

		$ShowUser_sql->bindParam(':email', $user_email, PDO::PARAM_STR);

		$ShowUser_sql->execute();
		$user = $ShowUser_sql->fetch(PDO::FETCH_BOTH);
		
		if (empty($user['id'])) {
			return "not_exist";
		}
	}

	function get_user_data($user_id) {
		Global $PDOdb;

	    $ShowUser_sql_str = "SELECT * FROM `users` 
	    					WHERE `id` = :id
	    					LIMIT 1";

		$ShowUser_sql =  $PDOdb->prepare($ShowUser_sql_str);

		$ShowUser_sql->bindParam(':id', $user_id, PDO::PARAM_STR);

		$ShowUser_sql->execute();
		$user = $ShowUser_sql->fetch(PDO::FETCH_BOTH);
		
		if (!empty($user['id'])) {
			return $user;
		}
	}


	function set_site($site_key, $site_url, $user_id) {

			if (strpos($site_url, 'http') !== false) {
			    $site_url = substr($site_url, 7);
			}

			global $PDOdb;
			$InsertUser_sql_str = "INSERT INTO `site` (keyword, url, user_id) 
										VALUES (:keyword, :url, :user_id)";

			$InsertUser_sql =  $PDOdb->prepare($InsertUser_sql_str);

			$InsertUser_sql->bindParam(':keyword', $site_key, PDO::PARAM_STR);
			$InsertUser_sql->bindParam(':url', $site_url, PDO::PARAM_STR);
			$InsertUser_sql->bindParam(':user_id', $user_id, PDO::PARAM_STR);

			$InsertUser_sql->execute();

		    if ($InsertUser_sql->errorCode() != 0000) {
		    	echo "Ошибка повторите позже!";
		        echo "Error: " . $error_array[2];
				exit;
		    } else {
		    	echo "Сайт успешно добавлен!";
		    }
	}

    function delete_site($site_id) {
        global $PDOdb;
        $Show_sql_str = "DELETE FROM `site` WHERE `url` = :url LIMIT 1";

        $Show_sql_str =  $PDOdb->prepare($Show_sql_str);
        $Show_sql_str->bindParam(':url', $site_id, PDO::PARAM_STR);
        $Show_sql_str->execute();
        $sites = $Show_sql_str -> fetch(PDO::FETCH_BOTH);
        return "Сайт успешно удален!";
        // header("Refresh:0; url=mycabinet.php");
    }

	function check_url() {
		if(isset($check_url)){
		     if (isSiteAvailable('http://'.$check_url)) {
		      // get_contents();
		     } else {
		       $ResultArrayItem['result']='SiteNoAvailable';
		     }
		} 
	}

	
 ?>