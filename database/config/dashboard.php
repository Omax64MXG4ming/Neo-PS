<?php
$homePath = '/../';
require_once __DIR__."../".$homePath."../index/app.php";
$installed = true; // Like i said, it changed!

$gdps = "$gdps"; // Used to title and download
$lrEnabled = 1; // 1 = Level reupload enabled, 0 = disabled
$msgEnabled = 1; // 1 = Messenger enabled, 0 = disabled
$clansEnabled = 1; // 1 = Clans enabled, 0 = disabled
$songEnabled = 12; // 0 = Song reupload disabled, add 1 to enable song file reupload, add 2 to enable song link reupload
$sfxEnabled = 1; // 0 = SFX upload disabled, 1 = enabled
$convertEnabled = 1; // 1 = Convert SFX to OGG enabled, 0 = disabled
$songSize = 8; // Max song size in megabytes
$sfxSize = 5; // Max SFX size in megabytes
$timeType = 1; // How time will show in-game, 0 - default Cvolton time, 1 - Dashboard-like time, 2 - RobTop-like time
$dashboardIcon = '../icon.png'; // Icon at the top left of dashboard, can be link
$dashboardFavicon = '../icon.png'; // Icon in browser's tab, can be link
$background = '../../bg.png';
$homeLink = '../dashboard/';//FIXED DASHBOARD LINK AND ICON BUTTON
$startLink = '../../';
$webIcon = 'https://neops.x10.mx/icon.png';
$listLink = 'https://neops.x10.mx/demonlist/';
$preenableSongs = true; // true = songs are enabled when reuploading, false = song must be enabled through dashboard/stats/disabledSongsList.php in order to use it
$preenableSFXs = true;

$pc = "$getWindows";
$mac = '';
$android = "$getAndroid";
$ios = "$getIos";

// Launcher executable names (like "launcher.exe"), place them to dashboard/download folder

$pcLauncher = "";
$macLauncher = "";
$androidLauncher = "";
$iosLauncher = "";

$vk = '';
$gdpshub = "$gdpshub";
$github = "$github";
$discord = "$discord";
$twitter = "$twitter";
$youtube = "$youtube";
$twitch = "$twitch";

# TY INFO IN : ../../index/app.php CONFIG
$thirdParty[] = array("$tyIcon1", "$tyUser1", "$tyLink1", "$tyInfo1");

# TY 2 :

$thirdParty[] = array("$tyIcon2", "$tyUser2", "$tyLink2", "$tyInfo2");

# TY 3 :

 $thirdParty[] = array("$tyIcon3", "$tyUser3", "$tyLink3", "$tyInfo3");

?>
