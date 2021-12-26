<?php


//my connection for DB

	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "classes";

$dsn = "mysql:host=$server;dbname=$database;charset=UTF8";

$conn = new PDO($dsn, $username, $password);



class user {

	// toutes des VARCHAR en DB max 50

	private $id,$password,$conn;
	public $login,$email,$firstname,$lastname; 

	function __construct($conn){
		$this->conn=$conn;
			return $conn;
	}

//___________REGISTER____________________________________________________________

	function register($login,$password,$email,$firstname,$lastname){
		
		$conn=$this->conn;
		$sql = " INSERT INTO utilisateurs(login,password,email,firstname,lastname) VALUES (:login,:password,:email,:firstname,:lastname) ";
        $prepared = $conn->prepare($sql);
        $executed = $prepared->execute([':login'=> $login ,':password'=> $password,':email'=> $email,':firstname'=> $firstname,':lastname'=> $lastname]);

		echo '<table><tr>';
		$arr=[$login,$password,$email,$firstname,$lastname];
			foreach($arr as $k => $v){
				echo '<th>'.$v.'</th>';
			}
		echo '</tr></table>';
	}

//___________CONNECT________________________________________________________________

	function connect($login,$password){
		$this->login=$login;
		$this->password=$password;
		$conn=$this->conn;
		$login=$this->login;
		setcookie('connected', $login, time() +3600);
		$prepared = $conn->prepare("SELECT * FROM utilisateurs WHERE login = :login ");
		$prepared->execute(['login' => $login]); 
		$row = $prepared->fetch();
		$id=$row[0];
		$this->id=$id;
		echo 'this user is connected. ';

	}

//___________DISCONNECT_____________________________________________________________

	function disconnect(){
		$login=$this->login;
		setcookie('connected', $login, time() -3600);
		return false;
	}

//___________DELETE_________________________________________________________________

	function delete(){
		$id=$this->id;
		$conn=$this->conn;
		$login=$this->login;
		$prepared= $conn->prepare("DELETE FROM utilisateurs WHERE id = :id ");
		$prepared->execute(['id' => $id]); 
		setcookie('connected', $login, time() -3600);
	}

//___________UPDATE_________________________________________________________________

	function update($login,$password,$email,$firstname,$lastname){
			$id=$this->id;
			$conn=$this->conn;
			$prepared= $conn->prepare("UPDATE utilisateurs SET login = :login ,password = :password, email = :email, firstname = :firstname, lastname = :lastname WHERE id = :id ");
			$executed = $prepared->execute([':id'=> $id, ':login'=> $login ,':password'=> $password,':email'=> $email,':firstname'=> $firstname,':lastname'=> $lastname]);
			$login=$this->login;
			$password=$this->password;
			$email=$this->email;
			$firstname=$this->firstname;
			$lastname=$this->lastname;
	}
//___________IS CONNECTED___________________________________________________________

	function isConnected() {
		if(isset($_COOKIE['connected'])){
			return TRUE;
		}
	}

//___________GET ALL INFOS___________________________________________________________

	function getAllInfos(){
			$login=$this->login;
			$conn=$this->conn;
			$prepared=$conn->prepare("SELECT * FROM utilisateurs WHERE login = :login ");
			$prepared->execute(['login' => $login]); 
			$row = $prepared->fetch(PDO::FETCH_ASSOC);
			echo '<table>';
			foreach($row as $k=> $v){
				echo '<tr><td><b>'.$k.'</b></td>';
				echo '<td>'.$v.'</td></tr>';
			}
			echo '</table>';
	}

//___________GET LOGIN_______________________________________________________________

	function getLogin(){
		$login=$this->login;
		return $login;
	}

//___________GET EMAIL_______________________________________________________________

	function getEmail(){
		$login=$this->login;
		$conn=$this->conn;
		$prepared=$conn->prepare("SELECT email FROM utilisateurs WHERE login = :login ");
		$executed=$prepared->execute(['login' => $login]);
		$row = $prepared->fetch(PDO::FETCH_ASSOC);
		return $row['email'];
	}

//___________GET FIRSTNAME___________________________________________________________

	function getFirstname(){
		$login=$this->login;
		$conn=$this->conn;
		$prepared=$conn->prepare("SELECT firstname FROM utilisateurs WHERE login = :login ");
		$executed=$prepared->execute(['login' => $login]);
		$row = $prepared->fetch(PDO::FETCH_ASSOC);
		return $row['firstname'];
	}

//___________GET LASTNAME____________________________________________________________

	function getLastname(){
		$login=$this->login;
		$conn=$this->conn;
		$prepared=$conn->prepare("SELECT lastname FROM utilisateurs WHERE login = :login ");
		$executed=$prepared->execute(['login' => $login]);
		$row = $prepared->fetch(PDO::FETCH_ASSOC);
		return $row['lastname'];
	}

}

// INITIALISE NEW USER

//$billy=new User($conn);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>user1</title>
	<link rel="stylesheet" type="text/css" href="user.css">
</head>
<body>
<?php

// TESTS

//$billy->register('billy','1234', 'billy@billy.io','joe','billy');
//$billy->connect('billy','1234');
//echo $billy->isConnected();

?>
</body>
</html>