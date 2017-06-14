<?php

require_once("startup.php");
include_once("includes/Search.php");

print '<div style="margin: 0 auto;">';
if(isset($_POST['submit'])){
	$name=request_var('name','');
	$uid=intval(request_var('org',0));
	$cid=intval(request_var('cat',0));
	$se=new Search($dbc); // name comes from "search engine";
	$name=($name)?$name:null;
	$uid=($uid)?$uid:null;
	$cid=($cid)?$cid:null;
	$result=$se->event_mix($name,$uid,$cid);
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
	$orgs=$dbc->grab_data('dbs_users',0,array(),'user_id,user_name');
	$cats=$dbc->grab_data('dbs_categories');
	if($orgs && $cats){
		$opts_o='<option value="0">-----</option>';
		foreach($orgs as $u){
			$opts_o.='<option value="'.$u['user_id'].'">'.$u['user_name'].'</option>';
		}
		$opts_c='<option value="0">-----</option>';
		foreach($cats as $c){
			$opts_c.='<option value="'.$c['cat_id'].'">'.$c['cat_name'].'</option>';
		}
		print '<h3>Search events by organizer and category</h3>';
		print '<form id="add" class="center" action="search_events_mix.php" method="post" accept-charset="UTF-8">';
		print '<label for="name">Category name:</label>';
		print '<input type="text" id="name" name="name" size="255" style="width:80%;"/> <br/><br/>';
		print '<label for="org">Select user to be searched:</label>';
		print '<select id="org" name="org">';
		print $opts_o;
		print '</select><br/><br/>';
		print '<label for="cat">Select category to be searched:</label>';
		print '<select id="cat" name="cat">';
		print $opts_c;
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