<?php
if($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest"
//AND $_SERVER["HTTP_SEC_FETCH_SITE"] == "same-origin"
AND $_SERVER["HTTP_REFERER"]){
	require_once("config.php");
	if(substr($mc_path,-1,1)!="/"){$mc_path.="/";}
	$edit = @explode("/",$_POST["param"]);
	$fullpath=$mc_path;
	foreach($edit AS $x){
		if($x){
			$fullpath.=$x."/";
		}
	}
	$filename=substr($fullpath,0,-1);
	// Zurück-Link erzeugen
	$back=$edit;
	array_pop($back);
	$link = "";
	foreach($back AS $x){
		$link .= $x."/";
	}
	$link=substr($link,0,-1);
	// Datei oder Verzeichnis
	if(filetype($filename)=="file"){
		if($_POST["action"] == "save"){
			$h=fopen($filename,"w");
			$bytes = fwrite($h,$_POST["content"]);
			fclose($h);
			if($bytes===false){
				echo "<span class='error'>".$lang["save_failed"]."</span>";
			}else{
				echo "<span class='success'>".$lang["save_ok"]."</span>";
			}
			exit();
		}
		echo "<h2>".$lang["button_filebrowser"]."</h2>";
		$filename2 = substr(str_replace($mc_path,"",$fullpath),0,-1);
		echo "<p><u>".$lang["file"].":</u> /".$filename2."</p>";
		if($filename2==$mc_server OR in_array($filename2,$forbidden) OR ($allow_mode AND !in_array(pathinfo($filename2, PATHINFO_EXTENSION),$allowed_types)) OR (!$allow_mode AND in_array(pathinfo($filename2, PATHINFO_EXTENSION),$denied_types))){
			echo "<p class='error'>".$lang["forbidden"]."</p>";
			echo "<button class=\"button_back\" onclick=\"openPopup('editor','".$link."')\"><div></div> ".$lang["button_back"]."</button> ";
		}else{
			echo "<p><textarea id='fileeditor'>".file_get_contents($filename)."</textarea></p>";
			echo "<button class=\"button_back\" onclick=\"openPopup('editor','".$link."')\"><div></div> ".$lang["button_back"]."</button> ";
			echo "<button class=\"button_save\" onclick=\"openPopup('editor','".$filename2."','save')\"><div></div> ".$lang["button_save"]."</button> ";
			echo "<span id='save_msg'></span>";
		}
	}else{
		echo "<h2>".$lang["button_filebrowser"]."</h2>";
		echo "<p><u>".$lang["path"].":</u> /".str_replace($mc_path,"",$fullpath)."</p><ul>";

		if($fullpath != $mc_path AND @filetype($fullpath)=='dir'){
			echo "<li class=\"back\" onclick=\"openPopup('editor','$link')\">".$lang["button_back"]."</li>";
		}
		$files=array_diff(scandir($fullpath,1),array('..','.'));
		foreach($files AS $f){
			if(filetype($fullpath.$f)=="dir"){
				$files=array_diff($files,array($f));
				$dirs[] = $f;
			}else if($hide_forbidden){
				if($filename2==$mc_server OR in_array($filename2,$forbidden) OR ($allow_mode AND !in_array(pathinfo($f, PATHINFO_EXTENSION),$allowed_types)) OR (!$allow_mode AND in_array(pathinfo($f, PATHINFO_EXTENSION),$denied_types))){
					$files=array_diff($files,array($f));
				}
			}
		}
		@natcasesort($dirs);
		@natcasesort($files);
		if($dirs){
			$files=array_merge($dirs,$files);
		}
		foreach($files AS $file){
			if(substr($file,0,1) != "."){
				$link="";
				foreach($edit AS $x){
					if($x){
						$link.=$x."/";
					}
				}
				$link.=$file;
				$ftype=filetype($mc_path.$link);
				echo "<li class=\"$ftype\" onclick=\"openPopup('editor','$link')\">".$file;
				if($ftype=="file"){ echo " (".showsize($mc_path.$link).")"; }
				echo "</li>";
			}
		}
		echo "</ul>";
	}
}else{
	header("Location: /");
	exit();
}
?>
