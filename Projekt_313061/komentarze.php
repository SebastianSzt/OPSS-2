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
            Komentarze do dysków
            <a href="login.php">
                <span class="icon_account">account_circle</span>
            </a>
        </header>
        
        <nav>
            <ul>
                <li><a href="konto.php" class="menuItem">Konto</a></li>
                <li><a href="dysk.php" class="menuItem">Mój dysk</a></li>
                <li><a href="udostepnione.php" class="menuItem">Udostępnione</a></li>
                <li><a href="komentarze.php" class="menuItem aktywny">Komentarze</a></li>
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
            <?php
                error_reporting(E_ALL|E_STRICT);
                ini_set('display_errors', 1);

                session_start();
                if (!isset($_SESSION['username']))
                {
                    echo "Musisz się zalogować żeby komentować dyski z innymi użytkownikami";
                    echo '
                    <script>
                        if (localStorage.getItem("motyw") == "ciemny")
                        {
                            motywy();
                        }
                    </script>';
                    exit;
                }

                $openDirectory = '/home/313061/public_html/OPSS-2/upload_kontener';
                $liczba = 0;       
                $database = new SQLite3('/home/313061/public_html/OPSS-2/bazy_danych/users.db');
                $sql = "SELECT login FROM users WHERE dysk = 'Publiczny'";
                $result = $database->query($sql);
                echo '<div class="pliki">';
                while ($row = $result->fetchArray(SQLITE3_ASSOC)) 
                {
                    if(is_dir($openDirectory.'/'.$row["login"]))
                    {
                        $pliki = scandir($openDirectory.'/'.$row["login"]);
                        if (count($pliki) > 2)
                        {
                            $liczba = $liczba + 1;
                            echo '<a href="komentarze.php?comment='.$row["login"].'" class="notextdec"><div class="plik_dysk">' . $row["login"] . '</div></a>';
                        }
                    }
                }
                echo '</div>';

                if ($liczba == 0)
                {
                    echo '
                    <script>
                        var pliki = document.getElementsByClassName("pliki");
                        pliki[0].style.display = "none";
                    </script>';
                    echo 'Brak dostępnych dysków do komentowania.';
                }

                $database = new SQLite3('/home/313061/public_html/OPSS-2/bazy_danych/comments.db');

                if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['komentarz']))
                {
                    $dysk = basename($_GET['comment']);
                    $nick = $_SESSION['username'];
                    $komentarz = $_POST['komentarz'];
                    date_default_timezone_set("Europe/Warsaw");
                    $data = date("d.m.Y H:i", time());
                    
                    $sql = "INSERT INTO comments (dysk, nick, tresc, data) VALUES (:dysk, :nick, :komentarz, :data)";
                    $statement = $database->prepare($sql);
                    $statement->bindValue(':dysk', $dysk, SQLITE3_TEXT);
                    $statement->bindValue(':nick', $nick, SQLITE3_TEXT);
                    $statement->bindValue(':komentarz', $komentarz, SQLITE3_TEXT);
                    $statement->bindValue(':data', $data, SQLITE3_TEXT);
                    $statement->execute();
                    
                    echo '<div class="komunikat_green">Komentarz został pomyślnie dodany.</div>';
                }

                if (isset($_GET['comment'])) 
                {
                    $dysk = basename($_GET['comment']);
                    echo '<div class="komentarze">';
                    echo '<b>Dodaj swój komentarz:</b><br /><br />
                    <form action="komentarze.php?comment='.$dysk.'" method="POST">
                        <label>Treść komentarza: <br /><textarea name="komentarz" maxlength="250"></textarea></label> <br />
                        <input type="submit" value="Wyślij" class="przycisk">
                        <input type="reset" value="Wyczyść" class="przycisk">
                    </form><br />';
                    echo '<b>Komentarze użytkowników:</b><br />';
                    
                    $sql = "SELECT nick, tresc, data FROM comments WHERE dysk = '".$dysk."'";
                    $result = $database->query($sql);
                    
                    while ($row = $result->fetchArray(SQLITE3_ASSOC)) 
                    {
                        echo '<p><div class="komentarz">';
                        echo '<span>'.$row["data"].'</span> '.$row["nick"].':<br />';
                        echo $row["tresc"];
                        echo '</div></p>';
                    }
                    echo '</div>';
                }
            ?>
        </main>
    </div>

    <script>
        if (localStorage.getItem('motyw') == 'ciemny')
        {
            motywy();
            const box_pliki = document.querySelectorAll(".pliki");
            for (const box of box_pliki) 
            {
                box.classList.toggle("pliki_dark");
            }
            const box_plik_dysk = document.querySelectorAll(".plik_dysk");
            for (const box of box_plik_dysk) 
            {
                box.classList.toggle("plik_dysk_dark");
            }
            const box_komentarze = document.querySelectorAll(".komentarze");
            for (const box of box_komentarze) 
            {
                box.classList.toggle("komentarze_dark");
            }
            const box_komentarz = document.querySelectorAll(".komentarz");
            for (const box of box_komentarz) 
            {
                box.classList.toggle("komentarz_dark");
            }
        }
        const box_komg= document.querySelectorAll(".komunikat_green");
        for (const box of box_komg) 
        {
            box.classList.toggle("komunikat_green100");
        }
    </script>

</body>
</html>