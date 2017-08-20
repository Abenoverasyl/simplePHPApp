<?php 

include 'dbconn.php';
include 'functions.php';

session_start();
session_destroy();
header('Location: /../index.php');

 ?>