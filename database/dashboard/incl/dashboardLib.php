<?php
$dbPath = '../'; // Path to main directory. It needs to point to main endpoint files. If you didn't change dashboard place, don't change this value. Usually it's '../' (cuz dashboard folder is inside main endpoints folder) (https://imgur.com/a/P8LdhzY).
require __DIR__."/../".$dbPath."config/dashboard.php";
require_once "auth.php";
$au = new au();
$dashCheck = $au->auth($dbPath);
// Dashboard library
class dashboardLib {
	public function printHeader($isSubdirectory = true){
		$this->handleLangStart();
      	global $gdps;
		global $dashboardIcon;
        global $background;
		if(file_exists("../../incl/cvolton.css")) $css = filemtime("../../incl/cvolton.css");
		elseif(file_exists("../incl/cvolton.css")) $css = filemtime("../incl/cvolton.css");
		else $css = filemtime("incl/cvolton.css");
		echo '<!DOCTYPE html>
				<html lang="en">
					<head>
  
                    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
						<link rel="icon" type="image/png" sizes="64x64" href="'.$dashboardIcon.'">
						<meta charset="utf-8">
						<meta name="color-scheme" content="black">
							
						<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit="no">';
if($isSubdirectory) echo '<base href="../">'; else echo '<base href="./">';
				echo '<script src="incl/jq.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script async src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
<script src="incl/jsmediatags.js"></script>
<script src="incl/imgcolr.js"></script>
<link href="incl/fontawesome/css/fontawesome.css" rel="stylesheet">
<link href="incl/fontawesome/css/brands.css" rel="stylesheet">
<link href="incl/fontawesome/css/solid.css" rel="stylesheet">
<link href="incl/fontawesome/css/regular.css" rel="stylesheet">
                          
						  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="incl/cvolton.css?'.$css.'">
<body><div id="loader"><img src="logo.png" alt="Logo" class="loader-logo">

        <title>'.$gdps.'</title>';
	echo '</head>

</div>

<div style="height: 100%;display: contents;">

                ';
	}
	public function getLocalizedString($stringName, $lang = '') {
		if(empty($lang)) {
			if(!isset($_COOKIE["lang"]) OR !ctype_alpha($_COOKIE["lang"])) {
				if(file_exists(__DIR__.'/lang/locale'.strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))).'.php') $lang = strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
				else $lang = "EN";
			} else $lang = $_COOKIE["lang"];
		}
		$lang = substr($lang, 0, 2);
		$locale = __DIR__."/lang/locale".$lang.".php";
		if(file_exists($locale)) require $locale;
		else require __DIR__."/lang/localeEN.php";
		if(isset($string[$stringName])) return $string[$stringName];
		else {
		    require __DIR__."/lang/localeEN.php";
		    if(isset($string[$stringName])) return $string[$stringName];
			else return "lnf:$stringName";
		}
	}
	public function printBoxBody(){
		echo '<span id="htmlpage" style="width: 100%;height: 100%;display: contents;">
<div class="container container-box">
					<div class="card">
						<div class="card-block buffer">';
	}
	public function printBox($content, $active = "", $isSubdirectory = true){
		$this->printHeader($isSubdirectory);
		$this->printNavbar($active);
        $this->printFooter();
        $this->printBoxFooter();
		$this->printBoxBody();
		echo $content;
		
	}
	public function printSong($content, $active = "", $isSubdirectory = true){
		$this->printHeader($isSubdirectory);
		$this->printNavbar($active, $isSubdirectory);
		echo '<span id="htmlpage" style="width: 100%;height: 100%;display: contents;">'.$content.'</span>';
	}
  
  /* footer */
  
  public function printFooter($sub = ''){
		global $dbPath;
		global $wiki;
      	global $vk;
      	global $discord;
      	global $twitter;
      	global $youtube;
      	global $twitch;
		echo '<div class="footer">'.$this->getLocalizedString("footer").'<div>';
// extra 10 
      	if($wiki != '') echo '<a href="'.$wiki.'"target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/wiki.png"></a>';

// extra 10 end 

        if($youtube != '') echo '<a href="'.$youtube.'" target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/youtube.png"></a>';
        if($discord != '') echo '<a href="'.$discord.'"target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/discord.png"></a>';
      	if($twitter != '') echo '<a href="'.$twitter.'"target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/twitter.png"></a>';
      	if($vk != '') echo '<a href="'.$vk.'"target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/vk.png"></a>';
      	if($twitch != '') echo '<a href="'.$twitch.'"target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/twitch.png"></a>';
        echo '</div></div></div>
        
    <script>
document.addEventListener("DOMContentLoaded", () => {
    setTimeout(() => {
        const loader = document.getElementById("loader");
        if (loader) loader.classList.add("hide");
    }, 300);
});
</script>      


        </body></html>';
	}
  
  /* footer end */
  
	public function printBoxFooter(){
		echo '</div></div></div></span>';
	}
	
	public function printLoginBox($content){
		$this->printBox("<h1 id='center'>".$this->getLocalizedString("loginBox")."</h1>".$content);
	}
	public function printLoginBoxInvalid(){
		$this->printLoginBox("<p>".$this->getLocalizedString("wrongNickOrPass")."");
	}
	public function printLoginBoxError($content){
		$this->printLoginBox("<p>An error has occured: $content. <a href=''>Click here to try again.</a>");
	}
	public function printNavbar($active, $isSubdirectory = true) {
		global $gdps;
		global $lrEnabled;
      	global $msgEnabled;
      	global $songEnabled;
      	global $sfxEnabled;
      	global $clansEnabled;
      	global $pc;
      	global $mac;
      	global $android;
        global $ios;
        global $pcLauncher;
        global $macLauncher;
        global $androidLauncher;
        global $iosLauncher;
		global $thirdParty;
      	global $dbPath;
		global $dashboardIcon;
		require_once __DIR__."/../".$dbPath."incl/lib/Captcha.php";
		require __DIR__."/../".$dbPath."config/security.php";
		require __DIR__."/../".$dbPath."config/mail.php";
		require_once __DIR__."/../".$dbPath."incl/lib/mainLib.php";
      	require __DIR__."/../".$dbPath."incl/lib/connection.php";
		if(!isset($enableCaptcha)) global $enableCaptcha;
		if(!isset($preactivateAccounts)) global $preactivateAccounts;
      	if($enableCaptcha) {
      	    $captchaTypes = ['hcaptcha', 'grecaptcha', 'turnstile'];
      	    $captchaUsed = $captchaTypes[$captchaType-1];
      	}
		$gs = new mainLib();
		$homeActive = $accountActive = $browseActive = $modActive = $reuploadActive = $statsActive = $msgActive = $profileActive = "";
		switch($active) {
			case "home":
				$homeActive = "active tooactive";
				break;
			case "account":
				$accountActive = "active tooactive";
				break;
			case "browse":
				$browseActive = "active tooactive";
				break;
			case "mod":
				$modActive = "active tooactive";
				break;
			case "reupload":
				$reuploadActive = "active tooactive";
				break;
			case "stats":
				$statsActive = "active tooactive";
				break;
           	case "msg":
				$msgActive = "active tooactive";
				break;
           	case "profile":
				$profileActive = "active tooactive";
				break;
		}
		echo '<nav id="navbarepta" class="navbar navbar-expand-lg navbar-dark menubar">
			<input type="hidden" id="isSubdirectory" value="'.($isSubdirectory ? 'true' : 'false').'"></input>
     <button href="'.$homeLink.'" onclick="a(\'../dashboard\')" class="navbar-brand" style="margin-right:0.5rem; position:relative; background:none;border:none">       
            <img src="'.$dashboardIcon.'" style="width:35px; position:relative; left:0px;"></button>
	
    
    
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="navbar-nav">
				<li class="nav-item '.$homeActive.' ">
						<a href=".$homeLink." onclick="a(\'../dashboard\')" style="background:none;border:none" class="nav-link" >
							<i class="fa-solid fa-house"></i> '.$this->getLocalizedString("homeNavbar").'
						</a>
					</li>';
		$browse = '<li class="nav-item dropdown '.$browseActive.' ">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-magnifying-glass" aria-hidden="false"></i> '.$this->getLocalizedString("browse").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a type="button" href="stats/accountsList.php" onclick="a(\'stats/accountsList.php\')" class="dropdown-item"><div class="icon"><i class="fa-solid fa-user" aria-hidden="false"></i></div>'.$this->getLocalizedString("accounts").'</a>
							<a type="button" href="stats/levelsList.php" onclick="a(\'stats/levelsList.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-gamepad" style="margin-top: 1px;"></i></div>'.$this->getLocalizedString("levels").'</a>
							<a type="button" href="stats/packTable.php" onclick="a(\'stats/packTable.php\')"class="dropdown-item"><div class="icon"><i class="fa-regular fa-folder-open" aria-hidden="false"></i></div>'.$this->getLocalizedString("packTable").'</a>
							<a type="button" href="stats/gauntletTable.php" onclick="a(\'stats/gauntletTable.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-globe" aria-hidden="false"></i></div>'.$this->getLocalizedString("gauntletTable").'</a>
							<a type="button" href="stats/listsTable.php" onclick="a(\'stats/listsTable.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-list-ul" aria-hidden="false"></i></div>'.$this->getLocalizedString("listTable").'</a>
							<a type="button" href="stats/songList.php" onclick="a(\'stats/songList.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("songs").'</a>
							<a type="button" href="stats/SFXList.php" onclick="a(\'stats/SFXList.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-drum" aria-hidden="false"></i></div>'.$this->getLocalizedString("sfxs").'</a>';
							if($clansEnabled) $browse .= '<a type="button" href="clans" onclick="a(\'clans\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-dungeon" aria-hidden="false"></i></div>'.$this->getLocalizedString("clans").'</a>';
		if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0) {
			echo '<li class="nav-item dropdown '.$accountActive.' ">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-user" aria-hidden="true"></i> '.$this->getLocalizedString("accountManagement").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a type="button" href="account/changePassword.php" onclick="a(\'account/changePassword.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-key" aria-hidden="false"></i></div>'.$this->getLocalizedString("changePassword").'</a>
							<a type="button" href="account/changeUsername.php" onclick="a(\'account/changeUsername.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-user" aria-hidden="false"></i></div>'.$this->getLocalizedString("changeUsername").'</a>
							<a type="button" href="stats/unlisted.php" onclick="a(\'stats/unlisted.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-list-ul" aria-hidden="false"></i></div>'.$this->getLocalizedString("unlistedLevels").'</a>
							<a type="button" href="stats/manageSongs.php" onclick="a(\'stats/manageSongs.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("manageSongs").'</a>
							<a type="button" href="stats/manageSFX.php" onclick="a(\'stats/manageSFX.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-drum" aria-hidden="false"></i></div>'.$this->getLocalizedString("manageSFX").'</a>
							<a type="button" href="stats/favouriteSongs.php" onclick="a(\'stats/favouriteSongs.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-heart" aria-hidden="false"></i></div>'.$this->getLocalizedString("favouriteSongs").'</a>
							<a type="button" href="stats/listsTableYour.php" onclick="a(\'stats/listsTableYour.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-list" aria-hidden="false"></i></div>'.$this->getLocalizedString("listTableYour").'</a>
						</div>
					</li>' . $browse . '</div></li>';
					echo '<li class="nav-item dropdown '.$reuploadActive.'">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-upload" style="margin-right:5" aria-hidden="true"></i>'.$this->getLocalizedString("reuploadSection").'
						</a>
						<div class="dropdown-menu" id="cronview" aria-labelledby="navbarDropdownMenuLink">';
          					if(strpos($songEnabled, '1') !== false) echo '<a type="button" href="songs" onclick="a(\'songs\')" class="dropdown-item"><i class="fa-solid fa-file" style="position: absolute;font-size: 10px;margin: 5px 5px 5px -2px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("songAdd").'</a>';
          					if(strpos($songEnabled, '2') !== false) echo '<a type="button" href="reupload/songAdd.php" onclick="a(\'reupload/songAdd.php\')"class="dropdown-item"><i class="fa-solid fa-link" style="position: absolute;font-size: 9px;margin: 5px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("songLink").'</a>';
          					if(strpos($sfxEnabled, '1') !== false) echo '<a type="button" href="sfxs" onclick="a(\'sfxs\')" class="dropdown-item"><div class="icon"><i class="fa-solid fa-drum" aria-hidden="false"></i></div>'.$this->getLocalizedString("sfxAdd").'</a>';
								if($lrEnabled == 1) echo '<a type="button" href="levels/levelReupload.php" onclick="a(\'levels/levelReupload.php\')"class="dropdown-item"><i class="fa-solid fa-arrow-down" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-cloud" aria-hidden="false"></i></div>'.$this->getLocalizedString("levelReupload").'</a>
                                <a type="button" href="levels/levelToGD.php" onclick="a(\'levels/levelToGD.php\')"class="dropdown-item"><i class="fa-solid fa-arrow-up" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-cloud" aria-hidden="false"></i></div>'.$this->getLocalizedString("levelToGD").'</a>';
          				echo '<button type="button" class="dropdown-item" id="crbtn" onclick="cron(), event.stopPropagation();"><div class="icon"><i id="iconcron" class="fa-solid fa-bars-progress"></i></div>'.$this->getLocalizedString('tryCron').'</button>
						</div>
					</li>';
			if($gs->checkPermission($_SESSION["accountID"], "dashboardModTools")) {
				echo '<li class="nav-item dropdown '.$modActive.'">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-wrench" aria-hidden="true"></i> '.$this->getLocalizedString("modTools").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a type="button" href="account/banPerson.php" onclick="a(\'account/banPerson.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-gavel"></i></div>'.$this->getLocalizedString("leaderboardBan").'</a>
							<a type="button" href="stats/banList.php" onclick="a(\'stats/banList.php\')"class="dropdown-item"><i class="fa-solid fa-gavel" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-list"></i></div>'.$this->getLocalizedString("banList").'</a>';
							echo '<a type="button" href="stats/unlistedMod.php" onclick="a(\'stats/unlistedMod.php\')"class="dropdown-item"><i class="fa-solid fa-eye-slash" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-list-ul" aria-hidden="false"></i></div>'.$this->getLocalizedString("unlistedMod").'</a>
							<a type="button" href="stats/suggestList.php" onclick="a(\'stats/suggestList.php\')"class="dropdown-item"><i class="fa-solid fa-user" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-list" aria-hidden="false"></i></div>'.$this->getLocalizedString("suggestLevels").'</a>
							<a type="button" href="stats/listsTableMod.php" onclick="a(\'stats/listsTableMod.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-list-ul" aria-hidden="false"></i></div>'.$this->getLocalizedString("listTableMod").'</a>';
							echo '<a type="button" href="stats/reportMod.php" onclick="a(\'stats/reportMod.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-exclamation" aria-hidden="false"></i></div>'.$this->getLocalizedString("reportMod").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "dashboardLevelPackCreate")) echo '<a type="button" href="levels/packCreate.php" onclick="a(\'levels/packCreate.php\')"class="dropdown-item"><i class="fa-solid fa-plus" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-regular fa-folder-open" style="margin-left: 2px;" aria-hidden="false"></i></div>'.$this->getLocalizedString("packManage").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "dashboardGauntletCreate")) echo '<a type="button" href="levels/gauntletCreate.php" onclick="a(\'levels/gauntletCreate.php\')"class="dropdown-item"><i class="fa-solid fa-plus" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-globe" aria-hidden="false"></i></div>'.$this->getLocalizedString("gauntletManage").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "dashboardManageSongs")) {
								echo '<a type="button" href="stats/disabledSongsList.php" onclick="a(\'stats/disabledSongsList.php\')"class="dropdown-item"><i class="fa-solid fa-xmark" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("disabledSongs").'</a>';
								echo '<a type="button" href="stats/disabledSFXsList.php" onclick="a(\'stats/disabledSFXsLi
