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

<!DOCTYPE html>
<html lang="pl_PL">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadanie 17 313061</title>
</head>

<body>
    <h1>
        Witaj 
        <?php
        session_start();
        echo $_SESSION['username']; 
        ?>!
    </h1>
    Zostałeś poprawnie zalogowany (<a href="?logout">Wyloguj</a>).
</body>
</html>

