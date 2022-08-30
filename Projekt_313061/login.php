<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: konto.php');
}
?>

<!DOCTYPE html>
<html lang="pl-PL">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Projekt 313061</title>
        <meta name="description" content="Projekt zaliczeniowy">
        <meta name="author" content="Sebastian Sztankowski 313061">
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="skrypty.js"></script>
    </head>
    <body>
        <div id="content">
            <mark>
                <a href="index.html" class="notextdec">
                    <span class="icon_home">home</span>
                </a>
            </mark>

            <header>
                <span class="icon_menu" onclick="mobileMenu()">menu</span>
                Logowanie
                <a href="login.php">
                    <span class="icon_account">account_circle</span>
                </a>
            </header>

            <nav>
                <ul>
                    <li><a href="konto.php" class="menuItem aktywny">Konto</a></li>
                    <li><a href="dysk.php" class="menuItem">Mój dysk</a></li>
                    <li><a href="udostepnione.php" class="menuItem">Udostępnione</a></li>
                    <li><a href="komentarze.php" class="menuItem">Komentarze</a></li>
                    <li><a href="kontakt.php" class="menuItem">Kontakt</a></li>
                </ul>
            </nav>

            <div class="mobile_menu">
                <ul>
                    <li><a href="index.html" class="menuItem_mobile">Strona główna</a></li>
                    <li><a href="konto.php" class="menuItem_mobile">Konto</a></li>
                    <li><a href="dysk.php" class="menuItem_mobile">Mój dysk</a></li>
                    <li><a href="udostepnione.php" class="menuItem_mobile">Udostępnione</a></li>
                    <li><a href="komentarze.php" class="menuItem_mobile">Komentarze</a></li>
                    <li><a href="kontakt.php" class="menuItem_mobile">Kontakt</a></li>
                </ul>
            </div>

            <main>
                <p>Nie jesteś zalogowany, zaloguj się poniżej.</p>

                <div class="formularz75">
                    <b>Formularz logowania:</b>
                    <form action="login.php" method="POST">
                        <label>Login: <input type="text" name="login"></label><br />
                        <label>Hasło: <input type="password" name="haslo"></label><br />
                        <input type="submit" value="Zaloguj się" name="logowanie" class="przycisk">
                        <input type="reset" value="Wyczyść" class="przycisk">
                    </form>
                    <p>Nie masz jeszcze konta? <a href="rejestracja.php">Zarejestruj się!</a></p>
                </div>

                <?php
                if (($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['haslo']) && !empty($_POST['haslo'])))
                {
                    $login = $_POST['login'];
                    $haslo = $_POST['haslo'];
                    $database = new SQLite3('/home/313061/public_html/OPSS-2/bazy_danych/users.db');
                    $sql = "SELECT * FROM users WHERE login = :login AND haslo = :haslo";
                    $statement = $database->prepare($sql);
                    $statement->bindValue(':login', $login, SQLITE3_TEXT);
                    $statement->bindValue(':haslo', $haslo, SQLITE3_TEXT);
                    $result = $statement->execute()->fetchArray(SQLITE3_ASSOC);
                    if (count($result)>1)
                    {
                        session_start();
                        $_SESSION['username'] = $login;
                        echo '<div class="komunikat_green">Poprawne logowanie, za 3 sekundy zostaniesz przekierowany do ustawień konta.</div>';
                        header("refresh: 3; url=konto.php");
                    }
                    else 
                    {
                        echo '<div class="komunikat_red">Podano niepoprawne dane logowania.</div>';
                    }
                }
                elseif (($_SERVER['REQUEST_METHOD'] === 'POST') && (empty($_POST['login']) || empty($_POST['haslo'])))
                {
                    echo '<div class="komunikat_red">Nie podano loginu i/lub hasła.</div>';
                }
                ?>

            </main>
        </div>

        <script type="text/javascript">
            if (localStorage.getItem('motyw') == 'ciemny')
            {
                motywy();
                document.querySelector(".formularz75").classList.toggle("formularz75_dark");
            }
        </script>

    </body>
</html>