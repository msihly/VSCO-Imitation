# VSCO Imitation
### This project is a partially functional imitation of the desktop version of VSCO. Created in 1 week for CIS 4160 final project.

---
# Changelog
*This changelog is not comprehensive and does not cover all or most changes. Use the GitHub commit history to view details*
## Version 0.31 &nbsp;-&nbsp; (2020-05-13)
* Fixed mixed-content error thrown on https caused by improper redirection in `.htaccess`
* Fixed `MutationObserver` functionality in `feed.js`

## Version 0.30 &nbsp;-&nbsp; (2020-05-13)
* `.htaccess` root file rewritten to mask URLs using VSCO's scheme
* Added `feed.php`, `footer.php`, `user/account.php`, and `user/login.php` copying the relevant HTML structures from the respective VSCO pages
* Added `feed.css`, `account.css`, and `login.css` copying the relevant selectors and definitions from the respective VSCO pages
    * Updated `common.css` with shared relevant selectors and definitions from VSCO as well as selectors from OneMark for `js/modules/common.js` functions
* Added 'Feature not implemented' functionality to all pages
* `js/account.js` :
    * Removed irrelevant artifacts
    * Reduced logout redirect delay from 1000ms to 300ms and corrected redirect page reference
* `js/feed.js` :
    * Removed irrelevant artifacts
    * Removed modal functionality
    * Updated `loadPage(...)` function to handle quasi-infinite pagination
        * Now calls `createPosts(...)` and is used for page initialization
    * Added a `MutationObserver` to observe the post feed and modify image wrapper elements to use a `padding-top` value of `100 / (width / height)` as per VSCO's image sizing algorithim
* `js/login.js` :
    * Removed usage of `Cmn.errorCheck()` and `Cmn.insertInlineMessage(...)`
    * Reduced login redirect delay from 500ms to 300ms
* `php/db-functions.php` :
    * Fixed missing `p.postID` in `SELECT` statements in `getFeedPosts(...)` and `getPost(...)`
    * Fixed missing `JOIN` on `Images` table in `getFeedPosts(...)`

## Version 0.20 &nbsp;-&nbsp; (2020-05-11)
* Separated OneMark's SPA structure into distinct pages to match VSCO's page structure
* Added ability to update account details using the profile and password forms on the **Account** page
* Added logout functionality to **Account** page
* Added multiple functions to **Feed** page for fetching posts and creating elements for them
* Added basic pagination functionality to **Feed** page
* Added login functionality and automatic creation of authentication tokens
* Added functions for registration, but not implemented due to VSCO restricting sign-ups to its mobile app
* Added skeleton `index.php` for processing buildpack on Heroku
* Imported and updated `Common` JavaScript module used in OneMark and my other projects

## Version 0.10 &nbsp;-&nbsp; (2020-05-05)
* Initial commits of existing files from [OneMark](https://github.com/msihly/OneMark-Public)