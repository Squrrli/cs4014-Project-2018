<?php
	if (isset($_POST['user_id'])) {
		setcookie('user_id', $_POST['user_id'], time()+3600);
	}
	echo "post";
	print_r($_POST);
	echo "cookie";
	print_r($_COOKIE);

?>

<!DOCTYPE html>
<html>
	<head>
		<title>cs4014 project</title>
		<!-- Latest compiled css -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
		<!-- My custom CSS file -->
		<link rel="stylesheet" type="text/css" href="../css/custom.css">
	</head>
	
	<body>
		<div class="container-fluid content-center">
			<div class="col-sm-10"> <!-- WRAP CONTAINER -->
				<div class="row">
					<div class="col-sm-12">
						<!-- Navigation bar- TEMPORARY FROM BOOTSTRAP WEBSITE -->
						<nav class="navbar navbar-light bg-light">
						  <a class="navbar-brand" href="#">Navbar</a>
						  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						    <span class="navbar-toggler-icon"></span>
						  </button>
						  <div class="collapse navbar-collapse" id="navbarNav">
						    <ul class="navbar-nav">
						      <li class="nav-item">
						        <a class="nav-link" href="home.php">Home</a>
						      </li>
						      <li class="nav-item active">
						        <a class="nav-link" href="connect.php">Connect<span class="sr-only">(current)</span></a>
						      </li>
						      <li class="nav-item">
						        <a class="nav-link" href="jobs.php">Jobs</a>
						      </li>
						      <li class="nav-item">
						        <a class="nav-link" href="profile.php">Profile</a>
						      </li>
						      <li class="nav-item">
						        <form method="POST" action="../index.php">
						        	<button class="form-control btn btn-primary" name="logout" value="1">Logout</button>
						        </form>
						      </li>
						    </ul>
						  </div>
						</nav>
					</div>

					<!--Webpage Content -->
					<div class="col-sm-12">
					<?php 
						//print 5 rows of users to add
						for($ctr=0; $ctr<5; $ctr++){
							print "<div class=\"row\">
								<div class=\"col-sm-6\">
									<div class=\"row user-card\">
										<div class=\"col-sm-10\">
											<p>user</p>	
										</div>
										<div class=\"col-sm-2\">
											<form method=\"post\" action=\"#\">
												<button class=\"form-control btn btn-link\">Add</button>
											</form>
										</div>
									</div>
								</div>
								<div class=\"col-sm-6\">
									<div class=\"row user-card\">
										<div class=\"col-sm-10\">
											<p>user</p>	
										</div>
										<div class=\"col-sm-2\">
											<form method=\"post\" action=\"#\">
												<button class=\"form-control btn btn-link\">Add</button>
											</form>
										</div>
									</div>
								</div>
							</div>";
						}
					?>

					</div>
				</div>
			</div>


		<!-- Necessary JS files from CDN -->
		<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	</body>
</html>