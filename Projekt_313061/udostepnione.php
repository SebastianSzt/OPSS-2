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
            Udostępnione dyski
            <a href="login.php">
                <span class="icon_account">account_circle</span>
            </a>
        </header>
        
        <nav>
            <ul>
                <li><a href="konto.php" class="menuItem">Konto</a></li>
                <li><a href="dysk.php" class="menuItem">Mój dysk</a></li>
                <li><a href="udostepnione.php" class="menuItem aktywny">Udostępnione</a></li>
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
            <?php
                session_start();
                if (!isset($_SESSION['username']))
                {
                    echo "Musisz się zalogować żeby zobaczyć dyski udostępnione przez innych.";
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
                        if ($row["login"] != $_SESSION['username'] && count($pliki) > 2)
                        {
                            $liczba = $liczba + 1;
                            echo '<a href="udostepnione.php?open='.$row["login"].'" class="notextdec"><div class="plik_dysk">' . $row["login"] . '</div></a>';
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
                    echo 'Brak udostępnionych dysków.';
                }

                if (isset($_GET['open'])) 
                {
                    $fileToOpen = basename($_GET['open']);
                    $userOpenDirectory = "$openDirectory/$fileToOpen";
                    echo '<div class="pliki">';
                    $pliki = scandir($userOpenDirectory);
                    for($i=2; $i < count($pliki); $i++)
                    {
                        echo '<div class="plik"><a href="udostepnione.php?download='.$pliki[$i].'&login='.$fileToOpen.'" title="Pobierz plik" class="notextdec"><span class="icon_download">file_download</span></a>' . $pliki[$i] . '</div>';
                    }
                    echo '</div>';
                }

                if (isset($_GET['download']) && isset($_GET['login'])) 
                {
                    $fileToOpen = basename($_GET['login']);
                    $fileToDownload = basename($_GET['download']);
                    $file = "$openDirectory/$fileToOpen/$fileToDownload";
                            
                    if(file_exists($file)) 
                    {
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename="'.$fileToDownload.'"');
                        header('Content-Transfer-Encoding: binary');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($file));
                        ob_clean();
                        flush();
                        readfile($file);
                    }
                    else
                    {
                        echo "File does not exist.";
                    }
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
            const box_plik = document.querySelectorAll(".plik");
            for (const box of box_plik) 
            {
                box.classList.toggle("plik_dark");
            }
            const box_icon = document.querySelectorAll(".icon_download");
            for (const box of box_icon) 
            {
                box.classList.toggle("icon_download_dark");
            }
            const box_plik_dysk = document.querySelectorAll(".plik_dysk");
            for (const box of box_plik_dysk) 
            {
                box.classList.toggle("plik_dysk_dark");
            }
        }
    </script>

</body>
</html>