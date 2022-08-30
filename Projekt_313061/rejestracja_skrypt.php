<?php
    $edycja = trim($_POST['edycja']);

    $database = new SQLite3('/home/313061/public_html/OPSS-2/bazy_danych/users.db');

    if ($edycja == '0')
    {
        $imie = trim($_POST['imie']);
        $nazwisko = $_POST['nazwisko'];
        $email = trim($_POST['email']);
        $login = trim($_POST['login']);
        $haslo = trim($_POST['haslo']);

        $sql = "SELECT * FROM users WHERE login = :login";

        $statement = $database->prepare($sql);
        $statement->bindValue(':login', $login, SQLITE3_TEXT);
        $result = $statement->execute()->fetchArray(SQLITE3_ASSOC);

        if (count($result)>1)
        {
            echo '2';
        }
        else 
        {
            $sql = "INSERT INTO users (imie, nazwisko, email, login, haslo, dysk) VALUES (:imie, :nazwisko, :email, :login, :haslo, 'Prywatny')";

            $statement = $database->prepare($sql);
            $statement->bindValue(':imie', $imie, SQLITE3_TEXT);
            $statement->bindValue(':nazwisko', $nazwisko, SQLITE3_TEXT);
            $statement->bindValue(':email', $email, SQLITE3_TEXT);
            $statement->bindValue(':login', $login, SQLITE3_TEXT);
            $statement->bindValue(':haslo', $haslo, SQLITE3_TEXT);
            $statement->execute();
            
            echo '1';
        }
    }

    if ($edycja == '1')
    {
        $imie = trim($_POST['imie']);
        $nazwisko = $_POST['nazwisko'];
        $email = trim($_POST['email']);
        $login = trim($_POST['login']);
        $haslo = trim($_POST['haslo']);
        $dysk = trim($_POST['dysk']);

        $sql = "UPDATE users SET imie = :imie, nazwisko = :nazwisko, email = :email, haslo = :haslo, dysk = :dysk WHERE login = :login";

        $statement = $database->prepare($sql);
        $statement->bindValue(':imie', $imie, SQLITE3_TEXT);
        $statement->bindValue(':nazwisko', $nazwisko, SQLITE3_TEXT);
        $statement->bindValue(':email', $email, SQLITE3_TEXT);
        $statement->bindValue(':login', $login, SQLITE3_TEXT);
        $statement->bindValue(':haslo', $haslo, SQLITE3_TEXT);
        $statement->bindValue(':dysk', $dysk, SQLITE3_TEXT);
        $statement->execute();

        echo '1';
    }

    if ($edycja == '2')
    {
        $login = trim($_POST['login']);
        $dysk = trim($_POST['dysk']);

        $sql = "UPDATE users SET dysk = :dysk WHERE login = :login";

        $statement = $database->prepare($sql);
        $statement->bindValue(':dysk', $dysk, SQLITE3_TEXT);
        $statement->bindValue(':login', $login, SQLITE3_TEXT);
        $statement->execute();

        echo '1';
    }
?>