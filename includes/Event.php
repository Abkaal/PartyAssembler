<?php

include_once("includes/Validator.php");

class Event{
	
	private $id;
	private $name;
	private $time;
	private $cat; // object!!!
	private $owner; // object!!!
	private $dbc;
	private $table_name;
	
	// Constructor
	// params:
	// $id - identifier obtained from the db
	public function __construct($id_in=0,$dbc_in=null){
		// TODO
		if(!class_exists('Database')) include('includes/Database.php');
		if($id_in>0) $this->id=$id_in;
		else $this->id=0;
		$this->dbc=$dbc_in;
		$this->table_name='dbs_events';
		$this->cat=null;
		$this->owner=null;
	}
	
	public function setDB($dbc_in=null){
		if($dbc_in) $this->dbc=$dbc_in;
	}
	
	// Add new user to the db.
	// params:
	// $name - user name
	// $ip - user ip
	// $email - user e-mail
	// $day, $month, $year - date given by a user
	public static function add($name=null,$ip=null,$owner=null,$day=null,$month=null,$year=null){ // TODO: should not be static
		$s=Validator::validate_date($day,$month,$year);
		if($name && $owner && $s){
			$fields='event_name,$event_owner,$event_date';
			$values="$name,$owner,$s";
			$x=$dbc->insert_data('dbs_events',$fields,$values);
		} else $x=false;
		return $x;
	}
	
	// Move events aggregately from one category to another.
	// params:
	// $cat_old - identifier of category events are to be moved from
	// $cat_new - identifier of category events are to be moved to
	public static function update_cats($cat_old,$cat_new=0){
		global $dbc;
		return $dbc->update_data('dbs_events','cat_id',"$cat_new",$cat_old,array('cat_id'));
	}
	
	// Assign a category to an existing event
	// params:
	// $cat_in - identifier of the category to be assigned
	public function add_cat($cat_in){
		if($cat_in>0 && $this->dbc){
			//$x=$this->dbc->update_data($this->table_name,'cat_id',"$cat_in",$this->id,array('cat_id'));
			$x=$this->dbc->update_data($this->table_name,'cat_id',"$cat_in",$this->id); // for future;
			return $x;
		}
		else return false;
	}
	
	// Removes a category from an existing event
	public function del_cat(){
		if($this->dbc) $x=$this->dbc->update_data($this->table_name,'cat_id',"NULL",$this->id);
		else $x=false;
		return $x;
	}
	
	// Enroll for an event
	// params:
	// $user_id - identifier of the user to be enrolled
	public function get_enrolled($user_id){
		if($this->id>0 && $user_id>0){
			$fields='user_id,event_id';
			$values="$user_id,".$this->id;
			$x=$this->dbc->insert_data('dbs_enrollments',$fields,$values);
		}
		else $x=false;
		return $x;
	}

}

?>