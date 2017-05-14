<?php
require("startup.php");

$page=request_var('page',0);
$u_id=request_var('id',0);

if(($u_id)){
	$data=$dbc->grab_data('dbs_events',$u_id);
	if($data){
		print '<div class="center">';
		print "<h3>".$data['event_name']."</h3>";
		print "<hr/><a href=\"enroll.php?id=$u_id\">Enroll for this event</a>";
		print "<br/><a href=\"events.php\">".'Go back'."</a>";
		print "</div>";
	}
	else print "Something has gone wrong...";
} 
else{
	$num=$dbc->counter('dbs_events');
	$data=$dbc->grab_data('dbs_events',0,array(),'event_id,event_name'); // maybe replace it later with a dedicated static method;
	if($data && $num){
		print "<h2>Events:</h2><br/><div>";
		print "<table style=\"margin: 0 auto;\"><tbody>";
		foreach($data as $ev){
			print "<a href=\"events.php?id=".$ev['event_id']."\">".$ev['event_name']."</a>";
			//print "<hr/>";
		}
		print "</tbody></table></div>";
		// pagination will be added later;
		/*if($num){
			$pages=floor(($num/20));
			if($num%20) $pages+=1;
			if($pages>1){
				print "<br/><br/><div>Page: ";
				for($i=0;$i<$pages;$i++) print ' <a href="events.php?page='.$i.'">'.strval($i+1).'</a>';
			}
			print "</div>";
		}*/
	}
	else print "ERROR - NO EVENT ADDED YET";
}
?>