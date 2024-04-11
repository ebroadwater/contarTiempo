<?php

class TimeController {
	private $input = [];

	/**
     * Constructor
     */
    public function __construct($input) {
        session_start();
		
		$pdo = new PDO('mysql:host=localhost;port=8889;dbname=contarTiempo', 'root', 'root');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// $this->db = new Database();
        
        $this->input = $input;
        //$this->loadCategories();
    }
	/**
     * Run the server
     * 
     * Given the input (usually $_GET), then it will determine
     * which command to execute based on the given "command"
     * parameter.  Default is the welcome page.
     */
	public function run() {
        // Get the command
		$command = "home";
		if (isset($this->input["command"]))
			$command = $this->input["command"];

		switch($command) {
			case "signup":
				$this->signup();
				break;
			default:
				$this->showHome();
				break;
		}
    }
	public function showHome(){
		// include("/opt/src/Web-PL-Project/home.php");
        include("home.php");
	}
	public function showSignUp(){
		include("signup.php");
	}
	public function signup(){
		$message = "";
		
		$this->showSignUp($message);
	}
}