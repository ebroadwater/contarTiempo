<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tiempo de Trabajo Sign Up</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
	<h1 style="text-align:center;">Sign Up</h1>
	<div class="signup-container">
		<form action="?command=signup" method="post" class="signup-form">
			<!-- Name input -->
			<div>
				<strong>Name: </strong><input type="text" class="form-control" name = "name" 
					placeholder="Name" required/>
			</div>

			<!-- Email input -->
			<div>
				<strong>Email: </strong><input type="email" name="email" class="form-control" 
					placeholder="Enter a valid email address" required/>
			</div>
	
			<!-- Password input -->
			<div>
				<strong>Password: </strong><input type="password" name="password" class="form-control" 
					placeholder="Enter password" required/>
			</div>

			<!-- Re-Type Password input -->
			<div>
				<strong>Confirm Password: </strong><input type="password" class="form-control" name="re-password" 
					placeholder="Re-type password" required/>
			</div>
			<div>
				<p>
					<button type="submit" class="button"name="signup">Sign Up</button>
					<input type="submit" class="button cancel" name="cancel" value="Cancel">
				</p>
				
				<p class="small-text">Already have an account? <a href="?command=login" class="link-primary">Login</a></p>
			</div>
		</form>
	</div>
</body>
</html>