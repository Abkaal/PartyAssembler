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
	
	// Grab data from the db.
	// THIS FUNCTION SUPPORTS NEITHER JOINS NOR NON-EQUALITY CONDITIONS.
	// params:
	// $table_name - name of the db table
	// $id - the identfier(s) of row(s) to be selected (single number or array of numers)
	// $id_names - array of names of fields identficating uniquely a single row in the db, used in non-standard cases such as assignments tables
	// $to_select - string divided with commas containing of names of fields to be selected
	// $rethrow - boolean indicating if PDOException should be rethrown when it's caught in this function
	// $fetchall - this boolean should be set to false if and only if we want to select only one row
	// bug:
	// no possibility of ordering the data found;
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
					$type=gettype($id[0]);
					$ss.=(($y)?' WHERE ':' AND ').$id_names[0];
					switch($type){
						case 'NULL': $ss.=' IS NULL'; break;
						case 'string': $ss.=' LIKE "%'; $ss.=$id[0]; $ss.='%"'; break;
						default: $ss.='='; $ss.=$id[0]; break;
					}
					$y=false;
					array_shift($id);
					array_shift($id_names);
				}
			}
			else return false; // error - we will handle it higher;
			$query.=$ss; // if we are here, no error occured, so $ss is not empty;
		}
		elseif($id) $query.=' WHERE '.$field_id.'='.$id;
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
			$x=$sql->execute();
		} catch(PDOException $e){
			echo $e;
			$x=false;
		}
		return $x;
	}
	
	// Update data existing in the db.
	// params:
	// $table_name - table the data will be inserted to
	// $in_f - string divided with commas containing of names of fields which values are going to be set
	// $in_v - string divided with commas containing of values going to be set, ordered same way as $in_f
	// $id - the identfier(s) of row(s) to be updated, null value means all rows;
	// $id_names - array of names of fields identficating uniquely a single row in the db, used in non-standard cases such as assignments tables
	public function update_data($table_name,$in_f,$in_v,$id=null,$id_names=array()){
		$x=true;
		$where='';
		if(is_array($id) && !empty($id)){
			$len=count($id); // greater than 0;
			if(count($id_names)==$len){
				$where.=' WHERE '.$id_names[0].'='.$id[0];
				array_shift($id);
				array_shift($id_names);
				while($id){
					$where.=' AND '.$id_names[0].'='.$id[0];
					array_shift($id);
					array_shift($id_names);
				}
			}
			else $x=false;
		}
		else {
		    if($id_names && count($id_names)==1) $field_id=(is_array($id_names))?$id_names[0]:$id_names;
		    else{
		        $field_id=substr($table_name,4,-1);
		        $field_id.='_id';
		    }
		    $where=(is_int($id))?' WHERE '.$field_id.'='.$id.';':';';
		}
		$fields=explode(',',$in_f);
		$values=explode(',',$in_v);
		if(count($fields)==count($values) && $x){
			$query="UPDATE $table_name SET ";
			for($i=0;$i<count($fields);$i++){
				if($i) $query.=', ';
				$query.=$fields[$i].'='.$values[$i];
			}
			$query.=$where; // $where contains WHERE clause and is empty as long as $id is undefined;
			try{
				$sql=$this->db->prepare($query);
				$x=$sql->execute();
			} catch(PDOException $e){
				//echo $query;
				echo $e;
				$x=false;
			}
		}
		else $x=false;
		return $x;
	}
	
	// Remove data from a table.
	// params:
	// $table_name - the name of the table
	// $field - the name of key field (may be an array)
	// $value - value of the key field determining data to be deleted (may be an array as well)
	// the number of elements in $field and $value must be equal
	function remove_data($table_name,$field,$value){
		$x=true;
		$ss='';
		if((is_array($field))&&(count($field)==count($value))){
			$ss.=' WHERE '.$field[0].'='.$value[0];
			array_shift($value);
			array_shift($field);
			while($field){
				$ss.=' AND '.$field[0].'='.$value[0];
				array_shift($value);
				array_shift($field);
			}
		}
		else $ss=" WHERE $field=$value";
		$query='DELETE FROM '.$table_name.$ss.';';
		try{
			$sql=$this->db->prepare($query);
			$x=$sql->execute();
		} catch(PDOException $e){
			$x=false;
		}
		return $x;
	}
	
	// Count the number of records in a selected table.
	// params:
	// $table_name - the name of the table to be counted.
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