<?php
include_once("db_pdo.php");
define("HOST","localhost");
// CHANGE DB_USER AND DB_PASSWORD TO YOUR USER AND PASSOWRD (TRY TO USE/CREATE ANOTHER USER THAT IS NOT 'root')
define("DB_USER","user");
define("DB_PASSWORD","123");
// CHANGE DB_PORT IF YOUR MYSQL SERVER IS IN ANOTHER PORT
define("DB_PORT",3306);
// CHANGE DB_NAME IF THE NAME OF YOUR DATABASE IS DIFFERENT
define("DB_NAME","my_shop");
class DBManager{
	private $connection=null;
	private $table;
	public function __construct($table="users")
	{
		$this->connection = connect_db(HOST,DB_USER,DB_PASSWORD,DB_PORT,DB_NAME);
		if(!$this->connection){
			throw new Exception("Error Connecting to database");
		}
		$this->table= $table;
	}
	
	public function getById($id,$select = "*")
	{
		$sql = "SELECT $select FROM $this->table WHERE id=?";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	// IF YOU WANT THIS FUNCTION TO RETURN MORE THAN ONE RESULT, COPY AND PASTE, CHANGE THE NAME AND CHANGE 'fetch' FOR 'fetchAll'
	public function getByCol($column,$value,$select="*")
	{
		$sql = "SELECT $select FROM $this->table WHERE $column=?;";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$value]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	public function getAll($select="*")
	{
		$sql = "SELECT $select FROM $this->table ";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	public function insert($values,$columns=[])
	{

		$sql = "INSERT INTO $this->table ";

		$sql .= $this->formatColumns($columns);
		$sql .=" VALUES ";
		$sql .= $this->formatValues($values);
		
		$sql .=";";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute($values);
	}
	// FUNCTION TO FORMAT THE ARRAY OF COLUMNS FOR INSERT
	// EXAMPLE RESULT: (name,email,password)
	public function formatColumns($columns){
		$sql="";
		for ($i=0; $i < sizeof($columns); $i++) { 
			if($i ==0){
				$sql .="(";
				$sql .=$columns[$i];
			}
			else{
				$sql .=", ".$columns[$i];
			}
			if($i==sizeof($columns)-1){
				$sql .=")";
			}
		}
		return $sql;

	}
	// FUNCTION TO FORMAT THE ARRAY OF VALUES FOR INSERT
	// EXAMPLE RESULT: (?,?,?)
	public function formatValues($values){
		$sql="";
		for ($i=0; $i < sizeof($values); $i++) { 
			if($i ==0){
				$sql .="(";
				$sql .="?";
			}
			else{
				$sql .=", ?";
			}
			if($i==sizeof($values)-1){
				$sql .=")";
			}
		}
		return $sql;

	}
	public function updateById($id,$columns,$values)
	{
		if(sizeof($columns) != sizeof($values)){
			return ;
		}
		$sql ="UPDATE $this->table SET ";
		for ($i=0; $i < sizeof($columns); $i++) { 
			if($i != 0){
				$sql .= ", ";
			}
			$sql .=$columns[$i];
			$sql .="=?";
		}
		$sql .=" WHERE id=?;";
		$stmt = $this->connection->prepare($sql);
		$values[]=$id;
		$stmt->execute($values);
	}
	public function deleteById($id)
	{
		$sql = "DELETE FROM $this->table WHERE id=?";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$id]);
	}
}
//      TEST   
//-----initialize database manager  

//$date = date('Y/m/d');
//$dbm = new DBManager("users");

//-----get user by id
//var_dump($dbm->getById(1));

//-----get all users
//var_dump($dbm->getAll());

//-----modify user by id
//$dbm->updateById(1,["name","password"],["Pedro","pass"]);

//----insert user
/*
$columns = Array("name","password","email","created_at","is_admin");
$values = Array("new user","pass","mymail.com",$date,0);
$dbm->insert($values,$columns);
*/

//----delete user
//$dbm->deleteById(9);


