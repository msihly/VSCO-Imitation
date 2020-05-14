<?php
    session_start();
    if (!isset($_SESSION["uid"]) && isset($_COOKIE["authToken"])) {
        include_once("php/restricted/db-functions.php");
        $userID = validateToken($_COOKIE["authToken"]);
        $userID === false ? setcookie("authToken", "", 1) : $_SESSION["uid"] = $userID;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Feed | VSCO</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/ico" href="images/favicon.ico">
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/feed.css">
        <script src="js/feed.js" type="module"></script>
    </head>
    <body>
        <div id="root" class="root">
            <div class="page-wrap">
                <main class="main" role="main">
                    <header role="banner" class="Header clearfix">
                        <button class="Header-mobileNavBurgerBtn md-hide btn" type="button"></button>
                        <a data-listener="notImplemented" class="NavSearchButton ir" title="Search" href="/search">Search</a>
                        <?php if (isset($_SESSION["uid"])) { echo "<a class=\"Header-followingBtn ir\" title=\"Following\" href=\"/following\">Following</a>"; } ?>
                        <a class="Header-vscoLink md-hide" href="/">VSCO</a>
                        <nav class="Nav clearfix null null" role="navigation">
                            <?php
                                if (!isset($_SESSION["uid"])) {
                                    echo "<div class=\"Nav-getApp-container md-show\">
                                            <a data-listener=\"notImplemented\" class=\"Nav-getApp btn\" href=\"#\" type=\"button\">Get the app</a>
                                        </div>";
                                }
                            ?>
                            <div class="Nav-settings--mobileLinkWrapper md-hide">
                                <a class="Nav-settings Nav-settings--mobileLink ir" href="/user/account" title="Settings" type="button">Settings</a>
                            </div>
                            <?php
                                if (isset($_SESSION["uid"])) {
                                    echo "<div class=\"Nav-loggedInOptions\">
                                            <a data-listener=\"notImplemented\" href=\"/user/upload\" class=\"Nav-upload Nav-icon md-show ir\" title=\"Upload\">Upload</a>
                                            <a href=\"/user/account\" class=\"Nav-settings Nav-icon md-show ir\" title=\"Settings\">Settings</a>
                                        </div>";
                                }
                            ?>
                            <ul class="Nav-primaryPages">
                                <li class="Nav-text"><a href="/">VSCO</a></li>
                                <li class="Nav-text"><a aria-current="page" class="active" href="/feed">Feed</a></li>
                                <li class="Nav-text">
                                    <?php
                                        if (isset($_SESSION["uid"])) {
                                            if (!isset($_SESSION["username"])) { $_SESSION["username"] = getProfileInfo($_SESSION["uid"])["Username"]; }
                                            $username = $_SESSION["username"];
                                            echo "<a data-listener=\"notImplemented\" href=\"/$username\">$username</a>";
                                        } else {
                                            echo "<a href=\"/user/login\">Sign in</a>";
                                        }
                                    ?>
                                </li>
                            </ul>
                            <div class="Nav-secondaryPages mt20 md-hide">
                                <ul>
                                    <li class="Nav-text"><a href="/about/company">Company</a></li>
                                    <li class="Nav-text"><a data-listener="notImplemented" href="/about/careers">Careers</a></li>
                                    <li class="Nav-text"><a data-listener="notImplemented" href="//support.vsco.co">Support</a></li>
                                    <li class="Nav-text"><a data-listener="notImplemented" href="//vscopress.co">Press</a></li>
                                    <li class="Nav-text"><a data-listener="notImplemented" href="/redeem">Redeem</a></li>
                                </ul>
                                <ul>
                                    <li class="Nav-text"><a data-listener="notImplemented" href="/about/community_guidelines">Guidelines</a></li>
                                    <li class="Nav-text"><a data-listener="notImplemented" href="/about/privacy_policy">Privacy</a></li>
                                    <li class="Nav-text"><a data-listener="notImplemented" href="/about/terms_of_use">Terms</a></li>
                                    <li class="Nav-text"><a data-listener="notImplemented" href="/about/material_connection_disclosure">Disclosures</a></li>
                                </ul>
                            </div>
                        </nav>
                    </header>
                    <div class="css-lnnxvk ebat0h80">
                        <div class="Feed overflow-hidden">
                            <h1 class="sr-only">Feed</h1>
                            <?php
                                if (!isset($_SESSION["uid"])) {
                                    echo "<section class=\"SignedOutBanner\">
                                            <h2 class=\"SignedOutBanner-title\">VSCO — For creators, by creators</h2>
                                            <div class=\"SignedOutBanner-cta\">
                                                <a href=\"/user/login\" class=\"SignedOutBanner-btn btn btn--charcoal-dark\" type=\"button\">Sign in</a>
                                                <a data-listener=\"notImplemented\" href=\"#\" class=\"SignedOutBanner-btn btn btn--charcoal-dark\" type=\"button\">Sign up &amp; get the app</a>
                                            </div>
                                        </section>";
                                }
                            ?>
                            <section id="posts-container" class="grid grid--withGutter">
                            </section>
                            <div>
                                <button id="loadPage" class="css-1l8iuw5 e1e5bmu80" type="button">Load more</button>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include_once("footer.php"); ?>
            </div>
        </div>
    </body>
</html>