<?php

require_once("startup.php");
include_once("includes/Search.php");

print '<div style="margin: 0 auto;">';
if(isset($_POST['submit'])){
	$uid=intval(request_var('org',0));
	$se=new Search($dbc); // name comes from "search engine";
	$result=$se->event_by_org($uid);
	unset($se); // as it's no longer needed;
	if($result){
		print '<h2>Events found:</h2><br/><div style="margin-bottom: 50px;">';
		print '<table style="margin: 0 auto;"><tbody>';
		foreach($result as $ev){
			print "<a href=\"events.php?id=".$ev['event_id']."\">".$ev['event_name']."</a><br/>";
		}
		print '</tbody></table></div>';
	}
	elseif(is_array($result)) print '<h4>Sorry, no results found.</h4>';
	else print '<h4>Something has gone wrong... please check your input.</h4>';
	print '<a href="search_events.php">Go to the previous page</a>';
}
else{
	$data=$dbc->grab_data('dbs_users',0,array(),'user_id,user_name');
	if($data){
		$opts_o='<option value="0">-----</option>';
		foreach($data as $u){
			$opts_o.='<option value="'.$u['user_id'].'">'.$u['user_name'].'</option>';
		}
		print '<h3>Search events by organizer</h3>';
		print '<form id="add" class="center" action="search_events_org.php" method="post" accept-charset="UTF-8">';
		print '<label for="org">Select user to be searched:</label>';
		print '<select id="org" name="org">';
		print $opts_o;
		print '</select><br/><br/>';
		print '<input type="hidden" name="submit" value="submit">';
		print '<input type="submit" name="send" value="Send">';
		print '</form>';
	}
	else print 'ERROR - no user added yet.';
}
print '</div>';
$db=null;
?>