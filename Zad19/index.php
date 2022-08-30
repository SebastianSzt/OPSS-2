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
    <title>Zadanie 19 313061</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Upload plików z logowaniem</h1>
	<h2>Formularz logowania</h2>
    <div id="logowanie">
        <form action="index.php" method="POST">
            <label>Login: <input type="text" name="login"></label><br />
            <label>Hasło: <input type="password" name="haslo"></label><br />
            <input type="submit" value="Wyślij" name="logowanie">
            <input type="reset" value="Wyczyść">
        </form>
    </div>

    <?php
    if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['login']) && isset($_POST['haslo']))
    {
        $username = $_POST['login'];
        $password = $_POST['haslo'];
        $database = new SQLite3('database.db');
        $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
        $statement = $database->prepare($sql);
        $statement->bindValue(':username', $username, SQLITE3_TEXT);
        $statement->bindValue(':password', $password, SQLITE3_TEXT);
        $result = $statement->execute()->fetchArray(SQLITE3_ASSOC);
        if (count($result)>1)
        {
            session_start();
            $_SESSION['username'] = $username;
            header('Location: zalogowany.php');
        }
        else 
        {
            echo '<h2 id="czerwony">Podałeś niepoprawne dane!</h3>';
            echo "Za 5 sekund zostaniesz przekierowany na stronę logowania...";
            header("refresh: 5; url=index.php");
        }
    }
    ?>
</body>
</html>