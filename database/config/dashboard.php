<?php
$homePath = '/../';
require_once __DIR__."../".$homePath."../index/app.php";
$installed = true; // Like i said, it changed!

$gdps = "Neo PS"; // Used to title and download
$lrEnabled = 1; // 1 = Level reupload enabled, 0 = disabled
$msgEnabled = 1; // 1 = Messenger enabled, 0 = disabled
$clansEnabled = 1; // 1 = Clans enabled, 0 = disabled
$songEnabled = 12; // 0 = Song reupload disabled, add 1 to enable song file reupload, add 2 to enable song link reupload
$sfxEnabled = 1; // 0 = SFX upload disabled, 1 = enabled
$convertEnabled = 1; // 1 = Convert SFX to OGG enabled, 0 = disabled
$songSize = 8; // Max song size in megabytes
$sfxSize = 6; // Max SFX size in megabytes
$timeType = 1; // How time will show in-game, 0 - default Cvolton time, 1 - Dashboard-like time, 2 - RobTop-like time
$dashboardIcon = '../icon.png'; // Icon at the top left of dashboard, can be link
$dashboardFavicon = '../icon.png'; // Icon in browser's tab, can be link
$background = '../../bg.png';
$homeLink = '../dashboard/';
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
$gdpshub = 'https://gdpshub.com/gdps/5785';
$github = 'https://github.com/Omax64MXG4ming/Neo-PS';
$discord = 'https://discord.gg/TdB33cAyMn';
$twitter = '';
$youtube = 'https://youtube.com/@omarstudiosoff?si=BbZOU4yt26jFk8qc';
$twitch = '';

$thirdParty[] = array('https://yt3.googleusercontent.com/EZ149IVvU5JX2Fi6yH7R95NQmKdNsea_gggEvJXA0MIZQ397E_WHLLNCgBjL45npnMZNUkpq=s88-c-k-c0x00ffffff-no-rj', 'RobTop', 'https://store.steampowered.com/app/322170/Geometry_Dash/', 'For Geometry Dash');
$thirdParty[] = array('https://avatars.githubusercontent.com/u/5721187', 'Cvolton', 'https://github.com/Cvolton', 'For GDPS code');
$thirdParty[] = array('https://avatars.githubusercontent.com/u/52624723', 'Foxodever', 'https://github.com/foxodever/BetterCvoltonGDPS/blob/main/tools/songs/upload.php', 'For file upload script');

// SFX/Music libraries, syntax is: array(ID (must be unique), LIBRARY NAME, LIBRARY LINK (not to .dat file), LIBRARY TYPE (0 = only SFX, 1 = only music, 2 = both));
// Template: $customLibrary[] = array(1, '', '', 2); 

$customLibrary[] = array(1, 'Geometry Dash', 'https://geometrydashfiles.b-cdn.net', 2); 
$customLibrary[] = array(3, $gdps, null, 2); // Your GDPS's library, don't remove it
$customLibrary[] = array(2, 'Song File Hub', 'https://api.songfilehub.com', 1);

// SFX converter API links, make one by using code from https://github.com/MegaSa1nt/GDPS-ConvertSFX
// Template: $convertSFXAPI[] = "";

$convertSFXAPI[] = "https://niko.gcs.skin";
$convertSFXAPI[] = "https://lamb.gcs.skin";
$convertSFXAPI[] = "https://omori.gcs.skin"; // You're welcome
$convertSFXAPI[] = "https://im.gcs.skin";
$convertSFXAPI[] = "https://hat.gcs.skin";
$convertSFXAPI[] = "https://converter.m336.dev";

$requireAccountForReuploading = false;
$disallowReuploadingNotUserLevels = false;

/*
	Cobalt API
	
	Use Cobalt API to be able to reupload songs with YouTube links and etc.
	Requires file upload to be enabled!
	
	$useCobalt — Should server use Cobalt to reupload songs by links
		True — use Cobalt
		False — don't use Cobalt

	$cobaltAPI[] — links to Cobalt's APIs
		Server will randomly pick one of Cobalt APIs when reuploading song
		
	Turnstile-protected APIs are currently not supported, sorry
*/

$useCobalt = true;
$cobaltAPI[] = 'https://cobalt.gcs.skin';

/*
	Geometry Dash icons renderer Server
	
	Dashboard shows icons of players, therefore it requires some server to get icons
	
	$iconsRendererServer — what server to use
	
	If gdicon.oat.zone doesn't work for you for some reason, you can use icons.gcs.skin
*/

$iconsRendererServer = 'https://gdicon.oat.zone';
?>
