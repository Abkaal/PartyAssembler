<?php

include_once("Validator.php");

class User{
	
	private $id;
	private $name;
	private $ip;
	private $email;
	private $level;
	private $table_name;
	
	global $dbc;
	
	// Constructor, will be needed when logging in will be done;
	// params:
	// $id - user id
	// $all - bool indicating if we construct an object from an existing user id
	public function __construct($id=0, $all=true){
		// if($all) grab data and save in fields;
		if(is_int($id) && $id>0){} // TODO
		$this->table_name='dbs_users';
	}
	
	// Add new user to the db.
	// params:
	// $name - user name
	// $ip - user ip
	// $email - user e-mail
	public static function add($name=null,$ip=null,$email=null){
		if($name && $ip && $email){
			$fields='user_name,$user_ip,$user_email';
			$values="$name,$ip,$email";
			$x=$dbc->insert_data($table_name,$fields,$values);
		} else $x=false;
		return $x;
	}
	
}

?>