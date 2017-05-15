<?php

class Category{
	
	private $id;
	private $name;
	private $dbc;
	
	// Constructor.
	// params:
	// $id_in - identifier given by a user
	// $dbc_in - database handler given from higher layer
	public function __construct($id_in=0,$dbc_in=null){
		$this->id=$id_in;
		$this->dbc=$dbc_in;
	}
	
	// Static method. It adds a new category to the db.
	// params:
	// $name_in - name given by a user
	public static function add($name_in){
		global $dbc;
		$x=false;
		if($name_in && strlen($name_in)<256){
			$x=$dbc->insert_data('dbs_categories','cat_name',"'$name_in'");
		}
		return $x;
	}
	
	// Edit an existing category.
	// params:
	// $name_in - name given by a user
	public function edit($name_in){
		$x=false;
		if($this->dbc && $name_in && strlen($name_in)<256){
			$x=$this->dbc->update_data('dbs_categories','cat_name',"'$name_in'",$this->id,'cat_id');
		}
		return $x;
	}
	
	// Delete a category.
	// returns bool - true if deleted successfully
	public function delete(){
		$x=false;
		if($this->id>0 && $this->dbc) $x=$this->dbc->remove_data('dbs_categories','cat_id',$this->id);
		return $x;
	}
	
}

?>