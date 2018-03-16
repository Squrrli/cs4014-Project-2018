<!DOCTYPE html>
<html>
	<head>
		<title>cs4014 project</title>

		<!-- Latest compiled css -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		<!-- My custom CSS file -->
		<link rel="stylesheet" type="text/css" href="css/custom.css">

	</head>
	<body>
		<!-- bg-home sets background img to whole page -->
		<div class="container-fluid bg-login">
				<!-- Decription of website -->
				<!-- class="content-center" centers elements inside flexbox -->
				<div class="row">
					<div class="col-sm-12 content-center">
						<div class="col-sm-12" id="main">
							<h1 class="text-center font-weight-bold">Cs4014 Project</h1>
							<p class="text-center">Here is some place holder text for the future</p>
						</div>
					</div>
				</div>
			
				<!-- LOGIN, REGISTER BUTTONS & MODALS -->
				<div class="row">
					<div class="col-sm-12" id="login-form">

								<div class="row content-center"> 
									<div class="col-sm-3">
										<button type="button" class="btn btn-primary btn-block text-center" id="bt-register" data-toggle="modal" data-target="#regModal">Register</button>
									</div>
									<div class="col-sm-3">
										<button type="button" class="btn btn-block text-center" id="bt-login" data-toggle="modal" data-target="#loginModal">Login</button>
									</div>
								</div>
		

						<!-- Login Modal -->
						<div class="modal fade align-middle" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
						  	<div class="modal-dialog" role="login">
						  		<div class="modal-content">
						      		<div class="modal-body">
						        		
						      			<form method="POST" action="php/login.php">
						      				<div class="form-group">
						      					<label for="em">Email</label>
						      					<input type="email" class="form-control" name="em">
						      				</div>
						      				<div class="form-group">
						      					<label for="pw">Password</label>
						      					<input type="password" class="form-control" name="pw">
						      				</div>
						      				<div><hr></div>
						      				<button type="submit" class="form-control btn btn-outline-primary">Login</button>
						      			</form>

						      		</div>
						    	</div>
						  	</div>
						</div>

						<!-- Register Modal -->
						<div class="modal fade align-middle" id="regModal" tabindex="-1" role="dialog" aria-hidden="true">
						  	<div class="modal-dialog" role="register">
						  		<div class="modal-content">
						      		<div class="modal-body">
						        		
						      			<form method="POST" action="php/register.php">
						      				<div class="form-group">
						      					<label for="name">Name</label>
						      					<input type="text" class="form-control" name="name">
						      				</div>
						      				<div class="form-group">
						      					<label for="em">Email</label>
						      					<input type="email" class="form-control" name="em">
						      				</div>
						      				<div class="form-group">
						      					<label for="pw">Password</label>
						      					<input type="password" class="form-control" name="pw">
						      				</div>
						      				<div class="form-group">
						      					<label for="pw2">Confirm Password</label>
						      					<input type="password" class="form-control" name="pw2">
						      				</div>
						      				<div><hr></div>
						      				<button type="submit" class="form-control btn btn-outline-primary">Register</button>
						      			</form>

						      		</div>
						    	</div>
						  	</div>
						</div>
							
					</div>

				</div>

				

				<!-- Footer -->
				
		</div>

		<!-- Necessary JS files from CDN -->
		<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	</body>
</html>