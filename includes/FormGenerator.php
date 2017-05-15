<?php

// this class will not be in use as of 0.04;
// in 0.02 no module uses this class;

class FormGenerator{
	
	private $id;
	private $target;
	
	// Constructor.
	// params:
	// $t_in - target for form action, given by a user;
	// $id_in - form id, given by a user.
	public function __construct($t_in,$id_in=''){
		$this->id=($id_in)?$id_in:'';
		$this->target=$t_in;
	}
	
	// Create options for selecting a category
	// params:
	// $cats_arr - array containing categories data obtained from the DB;
	// $special_id - integer pointing at special category that should be selected by default;
	public function create_category_options($cats_arr,$special_id=0){
		$opts_c='';
		if($cats_arr){
			$opts_c='<option value="0">-----</option>';
			foreach($cats_arr as $c){
				$opts_c.='<option value="'.$c['cat_id'].'"'.(($special_id>0 && $special_id==$c['cat_id'])?' selected="selected"':'').'>'.$c['cat_name'].'</option>';
			}
		}
		return $opts_c;
	}
	
	// Create options for selecting an event
	// params:
	// $evs_arr - array containing events data obtained from the DB;
	// $special_id - integer pointing at special event that should be selected by default;
	public function create_event_options($evs_arr,$special_id=0){
		$opts_e='';
		if($evs_arr){
			$opts_e='<option value="0">-----</option>';
			foreach($evs_arr as $e){
				$opts_e.='<option value="'.$e['event_id'].'"'.(($special_id>0 && $special_id==$e['event_id'])?' selected="selected"':'').'>'.$e['event_name'].'</option>';
			}
		}
		return $opts_e;
	}
	
	// Create options for selecting a user
	// params:
	// $users_arr - array containing users data obtained from the DB;
	// $special_id - integer pointing at special category that should be selected by default;
	public function create_user_options($users_arr,$special_id=0){
		$opts_u='';
		if($users_arr){
			$opts_u='<option value="0">-----</option>';
			foreach($users_arr as $u){
				$opts_u.='<option value="'.$u['user_id'].'"'.(($special_id>0 && $special_id==$u['user_id'])?' selected="selected"':'').'>'.$u['user_name'].'</option>';
			}
		}
		return $opts_u;
	}
	
	// Create the beginning of a form.
	// may return NULL if an object was not initialized with a proper target.
	public function create_beginning(){
		$s='<form class="center" method="post" accept-charset="UTF-8"';
		if(gettype($this->target)=='string' && $this->target){
			$s.=' action="'.$this->target.'"';
		}
		else return NULL;
		if(gettype($this->id)=='string' && $this->id){
			$s.=' id="'.$this->id.'"';
		}
		$s.='>';
		return $s;
	}
	
	// Create the ending of the form.
	public function create_ending(){
		$s='<input type="hidden" name="submit" value="submit">';
		$s.='<input type="submit" name="send" value="Send">';
		$s.='</form>';
		return $s;
	}
	
}

?>