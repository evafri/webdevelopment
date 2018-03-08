<?php
/*******************************************************************************
 * Laboration 2, Kurs: DT161G
 * File: member.php
 * Desc: Member page for laboration 2
 *
 * Eva Frisell
 * evmo1600
 * evmo1600@student.miun.se
 ******************************************************************************/

// Här skall det ske kontroll om man har loggat in och är behörig att se denna sida.
// Annars redirekt till startsidan

session_start();

if (!isset($_SESSION['username'])){
    header("Location: index.php");
    exit;
 }
 else {
   $title = "Laboration 2";
     $_SESSION["showLoginForm"] = false;
     $_SESSION["showButton"] = true;
     showInlogLinks();
}

if(isset($_POST['logoutButton'])) {
    header("Location: logout.php");
    exit;
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

function showLoginForm(){
    if(isset($_SESSION["showLoginForm"]) && $_SESSION["showLoginForm"] === false){
        echo "style='display:none;'";
        $_SESSION["showLoginForm"] = true;
    }
}

function showButton(){
    if(isset($_SESSION["showButton"]) && $_SESSION["showButton"] === true){
        echo "style='display:block;'";
        $_SESSION["showButton"] = false;
    }
}

?>

<!DOCTYPE html>
<html lang="sv-SE">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DT161G-Laboration2-member</title>
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
        <h2>Medlemssida</h2>
        <p>Denna sida skall bara kunna ses av inloggade medlemmar</p>
        <p id="status"></p>
    </section>
</main>
<footer>
    Footer
</footer>
</body>
</html>


