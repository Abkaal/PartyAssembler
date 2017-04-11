<?php

require("startup.php");
include_once("Validator.php");

print '<div style="margin: 0 auto;">';
if(isset($_POST['submit'])){
	$table_name='dbs_events';
	$fields='event_name,event_owner,event_date';
	$name=request_var('name','');
	$owner=intval(request_var('uid',0));
	$day=intval(request_var('day',0));
	$month=intval(request_var('month',0));
	$year=intval(request_var('year',0));
	$s=Validator::validate_date($day,$month,$year); // this also builds date string for the db;
	if($s!==false){
		$values="'$name',$owner,$s";
		$x=$dbc->insert_data($table_name,$fields,$values);
	}
	else{
		print "The date you provided is not valid.<br/>";
		$x=false;
	}
	if($x) print '<h4>New event created successfuly!.</h4>'; 
	else print '<h4>Something has gone wrong... please check your input.</h4>';
	print '<a href="register.php">Go to the previous page</a>';
}
else{
	$data=$dbc->grab_data('dbs_users',0,array(),'user_id,user_name');
	if($data){
		$opts='<option value="0">-----</option>';
		foreach($data as $u){
			$opts.='<option value="'.$u['user_id'].'">'.$u['user_name'].'</option>';
		}
		print '<h3>Add new event</h3>';
		print '<form id="add" class="center" action="add_event.php" method="post" accept-charset="UTF-8">';
		print '<label for="name">Event name:</label>';
		print '<input type="text" id="name" name="name" size="255" style="width:80%;"/> <br/><br/>';
		print '<label for="email">Owner:</label>';
		print '<select id="uid" name="uid">';
		print $opts;
		print '</select><br/><br/>';
		print '<label for="day">Date: (first day, then month and year):</label>';
		print '<br/><input type="text" size="2" name="day" value="0"> ';
		print '<input type="text" size="2" name="month" value="0"> ';
		print '<input type="text" size="4" name="year" value="0"><br/>';
		print '<input type="hidden" name="submit" value="submit">';
		print '<input type="submit" name="send" value="Send">';
		print '</form>';
	}
}
print '</div>';
$db=null;
?>