<!DOCTYPE html>
<html>
<head>
	<title>login to myweb</title>
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
			$user_data = $user->getByName($_POST["username"]);
			// CHECK IF THE USER EXISTS
			if($user_data){
				echo "User exists!!<br>";
				$password = $_POST["password"];
				// CHECK IF THE PASSWORD IS CORRECT
				// REMEMBER: THIS FUNCTION WILL ONLY WORK IF YOU HASH YOUR PASSWORD WITH 'password_hash()' CHANGE IF USING DIFFERENT ALGORITHM
				if(password_verify($password, $user_data["password"])){
					echo "password is the same!<br>";
					// TODO: SAVE THE USER IN SESSION / COOKIES
					//PUT YOUR CODE HERE
					setcookie("username",$user_data["username"],time()+3600* 24);

					//
				}
				else{
					echo "password is not the same<br>";
				}
			}
			else{
				echo "user doesn't exist!!";
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
	</nav>
	<h1>Login</h1>
	<form action="login.php" method="POST">
		<label for="username">Username</label>
		<input type="string" name="username">
		<br>
		<label for="password">Password</label>
		<input type="password" name="password">
		<br>
		<button type="submit">login</button>
	</form>
	<p>If you don't have an account, <a href="register.php">Register here!</a></p>


	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>