<?php

require_once("startup.php");
include_once("includes/Event.php");

$eid=intval(request_var('ev',0));

print '<div style="margin: 0 auto;">';
if(isset($_POST['submit']) || ($eid && is_int($eid))){
	$e=new Event($eid,$dbc);
	$x=$e->del_cat();
	if($x) print '<h4>The category removed from the event successfully!</h4>'; 
	else print '<h4>Something has gone wrong... please check your input.</h4>';
	print '<a href="del_cat_event.php">Go to the previous page</a>';
}
else{
	$evs=$dbc->grab_data('dbs_events',0,array(),'event_id,event_name');
	if($evs){
		$opts_e='<option value="0">-----</option>';
		foreach($evs as $e){
			$opts_e.='<option value="'.$e['event_id'].'">'.$e['event_name'].'</option>';
		}
		print '<h3>Remove category from an existing event</h3>';
		print '<form id="add" class="center" action="del_cat_event.php" method="post" accept-charset="UTF-8">';
		print '<label for="ev">Select event:</label>';
		print '<select id="ev" name="ev">';
		print $opts_e;
		print '</select><br/><br/>';
		print '<input type="hidden" name="submit" value="submit">';
		print '<input type="submit" name="send" value="Send">';
		print '</form>';
	}
	else print 'ERROR - no event created yet.';
}
print '</div>';
$db=null;
?>