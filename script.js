window.addEventListener("load", function() {
    let startTime = {}; // Objeto para almacenar la hora de inicio de cada actividad
  
    // Función para almacenar la hora actual en la memoria local
    function recordTime(activity) {
      let currentTime = new Date().getTime();
      localStorage.setItem(activity, currentTime);
      console.log(`Tiempo de ${activity}: ${new Date(currentTime).toLocaleTimeString()}`);
    }
  
    // Función para calcular el tiempo transcurrido en segundos para una actividad
    function calculateElapsedTime(activity) {
      let startTime = localStorage.getItem(activity);
      if (!startTime) return 0; // Si no se ha registrado ninguna hora de inicio, el tiempo es cero
      let currentTime = new Date().getTime();
      return Math.floor((currentTime - startTime) / 1000); // Convertir milisegundos a segundos
    }
  
    // Función para mostrar el tiempo transcurrido en formato de horas, minutos y segundos
    function formatTime(seconds) {
      let hours = Math.floor(seconds / 3600);
      let minutes = Math.floor((seconds % 3600) / 60);
      let remainingSeconds = seconds % 60;
      return `${hours} horas ${minutes} minutos ${remainingSeconds} segundos`;
    }
  
    // Event listeners para los botones
    document.getElementById("startButton").addEventListener("click", function() {
      for (let activity in localStorage) {
        if (localStorage.hasOwnProperty(activity)) {
          localStorage.removeItem(activity); // Limpiar la memoria local de todas las actividades
        }
      }
      recordTime("start");
    });
  
    document.getElementById("reunionInternaButton").addEventListener("click", function() {
      recordTime("reunionInterna");
    });
  
    document.getElementById("noTrabajandoButton").addEventListener("click", function() {
      recordTime("noTrabajando");
    });
  
    document.getElementById("reunionClienteButton").addEventListener("click", function() {
      recordTime("reunionCliente");
    });
  
    document.getElementById("codigoButton").addEventListener("click", function() {
      recordTime("codigo");
    });
  
    document.getElementById("stopButton").addEventListener("click", function() {
      let totalSeconds = 0;
      let activities = ["reunionInterna", "noTrabajando", "reunionCliente", "codigo"];
      for (let activity of activities) {
        let seconds = calculateElapsedTime(activity);
        let element = document.getElementById(`${activity}Time`);
        if (element) { // Verificar si el elemento existe antes de establecer su texto interno
          element.innerText = `Tiempo de ${activity}: ${formatTime(seconds)}`;
          console.log(`Tiempo de ${activity}: ${formatTime(seconds)}`);
        }
        totalSeconds += seconds;
      }
      let startSeconds = calculateElapsedTime("start");
      let startTotalElement = document.getElementById("startTotalTime");
      if (startTotalElement) { // Verificar si el elemento existe antes de establecer su texto interno
        startTotalElement.innerText = `Tiempo total de todas las actividades: ${formatTime(startSeconds)}`;
        console.log(`Tiempo total de todas las actividades: ${formatTime(startSeconds)}`);
      }
      totalSeconds += startSeconds;
      let totalTimeElement = document.getElementById("totalTime");
      if (totalTimeElement) { // Verificar si el elemento existe antes de establecer su texto interno
        totalTimeElement.innerText = `Tiempo total: ${formatTime(totalSeconds)}`;
        console.log(`Tiempo total: ${formatTime(totalSeconds)}`);
      }
    });
});


  
  
  