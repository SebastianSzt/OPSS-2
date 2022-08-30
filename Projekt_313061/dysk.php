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
            Mój dysk
            <a href="login.php">
                <span class="icon_account">account_circle</span>
            </a>
        </header>

        <nav>
            <ul>
                <li><a href="konto.php" class="menuItem">Konto</a></li>
                <li><a href="dysk.php" class="menuItem aktywny">Mój dysk</a></li>
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
            <?php
            session_start();
            if (!isset($_SESSION['username']))
            {
                echo "Musisz się zalogować żeby skorzystać z dysku.";
                echo '
                <script>
                    if (localStorage.getItem("motyw") == "ciemny")
                    {
                        motywy();
                    }
                </script>';
                exit;
            }
            ?>

            <div id="kontener_upload">

                <div class="upload">
                    <b>Wysyłanie plików na dysk:</b><br /><br />
                    <form action="dysk.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="files[]" multiple><br />
                        <input type="submit" value="Wyślij" class="przycisk" name="wyslij">
                        <input type="reset" value="Wyczyść" class="przycisk">
                    </form>
                </div>

                <div id="komunikaty">
                    <?php
                        $uploadDirectory = '/home/313061/public_html/OPSS-2/upload_kontener';
                        $userUploadDirectory = "$uploadDirectory/$_SESSION[username]";

                        if (!is_dir($userUploadDirectory)) 
                        {
                            if (file_exists($userUploadDirectory)) 
                            {
                                echo '<div class="komunikat_red">Nie udało się utworzyć katalogu użytkownika, ponieważ plik o tej nazwie już istnieje.</div>';
                                exit;
                            }
                            if (!mkdir($userUploadDirectory, 0777) || !chmod($userUploadDirectory, 0777)) 
                            {
                                echo '<div class="komunikat_red">Wystąpił błąd podczas tworzenia katalogu użytkownika.</div>';
                                exit;
                            }
                        }

                        if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_FILES['files']))
                        {
                            foreach ($_FILES['files']['error'] as $key => $error) 
                            {
                                if ($error === UPLOAD_ERR_OK) 
                                {
                                    $tmpName = $_FILES['files']['tmp_name'][$key];
                                    $fileName = basename($_FILES['files']['name'][$key]);
                                    if (move_uploaded_file($tmpName, "$userUploadDirectory/$fileName")) 
                                    {
                                        echo '<div class="komunikat_green">Plik: ' . $fileName . ' został zapisany poprawnie.</div>';
                                    } 
                                    else 
                                    {
                                        echo '<div class="komunikat_red">Wysyłanie pliku: ' . $fileName . 'nie powiodło się.</div>';
                                    }
                                }
                            }
                        }

                        if (isset($_GET['remove'])) 
                        {
                            $fileToRemove = basename($_GET['remove']);
                            if (unlink("$userUploadDirectory/$fileToRemove")) 
                            {
                                echo '<div class="komunikat_green">Plik: ' . $fileToRemove . ' został pomyślnie usunięty.</div>';
                            } 
                            else 
                            {
                                echo '<div class="komunikat_red">Nie udało się usunąć pliku: ' . $fileToRemove . '</div>';
                            }
                        }

                        if (isset($_GET['download'])) 
                        {
                            $fileToDownload = basename($_GET['download']);
                            $file = "$userUploadDirectory/$fileToDownload";
                            
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
                </div>

                <div class="pliki">
                    <?php
                        $liczba = 0; 
                        $pliki = scandir($userUploadDirectory);
                        for($i=2; $i < count($pliki); $i++)
                        {
                            $liczba = $liczba + 1;
                            echo '<div class="plik"><a href="dysk.php?download='.$pliki[$i].'" title="Pobierz plik" class="notextdec"><span class="icon_download">file_download</span></a>' . $pliki[$i] . '<a href="dysk.php?remove='.$pliki[$i].'" title="Usuń plik" class="notextdec"><span class="icon_remove">delete</span></a></div>';
                        }

                        if ($liczba == 0)
                        {
                            echo '
                            <script>
                                var pliki = document.getElementsByClassName("pliki");
                                pliki[0].style.display = "none";
                            </script>';
                        }
                    ?>
                </div>
            </div>
        </main>
    </div>

    <script>
        if (localStorage.getItem('motyw') == 'ciemny')
        {
            motywy();
            document.querySelector(".upload").classList.toggle("upload_dark");
            document.querySelector(".pliki").classList.toggle("pliki_dark");
            const box_p = document.querySelectorAll(".plik");
            for (const box of box_p) 
            {
                box.classList.toggle("plik_dark");
            }
            const box_md = document.querySelectorAll(".icon_download");
            for (const box of box_md) 
            {
                box.classList.toggle("icon_download_dark");
            }
            const box_mr = document.querySelectorAll(".icon_remove");
            for (const box of box_mr) 
            {
                box.classList.toggle("icon_remove_dark");
            }
        }
    </script>

</body>
</html>