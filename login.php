<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Contar Tiempo Login</title>
    <link rel="stylesheet" href="styles.css">
    <!-- <script src="script.js" defer></script> -->
</head>
<body>
    <div class="navbar">
		<h3>Contar Tiempo</h3>
        <a href="?command=home">Home</a>
		<?php 
			if (isset($_SESSION["email"]) && isset($_SESSION['name'])){
				echo "<a href='?command=profile'>Profile</a>";
				echo "<a href='?command=logout'>Log Out</a>";
				echo "<a style='color:#008bba8f;'>".$_SESSION["name"]."</a>";
			}
			else{
				echo "<a href='?command=signup'>Sign Up</a>";
				echo "<a href='?command=login'>Log In</a>";
			}
        ?>
	</div>
    <h1 style="text-align:center;">Log In</h1>
	<div>
		<?php
			if (isset($_SESSION["message"]) && !empty($_SESSION["message"])){
				echo "<div class='alert-message'><p>".$_SESSION["message"]."</p></div>";
				unset($_SESSION["message"]);
			}
		?>
	</div>
	<div class="signup-container">
		<form action="?command=login" method="post" class="signup-form">
			<!-- Email input -->
			<div>
				<strong>Email: </strong><input type="email" name="email" class="form-control" 
					placeholder="Enter your email address" required/>
			</div>
	
			<!-- Password input -->
			<div>
				<strong>Password: </strong><input type="password" name="password" class="form-control" 
					placeholder="Enter password" required/>
			</div>
			<div>
				<p>
					<button type="submit" class="button"name="login">Log In</button>
				</p>
				
				<p class="small-text">Don't have an account? <a href="?command=signup" class="link-primary">Sign Up</a></p>
			</div>
		</form>
	</div>
</body>
</html>