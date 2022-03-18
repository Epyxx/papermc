<?php require_once("config.php"); ?>
<html>
	<head>
		<title><?php echo $lang["title"]; ?></title>
		<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
		<link rel="stylesheet" href="/style.css">
		<script type="text/javascript" src="/jquery.js"></script>
		<script type="text/javascript" src="/main.js"></script>
	</head>
	<body>
		<div id="layer"><div id="popup"></div></div>
		<h2><img src="/img/logo.png" alt=""> <?php echo $lang["title"]; ?></h2>
		<div id="info"></div>
		<div id="log"><?php echo $lang["wait"]; ?></div>
		<hr>
		<form id="input" method="post" action"/" onsubmit="return sendCmd()">
			<?php echo $lang["send_cmd"]; ?> <input type="text" id="cmd" name="cmd" size="100">
			<button type="submit" class="button_send"><div></div> <?php echo $lang["button_send"]; ?></button>
			<input type="checkbox" id="autoscroll" checked>
			<label for="autoscroll"><?php echo $lang["autoscroll"]; ?></label>
			<input type="checkbox" id="autoload" checked>
			<label for="autoload"><?php echo $lang["autoload"]; ?></label>
		</form>
		<div id="copy">(c) 2020-<?php echo date("Y"); ?> Epyx</div>
	</body>
</html>
