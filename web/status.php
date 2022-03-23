<?php
if ( $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" AND ( $_SERVER["HTTP_REFERER"] == "https://".$_SERVER["SERVER_NAME"]."/" OR $_SERVER["HTTP_REFERER"] == "https://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/" OR $_SERVER["HTTP_REFERER"] == "http://".$_SERVER["SERVER_NAME"]."/" OR $_SERVER["HTTP_REFERER"] == "http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/" ) ) {
	require_once("config.php");
	include("systeminfo.php");
	$cpuLoad = getServerLoad();
	$memoryLoad = getSystemMemInfo();
	$status = @json_decode(@file_get_contents("https://api.minetools.eu/ping/".$_SERVER["HTTP_HOST"]."/".$server_port),true);
	if(!$status){ $status = array(); }
	$spacefree = disk_free_space("/");
	$spacetotal = disk_total_space("/");

	echo "<span id='systemstatus'><img src='img/cpu.png' alt='CPU Load' title='CPU Load'> ".round($cpuLoad,2)."% &nbsp;";
	echo "<img src='img/ram.png' alt='RAM Usage' title='RAM Usage'> ".@round(($memoryLoad["MemTotal"]-$memoryLoad["MemFree"])/1048576,2)."/".@round($memoryLoad["MemTotal"]/1048576,2)." GB &nbsp;";
	echo "<img src='img/space.png' alt='Disk Usage' title='Disk Usage'> ".@round(($spacetotal-$spacefree)/1073741824,2)."/".@round($spacetotal/1073741824,2)." GB (".@round(100/$spacetotal*($spacetotal-$spacefree),2)."%)</span>";

	echo "<button class=\"button_config\" onclick=\"openPopup('servercfg');\"><div></div> ".$lang["button_servercfg"]."</button> ";
	echo "<button class=\"button_editor\" onclick=\"openPopup('editor');\"><div></div> ".$lang["button_filebrowser"]."</button> ";
	$mcstatus = exec("/etc/init.d/minecraft status");
	if ( $mcstatus == "Running" ) {
		$icon = "off";
		$msg = $lang["server_stop"];
		echo "<button class=\"button_server_restart\" onclick=\"setServer('restart','".$lang["server_msg"]."');\"><div></div> ".$lang["server_restart"]."</button> ";
	} else {
		$icon = "on";
		$msg = $lang["server_start"];
	}
	echo "<button class=\"button_server_$icon\" onclick=\"setServer('$icon','".$lang["server_msg"]."')\"><div></div> $msg</button>";

	if(!@$status["players"]["online"]){
		$status["players"]["online"] = "0";
	}
	if(!@$status["players"]["max"]){
		if(@$config["max-players"]){
			$status["players"]["max"] = $config["max-players"];
		}else{
			$status["players"]["max"] = "0";
		}
	}
	echo "<div id='players'>Online: ".$status["players"]["online"]."/".$status["players"]["max"]." ".$lang["players"];
	$c=0;

	if(@$status["players"]["sample"]){
		foreach($status["players"]["sample"] AS $player){
			if(!$c){
				echo "<hr>";
			}else{
				echo "<br>";
			}
			$imgurl = "img/players/".$player["id"].".png";
			if(!file_exists($imgurl)){
				file_put_contents($imgurl,file_get_contents("https://mc-heads.net/avatar/".$player["id"]."/16/nohelm.png"));
			}
			echo "<img class='head' src='$imgurl' alt=''> ".$player["name"];
			$c++;
		}
	}
	echo "</div>";
}
?>
