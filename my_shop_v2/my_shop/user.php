<?php

include_once("dbManager.php");

class User {
	private $username;
	private $password;
	private $email;
	private $admin;
	private static $dbManager=null;
	private function __construct($username="",$password="",$email="",$admin=0){
		$this->setUsername($username);
		$this->setPassword($password);
		$this->setEmail($email);
		$this->setAdmin($admin);
		

	}
	public static function initialize(){
		if(!self::$dbManager){
			self::$dbManager=  new DBManager("users");
		}
		
	}
	// YOU CAN CHANGE THIS FUNCTION TO GET USERS BY EMAIL OR ANY OTHER FIELD
	// THIS FUNCTION WILL RETURN ONLY ONE RESULT (DBManager::getByCol returns only one result)
	// IF YOU WANT MORE THAN ONE RESULT, YOU SHOULD COPY THAT FUNCTION AND CHANGE 'fetch' BY 'fetchAll'
	
	public function insert(){
		$columns =[];
		$values = [];
		foreach (get_object_vars($this) as $key => $value) {
			if($key=="dbManager"){
				continue;
			}
			$columns[]=$key;
			$values[]=$value;
		}
		var_dump($columns);
		var_dump($values);
		
		self::$dbManager->insert($values,$columns);
	}
	public static function _create($username,$password,$email,$admin=0){
		self::initialize();
		$user = new User($username,$password,$email,$admin);
		$user->insert();
		return $user;
	}
	public static function _getById($id){
		self::initialize();
		$user = new User();
		return $user->getById($id);
	}
	public function getById($id){
		$user_data = self::$dbManager->getById($id);
		if($user_data){
			$this->setUsername($user_data["username"]);
			$this->setEmail($user_data["email"]);
			$this->setPassword($user_data["password"]);
			$this->setAdmin($user_data["admin"]);
			return $this;
		}
		return null;
	}

	public static function _getByName($name){
		self::initialize();
		$user = new User();
		return $user->getByName($name);
	}
	public function getByName($name,$select="*"){
		// DEPENDING ON YOUR DATABASE YOU SHOULD CHANGE 'username' TO 'user'
		$user_data = self::$dbManager->getByCol("username",$name,$select);
		if($user_data){
			$this->setUsername($user_data["username"]);
			$this->setEmail($user_data["email"]);
			$this->setPassword($user_data["password"]);
			$this->setAdmin($user_data["admin"]);
			return $this;
		}
		return null;
	}
	public static function _getAll($object=true){
		self::initialize();
		$user = new User();
	
		return $user->getAll($object);
	}
	public function getAll($object=true){
		$user_array= self::$dbManager->getAll();
		$users = [];
		if(!$object){
			return $user_array;
		}
		foreach ($user_array as $user_data) {
			
			$new_user = new User();
			
			$users[]=$new_user->setFromArray($user_data);
		}
		return $users;
	}
	public function setFromArray($user_data){
		if($user_data){
			$this->setUsername($user_data["username"]);
			$this->setEmail($user_data["email"]);
			$this->setPassword($user_data["password"]);
			$this->setAdmin($user_data["admin"]);
			return $this;
		}
		return null;
	}
	public static function _delete($id){
		
	}
	public function getUsername(){
		return $this->name;
	}
	public function getPassword()
	{
		return $this->password;
	}
	public function getEmail(){
		return $this->email;
	}
	public function isAdmin(){
		return $this->admin;
	}

	public function setUsername($name){
		$this->username = $name;
	}

	public function setEmail($email){
		$this->email = $email;
	}
	public function setPassword($password){
		$this->password = password_hash($password, PASSWORD_DEFAULT);
	}
	public function setAdmin($admin){
		$this->admin = $admin;
	}

}

//      TEST   
//-----initialize database manager  

//$date = date('Y/m/d');
//$dbm = new User();
//var_dump($dbm->getByName("Martin"));
//-----get user by id
//var_dump($dbm->getById(4));

//-----get all users
//var_dump($dbm->getAll());

//-----modify user by id
//$dbm->updateById(1,["name","password"],["Pedro",password_hash("password", PASSWORD_DEFAULT)]);

//----insert user
/*
$columns = Array("name","password","email","created_at","is_admin");
$values = Array("new user","pass","mymail.com",$date,0);
$dbm->insert($values,$columns);
*/

//----delete user
//$dbm->deleteById(9);
var_dump(User::_getAll(true));