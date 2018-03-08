<?php
/*******************************************************************************
 * Laboration 2, Kurs: DT161G
 * File: logout.php
 * Desc: Logout page for laboration 2
 *
 * Eva Frisell
 * evmo1600
 * evmo1600@student.miun.se
 ******************************************************************************/

// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

class logoutResponse {
    public $msg;
    public $link_array;
}

$logoutResponse = new logoutResponse();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie($_session_name, '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
$msg = "You are logged out and the session cookie has been destroyed";
$logoutResponse->msg = $msg;
$logoutResponse->link_array = array ("Gästbok" => "guestbook.php");

// Finally, destroy the session.
session_destroy();

header('Content-Type: application/json');
echo json_encode($logoutResponse);

?>

