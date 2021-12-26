<?php


//my connection for DB

	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "classes";

$conn = new mysqli($server, $username, $password, $database);


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
		$conn->query("INSERT INTO utilisateurs (login,password,email,firstname,lastname) VALUES ('$login','$password','$email','$firstname','$lastname') ");

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
		$res=$conn->query("SELECT * FROM utilisateurs WHERE login ='$login'");
		$row=$res->fetch_row();
		$id=$row[0];
		$this->id=$id;

	}

//___________DISCONNECT_____________________________________________________________

	function disconnect(){
		$login=$this->login;
		setcookie('connected', $login, time() -3600);
		$conn=$this->conn;
		$conn->close();
		return false;
	}

//___________DELETE_________________________________________________________________

	function delete(){
		$id=$this->id;
		$conn=$this->conn;
		$login=$this->login;
		$conn->query("DELETE FROM utilisateurs WHERE login = '$id' ");
		setcookie('connected', $login, time() -3600);
		$conn->close();
	}

//___________UPDATE_________________________________________________________________

	function update($login,$password,$email,$firstname,$lastname){
			$id=$this->id;
			echo $id;
			$conn=$this->conn;
			$conn->query("UPDATE utilisateurs SET login = '$login',password = '$password', email = '$email', firstname = '$firstname', lastname = '$lastname' WHERE id = '$id' ");
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
			$result=$conn->query("SELECT * FROM utilisateurs WHERE login = '$login' ");
			$row=$result->fetch_row();
			echo '<table><tr>';
			foreach($row as $k=> $v){
				echo '<td>'.$v.'</td>';
			}
			echo '<table></tr>';
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
		$result=$conn->query("SELECT email FROM utilisateurs WHERE login = '$login' ");
		$email=$result->fetch_assoc();
		return $email['email'];
	}

//___________GET FIRSTNAME___________________________________________________________

	function getFirstname(){
		$login=$this->login;
		$conn=$this->conn;
		$result=$conn->query("SELECT firstname FROM utilisateurs WHERE login = '$login' ");
		$firstname=$result->fetch_assoc();
		return $firstname['firstname'];
	}

//___________GET LASTNAME____________________________________________________________

	function getLastname(){
		$login=$this->login;
		$conn=$this->conn;
		$result=$conn->query("SELECT lastname FROM utilisateurs WHERE login = '$login' ");
		$lastname=$result->fetch_assoc();
		return $lastname['lastname'];
	}

}

// INITIALISE NEW USER

$mina=new User($conn);

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

//$mina->register('mina','1234', 'mina@mina.io','etta','mina');
//$mina->connect('mina','1234');
//$mina->disconnect();
//echo $mina->getEmail();

?>
</body>
</html>