// // Esperar a que la ventana se cargue completamente
// window.addEventListener("load", function() {
//   // Objeto para almacenar la hora de inicio de cada actividad
//   let startTimes = {};

//   // Variable para almacenar el tiempo total de todas las actividades
//   let totalTimeAllActivities = 0;

//   // Función para registrar la hora de inicio de una actividad
//   function recordTime(activity) {
//       let currentTime = new Date();
//       startTimes[activity] = currentTime.getTime();
//       console.log(`Tiempo de inicio de ${activity}: ${currentTime.toLocaleTimeString()}`);
//   }

//   // Función para calcular el tiempo transcurrido en segundos entre dos actividades
//   function calculateElapsedTime(previousActivity, currentActivity) {
//   let startTime = startTimes[previousActivity];
//   let endTime = startTimes[currentActivity] || new Date().getTime();
  
//   // Si no hay actividad siguiente, se calcula con la hora de parada
//   if (!startTimes[currentActivity] && currentActivity !== "stop") {
//       endTime = new Date().getTime();
//   }

//   return Math.max(Math.floor((endTime - startTime) / 1000), 0); // Devolver el tiempo máximo de 0 segundos si es negativo
// }


//   // Función para dar formato al tiempo en horas, minutos y segundos
//   function formatTime(seconds) {
//       let hours = Math.floor(seconds / 3600);
//       let minutes = Math.floor((seconds % 3600) / 60);
//       let remainingSeconds = seconds % 60;
//       return `${hours} horas ${minutes} minutos ${remainingSeconds} segundos`;
//   }

//   // Event listener para el botón de inicio
//   document.getElementById("startButton").addEventListener("click", function() {
//       // Limpiar el registro de tiempos
//       startTimes = {};
//       // Registrar la hora de inicio de la actividad "start"
//       recordTime("start");
//   });

//   let reunionInternaTotal = 0;
//   let reunionClienteTotal= 0;
//   let codigoTotal=0;
//   let noTrabajandoTotal=0;

//   // Función para registrar la hora de inicio de una actividad y calcular el tiempo total de la actividad anterior
//   function recordAndCalculateTime(activity) {
//       // Encontrar la actividad anterior
//       let previousActivity = Object.keys(startTimes).reverse().find(activity => activity !== "start");
//       // Si hay una actividad anterior, calcular y mostrar el tiempo total de esa actividad
//       if (previousActivity) {
//           let elapsedTime = calculateElapsedTime(previousActivity, "stop");
//           // Mostrar el tiempo total de la actividad anterior en la consola y en el HTML
//           console.log(`Tiempo total de ${previousActivity}: ${formatTime(elapsedTime)}`);
//           document.getElementById(`${previousActivity}Time`).innerText = `Tiempo total de ${previousActivity}: ${formatTime(elapsedTime)}`;
//           // Actualizar el tiempo total de todas las actividades
//           totalTimeAllActivities += elapsedTime;
//       }
//       // Registrar la hora de inicio de la actividad actual
//       recordTime(activity);
      
//       // Si la actividad actual es "stop", calcular y mostrar el tiempo total de la última actividad

//   }

//   // Event listeners para los botones de las diferentes actividades
//   document.getElementById("reunionInternaButton").addEventListener("click", function() {
//       recordAndCalculateTime("reunionInterna");
//   });

//   document.getElementById("noTrabajandoButton").addEventListener("click", function() {
//       recordAndCalculateTime("noTrabajando");
//   });

//   document.getElementById("reunionClienteButton").addEventListener("click", function() {
//       recordAndCalculateTime("reunionCliente");
//   });

//   document.getElementById("codigoButton").addEventListener("click", function() {
//       recordAndCalculateTime("codigo");
//   });

//   // Event listener para el botón de parar
//   document.getElementById("stopButton").addEventListener("click", function() {
//       // Registrar la hora de parada
//       let stopTime = new Date().getTime();
//       console.log(`Hora de Stop: ${new Date(stopTime).toLocaleTimeString()}`);
//       // Calcular y mostrar el tiempo total de todas las actividades en la consola y en el HTML
//       let totalTime = Math.floor((stopTime - startTimes["start"]) / 1000); // Convertir el tiempo total a segundos como número entero
//       console.log(`Tiempo total de todas las actividades: ${formatTime(totalTime)}`);
//       document.getElementById("totalTime").innerText = `Tiempo total de todas las actividades: ${formatTime(totalTime)}`;

//         let lastActivity = Object.keys(startTimes).reverse()[0];
//         let elapsedTime = calculateElapsedTime(lastActivity, "stop");
//         console.log(`Tiempo total de ${lastActivity}: ${formatTime(elapsedTime)}`);
//         document.getElementById(`${lastActivity}Time`).innerText = `Tiempo total de ${lastActivity}: ${formatTime(elapsedTime)}`;

      
//   });

// });

window.addEventListener("load", function() {
    let startTimes = {};
    let activityTotals = {};
    let currentActivity = null;

    // Modificamos la función recordTime para que verifique si la actividad ya tiene un tiempo registrado
    function recordTime(activity) {
        let currentTime = new Date();
        if (currentActivity && currentActivity !== activity) {
            let elapsedTime = calculateElapsedTime(startTimes[currentActivity], currentTime.getTime());
            activityTotals[currentActivity] = activityTotals[currentActivity] || 0;
            activityTotals[currentActivity] += elapsedTime;
            console.log(`Tiempo total de ${currentActivity}: ${formatTime(activityTotals[currentActivity])}`);
            let activityElement = document.getElementById(`${currentActivity}StartTime`);
            if (activityElement) {
                activityElement.innerText = `Tiempo total de ${currentActivity}: ${formatTime(activityTotals[currentActivity])}`;
            }
        }
        startTimes[activity] = currentTime.getTime();
        console.log(`Hora de ${activity}: ${currentTime.toLocaleTimeString()}`);
        let activityStartElement = document.getElementById(`${activity}StartTime`);
        if (activityStartElement) {
            activityStartElement.innerText = `Hora de ${activity}: ${currentTime.toLocaleTimeString()}`;
        }
        currentActivity = activity;
        // Verificamos si la actividad actual no tiene un tiempo registrado, lo establecemos en 0
        activityTotals[currentActivity] = activityTotals[currentActivity] || 0;
    }

    function calculateElapsedTime(startTime, endTime) {
        return Math.max(Math.floor((endTime - startTime) / 1000), 0);
    }

    function formatTime(seconds) {
        let hours = Math.floor(seconds / 3600);
        let minutes = Math.floor((seconds % 3600) / 60);
        let remainingSeconds = seconds % 60;
        return `${hours} horas ${minutes} minutos ${remainingSeconds} segundos`;
    }

    function formatDateTime(date) {
        // return date.toISOString().slice(0, 19).replace('T', ' '); // Formato: YYYY-MM-DD HH:MM:SS
        const original_time = date;
        original_time.setMinutes(date.getMinutes() - date.getTimezoneOffset()); //Get timezone difference since ISOString in UTC timezone
        return isostring = original_time.toISOString().slice(0, 19).replace('T', ' '); // Formato: YYYY-MM-DD HH:MM:SS
    }

    function guardarTiempo(activityTotals) {
        let startDateTime = formatDateTime(new Date(startTimes.start));
        let stopDateTime = formatDateTime(new Date());
        let actividades = ["reunionCliente", "reunionInterna", "codigo", "noTrabajando"];
        let dataToSend = {};
        dataToSend.start = { action: 'start', time: startDateTime };
        
        for (let i = 0; i < actividades.length; i++) {
            let actividad = actividades[i];
            let totalTime = activityTotals[actividad] || 0;
            dataToSend[actividad] = { action: actividad, totalTime: totalTime };
        }
        
        dataToSend.stop = { action: 'stop', time: stopDateTime};
        
        console.log('Datos a enviar por POST:', dataToSend);
        
        let jsonData = JSON.stringify(dataToSend);
        console.log('Datos jsonData:', jsonData);
        
        fetch('?command=time', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: jsonData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            console.log('Respuesta del servidor:', response);
            return response.text();
        })
        .then(jsonData => {
            console.log('Respuesta del servidor jsonData (texto):', jsonData);
        })
        .catch(error => {
            console.error('Error al enviar la solicitud:', error);
        });
    }
    
    
    
    

    document.getElementById("timeForm").addEventListener("click", function(event) {
        let target = event.target;
        console.log("Clicked button:", target.id);
        if (target.matches('.action-button')) {
            let activity = target.id.replace("Button", "");
            console.log("Activity:", activity);
            recordTime(activity);
        }
    });

    document.getElementById("stopButton").addEventListener("click", function() {
        let stopTime = new Date().getTime();
        if (currentActivity) {
            let elapsedTime = calculateElapsedTime(startTimes[currentActivity], stopTime);
            activityTotals[currentActivity] = activityTotals[currentActivity] || 0;
            activityTotals[currentActivity] += elapsedTime;
            console.log(`Tiempo total de ${currentActivity}: ${formatTime(activityTotals[currentActivity])}`);
            let activityElement = document.getElementById(`${currentActivity}StartTime`);
            if (activityElement) {
                activityElement.innerText = `Tiempo total de ${currentActivity}: ${formatTime(activityTotals[currentActivity])}`;
            }
            let totalTimeAllActivities = 0;
            for (const activity in activityTotals) {
                totalTimeAllActivities += activityTotals[activity];
                let activityElement = document.getElementById(`${activity}StartTime`);
                if (activityElement) {
                    let totalTime = activityTotals[activity] || 0;
                    activityElement.innerText = `Tiempo total de ${activity}: ${formatTime(totalTime)}`;
                }
            }
            console.log(`Tiempo total de todas las actividades: ${formatTime(totalTimeAllActivities)}`);
            let totalTimeElement = document.getElementById("totalTimeAllActivities");
            if (totalTimeElement) {
                totalTimeElement.innerText = `Tiempo total de todas las actividades: ${formatTime(totalTimeAllActivities)}`;
            }
            guardarTiempo(activityTotals); // Llamamos a guardarTiempo() antes de restablecer los totales de tiempo a cero
            startTimes = {};
            activityTotals = {};
            currentActivity = null;
        } else {
            console.error("Error: No se recibió ninguna actividad.");
        }
    });
});
