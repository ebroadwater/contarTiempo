<?php

class TimeController {
	private $input = [];

	// private $pdo;
	/**
     * Constructor
     */
    public function __construct($input) {
        session_start();

		// $this->db = new Database();
        
		$this->pdo = new PDO('mysql:host=localhost;port=8889;dbname=contarTiempo', 'root', 'root');
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
		unset( $_SESSION["message"] );
		$salt = 'XyZzy12*_';

		if(isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["password"]) &&
            isset($_POST["re-password"]) && !empty($_POST["re-password"]) && isset($_POST["name"]) && !empty($_POST["name"])) {
                // Check if user is in database
                // $res = $this->db->query("select * from users where email = $1;", $_POST["email"]);

				$stmt = $this->pdo->prepare('SELECT * FROM Usuario WHERE email= :em');
				$stmt->execute(array(
					':em' => $_POST['email']
				));
				// User was in the database, verify password
                if (!empty($res)){
                    $message = "User with email ".$_POST["email"]." already exists. Please log in.";
                } else{
                    // User was not there, so insert them
                    //Check passwords match
                    if ($_POST["password"] !== $_POST["re-password"]) {
                        $message = "Passwords must match";
                    }else{
						$hash = hash('md5', $salt.$_POST['password']);
                        $stmt = $this->pdo->prepare("INSERT INTO Usuario (name, email, password) values (:na, :em, :pwd);");
						$stmt->execute(array(
							':na' => $_POST['name'], 
							':em' => $_POST['email'], 
							':pwd' => $hash
						));

                        $_SESSION["name"] = $_POST["name"];
                        $_SESSION["email"] = $_POST["email"];

                        // Send user to the appropriate page
                        header("Location: ?command=home");
                        return;
                    }
                }
        } else {
            if (isset($_POST["signup"]) && !empty($_POST["signup"])){
                $message = "All fields are required.";
            }
        }
        $_SESSION["message"] = $message;
		$this->showSignUp($message);
	}
}