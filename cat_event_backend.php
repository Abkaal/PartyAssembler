<?php

require_once("startup.php");
include_once("includes/Event.php");

$eid=intval(request_var('ev',0));

print '<div style="margin: 0 auto;">';
if(isset($_POST['submit'])){
	$cid=intval(request_var('cat',0));
	$e=new Event($eid,$dbc);
	$x=$e->add_cat($cid);
	if($x) print '<h4>The category assigned to the event successfully!</h4>'; 
	else print '<h4>Something has gone wrong... please check your input.</h4>';
	print '<a href="cat_event.php">Go to the previous page</a>';
}
else{
	$evs=$dbc->grab_data('dbs_events',array(null),array('cat_id'),'event_id,event_name');
	$cats=$dbc->grab_data('dbs_categories');
	if($evs && $cats){
		$opts_e=$opts_c='<option value="0">-----</option>';
		foreach($evs as $e){
			$opts_e.='<option value="'.$e['event_id'].'"'.(($eid==$e['event_id'])?' selected="selected"':'').'>'.$e['event_name'].'</option>';
		}
		foreach($cats as $c){
			$opts_c.='<option value="'.$c['cat_id'].'">'.$c['cat_name'].'</option>';
		}
		print '<h3>Assign category to an existing event</h3>';
		print '<form id="add" class="center" action="cat_event.php" method="post" accept-charset="UTF-8">';
		print '<label for="ev">Select event:</label>';
		print '<select id="ev" name="ev">';
		print $opts_e;
		print '</select><br/><br/>';
		print '<label for="cat">Select category:</label>';
		print '<select id="cat" name="cat">';
		print $opts_c;
		print '</select><br/><br/>';
		print '<input type="hidden" name="submit" value="submit">';
		print '<input type="submit" name="send" value="Send">';
		print '</form>';
	}
	else print 'ERROR - each event has a category assigned or no category created yet.';
}
print '</div>';
$db=null;
?>