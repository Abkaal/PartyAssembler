<?php

class Validator{
	
	// Check if e-mail given by user is valid
	// params:
	// $email - e-mail string to be validated
	public static function validate_email($email){
		// make it better!
		if(empty($email)) return false;
		$pos=strpos($email,'@');
		//var_dump($pos);
		if($pos!==false && $pos<strlen($email)-5) $x=true;
		else $x=false;
		return $x;
	}
	
	// Check if password given by user is valid
	// params:
	// $pass - password given
	// $rpass - password repeated
	public static function validate_pass($pass, $rpass){
		if(!empty($pass) && $pass===$rpass && md5($pass)===md5($rpass)) return true;
		else return false;
	}
	
	// Check if date given by user is valid and build date string to be inserted to the db
	// params:
	// $day, $month, $year - date given by a user
	public static function validate_date($day, $month, $year){
		if($day>0 && $day<32 && $month>0 && $month<13 && $year){
			$date_str="'$day,$month,$year'";
			$s="'%d,%m,%Y'";
			$s='STR_TO_DATE('.$date_str.','.$s.')';
			return $s;
		}
		else return false;
	}
}

?>