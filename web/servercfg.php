<?php
if($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest"
//AND $_SERVER["HTTP_SEC_FETCH_SITE"] == "same-origin"
AND $_SERVER["HTTP_REFERER"]){
	require_once("config.php");
?>
<h2><?php echo $lang["button_servercfg"]; ?></h2>
<?php
	if(file_exists($mc_path.$server_cfg)){
		$output = @file_get_contents($mc_path.$server_cfg);
		if($output === FALSE){
			echo '<span style="color:#FF5555">'.str_replace("{log_file}",$server_cfg,$lang["forbidden_log"]).'</span>';
		}else{
			$options = explode("\n",$output);
			foreach($options AS $option){
				echo "<p>".$option."</p>";
			}
		}
	}else{
		echo '<span style="color:#FF5555">'.str_replace("{log_file}",$server_cfg,$lang["notfound_log"]).'</span>';
	}
}
?>
