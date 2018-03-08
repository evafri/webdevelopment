<?PHP
/*******************************************************************************
 * Laboration 2, Kurs: DT161G
 * File: guestbook.php
 * Desc: Guestbook page for laboration 2.
 *
 * Eva Frisell
 * evmo1600
 * evmo1600@student.miun.se
 ******************************************************************************/
session_start();

$title = "Laboration 2";

class tableRow
{
    public $name;
    public $text;
    public $ip;
    public $date;
}

if (!isset($_SESSION["tableRows"])) {
    $_SESSION["tableRows"] = array();
}

if (!isset($_SESSION['username'])){
    header("Location: index.php");
    exit;
}
else {
    $_SESSION["showLoginForm"] = false;
    $_SESSION["showButton"] = true;
    showInlogLinks();
}
// Testing if cookie is set and hiding form
/*
if (isset($_COOKIE[$SESSION['poster']] )){
  if($_SESSION["showButton"] == true && $_SESSION['updatedTable'] == true ){
        $_SESSION["showForm"] = FALSE;

    }
}*/

if (isset($_COOKIE[$_POST['name']])){
    if($_SESSION["showButton"] == true && $_SESSION['updatedTable'] == true ){
        $_SESSION["showForm"] = false;

    }
}

if(isset($_POST['loginButton'])) {
    header("Location: login.php");
    $_SESSION["showButton"] = true;
    $_SESSION["showLoginForm"] = false;
    exit;
}

if(isset($_POST['logoutButton'])) {
    header("Location: logout.php");
    exit;
}

function showLoginForm(){
    if(isset($_SESSION["showLoginForm"]) && $_SESSION["showLoginForm"] === false){
        echo "style='display:none;'";
        $_SESSION["showLoginForm"] = true;
    }
}

if (isset($_POST['submit'])) {
    if (strcmp($_POST['captcha'], $_SESSION['code']) === 0) {
        $message = "<span style='color:green'>Correct captcha.</span>";
        echo $message;
        
        if (!isset($_COOKIE[$_POST['name']])) {
            if (isset($_POST['name'])) {
                $cookie_value = $_POST['name'];
            }

            setcookie($_POST['name'], $cookie_value);
            setcookie($name, $cookie_value);
            fillTable();
            $_SESSION["showForm"] = false;
        } else {
            if (isset($_COOKIE[$_POST['name']]) && strcmp($_COOKIE[$_POST['name']], $_POST['name']) === 0) {
                echo $_COOKIE[$_POST['name']] . ", you have already made a post!";
                $_SESSION["showForm"] = false;
            } else {
                fillTable();
            }
        }
    } else {
        $message = "<span style='color:red'>Invalid captcha!</span>";
        $_SESSION["name"] = htmlspecialchars($_POST["name"]);
        $_SESSION["text"] = htmlspecialchars($_POST["text"]);

        echo $message;
    }
}

function fillTable()
{
    // Variable used when testing if cookie exists
    //$_SESSION['poster'] = htmlspecialchars($_POST["name"]);

    $name = htmlspecialchars($_POST["name"]);
    $text = htmlspecialchars($_POST["text"]);
    $ip = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set("Europe/Stockholm");
    $date = date("Y-m-d H:i");

    $tableRow = new tableRow();
    $tableRow->name = $name;
    $tableRow->text = $text;
    $tableRow->ip = $ip;
    $tableRow->date = $date;

    array_push($_SESSION["tableRows"], $tableRow);
    $_SESSION["name"] = "";
    $_SESSION["text"] = "";

    $_SESSION['updatedTable'] = true;

    $formattedData = json_encode($_SESSION["tableRows"]);
    $filename = 'guestbook.json';
    $handle = fopen('/home/evmo1600/public_html/writeable/guestbook.json', 'w+');
    fwrite($handle, $formattedData);
    fclose($handle);
}

function showForm()
{
    if (isset($_SESSION["showForm"]) && $_SESSION["showForm"] === false) {
        echo "style='display:none;'";
        $_SESSION["showForm"] = true;
        $_SESSION["name"] = "";
        $_SESSION["text"] = "";
    }
}

function createTableRow()
{
    $x = "";
    foreach ($_SESSION["tableRows"] as $tableRow) {
        $x .= "<tr><td>$tableRow->name</td><td>$tableRow->text</td><td>IP:$tableRow->ip<br>TID:$tableRow->date</td></tr>";
    }
    return $x;
}

function printSavedName()
{
    if (!isset($_SESSION['name'])) {
        return "";
    } else {
        return $_SESSION['name'];
    }
}

function printSavedText()
{
    if (!isset($_SESSION['text'])) {
        return "";
    } else {
        return $_SESSION['text'];
    }
}

function createCaptcha()
{
    $captcha_num = 'ABCDEFGHIJKLMNOPQRSTUVXYZ0123456789abcdefghijklmnopqrstuvxyz';
    $captcha_num = substr(str_shuffle($captcha_num), 0, 5);
    $_SESSION["code"] = $captcha_num;
    echo $captcha_num;
}

function showButton(){
    if(isset($_SESSION["showButton"]) && $_SESSION["showButton"] === true){
        echo "style='display:block;'";
        $_SESSION["showButton"] = false;
    }
}

function showInlogLinks(){

    foreach ($_SESSION['link_array'] as $x => $y){
        if($x === 'Gästbok') {
            $_SESSION['link1'] = "<a href= '".$y."'>.$x.</a>";
        }
        if ($x === 'Medlemssida'){
            $_SESSION['link2'] = "<a href= '".$y."'>.$x.</a>";
        }
    }
}

/*******************************************************************************
 * HTML section starts here
 ******************************************************************************/
?>
<!DOCTYPE html>
<html lang="sv-SE">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css"/>
    <script src="js/main.js"></script>
    <title>DT161G-Laboration1</title>
</head>
<body>
<header>
    <img src="img/mittuniversitetet.jpg" alt="miun logga" class="logo"/>
    <h1><?php echo $title ?></h1>
</header>
<main>
    <aside>
        <div id="login" <?php showLoginForm(); ?>>
            <h2>LOGIN</h2>
            <form id="loginForm">
                <label><b>Username</b></label>
                <input type="text" placeholder="m" name="uname" id="uname"
                       required maxlength="10" value="m" autocomplete="off">
                <label><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" id="psw"
                       required>
                <button type="button" id="loginButton">Login</button>
            </form>
        </div>
        <div id="logout" <?php showButton(); ?>>
            <h2>LOGOUT</h2>
            <button type="button" id="logoutButton">Logout</button>
        </div>
        <h2>MENY</h2>
        <nav>
            <ul>
                <li id="link1"><?php echo $_SESSION['link1'] ?></li>
                <li id="link2"><?php echo $_SESSION['link2'] ?></li>
                <li id="logoutlink"></li>
            </ul>
        </nav>
        <p id="status"></p>
    </aside>
    <section>
        <h2>GÄSTBOK</h2>

        <table>
            <tr>
                <th class="th20">FRÅN
                </th>
                <th class="th40">INLÄGG
                </th>
                <th class="th40">LOGGNING
                </th>
            </tr>
            <?php echo createTableRow(); ?>
        </table>
        <form action="guestbook.php" method="POST" <?php showForm(); ?> >
            <fieldset>
                <legend>Skriv i gästboken</legend>
                <label>Från: </label>
                <input type="text" placeholder="Skriv ditt namn"
                       name="name" value="<?php echo printSavedName(); ?>"/>
                <br>
                <label for="text">Inlägg</label>
                <textarea id="text" name="text"
                          rows="10" cols="50"
                          placeholder="Skriva meddelande här"><?php echo printSavedText(); ?></textarea>
                <br>
                <label>Captcha: <span class="red"><?php echo createCaptcha(); ?></span></label>
                <input type="text" placeholder="Skriva captcha här"
                       name="captcha" required/>

                <button type="submit" name="submit">Skicka</button>
            </fieldset>
        </form>


    </section>
</main>
<footer>
    Footer
</footer>
</body>
</html>
