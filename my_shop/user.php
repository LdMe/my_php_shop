<?php

include_once("dbManager.php");

class User extends DBManager {
	public function __construct(){
		parent::__construct("users");
	}
	// YOU CAN CHANGE THIS FUNCTION TO GET USERS BY EMAIL OR ANY OTHER FIELD
	// THIS FUNCTION WILL RETURN ONLY ONE RESULT (DBManager::getByCol returns only one result)
	// IF YOU WANT MORE THAN ONE RESULT, YOU SHOULD COPY THAT FUNCTION AND CHANGE 'fetch' BY 'fetchAll'
	public function getByName($name,$select="*"){
		// DEPENDING ON YOUR DATABASE YOU SHOULD CHANGE 'username' TO 'user'
		return $this->getByCol("username",$name,$select);
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