window.addEventListener("load", function() {
    let startTimes = {};
    let activityTotals = {};
    let currentActivity = null;

    // Modificamos la función recordTime para que verifique si la actividad ya tiene un tiempo registrado
    function recordTime(activity) {
        let currentTime = new Date();
        if (currentActivity && currentActivity !== activity) {
            let temp = `${currentActivity}StartTime`;
            if (temp !== "startStartTime"){
                let elapsedTime = calculateElapsedTime(startTimes[currentActivity], currentTime.getTime());
                activityTotals[currentActivity] = activityTotals[currentActivity] || 0;
                activityTotals[currentActivity] += elapsedTime;
                console.log(`Tiempo total de ${currentActivity}: ${formatTime(activityTotals[currentActivity])}`);
                let activityElement = document.getElementById(temp);
                if (activityElement) {
                    // activityElement.innerText = `Tiempo total de ${currentActivity}: ${formatTime(activityTotals[currentActivity])}`;
                    activityElement.innerText = `${formatTime(activityTotals[currentActivity])}`;
                }
            }
        }
        startTimes[activity] = currentTime.getTime();
        console.log(`Hora de ${activity}: ${currentTime.toLocaleTimeString()}`);
        let activityStartElement = document.getElementById(`${activity}StartTime`);
        if (activityStartElement) {
            // activityStartElement.innerText = `Hora de ${activity}: ${currentTime.toLocaleTimeString()}`;
            activityStartElement.innerText = `${currentTime.toLocaleTimeString()}`;
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
                // activityElement.innerText = `Tiempo total de ${currentActivity}: ${formatTime(activityTotals[currentActivity])}`;
                activityElement.innerText = `${formatTime(activityTotals[currentActivity])}`;
            }
            let totalTimeAllActivities = 0;
            for (const activity in activityTotals) {
                totalTimeAllActivities += activityTotals[activity];
                let temp = `${activity}StartTime`
                let activityElement = document.getElementById(temp);
                if (activityElement) {
                    if (temp != "startStartTime"){
                        let totalTime = activityTotals[activity] || 0;
                        // activityElement.innerText = `Tiempo total de ${activity}: ${formatTime(totalTime)}`;
                        activityElement.innerText = `${formatTime(totalTime)}`;
                    }
                }
            }
            console.log(`Tiempo total de todas las actividades: ${formatTime(totalTimeAllActivities)}`);
            let totalTimeElement = document.getElementById("totalTimeAllActivities");
            if (totalTimeElement) {
                // totalTimeElement.innerText = `Tiempo total de todas las actividades: ${formatTime(totalTimeAllActivities)}`;
                totalTimeElement.innerText = `${formatTime(totalTimeAllActivities)}`;
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
