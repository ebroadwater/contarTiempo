<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiempo de Trabajo</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="navbar">
		<h3>Contar Tiempo</h3>
        <a href="?command=home">Home</a>
		<?php 
			if (isset($_SESSION["email"]) && isset($_SESSION['name'])){
				echo "<a href='?command=logout'>Log Out</a>";
				echo "<a style='color:#008bba8f;'>".$_SESSION["name"]."</a>";
			}
			else{
				echo "<a href='?command=signup'>Sign Up</a>";
				echo "<a href='?command=login'>Log In</a>";
			}
        ?>
	</div>
    <div class="countTimeContainer">
        <div>
            <h3>Contar Tiempo</h3>
        </div>
        <div class="btn boton-start">
            <button id="startButton">Start</button>
        </div>
        <div class="btn boton-reunion-interna">
            <button id="reunionInternaButton">Reunión Interna</button>
        </div>
        <div class="btn boton-no-trabajando">
            <button id="noTrabajandoButton">No Trabajando</button>
        </div>
        <div class="btn boton-reunion-cliente">
            <button id="reunionClienteButton">Reunión Cliente</button>
        </div>
        <div class="btn boton-codigo">
            <button id="codigoButton">Código</button>
        </div> 
        <div class="btn boton-stop">
            <button id="stopButton">Stop</button>
        </div>
    </div>
    <div>
        <div id="registroHoras"></div>
        <div id="segundos"></div>
        <div id="reunionInternaTime"></div>
        <div id="noTrabajandoTime"></div>
        <div id="reunionClienteTime"></div>
        <div id="codigoTime"></div>
        <div id="startTotalTime"></div>
        <div id="totalTime"></div> 
    </div>
</body>
</html>