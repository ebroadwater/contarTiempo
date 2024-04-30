<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contar Tiempo</title>
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
    <?php
        if (!isset($_SESSION["email"]) && !isset($_SESSION["user_id"])){
            echo "<div class='alert-message'><p>Please log in to save these values</p></div>";
        }
    ?>
    <!-- <div class="countTimeContainer">
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
    </div> -->
    <form id="timeForm" method="post" action="?command=time">
        <div class="countTimeContainer">
            <div>
                <h3>Contar Tiempo</h3>
            </div>
            <div class="btn boton-start">
                <input type="button" id="startButton" name="activity" value="start" class="action-button"/>
            </div>
            <div class="btn boton-reunion-interna">
                <input type="button" id="reunionInternaButton" name="activity" value="reunionInterna" class="action-button"/>
            </div>
            <div class="btn boton-no-trabajando">
                <input type="button" id="noTrabajandoButton" name="activity" value="noTrabajando" class="action-button"/>
            </div>
            <div class="btn boton-reunion-cliente">
                <input type="button" id="reunionClienteButton" name="activity" value="reunionCliente" class="action-button"/>
            </div>
            <div class="btn boton-codigo">
                <input type="button" id="codigoButton" name="activity" value="codigo" class="action-button"/>
            </div>
            <div class="btn boton-stop">
                <input type="button" id="stopButton" name="activity" value="stop" class="action-button"/>
            </div>
        </div>
    </form>
    <!-- <div>
        <div id="startStartTime"></div>
        <div id="reunionInternaStartTime"></div>
        <div id="noTrabajandoStartTime"></div>
        <div id="reunionClienteStartTime"></div>
        <div id="codigoStartTime"></div>
        <div id="stopStartTime"></div>
        <div id="totalTimeAllActivities"></div>
    </div> -->
    <div class="finalTotal">
        <div class="square">
            <h4>Start Time and Stop Time</h4>
            <p id="startStartTime"></p>
            <p id="stopStartTime"></p>
        </div>
        <div class="square">
            <h4>Reunion Interna</h4>
            <p id="reunionInternaStartTime"></p>
        </div>
        <div class="square">
            <h4>No Trabajando</h4>
            <p id="noTrabajandoStartTime"></p>
        </div>
        <div class="square">
            <h4>Reunion Cliente</h4>
            <p id="reunionClienteStartTime"></p>
        </div>
        <div class="square">
            <h4>Código</h4>
            <p id="codigoStartTime"></p>
        </div>
        <div class="square">
            <h4>Total Time of Activities</h4>
            <p id="totalTimeAllActivities"></p>
        </div>
        <!-- <div class="square">
            <div id="stopStartTime"></div>
        </div> -->
    </div>
</body>
</html>