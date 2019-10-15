<html prefix="og: http://ogp.me/ns#">
<head>
    <meta property="og:url"           content="https://www.jeguglie.tk" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="Camagru" />
    <meta property="og:description"   content="Upload your picture by cam or file, with a filter and a sticker." />
    <meta property="og:image"         content="https://www.jeguglie.tk/app/public/images/wall/2019-10-13-10-22.png" />
    <meta name="viewport"             content="width=device-width, initial-scale=1" />
    <meta property="fb:app_id"         content="531088437465207" />

    <title>Camagru</title>
    <link rel="icon" type="image/png" href="/app/public/img/favicon.png" />
    <link rel="stylesheet" href="/app/public/css/bulma.css">
    <link rel="stylesheet" href="/app/public/css/style.css">
    <script src="https://kit.fontawesome.com/2fa8f5d105.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500&display=swap" rel="stylesheet">
</head>
<body class="touchstart">

<nav class="navbar">
        <div id="fb-root"></div>
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v4.0"></script>

    <div class="container">
        <div class="navbar-brand">
            <a href="/index.php" class="navbar-item">
                <img src="/app/public/img/camagru-logo.png">
            </a>
            <a id="burger" role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div id="navbarMenuHeroB" class="navbar-menu">
            <div class="navbar-end">
                <?php
                if (isset($_SESSION['username'])){
                    echo'<a href="/index.php?wall" class="navbar-item">Wall</a>';
                    echo'<a href="/index.php?takepic" class="navbar-item">Take a pic</a>';
                    echo'<a href="/index.php?profile" class="navbar-item">Profile</a>';
                    echo'<a href="/index.php?logout" class="navbar-item">Logout</a>';
                }
                else
                    echo'<a class="navbar-item">Welcome</a>';
                ?>
            </div>
        </div>
    </div>
</nav>
<script>

    let touchEvent = 'ontouchstart' in window ? 'touchstart' : 'click';
    let body = document.getElementsByTagName('body');
    var navburger = document.getElementById('burger');
    var navmenu = document.getElementById('navbarMenuHeroB');

    if (touchEvent === 'click'){
        body[0].className = "";
    }
    navburger.addEventListener(touchEvent, function() {
        if (navburger.classList.contains("is-active")){
            navburger.className = " navbar-burger burger";
            navmenu.className = "navbar-menu";
        }
        else {
            navburger.className += navburger.className + " is-active";
            navmenu.className += " is-active";
        }
});
</script>
