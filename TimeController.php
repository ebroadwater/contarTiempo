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
			case "login":
				$this->login();
				break;
			case "logout":
				$this->logout();
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
	public function showSignUp($message = ""){
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

				$res = $this->pdo->prepare('SELECT * FROM Usuario WHERE email= :em');
				$res->execute(array(
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
	public function showLogin($message = ""){
		include("login.php");
	}
	public function login(){
		$message = "";
        unset( $_SESSION["message"] );
		$salt = 'XyZzy12*_';

		if(isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["password"])) {
            $check = hash('md5', $salt.$_POST['password']);
			$stmt = $this->pdo->prepare('SELECT * FROM Usuario WHERE email=:em AND password=:pw');
			$stmt->execute(array(
				':em' => $_POST['email'], 
				':pw' => $check
			));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($row !== false){
				$_SESSION['name'] = $row['name'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['user_id'] = $row['user_id'];

				header("Location: ?command=home");
				return;
			}
			else{
				$message = "Incorrect email or password";
			}
        } else {
            if (isset($_POST["login"]) && !empty($_POST["login"])){
                $message = "Email and password are required.";
            }
        }
        $_SESSION["message"] = $message;

		$this->showLogin($message);
	}
	public function logout() {
        session_destroy();
        session_start();
        // header("Location: /wur7ua/hw5/");
        $this->showHome();
    }
}