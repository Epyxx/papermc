<?php
if ( $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" AND ( $_SERVER["HTTP_REFERER"] == "https://".$_SERVER["SERVER_NAME"]."/" OR $_SERVER["HTTP_REFERER"] == "https://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/" OR $_SERVER["HTTP_REFERER"] == "http://".$_SERVER["SERVER_NAME"]."/" OR $_SERVER["HTTP_REFERER"] == "http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/" ) ) {
	require_once("config.php");

	function translateMCColors($text) {
		$dictionary = array(
			'<' => '&lt;',
			'>' => '&gt;',
			'  ' => '&nbsp;&nbsp;',
			'[30;22m' => '</span><span style="color:#000000">', // §0 - Black
			'[34;22m' => '</span><span style="color:#0000AA">', // §1 - Dark_Blue
			'[32;22m' => '</span><span style="color:#00AA00">', // §2 - Dark_Green
			'[36;22m' => '</span><span style="color:#00AAAA">', // §3 - Dark_Aqua
			'[31;22m' => '</span><span style="color:#AA0000">', // §4 - Dark_Red
			'[35;22m' => '</span><span style="color:#AA00AA">', // §5 - Purple
			'[33;22m' => '</span><span style="color:#FFAA00">', // §6 - Gold
			'[37;22m' => '</span><span style="color:#AAAAAA">', // §7 - Gray
			'[30;1m' => '</span><span style="color:#555555">', // §8 - Dakr_Gray
			'[34;1m' => '</span><span style="color:#5555FF">', // §9 - Blue
			'[32;1m' => '</span><span style="color:#55FF55">', // §a - Green
			'[36;1m' => '</span><span style="color:#55FFFF">', // §b - Aqua
			'[31;1m' => '</span><span style="color:#FF5555">', // §c - Red
			'[35;1m' => '</span><span style="color:#FF55FF">', // §d - Light_Purple
			'[33;1m' => '</span><span style="color:#FFFF55">', // §e - Yellow
			'[37;1m' => '</span><span style="color:#FFFFFF">', // §f - White
			'[0;30;22m' => '</span><span style="color:#000000">', // §0 - Black
			'[0;34;22m' => '</span><span style="color:#0000AA">', // §1 - Dark_Blue
			'[0;32;22m' => '</span><span style="color:#00AA00">', // §2 - Dark_Green
			'[0;36;22m' => '</span><span style="color:#00AAAA">', // §3 - Dark_Aqua
			'[0;31;22m' => '</span><span style="color:#AA0000">', // §4 - Dark_Red
			'[0;35;22m' => '</span><span style="color:#AA00AA">', // §5 - Purple
			'[0;33;22m' => '</span><span style="color:#FFAA00">', // §6 - Gold
			'[0;37;22m' => '</span><span style="color:#AAAAAA">', // §7 - Gray
			'[0;30;1m' => '</span><span style="color:#555555">', // §8 - Dakr_Gray
			'[0;34;1m' => '</span><span style="color:#5555FF">', // §9 - Blue
			'[0;32;1m' => '</span><span style="color:#55FF55">', // §a - Green
			'[0;36;1m' => '</span><span style="color:#55FFFF">', // §b - Aqua
			'[0;31;1m' => '</span><span style="color:#FF5555">', // §c - Red
			'[0;35;1m' => '</span><span style="color:#FF55FF">', // §d - Light_Purple
			'[0;33;1m' => '</span><span style="color:#FFFF55">', // §e - Yellow
			'[0;37;1m' => '</span><span style="color:#FFFFFF">', // §f - White
			'[5m' => '', // Obfuscated
			'[21m' => '<b>', // Bold
			'[9m' => '<s>', // Strikethrough
			'[4m' => '<u>', // Underline
			'[3m' => '<i>', // Italic
			'[0;39m' => '</b></s></u></i></span>', // Reset
			'[0m' => '</b></s></u></i></span>', // Reset
			'[m' => '</b></s></u></i></span>', // End
		);
		$text = str_replace(array_keys($dictionary), $dictionary, $text);
		return $text;
	}
	if(file_exists($mc_path."logs/".$log_file)){
		$output = @file_get_contents($mc_path."logs/".$log_file);
		if($output === FALSE){
			echo '<span style="color:#FF5555">'.str_replace("{log_file}",$log_file,$lang["forbidden_log"]).'</span>';
		}else{
			$output = translateMCColors($output);
			$output = array_filter(explode("\n",$output));
			for($i=0;$i<=count($output);$i++){
				if($output[$i]){
					echo $output[$i]."<br>";
				}
			}
		}
	}else{
		echo '<span style="color:#FF5555">'.str_replace("{log_file}",$log_file,$lang["notfound_log"]).'</span>';
	}
}
?>
