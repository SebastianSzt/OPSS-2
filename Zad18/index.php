<!DOCTYPE html>
<html lang="pl_PL">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadanie 18 313061</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Upload plików na serwer</h1>
    <div id="blok">
        Pliki do przesłania:
        <form action="index.php" method="POST" enctype="multipart/form-data">
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

echo '<div id="komunikaty">';
if(isSet($_POST['wyslij']))
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
                if (move_uploaded_file($tmpName, "$uploadDirectory/$fileName")) 
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
    if (unlink("$uploadDirectory/$fileToRemove")) 
    {
        echo '<div id="komunikaty"><div class="green">Plik: ' . $fileToRemove . ' został usunięty</div></div>';
    } 
    else 
    {
        echo '<div id="komunikaty"><div class="red">Nie udało się usunąć pliku</div></div>';
    }
}

echo '<div id="pliki">';
$pliki = scandir($uploadDirectory);
//for($i=2; $i<count($pliki); $i++)
foreach($pliki as $plik) 
{
    if ($plik !== "." && $plik !== "..")
    {
        echo '<p><a href="index.php?remove=' . $plik .'" title="Usuń plik">[X]</a> ' . $plik . '</p>';
    }
}
echo '</div>';
?>
</div>
</body>
</html>