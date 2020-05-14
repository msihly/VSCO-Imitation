<?php
    include_once("../php/restricted/db-functions.php"); // session_start() already included in file
    if (!isset($_SESSION["uid"])) {
        if (isset($_COOKIE["authToken"])) {
            $userID = validateToken($_COOKIE["authToken"]);
            if ($userID === false) {
                setcookie("authToken", "", 1);
                header("Location: /user/login.php");
            } else {
                $_SESSION["uid"] = $userID;
            }
        } else {
            header("Location: /user/login.php");
        }
    }
    $_SESSION["profileInfo"] = getProfileInfo($_SESSION["uid"]);
?>
<!DOCTYPE html>
<html lang="en" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs
    backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent
    video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">
    <head>
        <title>Account | VSCO</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/ico" href="/../images/favicon.ico">
        <link rel="stylesheet" href="/../css/common.css">
        <link rel="stylesheet" href="/../css/account.css">
        <script src="/../js/account.js" type="module"></script>
    </head>
    <body class="user-account dashboard profile personal">
        <div class="pageWrapper">
            <header class="global-header clearfix" role="banner">
                <nav role="navigation">
                    <ul>
                        <li class="nav-item nav-vsco-home"><a href="/">VSCO</a></li>
                        <li class="nav-feed nav-item"><a href="/feed">Feed</a></li>
                        <?php
                            if (!isset($_SESSION["username"])) { $_SESSION["username"] = getProfileInfo($_SESSION["uid"])["Username"]; }
                            $username = $_SESSION["username"];
                            echo "<li class=\"nav-signin nav-item\">
                                    <a data-listener=\"notImplemented\" href=\"/$username\" class=\"nav_signin loggedIn\" data-target=\"accountView\">$username</a>
                                </li>";
                        ?>
                        <li id="nav-account" class="nav-account nav-item nav-icon"><a href="/user/account/" class="nav_settings ir" data-target="accountView">AccountSettings</a></li>
                        <li id="nav-upload" class="nav-upload nav-item nav-icon"><a data-listener="notImplemented" href="/upload/" class="ir">UPLOAD</a></li>
                        <li class="nav-item nav-getAppBtnContainer hide"><a data-listener="notImplemented" class="nav-getAppBtn" href="/download">Get the App</a></li>
                        <li id="nav-search" class="nav-search nav-item nav-icon"><a data-listener="notImplemented" href="/search" class="ir">Search</a></li>
                    </ul>
                </nav>
            </header>
            <div class="message-bar ta-center">
                <div id="errorBar" class="messageBar error"></div>
                <div id="infoBar" class="messageBar info"></div>
            </div>
            <div class="dashboard-menu-wrapper">
                <ul class="dashboard-menu col2">
                    <li class="profile">
                        <a href="/user/account" title="My Profile">Account</a>
                    </li>
                    <li class="support">
                        <a data-listener="notImplemented" href="/user/zendesk" title="VSCO Support">Support</a>
                    </li>
                </ul>
            </div>
            <main id="pageBounds" class="pageBounds" role="main">
                <div id="account">
                    <ul class="accountNav">
                        <li>
                            <a href="/user/account" class="profile">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="60px" height="60px"
                                    viewBox="0 90 612 612" enable-background="new 0 90 612 612" xml:space="preserve">
                                    <circle cx="306" cy="396" r="306"></circle>
                                    <g><path fill="#FFFFFF" d="M291.7,541.9c-1,0-1,0-2,0c-2-1-4.1-2-5.1-4.1c-1-2-1-4.1-1-6.1v-1c0-3.1,0-6.1,0-9.2c1-6.1,0-8.2-3.1-13.3
                                                    c-1-1-2-3.1-2-5.1l-3.1-5.1c-2-4.1-3.1-7.1-5.1-12.2l0,0c-4.1-1-8.2-1-13.3-2c-6.1-1-12.2-3.1-17.3-4.1
                                                    c-9.2-3.1-14.3-10.2-14.3-20.4c0-1,0-2,0-4.1s0-3.1,0-5.1c-3.1-1-10.2-3.1-10.2-11.2c0-2,0-4.1,1-6.1c-4.1-3.1-5.1-7.1-5.1-11.2
                                                    s2-7.1,3.1-8.2c-3.1,0-4.1,0-6.1-1c-5.1-1-9.2-5.1-11.2-9.2s-2-10.2,0-14.3c1-4.1,6.1-10.2,16.3-23.5c4.1-5.1,8.2-11.2,9.2-13.3
                                                    c2-2,1-4.1,1-6.1c0-1,0-1-1-2c-1-7.1,0-11.2,1-15.3l1-3.1c2-6.1,4.1-10.2,5.1-13.3c2-3.1,3.1-6.1,4.1-11.2l1-12.2
                                                    c0-24.5,37.7-43.9,86.7-43.9c47.9,0,86.7,33.7,89.8,78.5c2,22.4,0,37.7-7.1,54.1c-4.1,10.2-9.2,19.4-13.3,29.6
                                                    c-4.1,7.1-7.1,15.3-11.2,22.4c-2,3.1-2,8.2-2,13.3c0,6.1,0,8.2,1,12.2c0,2,1,5.1,1,9.2s-2,8.2-3.1,10.2l-1,1l-80.6,64.3
                                                    C295.8,540.8,293.8,541.9,291.7,541.9z M232.6,435.8c3.1,1,6.1,3.1,7.1,7.1s2,9.2,0,15.3c0,5.1,2,6.1,4.1,7.1
                                                    c4.1,1,9.2,3.1,15.3,4.1c4.1,1,8.2,1,12.2,2l4.1,1c3.1,0,5.1,2,6.1,5.1c2,6.1,4.1,10.2,7.1,15.3l2,5.1c1,2,2,3.1,2,4.1
                                                    c3.1,5.1,5.1,10.2,5.1,18.4l67.3-54.1c0-3.1-1-5.1-1-7.1c0-4.1-1-7.1-1-13.3c0-7.1,1-14.3,4.1-20.4c3.1-8.2,7.1-15.3,11.2-23.5
                                                    c4.1-9.2,9.2-18.4,13.3-28.6c5.1-13.3,7.1-27.5,6.1-46.9c-3.1-36.7-34.7-64.3-74.5-64.3c-41.8,0-71.4,15.3-71.4,29.6l-1,13.3v1
                                                    c-2,7.1-4.1,11.2-5.1,15.3c-1,3.1-3.1,6.1-4.1,11.2l-1,3.1c-1,3.1-2,5.1-1,7.1c1,4.1,3.1,11.2-2,19.4c-2,3.1-6.1,8.2-10.2,14.3
                                                    c-5.1,7.1-13.3,18.4-14.3,20.4c0,1,0,1,0,2l1,1c1,0,3.1,0,5.1,0c4.1,0,6.1,0,8.2,1c3.1,1,4.1,3.1,5.1,6.1c2,9.2-1,13.3-3.1,17.3
                                                    c2,1,6.1,3.1,7.1,7.1C235.6,431.7,233.6,434.8,232.6,435.8z"></path></g>
                                </svg>
                                <span>My Info</span>
                            </a>
                        </li>
                        <li>
                            <a data-listener="notImplemented" href="/user/account/apps" class="apps">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="60px" height="60px"
                                    viewBox="0 90 612 612" enable-background="new 0 90 612 612" xml:space="preserve">
                                    <path fill="#FFFFFF" d="M181.6,311.3v168.3h249.9V311.3H181.6z M416.2,326.6v42.8H196.9v-42.8H416.2z M196.9,464.3v-78.5h219.3v79.6 H196.9V464.3z"></path>
                                    <circle cx="306" cy="396" r="306"></circle>
                                    <g>
                                        <rect x="257" y="407.2" fill="#FFFFFF" width="98.9" height="15.3"></rect>
                                        <rect x="257" y="362.3" fill="#FFFFFF" width="98.9" height="15.3"></rect>
                                        <path fill="#FFFFFF" d="M208.1,271.6v249.9h196.9V271.6H208.1z M388.6,506.2H223.4V285.8h166.3v220.3H388.6z"></path>
                                        <rect x="257" y="317.5" fill="#FFFFFF" width="49" height="15.3"></rect>
                                        <rect x="257" y="452.1" fill="#FFFFFF" width="98.9" height="15.3"></rect>
                                    </g>
                                </svg>
                                <span>Apps</span>
                            </a>
                        </li>
                        <li>
                            <form id="signout" class="sign-out" enctype="multipart/form-data">
                                <input type="hidden" name="CsrfToken" value="foobar">
                                <button type="submit">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="60px" height="60px"
                                        viewBox="0 90 612 612" enable-background="new 0 90 612 612" xml:space="preserve">
                                        <circle cx="306" cy="396" r="306"></circle>
                                        <polygon fill="#FFFFFF" points="304,294 292.7,304.2 381.5,394 198.9,394 198.9,409.3 381.5,409.3 292.7,498 304,508.2 411.1,401.1"></polygon>
                                    </svg>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                    <div id="c1" class="container_12">
                        <hr class="hr">
                        <h4 class="account-section-title">Profile</h4>
                        <form id="updateAccount" data-listener="updateAccount" data-form-type="profile" enctype="multipart/form-data">
                            <input type="hidden" name="CsrfToken" value="foobar">
                            <div class="clearfix">
                                <div class="grid_6 alpha">
                                    <div class="form_element">
                                        <label for="firstName">First Name</label>
                                        <input type="text" id="firstName" name="firstName" value="<?php echo $_SESSION["profileInfo"]["FirstName"] ?? ""; ?>">
                                    </div>
                                </div>
                                <div class="grid_6 omega">
                                    <div class="form_element">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" id="lastName" name="lastName" value="<?php echo $_SESSION["profileInfo"]["LastName"] ?? ""; ?>">
                                    </div>
                                </div>
                                <div class="grid_6 alpha">
                                    <div class="form_element">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" value="<?php echo $_SESSION["profileInfo"]["Email"] ?? ""; ?>">
                                    </div>
                                </div>
                                <div class="grid_6 omega">
                                    <div class="form_element">
                                        <label for="company">Company</label>
                                        <input type="text" id="company" name="company" value="<?php echo $_SESSION["profileInfo"]["Company"] ?? ""; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="grid_4 alpha omega">
                                    <button class="btn btn--inverted btn--full" type="submit">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="c2" class="container_12">
                        <div class="grid_6 alpha">
                            <hr class="hr">
                            <h4 class="account-section-title">Password</h4>
                            <form id="changePassword" data-listener="updateAccount" data-form-type="pass" enctype="multipart/form-data">
                                <input type="hidden" name="CsrfToken" value="foobar">
                                <div class="form_element">
                                    <label for="currentPassword">Current Password</label>
                                    <input type="password" id="currentPassword" name="password">
                                </div>
                                <div class="form_element">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" id="newPassword" name="password-new">
                                </div>
                                <div class="form_element">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input type="password" id="confirmPassword" name="password-confirm">
                                </div>
                                <div id="error-password" class="message message-error"></div>
                                <div id="success-password" class="message message-success"></div>
                                <div class="grid_8 alpha omega mb20">
                                    <button class="btn btn--inverted btn--full" id="changePasswordBtn" type="submit">Save Changes</button>
                                </div>
                            </form>
                        </div>
                        <div class="grid_6 omega">
                            <hr class="hr">
                            <h4 class="account-section-title">VSCO Profile</h4>
                            <div class="account-grid-share mt20">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 124 124" enable-background="new 0 0 124 124">
                                    <path d="M62 .4C28.1.4.5 28 .5 61.9s27.6 61.5 61.5 61.5 61.5-27.6 61.5-61.5S95.9.4 62 .4zm59.1 61.5c0 2-.1 4.1-.3 6.1l-10.4-1.3c.2-1.6.2-3.2.2-4.8
                                        0-1.5-.1-3-.2-4.5l10.4-1.2c.2 1.9.3 3.8.3 5.7zm-118.2 0c0-2 .1-4 .3-6l10.4 1.3c-.1 1.5-.2 3.1-.2 4.7s.1 3.1.2 4.7L3.2 67.8c-.2-1.9-.3-3.9-.3-5.9zm105-15.9l9.8-3.7c1.3
                                        3.7 2.2 7.5 2.8 11.5L110 55c-.4-3.1-1.1-6.1-2.1-9zm.2 15.9c0 3.1-.3 6.1-.9 9l-10.3-2.4c.4-2.1.6-4.3.6-6.6s-.2-4.6-.7-6.9l10.4-2.3c.6 3 .9 6.1.9 9.2zM62 95.1c-18.3
                                        0-33.1-14.9-33.1-33.1S43.7 28.8 62 28.8s33.1 14.9 33.1 33.1S80.2 95.1 62 95.1zm1.1 13V97.5c4.7-.1 9.1-1.2 13.2-3l4.6 9.6c-5.5 2.4-11.5 3.8-17.8 4zm-20.2-4.2l4.6-9.6c4.1
                                        1.8 8.5 2.9 13.2 3.1V108c-6.3-.1-12.4-1.6-17.8-4.1zm-27.1-42c0-3.2.3-6.3 1-9.3L27.1 55c-.5 2.3-.7 4.6-.7 7 0 2.2.2 4.4.6 6.5l-10.4 2.4c-.5-3-.8-6-.8-9zm45-46.1v10.6c-4.6.2-9
                                        1.2-13 2.9l-4.6-9.6c5.4-2.3 11.3-3.7 17.6-3.9zm20.1 4.1l-4.6 9.5c-4-1.8-8.5-2.8-13.1-3V15.8c6.3.2 12.3 1.6 17.7 4.1zM107 43.8c-1.2-2.9-2.6-5.6-4.3-8.2l8.7-6c2.2 3.3 4 6.8
                                        5.5 10.5l-9.9 3.7zm-.3 6.6l-10.4 2.3c-1.2-4.4-3.2-8.5-5.9-12.1l8.3-6.6c3.7 4.9 6.4 10.4 8 16.4zM88.9 38.8c-2.9-3.4-6.5-6.2-10.4-8.3l4.6-9.5c5.4 2.8 10.2 6.7 14.1 11.3l-8.3
                                        6.5zm-3.1-19.2l4.9-9.3c3.5 1.9 6.7 4.2 9.7 6.8l-7 7.8c-2.3-1.9-4.8-3.7-7.6-5.3zm-2.1-1.1C81 17.1 78.1 16 75 15.2L77.5 5c3.8 1.1 7.5 2.5 11 4.3l-4.8 9.2zm-11-3.9c-3-.7-6.2-1.1-9.4-1.2V2.9c4.1.1
                                        8.1.6 11.9 1.5l-2.5 10.2zm-11.8-1.2c-3.2.1-6.3.4-9.3 1.1L49.2 4.2C53 3.4 56.9 2.9 61 2.8v10.6zM49.3 15c-3 .8-6 1.9-8.7 3.3L35.7 9c3.5-1.8 7.2-3.2 11.1-4.2L49.3 15zm-10.8 4.4c-2.7
                                        1.5-5.3 3.3-7.7 5.3l-7-7.9c3-2.6 6.3-4.8 9.8-6.7l4.9 9.3zm2.5 1.4l4.6 9.6c-4 2.1-7.5 4.9-10.5 8.3l-8.3-6.6c3.9-4.6 8.7-8.5 14.2-11.3zM25.3 33.9l8.3 6.6c-2.7 3.6-4.7 7.6-5.9 12l-10.4-2.4c1.6-5.9
                                        4.3-11.4 8-16.2zM17 43.5l-9.8-3.7c1.5-3.7 3.4-7.2 5.5-10.5l8.7 6c-1.7 2.6-3.2 5.3-4.4 8.2zm-.8 2.3c-1 2.9-1.8 5.9-2.2 9.1L3.5 53.6C4 49.6 5 45.7 6.3 42l9.9 3.8zM13.9 69c.5 3.1 1.2 6.2 2.2
                                        9.1l-9.8 3.7C5 78.1 4 74.2 3.5 70.2L13.9 69zM17 80.3c1.2 2.9 2.7 5.7 4.4 8.3l-8.7 6c-2.2-3.3-4-6.8-5.5-10.5l9.8-3.8zm.2-7.2l10.3-2.3c1.1 4.5 3.1 8.6 5.8 12.2L25 89.5c-3.6-4.8-6.3-10.4-7.8-16.4zm17.6
                                        11.7c2.9 3.5 6.5 6.4 10.5 8.5l-4.6 9.6c-5.5-2.8-10.3-6.7-14.2-11.4l8.3-6.7zm3.6 19.6l-4.9 9.3c-3.5-1.9-6.7-4.2-9.7-6.7l7-7.9c2.3 2 4.9 3.8 7.6 5.3zm2.2 1.1c2.8 1.4 5.7 2.5 8.7 3.3L46.8
                                        119c-3.9-1-7.6-2.4-11.1-4.2l4.9-9.3zm11 3.9c3 .7 6.1 1 9.2 1.1V121c-4-.1-8-.6-11.8-1.4l2.6-10.2zm11.7 1.1c3.2-.1 6.2-.5 9.2-1.1l2.5 10.2c-3.8.9-7.7 1.3-11.7 1.4v-10.5zm11.5-1.8c3-.8
                                        5.9-1.9 8.7-3.3l4.9 9.3c-3.5 1.8-7.2 3.2-11 4.2l-2.6-10.2zm10.8-4.4c2.7-1.5 5.3-3.3 7.6-5.3l7 7.9c-3 2.5-6.2 4.8-9.7 6.7l-4.9-9.3zm-2.5-1.3l-4.6-9.6c4-2.1 7.6-5 10.6-8.5l8.3 6.6c-4 4.7-8.8 8.6-14.3
                                        11.5zm15.7-13.3L90.5 83c2.7-3.6 4.7-7.7 5.8-12.2l10.3 2.4c-1.4 6.1-4.1 11.6-7.8 16.5zm8.1-9.4l9.8 3.7c-1.5 3.7-3.3 7.2-5.5 10.4l-8.6-6c1.7-2.5 3.1-5.2 4.3-8.1zm.9-2.2c1-2.9 1.8-5.9 2.2-9l10.4 1.3c-.6
                                        4-1.5 7.8-2.8 11.5l-9.8-3.8zm2.2-50.5l-8.7 6c-1.8-2.5-3.9-4.8-6.1-7l7-7.9c2.9 2.7 5.5 5.7 7.8 8.9zm-88-9.2l7 7.9c-2.3 2.1-4.4 4.5-6.2 7l-8.6-6c2.3-3.2 4.9-6.2 7.8-8.9zm-7.9 78.1l8.7-6c1.8 2.5 3.9 4.8
                                        6.2 7l-7 7.9c-2.9-2.7-5.6-5.7-7.9-8.9zm87.9 8.8l-7-7.9c2.3-2.1 4.3-4.4 6.1-6.9l8.6 6c-2.2 3.2-4.8 6.1-7.7 8.8z">
                                    </path>
                                </svg>
                                <h5>vsco.co/<?php echo $_SESSION["profileInfo"]["Username"]?></h5>
                                <a data-listener="notImplemented" href="/user/share">Share Your VSCO Profile</a>
                            </div>
                        </div>
                    </div>
                    <div id="c3" class="container_12">
                        <div class="account-data grid_12 alpha omega">
                            <hr class="hr">
                            <h4 class="account-section-title">My VSCO Data</h4>
                            <p class="account-data-intro">At VSCO, it’s important to us that you have ownership of your creative journey, which includes controlling your content
                                and your data. To help you maintain that ownership, we offer you the options to download, correct, or delete your information.</p>
                            <div class="account-data-section">
                                <h5>Download my data</h5>
                                <div class="account-data-state js-account-data-state" style="display: none;">
                                    <h6 class="js-account-data-state-heading" style="color: blue"></h6>
                                    <p class="js-account-data-state-text"></p>
                                </div>
                                <div class="account-data-static" style="display: block;">
                                    <p>To get a copy of your data, you can create a downloadable snapshot. Please note that images in your Studio will not be included because they
                                        are stored locally on your client device.</p>
                                    <p class="small">A snapshot is a ZIP file of your data on VSCO. It can take up to two hours to create. Once created, it will be available for you
                                        to download for 7 days.</p>
                                </div>
                                <button data-listener="notImplemented" class="block btn btn--blue js-data-snapshot" style="width: 133px;">Access snapshot</button>
                            </div>
                            <div class="account-data-section">
                                <h5>Correct my information</h5>
                                <p>Information associated with your account — such as your email address, profile name, and password — can be changed within the VSCO app. Visit
                                    our <a data-listener="notImplemented" href="https://support.vsco.co" target="_blank" rel="noopener noreferrer">help center</a> to learn more.</p>
                            </div>
                            <div class="account-data-section">
                                <h5>Delete my data</h5>
                                <p>If you’d like to delete your content and data from VSCO, you have the option to delete your account.</p>
                                IMPORTANT:
                                <ul>
                                    <li>You won’t be able to reactivate your account or retrieve anything once it’s deleted.</li>
                                    <li>Deleting your account includes deletion of your images, and mobile and desktop purchases.</li>
                                </ul>
                                <p><strong>For VSCO Members</strong> — Deleting your account will <strong>not</strong> cancel your VSCO Membership. To cancel your VSCO Membership, visit our
                                    <a data-listener="notImplemented" href="https://support.vsco.co/hc/en-us/articles/115005759406-VSCO-X-How-to-Manage-or-Cancel-Your-VSCO-X-Membership">help center</a>.</p>
                                <p class="small">Once you submit your deletion request, it may take several hours to fully delete your data. During this time, your account may still be publicly viewable.</p>
                                <button data-listener="notImplemented" class="block btn btn--blue mb20 js-data-delete">Delete my account</button>
                                <p><em>If you’d prefer to keep your content and data on VSCO, deactivate your account by following the instructions
                                    <a data-listener="notImplemented" href="https://support.vsco.co/hc/en-us/articles/201893264-How-do-I-deactivate-my-VSCO-Account-">here</a>.</em></p>
                            </div>
                            <section class="modal">
                                <div class="modal-inner">
                                    <div class="modal-header">
                                        <h1 class="modal-title"></h1>
                                        <i class="modal-close">×</i>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <button data-listener="notImplemented" class="btn btn--blue" disabled=""></button>
                                        <button class="btn btn--blue js-data-revoke-btn" style="display: none;">Sign out</button>
                                        <a data-listener="notImplemented" href="/user/forgotpassword" class="js-account-forgot-pw fs12" style="display: none; color: blue;">Forgot your password?</a>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once("../footer.php"); ?>
        </div>
    </body>
</html>