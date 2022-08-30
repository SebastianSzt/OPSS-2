
<!DOCTYPE html> 
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
$username = $_POST['login'];
$password = $_POST['haslo'];
$database = new SQLite3('database.db');
$sql = "SELECT * FROM users WHERE username = :username AND password = :password";
$statement = $database->prepare($sql);
$statement->bindValue(':username', $username, SQLITE3_TEXT);
$statement->bindValue(':password', $password, SQLITE3_TEXT);
$result = $statement->execute()->fetchArray(SQLITE3_ASSOC);
//count($result)>0
if ($test = $result)
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
?>
</body>
</html>