<?php
require("startup.php");

$e_id=intval(request_var('id',0));
$u_id=intval(request_var('uid',0));

if(($e_id)){
	if($u_id){
		/*$table_name='dbs_enrollments';
		$fields='event_id,user_id';
		$values="$e_id,$u_id";
		$x=$dbc->insert_data($table_name,$fields,$values);*/
		if(!class_exists('Event')) include("Event.php");
		$e=new Event($e_id,$dbc);
		$x=$e->get_enrolled($u_id);
		if($x) print '<h4>You have enrolled for the event successfully!</h4>';
		else print '<h4>Something has gone wrong... please check your input.</h4>';
	}
	else{
		$data=$dbc->grab_data('dbs_users',0,array(),'user_id,user_name');
		if($data){
			$opts='<option value="0">-----</option>';
			foreach($data as $u){
				$opts.='<option value="'.$u['user_id'].'">'.$u['user_name'].'</option>';
			}
			print '<div class="center">';
			print '<h2>You are going to enroll for the event</h2>';
			print '<form id="add" class="center" action="enroll.php" method="post" accept-charset="UTF-8">';
			print '<label for="line">Select user:</label>';
			print '<select id="uid" name="uid">';
			print $opts;
			print '</select><br/><br/>';
			print '<br/><input type="hidden" name="id" value="'.$e_id.'">';
			print '<input type="submit" name="send" value="Send">';
			print '</form>';			
			print "</div>";
		}
		else print "Something has gone wrong...";
	}
} 
else print "ERROR - NO EVENT SELECTED";
?>