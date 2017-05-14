<?php

require_once("startup.php");
include_once("includes/Search.php");

print '<div style="margin: 0 auto;">';
if(isset($_POST['submit'])){
	$cid=intval(request_var('cat',0));
	$se=new Search($dbc); // name comes from "search engine";
	$result=$se->event_by_cat($cid);
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
	$cats=$dbc->grab_data('dbs_categories');
	if($cats){
		$opts_c='<option value="0">-----</option>';
		foreach($cats as $c){
			$opts_c.='<option value="'.$c['cat_id'].'">'.$c['cat_name'].'</option>';
		}
		print '<h3>Search events by category</h3>';
		// in 0.03 action will be different;
		print '<form id="add" class="center" action="search_events.php" method="post" accept-charset="UTF-8">';
		print '<label for="cat">Select category to be searched:</label>';
		print '<select id="cat" name="cat">';
		print $opts_c;
		print '</select><br/><br/>';
		print '<input type="hidden" name="submit" value="submit">';
		print '<input type="submit" name="send" value="Send">';
		print '</form>';
	}
	else print 'ERROR - no category created yet.';
}
print '</div>';
$db=null;
?>