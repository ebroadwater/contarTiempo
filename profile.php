<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contar Tiempo Profile</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
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
    <h1>Time Log</h1>
	<div style="margin-top:25px;">
		<table>
			<tr>
				<th>Start Time</th>
				<th>Stop Time</th>
				<th>Reunion Interna</th>
				<th>Reunion Cliente</th>
				<th>Código</th>
				<th>No Trabajando</th>
			</tr>
			<!-- display all previous recorded times -->
			<div class="history">
				<?=$all_times?>
			</div>
		</table>
	</div>
</body>
</html>