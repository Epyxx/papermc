var autoload = true;

function layerClick(evt){
	if(evt.srcElement.id==="layer"){
		closePopup();
	}
}

function setServer(action,msg) {
	var conf = confirm(msg);
	if (conf) { $.post("/cmd.php",{action: action},function(data){console.log(data);}); }
}

function sendCmd() {
	var cmd = $("#cmd")[0].value;
	$.post("/cmd.php",{cmd: cmd});
	$("#cmd")[0].value = "";
	return false;
}

function loadStatus() {
	$.post("/status.php", function(data) {
		$("#info").html(data);
	});
}

function loadLogs() {
	if(autoload){
		$.post("/logs.php", function(data) {
			$("#log").html(data);
		});
	}
	var elem = $("#log")[0];
	if($("#autoscroll")[0]){
		var autoscroll = $("#autoscroll")[0].checked;
	}
	if($("#autoload")[0]){
		autoload = $("#autoscroll")[0].checked;
	}
	if (autoscroll) { elem.scrollTop = elem.scrollHeight; }
	//$("#cmd")[0].focus();
}

function openPopup(x,y,z){
	$("#layer")[0].style.display='block';
	var file = "/"+x+".php";
	if(z=='save' && $("#fileeditor")[0]){
		var cont=$("#fileeditor")[0].value;
	}else{
		var cont='';
	}
	$.post(file, {param: y, action: z, content: cont}, function(data) {
		if(z==="save"){
			if($("#save_msg")){
				$("#save_msg")[0].innerHTML=data;
				$("#save_msg").hide().fadeIn(1000,function(){
					$(this).delay(3000).fadeOut(1000);
				});
			}
		}else{
			var closeButton = "<div id='close_popup' class='hover' title='Schließen' onclick='closePopup()'></div>";
			$("#popup").html(closeButton+data);
		}
	});
}

function closePopup(){
	$("#popup").html('');
	$("#layer")[0].style.display='none';
}

document.addEventListener('click',layerClick);
setInterval(loadLogs, 500);
setInterval(loadStatus, 5000);
loadStatus();
loadLogs();
