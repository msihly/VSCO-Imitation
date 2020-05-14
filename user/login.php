<?php
    session_start();
    if (isset ($_SESSION["uid"])) {
        header("Location: /feed");
    } else if (isset($_COOKIE["authToken"])) {
        include_once("php/restricted/db-functions.php");
        $userID = validateToken($_COOKIE["authToken"]);
        if ($userID === false) { setcookie("authToken", "", 1); }
        else { $_SESSION["uid"] = $userID; header("Location: /feed"); }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sign In | VSCO</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/ico" href="/../images/favicon.ico">
        <link rel="stylesheet" href="/../css/common.css">
        <link rel="stylesheet" href="/../css/login.css">
        <script src="/../js/login.js" type="module"></script>
    </head>
    <body class="user-account user-signin">
        <div class="pageWrapper">
            <header class="global-header clearfix" role="banner">
                <nav role="navigation">
                    <ul>
                        <li class="nav-item nav-vsco-home"><a href="/">VSCO</a></li>
                        <li class="nav-feed nav-item"><a href="/feed">Feed</a></li>
                        <li class="nav-signin nav-item"><a href="/user/login" class="nav_signin" data-target="accountView">Sign In</a></li>
                        <li class="nav-item nav-getAppBtnContainer"><a data-listener="notImplemented" class="nav-getAppBtn" href="/download">Get the App</a></li>
                        <li id="nav-search" class="nav-search nav-item nav-icon"><a data-listener="notImplemented" href="/search" class="ir">Search</a></li>
                    </ul>
                </nav>
            </header>
            <main id="pageBounds" class="pageBounds " role="main">
                <div id="loginpage" class="loginpage">
                    <div class="sign-in-box container_12">
                        <a href="/"><img class="mb30 vsco-seal" src="/images/vsco-seal.svg" width="60" height="60"></a>
                        <p>Sign in to create, discover and connect<br>with the global&nbsp;community.</p>
                        <div class="message-bar ta-center">
                            <div id="errorBar" class="messageBar error"></div>
                            <div id="infoBar" class="messageBar info"></div>
                        </div>
                        <div class="loginBox">
                            <form id="loginForm" enctype="multipart/form-data" novalidate>
                                <input type="hidden" name="CsrfToken" value="foobar">
                                <input type="email" class="mb20" name="username" id="login" placeholder="Email or Profile name">
                                <input type="password" class="mb30" name="password" id="password" placeholder="Password">
                                <fieldset class="mb50">
                                    <label class="label--inline left">I accept to the <a data-listener="notImplemented" href="/about/terms_of_use" target="_blank">Terms</a> &amp; <a data-listener="notImplemented" href="/about/privacy_policy" target="_blank">Privacy Policy</a></label>
                                </fieldset>
                                <a data-listener="notImplemented" href="/store/app" class="left accountLink link">Sign Up - Get The App</a>
                                <button id="loginButton" class="right link" type="submit">Sign In</button>
                                <a data-listener="notImplemented" class="forgotpw link" href="/user/forgotpassword">Forgot password</a>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>