<?php
	require 'php/Database.php';

	//remove cookies after logout
	if (isset($_POST['logout'])) {
		setcookie('user_id', '', time()-3600);
	}

	// "database file doesnt exist"

	//$results = $db->get_countries();
	//$countries = $results[1];
?>

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
        <div class="container-fluid bg-home">

            <!--    Login in form  -->
                <div class="form-row" id="login">
                    <div class="col-sm-12">
                        <form class="form-inline" method="POST" action="php/login.php"> 
                            <div class="form-group">
                                <input type="email" name="emLog" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="password" name="pwLog" class="form-control" placeholder="Password">
                            </div>
                            
                                <button id="bt-login" class="btn btn-default">Login</button>
                        </form>
                    </div>
                </div>
    

                <!-- Decription of website -->
                <div class="row">
                    <div class="col-sm-12 content-center">
                        <div class="col-sm-10" id="main">
                            <h1 class="text-center font-weight-bold">Cs4014 Project</h1>
                            <p class="text-center">Here is some place holder text for the future</p>
                        </div>
                    </div>
                </div>
                            <!-- Register form -->

                <div class="row content-center" id="register"> 
                    <div class="col-sm-5">                      
                        
                        <form class="form" method="POST" action="php/register.php">
                            <div class="col-sm-12">
                               
                                    <!-- email -->
                                <div class="row"> 
                                    <div class="col-sm-6">
                                        <input class="form-control" type="email" name="em" placeholder="Email">      
                                    </div>
                                </div>
                                    <!-- password -->
                                <div class="row"> 
                                        <div class="col-sm-6">
                                            <input type="password" name="pw" placeholder="Password" class="form-control">
                                        </div>

                                        <div class="col-sm-6">
                                            <input type="password" name="cpw" placeholder="Confirm Password" class="form-control">
                                        </div>
                                </div>
                                    <!-- Name -->
                                <div class="row"> 
                                        <div class="col-sm-6">
                                            <input type="text" name="firstname" placeholder="Firstname" class="form-control">
                                        </div>

                                        <div class="col-sm-6">
                                            <input type="text" name="surname" placeholder="Surename" class="form-control">
                                        </div>
                                </div>
                                    <!-- Gender & DOB -->
                                <div class="row"> 
                                        <div class="col-sm-6">
                                            <select class="form-control" name="gender">
                                                <option> -- Sex --</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                                <option>Other</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-6">
                                            <input type="date" name="DOB" class="form-control">
                                        </div>
                                </div>
                                    <!-- City & Country -->
                                <div class="row">
                                        <div class="col-sm-6">
                                            <select class="form-control" name="city" >
                                                <option> -- Country --</option>
                                                <?php foreach ($countries as $value) {
                                                    print("<option>".$value."</option>");
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="city" >
                                                <option> -- City --</option>
                                                <option></option>
                                            </select>
                                        </div>                                        
                                </div>

                                <!-- Submit button -->
                            <input type="submit" class=" form-control btn btn-primary btn-block" id="bt-register">
                        </form>

                    </div>
                </div>
                
    
    

        </div>

		<!-- Necessary JS files from CDN -->
		<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	</body>
</html>