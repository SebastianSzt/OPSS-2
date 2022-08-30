<!DOCTYPE html>
<html lang="pl_PL">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadanie 19 313061</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    if (isset($_GET['logout'])) {
        echo 'Za 3 sekundy zostaniesz wylogowany...';
        session_start();
        unset($_SESSION['username']);
        session_destroy();
        header("refresh: 3; url=index.php");
        exit;
    }
    ?>
    <h1>Upload plików z logowaniem</h1>
    <h2>
        Witaj 
        <?php
        session_start();
        echo $_SESSION['username']; 
        ?>!
    </h2>
    Zostałeś poprawnie zalogowany (<a href="?logout">Wyloguj</a>).
    <h2>Upload plików na serwer</h2>
    <div id="wysylanie">
        Pliki do przesłania:
        <form action="zalogowany.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="files[]" multiple accept="image/*"><br />
            <input type="submit" value="Wyślij" name="wyslij">
            <input type="reset" value="Wyczyść">
        </form>
    </div>
    <h1 id="naglowek">Pliki znajdujące się w folderze</h1>
    <div id="container">
    <?php
    error_reporting(E_ALL|E_STRICT);
    ini_set('display_errors', 1);

    $uploadDirectory = '/home/313061/upload_kontener';
    $userUploadDirectory = "$uploadDirectory/$_SESSION[username]";
    if (!is_dir($userUploadDirectory)) 
    {
        if (file_exists($userUploadDirectory)) 
        {
            die("Nie udało się utworzyć katalogu użytkownika, ponieważ plik o tej nazwie już istnieje: $userUploadDirectory");
        }
        if (!mkdir($userUploadDirectory, 0777) || !chmod($userUploadDirectory, 0777)) 
        {
            die("Wystąpił błąd podczas tworzenia katalogu użytkownika: $userUploadDirectory");
        }
    }
    

    echo '<div id="komunikaty">';
    if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_FILES['files']))
    {
        foreach ($_FILES['files']['error'] as $key => $error) 
        {
            if ($error === UPLOAD_ERR_OK) 
            {
                $tmpName = $_FILES['files']['tmp_name'][$key];
                $fileName = basename($_FILES['files']['name'][$key]);
                $fileMimeType = mime_content_type($tmpName);
                if (strpos($fileMimeType, 'image/') !== false) 
                {
                    if (move_uploaded_file($tmpName, "$userUploadDirectory/$fileName")) 
                    {
                        echo '<div class="green">Plik: ' . $fileName . ' został zapisany poprawnie</div>';
                    } 
                    else 
                    {
                        echo '<div class="red">Wysyłanie nie powiodło się</div>';
                    }
                } 
                else 
                {
                    echo '<div class="red">Niewłaściwy typ pliku: ' . $fileName . '</div>';
                }
            }
        }
    }
    echo '</div>';

    if (isset($_GET['remove'])) {
        $fileToRemove = basename($_GET['remove']);
        if (unlink("$userUploadDirectory/$fileToRemove")) 
        {
            echo '<div id="komunikaty"><div class="green">Plik: ' . $fileToRemove . ' został usunięty</div></div>';
        } 
        else 
        {
            echo '<div id="komunikaty"><div class="red">Nie udało się usunąć pliku</div></div>';
        }
    }

    echo '<div id="pliki">';
    $pliki = scandir($userUploadDirectory);
    for($i=2; $i < count($pliki); $i++)
    {
        echo '<p><a href="zalogowany.php?remove=' . $pliki[$i] .'" title="Usuń plik">[X]</a> ' . $pliki[$i] . '</p>';
    }
    echo '</div>';
    ?>
    </div>
</body>
</html>
