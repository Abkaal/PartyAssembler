<?php

require_once("startup.php");

print '<div style="margin: 0 auto;">';

$cats=$dbc->grab_data('dbs_categories');
if($cats){
	print '<h3>Category list</h3>';
	foreach($cats as $c){
		print $c['cat_id'].': '.$c['cat_name'].'<br/>';
	}
	print '<hr/><a href="man_cats.php">Go to the previous page</a>';
}
else print 'ERROR - no category created yet.';

print '</div>';
?>