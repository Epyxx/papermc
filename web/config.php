<?php
$usessl = false; // Use SSL for webserver
$language = "lang_en.json"; // Language file
$mc_path = "/opt/minecraft/"; // Path to the minecraft installation
$exec = "/etc/init.d/minecraft"; // Path to init file
$server_port = 25565;
$mc_server = "paper.jar"; // Server file
$log_file = "latest.log"; // The Minecraft log file ($mc_path/logs/$log_file)
$forbidden = array($mc_server,$mc_server.".old"); // List of forbidden filenames to show in browser (relativ zu $mc_path)
$allow_mode = true;	// true = Allow file extensions, false = Deny file extensions
$hide_forbidden = true; // Hide forbidden files and file types completly in File browser
$allowed_types = array("txt","yml","json","properties","sh","log","mcmeta","gz","jar","db"); // List of allowed file extensions
$denied_types = array("jar","old","png","dat","dat_old","mca","lock","tar","gz"); // List of forbidden file extensions
$server_cfg = "server.properties"; // MC Server config file

$lang = json_decode(file_get_contents($language),true);
$config = loadConfigFile();

function showsize($file){
	$size = filesize($file);
	if($size>=1073741824){
		$multi=1073741824; $end="GB";
	}else if($size>=1048576){
		$multi=1048576; $end="MB";
	}else if($size>=1024){
		$multi=1024; $end="KB";
	}else{
		$multi=1; $end="Bytes";
	}
	$size/=$multi;
	if($size>100){ $size=round($size,0);
	}else if($size>10){ $size=round($size,1);
	}else{ $size=round($size,2); }
	$size.=" ".$end;
	return $size;
}

function loadConfigFile(){
	global $mc_path,$server_cfg;
	$config = array();
	$config_file = explode("\n",@file_get_contents($mc_path.$server_cfg));
	foreach($config_file AS $line){
		if($line){
			$tmp = explode("=",$line);
			if($tmp[0] AND $tmp[1]){
				$config[$tmp[0]] = $tmp[1];
			}
		}
	}
	return $config;
}
?>
