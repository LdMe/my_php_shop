<!DOCTYPE html>
<html>
<head>
	<title>register to myweb</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/142274cc7f.js" crossorigin="anonymous"></script>
	<style type="text/css">
		#loginButton {
			float: right;
		}
	</style>
</head>
<body>

	<?php
	include_once("user.php");
	if(!empty($_POST)){
		try {
			$user = new User();
			if(isset($_POST["username"])){

			// IF USER EXISTS, WE DON'T CREATE A NEW ONE
				if($user->getByName($_POST["username"])){
					echo "User exists!!<br>";
				}
			// IF THE USER DOESN'T EXIST, WE CHECK ALL THE VALUES (PASSWORD, EMAIL...) AND INSERT A NEW USER
				else{
					echo "user doesn't exist!!<br>";
				// TODO: CHECK EMAIL, PASSWORDS, ETC. AND HASH PASSWORD!!!
				//PUT YOUR CODE HERE:


				//
					$columns= ["username","password","email","admin"];
					$values = [$_POST["username"],$_POST["password"],$_POST["email"],0];
					$user->insert($values,$columns);
					echo "user created!<br>";
				}
			}
		} catch (Exception $e) {
			echo "Error connecting to database<br>";
		}
		
	}
	?>


	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="index.php">
			<i class="fas fa-store-alt"></i>
			myShop
		</a>
		<a id="loginButton" href="login.php">login</a>
	</nav>
	<h1>Register</h1>
	<form action="register.php" method="POST">
		<label for="username">Username</label>
		<input type="string" name="username">
		<br>
		<label for="email">Email</label>
		<input type="string" name="email">
		<br>
		<label for="password">password</label>
		<input type="string" name="password">
		<br>
		<label for="password_confirm">Confirm password</label>
		<input type="string" name="password_confirm">
		<br>
		<button type="submit">register</button>
	</form>
	<p>If you already have an account, <a href="login.php">Log in here</a></p>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>