<?PHP
/*******************************************************************************
 * Laboration 2, Kurs: DT161G
 * File: index.php
 * Desc: Start page for laboration 2
 *
 * Eva Frisell
 * evmo1600
 * evmo1600@student.miun.se
 ******************************************************************************/
session_start();

$title = "Laboration 2";

if(isset($_SESSION['username'])){
    showInlogLinks();
    $_SESSION["showButton"] = true;
    $_SESSION["showLoginForm"] = false;
}

function showInlogLinks(){

    if(isset($_SESSION['link_array']) && ($_SESSION['link_array']) !== null){
    foreach ($_SESSION['link_array'] as $x => $y){
        if($x === 'Gästbok') {
            $_SESSION['link1'] = "<a href= '".$y."'>.$x.</a>";
        }
        if ($x === 'Medlemssida'){
            $_SESSION['link2'] = "<a href= '".$y."'>.$x.</a>";
        }
    }
}
}

function showButton(){
    if(isset($_SESSION["showButton"]) && $_SESSION["showButton"] === true){
        echo "style='display:block;'";
        $_SESSION["showButton"] = false;
    }
}

function showLoginForm(){
    if(isset($_SESSION["showLoginForm"]) && $_SESSION["showLoginForm"] === false){
        echo "style='display:none;'";
        $_SESSION["showLoginForm"] = true;
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
    <title>DT161G-<?php echo $title ?></title>
    <link rel="stylesheet" href="css/style.css"/>
    <script src="js/main.js"></script>
</head>
<body>
<header>
    <img src="img/mittuniversitetet.jpg" alt="miun logga" class="logo"/>
    <h1><?php echo $title ?></h1>
</header>
<main>
    <aside>
        <div id="login"<?php showLoginForm(); ?>>
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
    </aside>
    <section>
        <h2>VÄLKOMMEN
        </h2>
        <p>Detta är andra laborationen</p>
        <p id="status"></p>
    </section>
</main>
<footer>
    Footer
</footer>
</body>
</html>
