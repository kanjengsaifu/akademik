// Configurations. For more information check the Documentation folder
// var bgColor        = "#630460";
// var LockWallpaper  = "back1.jpg";
var bgColor        = "rgb(1, 64, 81)";
var LockWallpaper  = "back10.png";
var WeekDays       = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
var Months         = new Array("january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december");
var MonthSeparator = "of";

var UserEnterMessage = "Please, enter your username.";
var RememberMeLabel  = "Remember me";
var LoadingMessage   = "Login.. Please Wait."
var ErrorMessage     = "Username and password are not correct.";
var ErrorBotonLabel  = "Accept";

var ColorBar    = new Array ("#014051", "#c50577", "#006731", "#22236c", "#000000", "#c2161d", "#f7941d", "#630460");
var Backgrounds = new Array ("back1.jpg","back2.jpg","back3.jpg","back4.jpg","back5.jpg","back6.jpg","back7.jpg","back8.jpg","back9.jpg");
var TimeOut = 10;

function isCorrect(IsCorrect){
	if(IsCorrect == 1){
		document.location.reload();
		// window.location.replace("indexs.php");
	}else{
		UnLoading();
	}
}

// Example: ChangeColor('#4b0049');
function ChangeColor(HTMLcolor){
	$("body").css("background",HTMLcolor);
	$("#botLogIn").css("background-color", HTMLcolor);
	$(".color").css("background", HTMLcolor);	
	$("#botTryAgain").css("background-color", HTMLcolor);
	$("#txtCurrentColor").val(HTMLcolor);
}
function ChangeWallpaper(URLimage){
	$("#BackgroundUp").css("background-image","url(backgrounds/"+ URLimage +")");
	$("#txtCurrentBack").val(URLimage);
}
$(".loginMessage").text(UserEnterMessage);
content = '<div id="BackgroundUp"></div>';
$("body").append(content);
content  = '<input type="hidden" id="HiddenPass" name="HiddenPass"/>';
content += '<div class="squaredTwo"><input type="checkbox" value="None" id="squaredTwo" name="chkRemember"/><label for="squaredTwo" class="color"></label></div><input type="hidden" id="txtRememberMe" name="txtRememberMe" value="0"/><span class="lblRemember">'+ RememberMeLabel +'</span>';
content += '<input type="hidden" id="txtCurrentColor" name="txtCurrentColor"/>';
content += '<input type="hidden" id="txtCurrentBack" name="txtCurrentBack"/>';
$("#frmLogin").append(content);
content = '<div class="boxLoading"><img src="img/loading82.gif"><span>'+LoadingMessage+'</span></div>';
content += '<div class="loginFail"><span class="OrangeSpan">'+ ErrorMessage +'</span><br/><br/><button id="botTryAgain">'+ ErrorBotonLabel +'</button></div>';
$(".LoginBox").append(content);

$("body").css("background",bgColor);
$("#botLogIn").css("background-color", bgColor);
$(".color").css("background", bgColor);
$("#botTryAgain").css("background-color", bgColor);

$("#BackgroundUp").css("background-image","url(backgrounds/"+ LockWallpaper +")");
$("#txtCurrentColor").val(bgColor);
$("#txtCurrentBack").val(LockWallpaper);

content = '<div id="DivBacks">';
for(i=0; i<Backgrounds.length ;i++){
	content += '<div class="boxBack"><img src="backgrounds/mini'+ Backgrounds[i] +'"/>'+ Backgrounds[i] +'</div>';
}content += '</div>';

$("body").append(content);

content = '<div id="DivColors">';
for(i=0; i<ColorBar.length ;i++){
	content += '<div class="boxColor">'+ ColorBar[i] +'</div>';
}content += '</div>';

$("body").append(content);
var Seeing  = 0;
var Save    = "";
var Open    = 0;
var OnError = 0;
var Checked = 0;

var BarOpen = 0;
var BacOpen = 0;

var TimeOutTempo = TimeOut;

// creating the div for time
var content = '<div class="MetroBox"><span id="MetroTime">hh:mm</span><br/><span id="MetroDate"><br/>day, dd of mm</span></div>';
$("#BackgroundUp").append(content);

// Time
NowTime();
// Timer tick
setInterval(function(){
	NowTime();
},1000);

function NowTime(){
	var now = new Date();
	$("#MetroDate").text(WeekDays[now.getDay()] + ", " + now.getDate() + " " + MonthSeparator + " " + Months[now.getMonth()]);
	var min = now.getMinutes();
	if(min < 10){
		min = "0" + now.getMinutes();
	}else{
		min =  now.getMinutes();
	}
	$("#MetroTime").text(now.getHours()+ ":" + min);
	// Closing if reach timeout
	if(Open==1){
		if(TimeOutTempo ==0){
			$("body").focus();
			$("#BackgroundUp").removeClass("fadeOutUpBig");
			$("#BackgroundUp").addClass("fadeInDownBig").delay(100).queue(function(){  
                $("#BackgroundUp").clearQueue();
				Open = 0;
            });
            TimeOutTempo = TimeOut;
		}else{
			TimeOutTempo = TimeOutTempo -1;
		}
	}else{
		TimeOutTempo = TimeOut;
	}
}

$("#BackgroundUp").click(function(){
	//IE fix
	if($.browser.msie){
		$("#BackgroundUp").hide();
	}
	$(".LoginBox").show();
	$(this).removeClass("fadeInDownBig");
	$(this).addClass("animated fadeOutUpBig");
	$("#userTB").focus();
	Open=1;

	if(BacOpen==1){
		$("#DivBacks").removeClass("animated fadeIn quick");
		$("#DivBacks").addClass("animated fadeOut quick").delay(300).queue(function(){
			$(this).clearQueue();
			$(this).hide();
		});
		BacOpen=0;
	}
});

$("#userTB").keyup(function(){
	var User = $(this).val();
	if(User.length <1)
		User = UserEnterMessage;
	$("h2").text(User);
});

// If you need more parameter values, you can modify this function
$("#botLogIn").click(function(){
	var User = $.trim($("#userTB").val());
	var Pass = $("#passTB").val();
	if(User.length <1){
		$("#userTB").focus();
		return false;
	}
	if(Pass.length <1){
		$("#passTB").focus();
		return false;
	}
	if(OnError==1){
		$("#botTryAgain").click();
	}else{
		Loading();	
	}
});

function Loading(){
	$(".fields").hide();
	$(".boxLoading").addClass("animated fadeIn quick");
	$(".boxLoading").show();
}
function UnLoading(){
	$(".boxLoading").hide();
	$(".loginFail").show();
}
$(".seePass").mousedown(function(){
	Save = $("#passTB").val();
	$("#passTB").replaceWith('<input id="txtVisible" type="text" value="'+ Save +'" placeholder="Password"/>');
});
$(".seePass").mouseup(function(){
	Save = $("#txtVisible").val();
	$("#txtVisible").replaceWith('<input id="passTB" type="password" value="'+ Save +'"  placeholder="Password"/>');
});
$(".seePass").mouseout(function(){
	$(this).mouseup();
});
$("#userTB").keypress(function(e){
	TimeOutTempo = TimeOut;
	var code = (e.keyCode ? e.keyCode : e.which);
	 if(code == 13) { 
	   	$("#botLogIn").click();
	 }
});
$("#passTB").keypress(function(e){
	TimeOutTempo = TimeOut;
	var code = (e.keyCode ? e.keyCode : e.which);
	 if(code == 13) { 
	   	$("#botLogIn").click();
	 }
});
// Open and close with ESC and ENTER Button
$("body").keyup(function(e){
	if (e.keyCode == 27) { 
		$("#userTB").val("");
		$("#passTB").val("");
		if(Open==1){
			//IE fix
			if($.browser.msie){
				$("#BackgroundUp").show();
			}
			$("body").focus();
			$("#BackgroundUp").removeClass("fadeOutUpBig");
			$("#BackgroundUp").addClass("fadeInDownBig").delay(100).queue(function()
            {  
                $("#BackgroundUp").clearQueue();
				Open = 0;
            });
		}else{
			$("#BackgroundUp").click();
		}
	}else{
		if (e.keyCode == 13 && Open == 0){
			$("#BackgroundUp").click();
		}
	}
// Accept button if the user type a word
});
$("#botTryAgain").click(function(){

	TimeOutTempo = TimeOut;

	$(".loginFail").delay(300).queue(function(){

		OnError=0;

		$("#passTB").val("");
		$("#passTB").focus();

		$(".loginFail").clearQueue();
		$(".loginFail").hide();

		$(".fields").addClass("animated fadeIn quick");
		$(".fields").show();

	});

});



$(document).ready(function() {
	$('#passTB').on('keyup load',function(){
		$('#pass2TB').val($.md5($('#passTB').val()));	
		// $('#pass2TB').val(encodemd5($('#passTB').val()));	
	});

  	// $(".LoginBox").show();
  	$("#frmLogin").submit(function(){     //Name of the summited form.
		// Save = $("#passTB").val();
		// $("#HiddenPass").val(Save);
		if(OnError==1){
			$("#botTryAgain").click();
			return false;
		}
		// var datax = 'user='+$('#userTB').val()+'&pass='+md5($('#passTB').val());
		// console.log(datax);
		$.ajax({
			type:"POST",             //Keep this value as POST. (is the form type) 
			url:"lib/dblogin.php",         //URL is the page that use the summited information
			dataType: "html",             //Keep the dataType to HTML.
			data:$(this).serialize(),     //Serialize the procedure. 
			// data:datax,     //Serialize the procedure. 
			beforeSend:function(){         //This function is triggered before send the information

			},success:function(response){   //This function is triggered after the "sendcomment.php" is processed.
				// alert(response);
				if(response !=1){
					OnError = 1;
					$(".loginFail").addClass("animated fadeIn quick");
					$(".loginFail").show();
				}isCorrect(response);		  // see "loginCheck.php" to get a better idea about response
			}
		})
		return false;                   //This line avoid the form refresh.
	})
});

// Style correction for firefox
	var ua = $.browser;
  	if ( ua.mozilla ) 
  	{
    	$("#botLogIn").css("top", "-32");
    	$(".seePass").css("top", "-24");
  	}

 $("#squaredTwo").click(function(){

 	if(Checked==0)
 	{
 		$("#txtRememberMe").val("1");
 		Checked=1;
 	}
 	else
 	{
 		$("#txtRememberMe").val("0");
 		Checked=0;
 	}
 	

 });


// Function that create the color bar engine
$("#OptionColor").click(function(){
	TimeOutTempo = TimeOut;
	if (BarOpen==0){
		$("#DivColors").addClass("animated fadeIn quick");
		$("#DivColors").show();
		BarOpen=1;
	}else{
		$("#DivColors").removeClass("fadeIn quick");
		$("#DivColors").addClass("fadeOut quick").delay(300).queue(function(){
			$(this).hide();
		});BarOpen=0;
	}
});

$("#OptionBack").click(function(){
	
	$(".LoginBox").hide();

	if(Open == 1)
	{
		Open = 0;
		$("#BackgroundUp").addClass("fadeInDownBig").delay(100).queue(function()
        {  
            $("#BackgroundUp").clearQueue();
        });

        //IE fix
		if($.browser.msie)
		{
			$("#BackgroundUp").show();
		}
	}



	if(BacOpen == 0)
	{
		$("#DivBacks").addClass("animated fadeIn quick");
		$("#DivBacks").show();
		BacOpen=1;
	}
	else
	{	
		$("#DivBacks").removeClass("fadeIn quick")
		$("#DivBacks").addClass("fadeOut quick").delay(300).queue(function(){
			$(this).clearQueue();
			$(this).hide();
		});
		
		BacOpen=0;
	}
	

});


 $('.boxColor').each(function(index) 
 {
 	var Color = $(this).text();
    $(this).css("background-color", Color);
});


$(".boxBack").click(function(){
	$("#LoginBox").hide();
	var BackImg = $(this).text();
	$("#BackgroundUp").css("background-image","url(backgrounds/"+ BackImg +")");
	$("#txtCurrentBack").val(BackImg);
});


$(".boxColor").click(function(){

	var Color = $(this).text();
	TimeOutTempo = TimeOut;
	
	$("body").css("background",Color);
	$("#botLogIn").css("background-color", Color);
	$(".color").css("background", Color);	
	$("#botTryAgain").css("background-color", Color);

	$("#txtCurrentColor").val(Color);
});


