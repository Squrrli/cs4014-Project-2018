<?php
/** Log user in */
require 'Database.php';

$db = new Database();
$user_email = $_POST['em'];
$password = $_POST['pw'];
$values = array($user_email, $password);

if (isset($user_email) && isset($password)) {
	
	if($db->login($values)){
		print('user logged in');
	}else{
		print('user needs to register');
	}
}else{
	header('Location: ../index.php');
	exit();
}
?>