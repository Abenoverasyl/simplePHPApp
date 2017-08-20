<?php 
    // db connect
    @header('Content-type: text/html; charset=UTF-8');
    @session_start();
    $host='localhost';
    $db='ps.diplom';
    $user='root';
    $password='';
    $host_web = "";

    $IsLocalhost = FALSE;

    try {
        $PDOdb = new PDO('mysql:host='.$host.';dbname='.$db, $user, $password);
    } catch(PDOException $e) {
        die("Error: ".$e->getMessage());
    }

    $error_array = $PDOdb->errorInfo();
    if($PDOdb->errorCode() != 0000) {
        echo "SQL: " . $error_array[2] . '<br /><br />';
    }
    // get sites
    include("functions.php");

    if (isset($_GET["info-sites"])) {
        $user_id = $_GET['info-sites'];
        get_sites($user_id);
    }

    if (isset($_GET["login"])) { // если нажато кнопка submit
        // получение данных 
        
        $user_email = $_GET['email'];
        $user_password = $_GET['password'];
        $user_status = get_user($user_email, $user_password);
        echo $user_status;
    }

    if (isset($_GET['insert-site'])) {
        $site_url = $_GET['insert-site'];
        $user_id = $_GET['user_id'];
        set_site("key", $site_url, $user_id);
    }

    if (isset($_GET['delete-site'])) {
        $site_url = $_GET['delete-site'];
        echo delete_site($site_url);
    }

    function get_sites($user_id) {
        global $PDOdb;

        $Show_sql_str = "SELECT `id`, `url`, `user_id` FROM `site` 
        WHERE `user_id` = ". $user_id;

        $Show_sql_str =  $PDOdb->prepare($Show_sql_str);

        $Show_sql_str->execute();
        $result = $Show_sql_str -> fetchAll();

        $err_sites = "";
        $ok_sites = "";

        foreach( $result as $site) {
            $url = $site['url'];
            if (!isSiteAvailable('http://'. $url)) {
            	$err_sites = $err_sites . $url . "#";
            } else {
                $ok_sites = $ok_sites . $url ."@". get_contents($url) . "#";
                // $ok_sites = $ok_sites . $url ."@". "apache" . "#";
            }
        }
        echo "Q#Q#Q";
        echo substr($ok_sites, 0, -1);
        echo "*";
        echo substr($err_sites, 0, -1);
    }

    function get_user_email($user_id) {
		Global $PDOdb;

	    $ShowUser_sql_str = "SELECT * FROM `users` 
	    					WHERE `id` = :id
	    					LIMIT 1";

		$ShowUser_sql =  $PDOdb->prepare($ShowUser_sql_str);

		$ShowUser_sql->bindParam(':id', $user_id, PDO::PARAM_STR);

		$ShowUser_sql->execute();
		$user = $ShowUser_sql->fetch(PDO::FETCH_BOTH);
		
		if (!empty($user['email'])) {
			return $user['email'];
		}
	}

    function isSiteAvailable($url) {
    // проверка на валидность представленного url
	    if(!filter_var($url, FILTER_VALIDATE_URL)) {
	      return FALSE;
	    }

	    // создаём curl подключение
	    $cl = curl_init($url);
	    curl_setopt($cl,CURLOPT_CONNECTTIMEOUT,10);
	    curl_setopt($cl,CURLOPT_HEADER,true);
	    curl_setopt($cl,CURLOPT_NOBODY,true);
	    curl_setopt($cl,CURLOPT_RETURNTRANSFER,true);

	    // получаем ответ
	    $response = curl_exec($cl);

	    curl_close($cl);
	    if ($response) return TRUE;

	    return FALSE;
	}

    function get_contents($site_url) {
        file_get_contents("http://". $site_url);
        $arr = $http_response_header;
        return $arr[0] ."@".$arr[1];
    }

?>

