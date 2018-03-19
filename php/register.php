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

$bool_2 = true;
$sql = "SELECT * FROM User WHERE email = '$email' "
$user_info = array($DOB, $first, $sur, $sex, $nationality, $email, $password, $country, $city, $admin);

//check each data item is set and is not an empty string
foreach ($user_info as $value) {
	if(($value == '') || !isset($value)){
		$bool_2 = false;
	}
}

//check if user already exists
if($bool_2){
	$result = $db->connection->query($sql);
	//rows = 0 if user has not already signed up with submitted email
	if($result->num_rows != 0){
		log('user already exists');
		header('Location: ../index.php');
	}else{
		//add user to db
		$db->add_user($user_info);
		header('Location: ../catalog/home.php');
	}
}

?>