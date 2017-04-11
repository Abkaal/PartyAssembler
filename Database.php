<?php

class Database{
	
	private $db; // connection handler;
	
	// Constructor.
	// Starts connection with the db.
	public function __construct(){
		$dbname='se_db';
		$dbuser='root';
		$dbpass='';
		try{
			$this->db=new PDO('mysql:host=localhost;dbname='.$dbname, $dbuser, $dbpass);
		} catch(PDOException $e){
			die('Cannot connect with db');
		}
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$this->db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8mb4');
	}
	
	// Destructor.
	// Closes the connection.
	public function __destruct(){
		$this->db=null;
	}
	
	// Insert data to the db.
	// params:
	// $table_name - table the data will be inserted to
	// $fields - string divided with commas containing of names of fields which values are going to be set
	// $values - string divided with commas containing of values going to be set, ordered same way as $fields
	public function insert_data($table_name,$fields,$values){
		$x=true;
		$query='INSERT INTO '.$table_name.'('.$fields.') VALUES('.$values.');';
		//echo $query;
		try{
			$sql=$this->db->prepare($query);
			$sql->execute();
		} catch(PDOException $e){
			echo $e;
			$x=false;
		}
		return $x;
	}
	
	// Grab data from the db.
	// THIS FUNCTION SUPPORTS NEITHER JOINS NOR NON-EQUALITY CONDITIONS.
	// params:
	// $table_name - name of the db table
	// $id - the identfier(s) of row(s) to be selected
	// $id_names - array of names of fields identficating uniquely a single row in the db, used in non-standard cases such as assignments tables
	// $to_select - string divided with commas containing of names of fields to be selected
	// $rethrow - boolean indicating if PDOException should be rethrown when it's caught in this function
	// $fetchall - this boolean should be set to false if and only if we want to select only one row
	public function grab_data($table_name,$id=0,$id_names=array(),$to_select='',$rethrow=false,$fetchall=true){
		$field_id=substr($table_name,4,-1);
		$field_id.='_id';
		$query=($to_select)?"SELECT $to_select":"SELECT *";
		$query.=" FROM $table_name";
		if(is_array($id) && !empty($id) && $id_names){
			$ss='';
			$len=count($id); // greater than 0;
			if(count($id_names)==$len){
				$y=true;
				while($id){
					$x=(gettype($id[0])=='string');
					if($id[0]){
						$ss.=(($y)?' WHERE ':' AND ').$id_names[0];
						$ss.=($x)?' LIKE "%':'=';
						$ss.=$id[0];
						$ss.=($x)?'%"':'';
						$y=false;
					}
					array_shift($id);
					array_shift($id_names);
				}
			}
			else return false; // error - we will handle it higher;
			$query.=$ss; // if we are here, no error occured, so $ss is not empty;
		}
		elseif($id) $query.=' WHERE '.$field_id.'='.$id;
		$query.=((stripos($table_name,'agns')===false)&&(stripos($table_name,'timetable')===false))?" ORDER BY $field_id;":';'; // workaround, in stable it can be another parameter;
		//print $query;
		try{
			$sql=$this->db->prepare($query);
			$sql->execute();
			$result = ((($id && !is_array($id))||(!$fetchall))? $sql->fetch() : $sql->fetchAll());
		} catch(PDOException $e){
			if($rethrow) throw $e; // think of when it may be useful;
			else echo $e;
			return false;
		}
		return $result;
	}
	
	function counter($table_name){
		try{
			$query='SELECT COUNT(*) AS num FROM '."$table_name".';';
			//echo $query;
			$sql=$this->db->prepare($query);
			$sql->execute();
			$result = $sql->fetch();
		} catch(PDOException $e){
			echo $e;
		}
		return $result['num'];
	}
	
}

?>