<?php
/*******************************************************************************
 * Laboration 2, Kurs: DT161G
 * File: login.php
 * Desc: Login page for laboration 2
 *
 * Eva Frisell
 * evmo1600
 * evmo1600@student.miun.se
 ******************************************************************************/
session_start();

class loginResponse {
    public $msg;
    public $link_array;
}

$user_array = array(
    "m" => "m",
    "a" => "a"
);

$loginResponse = new loginResponse();

foreach ($user_array as $username => $password) {
    if ($username == $_POST['username'] && $password == $_POST['password']) {
        $_SESSION['username'] = $user_array[$username];
        $msg = "<span style='color:green'>Successful login!";

        $_SESSION['link_array'] = array("Gästbok" => "guestbook.php","Medlemssida" => "members.php");
        $loginResponse->link_array = array ("Gästbok" => "guestbook.php","Medlemssida" => "members.php");
        break;
    }
    elseif($username != $_POST['username'] && $password == $_POST['password']){
        $msg = "<span style='color:red'>Invalid Login! Wrong Username!";
        break;
    }
    elseif($password != $_POST['password'] && $username == $_POST['username']){
        $msg = "<span style='color:red'>Invalid Login! Wrong password!";
        break;
    }
    else{
        $msg = "<span style='color:red'>Invalid Login! Try another username and password!";
    }
}

$loginResponse->msg = $msg;

header('Content-Type: application/json');
echo json_encode($loginResponse);
exit();

?>