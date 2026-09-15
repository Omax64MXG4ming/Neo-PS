<head>
 <link rel="icon" type="image/png" href="https://neops.x10.mx/icon.png" sizes="96x96" />
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

  
</head>
<?php
# save actual session with php server
# Field Name = string : indexLib.php
// Includes =
# $dbPath for Save The Memory On 
$dbPath = "/../database/";
# original paths for the Download Links : The Dashboard Gets The Links Via Config and in config gets The Writed Text Format on app.php 
# require_once __DIR__.$dbPath."/config/dashboard.php";
$globalDate = '.$globalDate.';
require "app.php";
require_once "checkService.php";
// calls in others php
$il = new indexLib();

class indexLib {
  public function printDashMail() {
    echo '
    ⚠️ You need a valid email address. I want to avoid future account problems. Then you should go to your email inbox and look for this GDPS registration message. ⚠️
    ';
    
    }
  
  public function printFont() {
    echo '<head>
<link href="https://neops.x10.mx/dashboard/incl/fontawesome/css/fontawesome.css" rel="stylesheet">
<link href="https://neops.x10.mx/dashboard/incl/fontawesome/css/brands.css" rel="stylesheet">
<link href="https://neops.x10.mx/dashboard/incl/fontawesome/css/solid.css" rel="stylesheet">
<link href="https://neops.x10.mx/dashboard/incl/fontawesome/css/regular.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
</head>';
    
    }
  
  public function printPage() {
  global $webIcon;
 
    # Print HTML page Headers
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bellota+Text:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" sizes="64x64" src="https://neops.x10.mx/icon.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="/index/style.css" rel="stylesheet">
  <link href="https://neops.x10.mx/dashboard/incl/fontawesome/css/fontawesome.css" rel="stylesheet">
<link href="https://neops.x10.mx/dashboard/incl/fontawesome/css/brands.css" rel="stylesheet">
<link href="https://neops.x10.mx/dashboard/incl/fontawesome/css/solid.css" rel="stylesheet">
<link href="https://neops.x10.mx/dashboard/incl/fontawesome/css/regular.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet"> 
    </head>
   <style>
     /* PARTICLES */
#particles{
    position:fixed;
    width:100vw;
    height:100vh;
    z-index:1;
}
     </style>
    <?php
  }
   
  public function printFooter()
  # First Build : Creater Footer In Any PHP with type include("**indexLib.php");
    {
  global $globalDate;
    
  echo '<div class="footer">Neo PS '.$globalDate.'<div>';
    if ($globalDate != '') echo '';
    ?>
   <style>
    .footer {
  	display: flex;
  	justify-content: space-between;
	position: fixed;
    bottom: 0px;
    font-size: 15px;
    padding: 10px;
    text-align: left;
    width: 100%;
    color: #c0c0c0;
    justify-self: center;
    background: linear-gradient(0deg, rgba(33,37,41,1) 0%, rgba(30,33,36,0) 100%);
    z-index: 15;
}
    </style>
    <a href="https://github.com/Omax64MXG4ming/Neo-PS"target="_blank"><img class="socials" style="width: 20px" src="https://uxwing.com/wp-content/themes/uxwing/download/brands-and-social-media/github-white-icon.png"></a>
  
    <a href="https://gdpshub.com/gdps/5785"target="_blank"><img class="socials" style="width: 20px" src="https://gdpshub.com/assets/brand-assets/detail.png"></a>

        <a href="https://youtube.com/@omarstudiosoff?si=BbZOU4yt26jFk8qc" target="_blank"><img class="socials" style="width: 20px" src="https://neops.x10.mx/dashboard/incl/socials/youtube.png"></a>
  
        <a href="https://discord.gg/TdB33cAyMn
        "target="_blank"><img class="socials" style="width: 20px" src="https://neops.x10.mx/dashboard/incl/socials/discord.png"></a>
 
  </div>
  </div>
   </html>
<?php
   // Successful Code! , Working 
  }
  
  public function printWelcomePage() {
  
    ?>
<title>Welcome | Neo PS</title>
<head>
  <meta property="og:title" content="Welcome | Neo PS" />
  <meta property="og:description" content="Hi,and Welcome to Neo PS,What I'm telling you is real." />
  <meta property="og:url" content="https://neops.x10.mx/" />
  <meta property="og:image" content="https://neops.x10.mx/icon.png" />
  <meta name="theme-color" content="#0090ff" />
</head> 
<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Bellota Text, sans-serif;
}

html,body{
    width:100%;
    height:100%;
    overflow:hidden;
}

/* BACKGROUND */
body{
    background:url("https://neops.x10.mx/bg.jpg") no-repeat center center;
    background-size:cover;
    background-attachment:fixed;
}

/* OVERLAYS */
.overlay,.light{
    position:fixed;
    top:0;
    left:0;
    width:100vw;
    height:100vh;
}

.overlay{
    background:linear-gradient(135deg,#1d4ed8aa,#38bdf866);
    z-index:1;
}

.light{
    background:radial-gradient(circle,rgba(255,255,255,.08),transparent 40%);
    animation:moveLight 10s linear infinite;
    z-index:2;
}

@keyframes moveLight{
    0%{transform:translate(-20%,-20%);}
    50%{transform:translate(10%,10%);}
    100%{transform:translate(-20%,-20%);}
}

/* PARTICLES */
#particles{
    position:fixed;
    width:100vw;
    height:100vh;
    z-index:1;
}

/* CENTER */
.center{
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    text-align:center;
    width:100%;
    max-width:1200px;
    z-index:5;
}

/* LOGO */
.logo{
    width:min(420px,80vw);
    animation:float 4s ease-in-out infinite, glow 3s ease-in-out infinite;
}

@keyframes float{
    0%,100%{transform:translateY(0);}
    50%{transform:translateY(-12px);}
}

@keyframes glow{
    0%,100%{
        filter:brightness(1)
        drop-shadow(0 0 15px rgba(0,170,255,.5))
        drop-shadow(0 0 35px rgba(0,120,255,.3));
    }
    50%{
        filter:brightness(1.4)
        drop-shadow(0 0 30px rgba(80,200,255,.9))
        drop-shadow(0 0 70px rgba(0,120,255,.7));
    }
}

/* TEXT */
.title{
    color:white;
    font-size:2rem;
    margin-top:10px;
}

.active{
    color:#a5f3fc;
    margin-top:8px;
    font-size:.85rem;
}

/* BUTTONS */
.buttons{
    margin-top:20px;
}

.btn{
    display:inline-block;
    padding:.8rem 1.4rem;
    margin:6px;
    border-radius:12px;
    color:white;
    text-decoration:none;
    font-weight:bold;
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.2);
    backdrop-filter:blur(10px);
    transition:.3s;
}

.btn:hover{
    transform:scale(1.08);
    background:rgba(56,189,248,.35);
}

@keyframes spin{
    from{transform:rotate(0);}
    to{transform:rotate(360deg);}
}

@keyframes introPop{
    0%{transform:scale(.4);opacity:0;}
    40%{transform:scale(1.2);opacity:1;}
    100%{transform:scale(1);opacity:1;}
}

@keyframes fadeOut{
    to{opacity:0;visibility:hidden;}
}

/* RESPONSIVE */
@media(max-width:600px){
    .title{font-size:1.6rem;}
}

</style>
</head>
<body>


<div class="overlay"></div>
<div class="light"></div>

<canvas id="particles"></canvas>

<div class="center">

    <img src="https://neops.x10.mx/logo.png" class="logo">
<!--
  <i class="fa-solid " aria-hidden="false"></i>
-->
    <div class="buttons">
        <a href="https://neops.x10.mx/download/" class="btn"><i class="fa-solid fa-cloud-arrow-down" aria-hidden="false"></i> Download</a>
        <a href="https://neops.x10.mx/dashboard/" class="btn"><i class="fa-solid fa-dashboard" aria-hidden="false"></i> Dashboard</a>
      <a href="https://gdpshub.com/gdps/5785" class="btn"> <i class="fa-solid fa-dice-d6" aria-hidden="false"></i> GDPSHub</a>
      <a href="./demonlist/" class="btn"><i class="fa-solid fa-dragon" aria-hidden="false"></i> DemonList</a>
 <a href="./LAN/gdps/" class="btn"><i class="fa-solid fa-chart-simple" aria-hidden="false"></i> Status</a>
<a href="./link/" class="btn"><i class="fa-solid fa-external-link-square-alt" aria-hidden="false"></i> Links</a>
<a href="./data/extra/" class="btn"><i class="fa-solid fa-clipboard-question" aria-hidden="false"></i> Extra</a>

       
    </div>
<iframe width="420" height="315"
src="https://www.youtube.com/embed/WclLsBd4TAo" frameborder="0">
</iframe>
</div>

</body>
</html>
<?php
    }
  
  public function printDwnPG() {
  
    global $getTP;
    
    echo '
    
    <title>Download | Neo PS</title>
    <head>
  <meta property="og:title" content="Download | Neo PS" />
  <meta property="og:description" content="Get Neo PS for Your Devices" />
  <meta property="og:url" content="https://neops.x10.mx/download" />
  <meta property="og:image" content="https://neops.x10.mx/icon.png" />
  <meta name="theme-color" content="#0090ff" />
</head> 
<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Bellota Text, sans-serif;
}

html,body{
    width:100%;
    height:100%;
    overflow:hidden;
}

/* BACKGROUND */
body{
    background:url("https://neops.x10.mx/bg.jpg") no-repeat center center;
    background-size:cover;
    background-attachment:fixed;
}

/* OVERLAYS */
.overlay,.light{
    position:fixed;
    top:0;
    left:0;
    width:100vw;
    height:100vh;
}

.overlay{
    background:linear-gradient(135deg,#1d4ed8aa,#38bdf866);
    z-index:1;
}

.light{
    background:radial-gradient(circle,rgba(255,255,255,.08),transparent 40%);
    animation:moveLight 10s linear infinite;
    z-index:2;
}

@keyframes moveLight{
    0%{transform:translate(-20%,-20%);}
    50%{transform:translate(10%,10%);}
    100%{transform:translate(-20%,-20%);}
}

/* PARTICLES */
#particles{
    position:fixed;
    width:100vw;
    height:100vh;
    z-index:1;
}

/* CENTER */
.center{
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    text-align:center;
    width:100%;
    max-width:1200px;
    z-index:5;
}

/* LOGO */
.logo{
    width:min(420px,80vw);
    animation:float 4s ease-in-out infinite, glow 3s ease-in-out infinite;
}

@keyframes float{
    0%,100%{transform:translateY(0);}
    50%{transform:translateY(-12px);}
}

@keyframes glow{
    0%,100%{
        filter:brightness(1)
        drop-shadow(0 0 15px rgba(0,170,255,.5))
        drop-shadow(0 0 35px rgba(0,120,255,.3));
    }
    50%{
        filter:brightness(1.4)
        drop-shadow(0 0 30px rgba(80,200,255,.9))
        drop-shadow(0 0 70px rgba(0,120,255,.7));
    }
}

/* TEXT */
.title{
    color:white;
    font-size:2rem;
    margin-top:10px;
}

.active{
    color:#a5f3fc;
    margin-top:8px;
    font-size:.85rem;
}

/* BUTTONS */
.buttons{
    margin-top:20px;
}

.btn{
    display:inline-block;
    padding:.8rem 1.4rem;
    margin:6px;
    border-radius:12px;
    color:white;
    text-decoration:none;
    font-weight:bold;
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.2);
    backdrop-filter:blur(10px);
    transition:.3s;
}

.btn:hover{
    transform:scale(1.08);
    background:rgba(56,189,248,.35);
}

/* INTRO */
#intro{
    position:fixed;
    width:100vw;
    height:100vh;
    background:#000;
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:9999;
    animation:fadeOut 2.8s ease forwards;
    animation-delay:1.8s;
}

.intro-logo{
    width:220px;
    animation:introPop 1.6s ease forwards;
}

@keyframes introPop{
    0%{transform:scale(.4);opacity:0;}
    40%{transform:scale(1.2);opacity:1;}
    100%{transform:scale(1);opacity:1;}
}

@keyframes fadeOut{
    to{opacity:0;visibility:hidden;}
}

/* RESPONSIVE */
@media(max-width:600px){
    .title{font-size:1.6rem;}
}

</style>
</head>

<body>


<div class="overlay"></div>
<div class="light"></div>

<canvas id="particles"></canvas>

<div class="center">

    <img src="https://neops.x10.mx/logo.png" class="logo">



    <div class="buttons">
        <a href="./and/" class="btn"><i class="fa-brands fa-android" aria-hidden="false"></i> Download Android</a>
   <a href="./win/" class="btn"><i class="fa-brands fa-windows" aria-hidden="false"></i> Download Windows</a>
    <a href="./ios/" class="btn"><i class="fa-brands fa-apple" aria-hidden="false"></i> Download iOS .ipa</a>
       <a href="'.$getTP.'" class="btn"><i class="fa-solid fa-tv" aria-hidden="false"></i> Download Texture Pack</a>
      
    </div>
 <header> 
  <img alt="All General Downloas of Neo PS" src="https://img.shields.io/github/downloads/Omax64MXG4ming/Neo-PS/total">
</header>
<iframe width="420" height="315"
src="https://www.youtube.com/embed/WclLsBd4TAo">
</iframe>

  <iframe width="420" height="315"
src="https://www.youtube.com/embed/0rpauFqJkMk">
</iframe>

</div>

</body>
</html>';
    
    
    }
  
  
  
  
  public function printAndroidGET() {
    global $android;
    global $androidRepo;
    global $getLauncher;
    echo '
    <title>Android | Neo PS</title>
<style>


*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Bellota Text, sans-serif;
}

html,body{
    width:100%;
    height:100%;
    overflow:hidden;
}


body{
    background:url("https://neops.x10.mx/bg.jpg") no-repeat center center;
    background-size:cover;
    background-attachment:fixed;
}


.overlay,.light{
    position:fixed;
    top:0;
    left:0;
    width:100vw;
    height:100vh;
}

.overlay{
    background:linear-gradient(135deg,#1d4ed8aa,#38bdf866);
    z-index:1;
}

.light{
    background:radial-gradient(circle,rgba(255,255,255,.08),transparent 40%);
    animation:moveLight 10s linear infinite;
    z-index:2;
}

@keyframes moveLight{
    0%{transform:translate(-20%,-20%);}
    50%{transform:translate(10%,10%);}
    100%{transform:translate(-20%,-20%);}
}


#particles{
    position:fixed;
    width:100vw;
    height:100vh;
    z-index:1;
}


.center{
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    text-align:center;
    width:100%;
    max-width:1200px;
    z-index:5;
}


.logo{
    width:min(420px,80vw);
    animation:float 4s ease-in-out infinite, glow 3s ease-in-out infinite;
}

@keyframes float{
    0%,100%{transform:translateY(0);}
    50%{transform:translateY(-12px);}
}

@keyframes glow{
    0%,100%{
        filter:brightness(1)
        drop-shadow(0 0 15px rgba(0,170,255,.5))
        drop-shadow(0 0 35px rgba(0,120,255,.3));
    }
    50%{
        filter:brightness(1.4)
        drop-shadow(0 0 30px rgba(80,200,255,.9))
        drop-shadow(0 0 70px rgba(0,120,255,.7));
    }
}


.title{
    color:white;
    font-size:2rem;
    margin-top:10px;
}

.active{
    color:#a5f3fc;
    margin-top:8px;
    font-size:.85rem;
}


.buttons{
    margin-top:20px;
}

.btn{
    display:inline-block;
    padding:.8rem 1.4rem;
    margin:6px;
    border-radius:12px;
    color:white;
    text-decoration:none;
    font-weight:bold;
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.2);
    backdrop-filter:blur(10px);
    transition:.3s;
}

.btn:hover{
    transform:scale(1.08);
    background:rgba(56,189,248,.35);
}

@keyframes introPop{
    0%{transform:scale(.4);opacity:0;}
    40%{transform:scale(1.2);opacity:1;}
    100%{transform:scale(1);opacity:1;}
}

@keyframes fadeOut{
    to{opacity:0;visibility:hidden;}
}


@media(max-width:600px){
    .title{font-size:1.6rem;}
}

</style>
</head>

<body>


<div class="overlay"></div>
<div class="light"></div>

<canvas id="particles"></canvas>

<div class="center">

    <img src="https://neops.x10.mx/logo.png" class="logo">


'; echo '
    <div class="buttons">
    <header>
       <p> <a href="'.$android.'" class="btn">📥 Download</a>
       <p> <iframe src="https://img.shields.io/github/downloads/'.$androidRepo.'" frameborder="0"></iframe>
       </header>
       
        <a href="'.$getLauncher.'" class="btn">📥 Download Launcher</a>

    </div>
<iframe width="420" height="315"
src="https://www.youtube.com/embed/WclLsBd4TAo">
</iframe>


</div>
<script>
const c=document.getElementById("particles");
const x=c.getContext("2d");

c.width=innerWidth;
c.height=innerHeight;

let p=[];

for(let i=0;i<60;i++){
    p.push({
        x:Math.random()*c.width,
        y:Math.random()*c.height,
        r:Math.random()*2,
        dx:(Math.random()-0.5),
        dy:(Math.random()-0.5)
    });
}

function draw(){
    x.clearRect(0,0,c.width,c.height);

    x.fillStyle="rgba(255,255,255,.6)";

    for(let i of p){
        x.beginPath();
        x.arc(i.x,i.y,i.r,0,Math.PI*2);
        x.fill();

        i.x+=i.dx;
        i.y+=i.dy;

        if(i.x<0||i.x>c.width)i.dx*=-1;
        if(i.y<0||i.y>c.height)i.dy*=-1;
    }

    requestAnimationFrame(draw);
}

draw();

</script>

</body>
</html>
';
    }
  
  public function printGETiOS() {
    global $getIos;
    global $webIcon;
    echo '
   
<title>iOS | Neo PS</title>

<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Bellota Text, sans-serif;
}

html,body{
    width:100%;
    height:100%;
    overflow:hidden;
}

/* BACKGROUND */
body{
    background:url("https://neops.x10.mx/bg.jpg") no-repeat center center;
    background-size:cover;
    background-attachment:fixed;
}

/* OVERLAYS */
.overlay,.light{
    position:fixed;
    top:0;
    left:0;
    width:100vw;
    height:100vh;
}

.overlay{
    background:linear-gradient(135deg,#1d4ed8aa,#38bdf866);
    z-index:1;
}

.light{
    background:radial-gradient(circle,rgba(255,255,255,.08),transparent 40%);
    animation:moveLight 10s linear infinite;
    z-index:2;
}

@keyframes moveLight{
    0%{transform:translate(-20%,-20%);}
    50%{transform:translate(10%,10%);}
    100%{transform:translate(-20%,-20%);}
}

/* PARTICLES */
#particles{
    position:fixed;
    width:100vw;
    height:100vh;
    z-index:1;
}

/* CENTER */
.center{
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    text-align:center;
    width:100%;
    max-width:1200px;
    z-index:5;
}

/* LOGO */
.logo{
    width:min(420px,80vw);
    animation:float 4s ease-in-out infinite, glow 3s ease-in-out infinite;
}

@keyframes float{
    0%,100%{transform:translateY(0);}
    50%{transform:translateY(-12px);}
}

@keyframes glow{
    0%,100%{
        filter:brightness(1)
        drop-shadow(0 0 15px rgba(0,170,255,.5))
        drop-shadow(0 0 35px rgba(0,120,255,.3));
    }
    50%{
        filter:brightness(1.4)
        drop-shadow(0 0 30px rgba(80,200,255,.9))
        drop-shadow(0 0 70px rgba(0,120,255,.7));
    }
}

/* TEXT */
.title{
    color:white;
    font-size:2rem;
    margin-top:10px;
}

.active{
    color:#a5f3fc;
    margin-top:8px;
    font-size:.85rem;
}

/* BUTTONS */
.buttons{
    margin-top:20px;
}

.btn{
    display:inline-block;
    padding:.8rem 1.4rem;
    margin:6px;
    border-radius:12px;
    color:white;
    text-decoration:none;
    font-weight:bold;
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.2);
    backdrop-filter:blur(10px);
    transition:.3s;
}

.btn:hover{
    transform:scale(1.08);
    background:rgba(56,189,248,.35);
}

@keyframes introPop{
    0%{transform:scale(.4);opacity:0;}
    40%{transform:scale(1.2);opacity:1;}
    100%{transform:scale(1);opacity:1;}
}

@keyframes fadeOut{
    to{opacity:0;visibility:hidden;}
}

/* RESPONSIVE */
@media(max-width:600px){
    .title{font-size:1.6rem;}
}

</style>
</head>

<body>


<div class="overlay"></div>
<div class="light"></div>

<canvas id="particles"></canvas>

<div class="center">

    <img src="https://neops.x10.mx/logo.png" class="logo">

';
    echo '

    <div class="buttons">
        <a href="'.$getIos.'" class="btn">📥 Download</a>

    </div>
<iframe width="420" height="315"
src="https://www.youtube.com/embed/WclLsBd4TAo">
</iframe>


</div>
<script>
/* PARTICLES */
const c=document.getElementById("particles");
const x=c.getContext("2d");

c.width=innerWidth;
c.height=innerHeight;

let p=[];

for(let i=0;i<60;i++){
    p.push({
        x:Math.random()*c.width,
        y:Math.random()*c.height,
        r:Math.random()*2,
        dx:(Math.random()-0.5),
        dy:(Math.random()-0.5)
    });
}

function draw(){
    x.clearRect(0,0,c.width,c.height);

    x.fillStyle="rgba(255,255,255,.6)";

    for(let i of p){
        x.beginPath();
        x.arc(i.x,i.y,i.r,0,Math.PI*2);
        x.fill();

        i.x+=i.dx;
        i.y+=i.dy;

        if(i.x<0||i.x>c.width)i.dx*=-1;
        if(i.y<0||i.y>c.height)i.dy*=-1;
    }

    requestAnimationFrame(draw);
}

draw();

</script>

</body>
</html>

    ';
    }
           public function printPPS() {

             echo ' 
<script>
/* PARTICLES */
const c=document.getElementById("particles");
const x=c.getContext("2d");

c.width=innerWidth;
c.height=innerHeight;

let p=[];

for(let i=0;i<60;i++){
    p.push({
        x:Math.random()*c.width,
        y:Math.random()*c.height,
        r:Math.random()*2,
        dx:(Math.random()-0.5),
        dy:(Math.random()-0.5)
    });
}

function draw(){
    x.clearRect(0,0,c.width,c.height);

    x.fillStyle="rgba(255,255,255,.6)";

    for(let i of p){
        x.beginPath();
        x.arc(i.x,i.y,i.r,0,Math.PI*2);
        x.fill();

        i.x+=i.dx;
        i.y+=i.dy;

        if(i.x<0||i.x>c.width)i.dx*=-1;
        if(i.y<0||i.y>c.height)i.dy*=-1;
    }

    requestAnimationFrame(draw);
}

draw();

</script>';
    }
  
  public function printStatusPG() {
    global $webIcon;
    global $service_url;
    echo '
<title>Status | Neo PS</title>
<head>
  <meta property="og:title" content="Status | Neo PS" />
  <meta property="og:description" content="The, Page of the Status of this Server and Machines in Connection" />
  <meta property="og:url" content="https://neops.x10.mx/LAN/gdps/" />
  <meta property="og:image" content="https://neops.x10.mx/icon.png" />
  <meta name="theme-color" content="#0090ff" />
</head> 
<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Bellota Text, sans-serif;
}

html,body{
    width:100%;
    height:100%;
    overflow:hidden;
}

/* BACKGROUND */
body{
    background:url("https://neops.x10.mx/bg.jpg") no-repeat center center;
    background-size:cover;
    background-attachment:fixed;
}

/* OVERLAYS */
.overlay,.light{
    position:fixed;
    top:0;
    left:0;
    width:100vw;
    height:100vh;
}

.overlay{
    background:linear-gradient(135deg,#1d4ed8aa,#38bdf866);
    z-index:1;
}

.light{
    background:radial-gradient(circle,rgba(255,255,255,.08),transparent 40%);
    animation:moveLight 10s linear infinite;
    z-index:2;
}

@keyframes moveLight{
    0%{transform:translate(-20%,-20%);}
    50%{transform:translate(10%,10%);}
    100%{transform:translate(-20%,-20%);}
}

/* PARTICLES */
#particles{
    position:fixed;
    width:100vw;
    height:100vh;
    z-index:1;
}

/* CENTER */
.center{
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    text-align:center;
    width:100%;
    max-width:1200px;
    z-index:5;
}

/* LOGO */
.logo{
    width:min(420px,80vw);
    animation:float 4s ease-in-out infinite, glow 3s ease-in-out infinite;
}

@keyframes float{
    0%,100%{transform:translateY(0);}
    50%{transform:translateY(-12px);}
}

@keyframes glow{
    0%,100%{
        filter:brightness(1)
        drop-shadow(0 0 15px rgba(0,170,255,.5))
        drop-shadow(0 0 35px rgba(0,120,255,.3));
    }
    50%{
        filter:brightness(1.4)
        drop-shadow(0 0 30px rgba(80,200,255,.9))
        drop-shadow(0 0 70px rgba(0,120,255,.7));
    }
}

/* TEXT */
.title{
    color:white;
    font-size:2rem;
    margin-top:10px;
}

.active{
    color:#a5f3fc;
    margin-top:8px;
    font-size:.85rem;
}

@keyframes introPop{
    0%{transform:scale(.4);opacity:0;}
    40%{transform:scale(1.2);opacity:1;}
    100%{transform:scale(1);opacity:1;}
}

@keyframes fadeOut{
    to{opacity:0;visibility:hidden;}
}

/* RESPONSIVE */
@media(max-width:600px){
    .title{font-size:1.6rem;}
}

.sfxError {
width:200px;
border-radius:50px;
}

.btn{
    display:inline-block;
    padding:.8rem 1.4rem;
    margin:6px;
    border-radius:12px;
    color:white;
    text-decoration:none;
    font-weight:bold;
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.2);
    backdrop-filter:blur(10px);
    transition:.3s;
}

.btn:hover{
    transform:scale(1.08);
    background:rgba(56,189,248,.35);
}
</style>
</head>
<body>
<div class="overlay"></div>
<div class="light"></div>
<canvas id="particles"></canvas>
<div class="center">
    <img src="https://neops.x10.mx/logo.png" class="logo">';
global $resAlt;
global $pingAlt;
$status = checkService($service_url);

if ($status["online"]): 
echo '
<br>
    <div class="converter">
<iframe
  src="'.$resAlt.'"
  width="320"
  height="140"
  frameborder="0"
  style="border: none; border-radius: 50px;"></iframe>
       
    </div>';
 else: 
echo '
    <div class="service-error">
        <img src="https://neops.x10.mx/index/catNoService.gif" class="sfxError">
        <p>
         Converter Host is OFF
        </p>

        <button onclick="location.reload()" class="btn">
            Retry
        </button>
    </div>';
endif;

    echo '
    
    <iframe
    src="'.$pingAlt.'"
    frameborder="0"
    style="
        width: 300px;
        margin-bottom: -20px;
        height: 165px;
        border: 0;" alt="Neo PS bot Ping to Discord APIs">
</iframe>';
    
    echo '
    <br>
    
<iframe
  src="https://status.bot-hosting.net/pub-api/embeds/fi3"
  width="320"
  frameborder="0"
  style="border: none; border-radius: 10px;">NeoPS bot Host Status</iframe>';
    echo '
    <br>
    <iframe
  src="https://discord.com/widget?id=1516253209029509150"
  frameborder="0"></iframe>';
 echo '</div></body></html>';
    
    }

  }
