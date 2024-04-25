<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuramos la salida para que sea JSON
header('Content-Type: application/json');

// Comprobar si se recibió algún dato en el POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener el contenido del cuerpo de la solicitud POST
    $postData = file_get_contents("php://input");

    // Decodificar los datos JSON en un array asociativo
    $requestData = json_decode($postData, true);

    // Verificar los datos recibidos
    echo "Datos recibidos:\n";
    var_dump($requestData);

    // Comprobar si se recibieron los datos de las actividades
    if (!empty($requestData)) {
        // Establecer la conexión a la base de datos
        $pdo = new PDO('mysql:host=localhost;port=8889;dbname=contarTiempo', 'root', 'root');

        $time_id; 
        // Iterar sobre los datos recibidos y procesar cada actividad
        foreach ($requestData as $activity => $activityData) {
            switch ($activity) {
                case 'start':
                    // Procesar actividad de inicio
                    $response['start'] = guardarInicio($pdo, $activityData['time']);
                    $time_id = $pdo->lastInsertId();
                    break;
                case 'reunionCliente':
                    // Procesar actividad de reunión con cliente
                    $response['reunionCliente'] = guardarReunionCliente($pdo, $activityData['totalTime'], $time_id);
                    break;
                case 'reunionInterna':
                    // Procesar actividad de reunión interna
                    $response['reunionInterna'] = guardarReunionInterna($pdo, $activityData['totalTime'], $time_id);
                    break;
                case 'codigo':
                    // Procesar actividad de código
                    $response['codigo'] = guardarCodigo($pdo, $activityData['totalTime'], $time_id);
                    break;
                case 'noTrabajando':
                    // Procesar actividad de no trabajando
                    $response['noTrabajando'] = guardarNoTrabajando($pdo, $activityData['totalTime'], $time_id);
                    break;
                case 'stop':
                    // Procesar actividad de parada
                    $response['stop'] = guardarStop($pdo, $activityData['time'], $time_id);
                    break;
                default:
                    // Acción desconocida
                    break;
            }
        }
    } else {
        $response['error'] = "Error: No se recibieron datos de actividades.";
    }
} else {
    $response['error'] = "Error: Método de solicitud no válido.";
}

// Devolver la respuesta como JSON
echo json_encode($response);

function guardarInicio($pdo, $startTime) {
    // Registro de depuración
    echo "Guardando inicio: $startTime\n";
	//User_id
	$user_id = $_SESSION["user_id"];
    
	try {
		$stmt = $pdo->prepare("INSERT INTO Tiempo (start_time, user_id) VALUES (:st, :ui);");
		$stmt->execute(array(
			':st' => $startTime,
			':ui' => $user_id
		));
        return "Hora de inicio registrada correctamente";
    } catch (PDOException $e) {
        return "Error al ejecutar la consulta: " . $e->getMessage();
    }
}

function guardarReunionInterna($pdo, $totalTime, $time_id) {
    // Registro de depuración
    echo "Guardando reunión interna: $totalTime\n";
    
    $formattedTime = gmdate("H:i:s", $totalTime); // Convert seconds to timestamp  
    $sql = "UPDATE tiempo SET reunion_interna = ? WHERE time_id = $time_id";
    return ejecutarConsulta($pdo, $sql, $formattedTime, "Tiempo de reunión interna registrado correctamente");
}

function guardarReunionCliente($pdo, $totalTime, $time_id) {
    // Registro de depuración
    echo "Guardando reunión con cliente: $totalTime\n";
    
    $formattedTime = gmdate("H:i:s", $totalTime); // Convert seconds to timestamp  
    $sql = "UPDATE tiempo SET reunion_cliente = ? WHERE time_id = $time_id";
    return ejecutarConsulta($pdo, $sql, $formattedTime, "Tiempo de reunión con el cliente registrado correctamente");
}

function guardarCodigo($pdo, $totalTime, $time_id) {
    // Registro de depuración
    echo "Guardando código: $totalTime\n";
    
    $formattedTime = gmdate("H:i:s", $totalTime); // Convert seconds to timestamp  
    $sql = "UPDATE tiempo SET codigo = ? WHERE time_id = $time_id";
    return ejecutarConsulta($pdo, $sql, $formattedTime, "Tiempo dedicado a escribir código registrado correctamente");
}

function guardarNoTrabajando($pdo, $totalTime, $time_id) {
    // Registro de depuración
    echo "Guardando no trabajando: $totalTime\n";
    
    $formattedTime = gmdate("H:i:s", $totalTime); // Convert seconds to timestamp  
    $sql = "UPDATE tiempo SET no_trabajando = ? WHERE time_id = $time_id";
    return ejecutarConsulta($pdo, $sql, $formattedTime, "Tiempo de no trabajando registrado correctamente");
}

function guardarStop($pdo, $stopTime, $time_id) {
    // Registro de depuración
    echo "Guardando parada: $stopTime\n";

    $sql = "UPDATE tiempo SET stop_time = ? WHERE time_id = $time_id";
    return ejecutarConsulta($pdo, $sql, $stopTime, "Tiempo de parada registrado correctamente");
}

function ejecutarConsulta($pdo, $sql, $parametro, $successMessage) {
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $parametro);
        $stmt->execute();
        return $successMessage;
    } catch (PDOException $e) {
        return "Error al ejecutar la consulta: " . $e->getMessage();
    }
}

