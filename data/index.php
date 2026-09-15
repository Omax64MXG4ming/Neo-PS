<?php
/*
 * ============================================================
 * Neo PS - Leaderboard
 * ============================================================
 * Available Statics:
 *   stars
 *   moons
 *   demons
 *   userCoins
 *
 * ============================================================
 */

chdir(dirname(__FILE__));

require "../database/incl/lib/connection.php";
require "../index/indexLib.php";
/*
 * ============================================================
 * CONFIG
 * ============================================================
 */

// Max Players In Leader
$limit = 100;

// Default Set Stat
$defaultStat = "stars";

// permited Stats
$statTypes = [
    "stars"    => [
        "name"  => "Stars",
        "icon"  => "⭐",
        "color" => "#ffd84d"
    ],

    "moons"    => [
        "name"  => "Moons",
        "icon"  => "🌙",
        "color" => "#7fc8ff"
    ],

    "demons"   => [
        "name"  => "Demons",
        "icon"  => "👹",
        "color" => "#ff6262"
    ],

    "userCoins" => [
        "name"  => "User Coins",
        "icon"  => "🪙",
        "color" => "#ffd35a"
    ]
];


/*
 * ============================================================
 * GET STATICS
 * ============================================================
 */

$stat = isset($_GET["stat"]) ? $_GET["stat"] : $defaultStat;

if (!isset($statTypes[$stat])) {
    $stat = $defaultStat;
}

$statInfo = $statTypes[$stat];


/*
 * ============================================================
 * GET PLAYERS
 * ============================================================
 *
 * The ``users`` table is used in the database
 *
 * The following blocks are removed:
 *   isBanned = 1
 *   isCreatorBanned = 1
 *
 * Accounts without an active registration are also not included. 
 */

$players = [];

try {

    $sql = "
        SELECT
            userID,
            extID,
            userName,
            stars,
            moons,
            demons,
            userCoins,
            coins,
            diamonds,
            orbs,
            creatorPoints,
            completedLvls,
            icon,
            iconType,
            color1,
            color2,
            color3,
            special,
            isRegistered,
            isBanned,
            isCreatorBanned
        FROM users
        WHERE
            isBanned = 0
            AND isCreatorBanned = 0
            AND isRegistered = 1
            AND `" . $stat . "` > 0
        ORDER BY `" . $stat . "` DESC, userID ASC
        LIMIT " . intval($limit);

    $query = $db->prepare($sql);
    $query->execute();

    $players = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {

    $dbError = $e->getMessage();

}


/*
 * ============================================================
 * FORMAT NUMBERS
 * ============================================================
 */

function formatNumber($number) {
    return number_format((int)$number, 0, ".", ",");
}


/*
 * ============================================================
 * POSITIONS
 * ============================================================
 */

$position = 0;

?>
<!DOCTYPE html>
<html lang="en">
<? $il->printFont(); ?>
<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>
  <head>
 <link rel="icon" type="image/png" href="https://neops.x10.mx/icon.png" sizes="96x96" />
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<title>
Top 100 | Neo PS
</title>

<style>

/* ============================================================
   RESET
   ============================================================ */

* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    padding: 0;
    min-height: 100%;
}

body {

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    background:
        radial-gradient(
            circle at top,
            #239ee8 0%,
            #1264c9 38%,
            #073b8e 100%
        );

    color: white;

    min-height: 100vh;

    padding: 30px 14px;
}


/* ============================================================
   CONTAINER
   ============================================================ */

.container {

    width: 100%;
    max-width: 1050px;

    margin: auto;
}


/* ============================================================
   HEADER
   ============================================================ */

.header {

    text-align: center;

    margin-bottom: 25px;
}

.header h1 {

    margin: 0;

    font-size: 42px;

    font-weight: 900;

    text-shadow:
        0 4px 0 rgba(0,0,0,.18),
        0 8px 25px rgba(0,0,0,.25);
}

.header p {

    margin-top: 8px;

    opacity: .85;

    font-size: 15px;
}


/* ============================================================
   ADMIN
   ============================================================ */

.panel {

    background: rgba(4, 34, 87, .62);

    border:
        1px solid rgba(255,255,255,.18);

    border-radius: 22px;

    padding: 18px;

    box-shadow:
        0 15px 45px rgba(0,0,0,.25);

    backdrop-filter: blur(12px);
}


/* ============================================================
   STAT BUTTONS
   ============================================================ */

.stats {

    display: flex;

    gap: 10px;

    flex-wrap: wrap;

    justify-content: center;

    margin-bottom: 20px;
}

.stat-button {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    padding:
        11px 18px;

    border-radius: 13px;

    color: white;

    text-decoration: none;

    font-weight: 800;

    background:
        rgba(255,255,255,.09);

    border:
        1px solid rgba(255,255,255,.15);

    transition:
        transform .15s ease,
        background .15s ease,
        box-shadow .15s ease;
}

.stat-button:hover {

    transform: translateY(-2px);

    background:
        rgba(255,255,255,.16);
}

.stat-button.active {

    background:
        linear-gradient(
            135deg,
            #31c8ff,
            #1673e6
        );

    box-shadow:
        0 6px 20px rgba(0,0,0,.2);
}


/* ============================================================
   TABLE HEADER
   ============================================================ */

.table-header {

    display: grid;

    grid-template-columns:
        75px
        minmax(180px, 1fr)
        170px;

    align-items: center;

    padding:
        10px 18px;

    color:
        rgba(255,255,255,.65);

    font-size: 12px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .8px;
}


/* ============================================================
   PLAYER ROW
   ============================================================ */

.player {

    display: grid;

    grid-template-columns:
        75px
        minmax(180px, 1fr)
        170px;

    align-items: center;

    min-height: 76px;

    padding:
        10px 18px;

    margin-bottom: 8px;

    border-radius: 16px;

    background:
        rgba(255,255,255,.07);

    border:
        1px solid rgba(255,255,255,.07);

    transition:
        transform .15s ease,
        background .15s ease;
}

.player:hover {

    transform: translateX(3px);

    background:
        rgba(255,255,255,.12);
}


/* ============================================================
   RANK
   ============================================================ */

.rank {

    font-size: 22px;

    font-weight: 900;

    text-align: center;
}

.rank-small {

    font-size: 18px;
}


/* ============================================================
   TOP 3
   ============================================================ */

.player.first {

    background:
        linear-gradient(
            90deg,
            rgba(255,207,64,.18),
            rgba(255,255,255,.07)
        );

    border-color:
        rgba(255,214,70,.35);
}

.player.second {

    background:
        linear-gradient(
            90deg,
            rgba(190,210,230,.17),
            rgba(255,255,255,.07)
        );

    border-color:
        rgba(210,225,240,.3);
}

.player.third {

    background:
        linear-gradient(
            90deg,
            rgba(210,130,75,.16),
            rgba(255,255,255,.07)
        );

    border-color:
        rgba(220,150,90,.3);
}


/* ============================================================
   PLAYER NAME
   ============================================================ */

.player-info {

    min-width: 0;
}

.player-name {

    font-size: 18px;

    font-weight: 900;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;
}

.player-id {

    margin-top: 4px;

    font-size: 11px;

    color:
        rgba(255,255,255,.5);
}


/* ============================================================
   STAT
   ============================================================ */

.player-stat {

    text-align: right;

    font-size: 20px;

    font-weight: 900;
}

.player-stat span {

    font-size: 15px;
}


/* ============================================================
   EMPTY
   ============================================================ */

.empty {

    text-align: center;

    padding: 60px 20px;

    color:
        rgba(255,255,255,.65);
}


/* ============================================================
   ERROR
   ============================================================ */

.error {

    background:
        rgba(255,60,60,.15);

    border:
        1px solid rgba(255,100,100,.35);

    border-radius: 15px;

    padding: 20px;

    text-align: center;

    color: #ffdede;
}

/* ============================================================
   MOBILE
   ============================================================ */

@media (max-width: 650px) {

    body {
        padding: 18px 8px;
    }

    .header h1 {
        font-size: 31px;
    }

    .panel {
        padding: 10px;
        border-radius: 17px;
    }

    .stats {
        gap: 7px;
    }

    .stat-button {
        flex: 1 1 calc(50% - 7px);
        padding: 10px 7px;
        font-size: 13px;
    }

    .table-header {
        grid-template-columns:
            45px
            minmax(100px, 1fr)
            105px;

        padding:
            8px 10px;

        font-size: 10px;
    }

    .player {

        grid-template-columns:
            45px
            minmax(100px, 1fr)
            105px;

        min-height: 68px;

        padding:
            8px 10px;
    }

    .rank {
        font-size: 17px;
    }

    .player-name {
        font-size: 14px;
    }

    .player-stat {
        font-size: 16px;
    }

    .player-stat span {
        font-size: 12px;
    }

}


/* ============================================================
   VERY SMALL PHONES
   ============================================================ */

@media (max-width: 390px) {

    .table-header {
        grid-template-columns:
            38px
            minmax(90px, 1fr)
            90px;
    }

    .player {
        grid-template-columns:
            38px
            minmax(90px, 1fr)
            90px;
    }

    .player-stat {
        font-size: 14px;
    }

}

</style>

</head>

<body>

<div class="container">

    <div class="header">

        <h1>
            <i class="fa-solid fa-people-group" aria-hidden="false"></i> Neo PS
        </h1>

        <p>
            Top 100 Players
        </p>

    </div>


    <div class="panel">


        <!-- ================================================
             PRINT STATICS
             ================================================= -->

        <div class="stats">

            <?php foreach ($statTypes as $key => $info): ?>

                <a
                    class="stat-button <?php echo $stat === $key ? 'active' : ''; ?>"
                    href="?stat=<?php echo urlencode($key); ?>"
                >

                    <span>
                        <?php echo $info["icon"]; ?>
                    </span>

                    <span>
                        <?php echo htmlspecialchars($info["name"]); ?>
                    </span>

                </a>

            <?php endforeach; ?>

        </div>


        <?php if (isset($dbError)): ?>

            <div class="error">

               ⬛ Information could not be obtained 

                <br><br>

                <small>
                   ❌ Database connection Error (ERROR 1KS)
                </small>

            </div>


        <?php elseif (empty($players)): ?>

            <div class="empty">

                <?php echo $statInfo["icon"]; ?>

                <br><br>

                No have Players. (ERROR 4)

            </div>


        <?php else: ?>


            <!-- ============================================
                 HEADER
                 ============================================= -->

            <div class="table-header">

                <div>
                    #
                </div>

                <div>
                    Player
                </div>

                <div style="text-align:right;">
                    <?php echo htmlspecialchars($statInfo["name"]); ?>
                </div>

            </div>


            <!-- ============================================
                 Players
                 ============================================= -->

            <?php

            $position = 0;

            foreach ($players as $player):

                $position++;

                $class = "";

                if ($position === 1) {
                    $class = "first";
                }
                elseif ($position === 2) {
                    $class = "second";
                }
                elseif ($position === 3) {
                    $class = "third";
                }

                $username = $player["userName"];

                if ($username === "" || $username === null) {
                    $username = "Unknown";
                }

                $value = $player[$stat];

            ?>

                <div class="player <?php echo $class; ?>">


                    <!-- RANK -->

                    <div class="rank">

                        <?php if ($position === 1): ?>

                            🥇

                        <?php elseif ($position === 2): ?>

                            🥈

                        <?php elseif ($position === 3): ?>

                            🥉

                        <?php else: ?>

                            <span class="rank-small">
                                <?php echo $position; ?>
                            </span>

                        <?php endif; ?>

                    </div>


                    <!-- PLAYER -->

                    <div class="player-info">

                        <div class="player-name">

                            <?php
                            echo htmlspecialchars(
                                $username,
                                ENT_QUOTES,
                                "UTF-8"
                            );
                            ?>

                        </div>

                        <div class="player-id">

                            Account ID:
                            <?php
                            echo htmlspecialchars(
                                $player["extID"],
                                ENT_QUOTES,
                                "UTF-8"
                            );
                            ?>

                        </div>

                    </div>


                    <!-- STAT -->

                    <div
                        class="player-stat"
                        style="
                            color:
                            <?php echo htmlspecialchars($statInfo["color"]); ?>;
                        "
                    >

                        <?php echo formatNumber($value); ?>

                        <span>
                            <?php echo $statInfo["icon"]; ?>
                        </span>

                    </div>


                </div>

            <?php endforeach; ?>


        <?php endif; ?>


    </div>


</div>

</body>

</html>
