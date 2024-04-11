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
    <div>
        <a href="?command=signup">Sign Up</a>
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
        <div id="startSeconds"></div>
        <div id="reunionInternaTime"></div>
        <div id="noTrabajandoTime"></div>
        <div id="reunionClienteTime"></div>
        <div id="codigoTime"></div>
        <div id="startTotalTime"></div>
		<div id="startTotalTime"></div>// prueba
    </div>
</body>
</html>