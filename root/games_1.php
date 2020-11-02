<?php
include_once("php_includes/check_login_status.php");
if($user_ok != true || $log_username == "") {
	header("location: http://leedavidsoncontentmanagementsystem1.com/cms_1/root/index.php");
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Games 1</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style/style.css">
<script src="js/main.js"></script>





<script type="text/javascript">
	function active(){
		var searchBar = document.getElementById('searchBar');
				
		if(searchBar.value == 'Search...'){
			searchBar.value = ''
			searchBar.placeholder = 'Search...'
		}
	}
	function inactive(){
		var searchBar = document.getElementById('searchBar');
				
		if(searchBar.value == ''){
			searchBar.value = 'Search...'
				searchBar.placeholder = ''
		}
	}
</script> 





<style type="text/css">
.button_bar{
border:1px solid #7eb9d0; -webkit-border-radius: 3px; -moz-border-radius: 3px;border-radius: 3px;font-size:14px;font-family:arial, helvetica, sans-serif; padding: 10px 10px 10px 10px; text-align: center; text-decoration:none; display:inline-block;text-shadow: -1px -1px 0 rgba(0,0,0,0.3);font-weight:bold; color: #FFFFFF;
 background-color: #a7cfdf; background-image: -webkit-gradient(linear, left top, left bottom, from(#a7cfdf), to(#23538a));
 background-image: -webkit-linear-gradient(top, #a7cfdf, #23538a);
 background-image: -moz-linear-gradient(top, #a7cfdf, #23538a);
 background-image: -ms-linear-gradient(top, #a7cfdf, #23538a);
 background-image: -o-linear-gradient(top, #a7cfdf, #23538a);
 background-image: linear-gradient(to bottom, #a7cfdf, #23538a);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#a7cfdf, endColorstr=#23538a);
 
 
    top: 1px;

    border: 1px solid #5B9BD5; /* Cyan border */
    color: white; /* White text */
    padding: 10px 24px; /* Some padding */
    cursor: pointer; /* Pointer/hand icon */
    float: left; /* Float the buttons side by side */
	margin-left: 20px;
	margin-right: 20px;
}

.button_bar:hover{
 border:1px solid #5ca6c4;
 background-color: #82bbd1; background-image: -webkit-gradient(linear, left top, left bottom, from(#82bbd1), to(#193b61));
 background-image: -webkit-linear-gradient(top, #82bbd1, #193b61);
 background-image: -moz-linear-gradient(top, #82bbd1, #193b61);
 background-image: -ms-linear-gradient(top, #82bbd1, #193b61);
 background-image: -o-linear-gradient(top, #82bbd1, #193b61);
 background-image: linear-gradient(to bottom, #82bbd1, #193b61);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#82bbd1, endColorstr=#193b61);
}
</style>





<style type="text/css">
.flip3D> .front{
    position:absolute;
	-webkit-transform: perspective( 600px ) rotateY( 0deg );
	transform: perspective( 600px ) rotateY( 0deg );
	-webkit-backface-visibility: hidden;
	backface-visibility: hidden;
	transition: -webkit-transform .5s linear 0s;
	transition: transform .5s linear 0s;
}

.flip3D > .back{
	position:absolute;
	-webkit-transform: perspective( 600px ) rotateY( 180deg );
	transform: perspective( 600px ) rotateY( 180deg );
	-webkit-backface-visibility: hidden;
	backface-visibility: hidden;
	transition: -webkit-transform .5s linear 0s;
	transition: transform .5s linear 0s;
}

.flip3D:hover > .front{
	-webkit-transform: perspective( 600px ) rotateY( -180deg );
	transform: perspective( 600px ) rotateY( -180deg );
}

.flip3D:hover > .back{
	-webkit-transform: perspective( 600px ) rotateY( 0deg );
	transform: perspective( 600px ) rotateY( 0deg );
}
</style>








<style>
.flip3Dclick > .front{
    position: absolute;
    transform:perspective(600px) rotateY(0deg);
    -webkit-transform:perspective(600px) rotateY(0deg);
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
    transition: 0.5s linear 0s;
    -webkit-transition: 0.5s linear 0s;
}
.flip3Dclick > .back{
    position: absolute;
    transform:perspective(600px) rotateY(180deg);
    -webkit-transform:perspective(600px) rotateY(180deg);
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
    transition: 0.5s linear 0s;
    -webkit-transition: 0.5s linear 0s;
}

.flip3Dclick:hover > .front{
	-webkit-transform: perspective( 600px ) rotateY( -180deg );
	transform: perspective( 600px ) rotateY( -180deg );
}

.flip3Dclick:hover > .back{
	-webkit-transform: perspective( 600px ) rotateY( 0deg );
	transform: perspective( 600px ) rotateY( 0deg );
}
</style>


<script>
    
    function flipit(el, boo) {
        
        if(boo == true){
        el.children[1].style.webkitTransform = "perspective(600px) rotateY(-180deg)";
        el.children[0].style.webkitTransform = "perspective(600px) rotateY(0deg)";
        el.children[1].style.transition = "all .5s linear 0s";
        el.children[0].style.transition = "all .5s linear 0s";
        el.children[1].style.transform = "perspective(600px) rotateY(-180deg)";
        el.children[0].style.transform = "perspective(600px) rotateY(0deg)";
        el.children[1].style.webkitTransition = "all .5s linear 0s";
        el.children[0].style.webkitTransition = "all .5s linear 0s";
        }
        if(boo == false){
        el.children[1].style.webkitTransform = "perspective(600px) rotateY(0deg)";
        el.children[0].style.webkitTransform = "perspective(600px) rotateY(180deg)";
        el.children[1].style.transition = "all .5s linear 0s";
        el.children[0].style.transition = "all .5s linear 0s";
        el.children[1].style.transform = "perspective(600px) rotateY(0deg)";
        el.children[0].style.transform = "perspective(600px) rotateY(180deg)";
        el.children[1].style.webkitTransition = "all .5s linear 0s";
        el.children[0].style.webkitTransition = "all .5s linear 0s";
        }
    }
</script>





<style type="text/css">
.beerman_1_button{
border:1px solid #7eb9d0; -webkit-border-radius: 3px; -moz-border-radius: 3px;border-radius: 3px;font-size:14px;font-family:arial, helvetica, sans-serif; padding: 10px 10px 10px 10px; text-align: center; text-decoration:none; display:inline-block;text-shadow: -1px -1px 0 rgba(0,0,0,0.3);font-weight:bold; color: #FFFFFF;
 background-color: #a7cfdf; background-image: -webkit-gradient(linear, left top, left bottom, from(#a7cfdf), to(#23538a));
 background-image: -webkit-linear-gradient(top, #a7cfdf, #23538a);
 background-image: -moz-linear-gradient(top, #a7cfdf, #23538a);
 background-image: -ms-linear-gradient(top, #a7cfdf, #23538a);
 background-image: -o-linear-gradient(top, #a7cfdf, #23538a);
 background-image: linear-gradient(to bottom, #a7cfdf, #23538a);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#a7cfdf, endColorstr=#23538a);
 
 
    padding: 10px 24px; /* Some padding */ 
    cursor: pointer; /* Pointer/hand icon */
	margin-left: 250px;
}

.beerman_1_button:hover{
 border:1px solid #5ca6c4;
 background-color: #82bbd1; background-image: -webkit-gradient(linear, left top, left bottom, from(#82bbd1), to(#193b61));
 background-image: -webkit-linear-gradient(top, #82bbd1, #193b61);
 background-image: -moz-linear-gradient(top, #82bbd1, #193b61);
 background-image: -ms-linear-gradient(top, #82bbd1, #193b61);
 background-image: -o-linear-gradient(top, #82bbd1, #193b61);
 background-image: linear-gradient(to bottom, #82bbd1, #193b61);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#82bbd1, endColorstr=#193b61);
}
</style>





</head>
<body>
<?php include_once("template_pageTop.php"); ?>
<div id="gamePageMiddle">
    </br>  
        <div class="game_button_group" style="width:100%">
            <a>
                <div><a class="button_bar" href="http://leedavidsoncontentmanagementsystem1.com/cms_1/root/games_1.php" title="link to Beerman" style="height:20px; width:100px">Game 1</div></h3></a>
                  
                  
                <div><a class="button_bar" href="http://leedavidsoncontentmanagementsystem1.com/cms_1/root/games_2.php" title="link to Beerman" style="height:20px; width:100px">Game 2</div></h3></a>
                
                
                <div><a class="button_bar" href="http://leedavidsoncontentmanagementsystem1.com/cms_1/root/games_3.php" title="link to Beerman" style="height:20px; width:100px">Game 3</div></h3></a>
                
                
                <div><a class="button_bar" href="http://leedavidsoncontentmanagementsystem1.com/cms_1/root/games_4.php" title="link to Beerman" style="height:20px; width:100px">Game 4</div></h3></a>
                
                
                <div><a class="button_bar" href="http://leedavidsoncontentmanagementsystem1.com/cms_1/root/games_5.php" title="link to Beerman" style="height:20px; width:100px">Game 5</div></h3></a>
            </a>
        </div>
    </br>
	</br>
	</br>
        <div id="pageMiddle_Game_Container" style="width:100%">
            <div class="flip3Dclick">
                <div class="back" onclick="flipit(this.parentNode, false);"><img src="images/games/beerman_back.png" alt="beerman_back_image" width="1000" height="400"></div>
                <div class="front" onclick="flipit(this.parentNode, true);"><img src="images/games/beerman_title.png" alt="beerman_title" width="1000" height="400"></div>
            </div>            
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>

        </div>        

	<h3>&nbsp;&nbsp;&nbsp;&nbsp;Download&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tap Image To Flip</h3>
	<div><a id="download_button_1" <a class="button_bar" href="https://1drv.ms/u/s!AthsCUt5GHHImzJFM0oWd9BXAsYT" title="Link to Beerman Game" style="height:20px; width:100px">Download</div></h3></a>
    </br>

   	<div id="gamelinks">
	        </br>
	        </br>
	        <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        Beerman Steam Website<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <a class="beerman_1_button" href="http://store.steampowered.com/app/508950/" title="link to Beerman Game" style="height:20px; width:100px">Link</div></h3></a>
	        
            <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp; Beerman Main Website<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <a class="beerman_1_button" href="http://beermangame.com" title="link to Beerman Website" style="height:20px; width:100px">Link</div></h3></a>
	        
            <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp; Beerman Video Website<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <a class="beerman_1_button" href="http://steamcommunity.com/app/508950/videos/" title="link to Beerman Videos" style="height:20px; width:100px">Link</div></h3></a>
	        
            <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp; Beerman Trading Cards<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <a class="beerman_1_button" href="http://www.steamcardexchange.net/index.php?gamepage-appid-508950" title="link to Beerman Trading Cards" style="height:20px; width:100px">Link</div></h3></a>
	        
            <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp; Beerman Android App<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <a class="beerman_1_button" href="https://www.amazon.co.uk/dp/B075KDY2Q4/ref=sr_1_1?s=mobile-apps&ie=UTF8&qid=1505359266&sr=1-1&keywords=Beerman" title="link to Beerman App" style="height:20px; width:100px">Link</div></h3></a>
	        
            <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp; Beerman Windows App<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <a class="beerman_1_button" href="https://www.microsoft.com/en-gb/store/p/beerman/9mx5g3mcvj3k" title="link to Beerman App" style="height:20px; width:100px">Link</div></h3></a>
	       
	    </div>
</div>

<div id="gamesstatusarea">

</div>

<div id="pageBottom" >
    <?php include_once("template_pageBottom.php");?>
</div>

</body>
</html>