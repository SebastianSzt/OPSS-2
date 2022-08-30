<?php
if(isSet($_POST['logowanie']))
{
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    $file = file("dane.txt", FILE_IGNORE_NEW_LINES);

    foreach($file as $line) 
    {
	    list($plik_login, $plik_haslo) = explode(":", $line);
 
	    if($login == $plik_login && $haslo == $plik_haslo) 
	    {
    		echo "<h1>Witaj " . $login . "!</h1>";
            echo "Zostałeś poprawnie zalogowany.";
            exit;
	    }
    }
    echo "<h1>Podałeś niepoprawne dane.</h1>";
    echo "Odśwież stronę żeby spróbowac zalogować się ponownie.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl_PL">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadanie 16 313061</title>
    <style>
        #blok {
            box-sizing: border-box;
            width: 400px;
            background-color: rgb(0, 255, 255);
            border: 3px solid black;
        }

        form {
            margin: 30px;
            font-size: 20px;
        }

        input {
            margin-bottom: 5px;
            margin-left: 5px;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <h1>Logowanie w PHP</h1>
    <div id="blok">
        <form action="index.php" method="POST">
            <label>Login: <input type="text" name="login"></label><br />
            <label>Hasło: <input type="password" name="haslo"></label><br />
            <input type="submit" value="Wyślij" name="logowanie">
            <input type="reset" value="Wyczyść">
        </form>
    </div>
</body>
</html>