<?php
if ( (@$_POST["cmd"] OR @$_POST["action"])
AND $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest"
AND ( $_SERVER["HTTP_REFERER"] == "https://".$_SERVER["SERVER_NAME"]."/"
OR $_SERVER["HTTP_REFERER"] == "http://".$_SERVER["SERVER_NAME"]."/" ) ) {
	include("config.php");
	if($_POST["action"] == "on") {
		$exec2 = "start";
	} else if ($_POST["action"] == "off") {
		$exec2 = "stop";
	} else if ($_POST["action"] == "restart") {
		$exec2 = "restart";
	} else if ($_POST["cmd"]) {
		$cmd = str_replace("\"","",htmlspecialchars($_POST["cmd"]));
		$exec2 = "command \"".$cmd."\"";
	}
	exec($exec." ".$exec2);
	echo exec($exec." ".$exec2);
}
?>
