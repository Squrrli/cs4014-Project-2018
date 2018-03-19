<?php
	/** Log user in */
	require 'Database.php';

	$db = new Database();
	$user_email = $_POST['emLog'];
	$password = $_POST['pwLog'];
	$values = array($user_email, $password);
	$bool = array();


	if ((isset($user_email) && isset($password)) && ($user_email!="" && $password!="")) {
		$bool = $db->login($values);

		if ($bool[0]) {
			$user = $bool[1];
			
			echo "<form id=user_id method=post action=../catalog/home.php>";
			echo	"<input type=hidden name=user_id value={$user['id']}>";
			echo "</form>";
			print "<script>
						(document.getElementById('user_id')).submit();
					</script>";
		}else{
			print("user must register");
		}

	}else{
		header("Location: ../index.php");

	}
	
?>

<?php
    if (isset($_GET['var']))
{?>

<script type="text/javascript">
    document.getElementById('dateForm').submit(); // SUBMIT FORM
</script>

<?php 
}
else
{
  // leave the page alone
}
?>