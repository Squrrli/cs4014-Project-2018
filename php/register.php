<?php
require 'Database.php';

//initialise Database object
$db = new Database();

//get information from form
$first = $_POST['firstname'];			$sur = $_POST['surname'];
$sex = $_POST['sex'];					$DOB = $_POST['DOB'];
$email = $_POST['em']					$password = $_POST['pw'];
$loc_country = $_POST['country'];		$loc_city = $_POST['city'];
$nationality = $_POST['nationality'];   $admin = false; //admin initialised as false, must be set by another admin

$user_info = array($DOB, $first, $sur, $sex, $nationality, $email, $password, $country, $city, $admin);

//add user to db
if($db->add_user($user_info);{
	header('Location: ../catalog/home.html');
	exit();
}else{
	header('Location: ..index.php');
	exit();
}
?>