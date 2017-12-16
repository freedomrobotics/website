<?php
function alert($type, $content){
	$alert = "<div class='alert alert-".$type."' role='alert'><center>".$content."</center></div>";
	return $alert;
}

?>
