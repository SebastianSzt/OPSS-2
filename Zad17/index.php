<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: zalogowany.php');
}
?>

<!DOCTYPE html>
<html lang="pl_PL">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadanie 17 313061</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Logowanie w PHP z SQLite</h1>
    <div id="blok">
        <form action="skrypt.php" method="POST">
            <label>Login: <input type="text" name="login"></label><br />
            <label>Hasło: <input type="password" name="haslo"></label><br />
            <input type="submit" value="Wyślij" name="logowanie">
            <input type="reset" value="Wyczyść">
        </form>
    </div>
</body>
</html>