<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: konto.php');
}
?>

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
        <script type="text/javascript">
            var liczba_kom = 0;
            function walidacja()
            {
                const imie = document.getElementById('imie');
                const wartoscImie = imie.value;
                const nazwisko = document.getElementById('nazwisko');
                const wartoscNazwisko = nazwisko.value;
                const email = document.getElementById('email');
                const wartoscEmail = email.value;
                const login = document.getElementById('login');
                const wartoscLogin = login.value;
                const haslo = document.getElementById('haslo');
                const wartoscHaslo = haslo.value;

                var komunikat = document.createElement('div'); 
                var parent = document.getElementById('komunikaty_js');

                if (wartoscImie != 0 && wartoscNazwisko != 0 && wartoscEmail != 0 && wartoscLogin != 0 && wartoscHaslo != 0)
                {
                    if (/^[a-z]{2,}$/i.test(wartoscImie)) 
                    {}
                    else
                    {
                        liczba_kom = liczba_kom + 1;
                        komunikat.className = 'komunikat_red';
                        komunikat.innerHTML = liczba_kom + ". Pole imię może składać się tylko z liter i musi mieć przynajmniej dwa znaki!";
                        parent.appendChild(komunikat);
                        return;
                    }

                    if (/^[a-z\-\s]{2,}$/i.test(wartoscNazwisko)) 
                    {}
                    else
                    {
                        liczba_kom = liczba_kom + 1;
                        komunikat.className = 'komunikat_red';
                        komunikat.innerHTML = liczba_kom + ". Pole nazwisko może składać się tylko z liter, myślnika i spacji oraz musi mieć przynajmniej dwa znaki!";
                        parent.appendChild(komunikat);
                        return;
                    }
                    
                    if (/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test(wartoscEmail)) 
                    {}
                    else
                    {
                        liczba_kom = liczba_kom + 1;
                        komunikat.className = 'komunikat_red';
                        komunikat.innerHTML = liczba_kom + ". Pole email może składać się z dużych i małych liter, liczb oraz musi miec jedną litere/cyfre po @ i od 2 do 4 liter po kropce!";
                        parent.appendChild(komunikat);
                        return;
                    }

                    if (/^[a-z0-9]{5,20}$/i.test(wartoscLogin)) 
                    {}
                    else
                    {
                        liczba_kom = liczba_kom + 1;
                        komunikat.className = 'komunikat_red';
                        komunikat.innerHTML = liczba_kom + ". Pole login może składać się tylko z liter i liczb oraz musi mieć od 5 do 20 znaków!";
                        parent.appendChild(komunikat);
                        return;
                    }

                    if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\!\@\#\$\%\^\&\*\(\)\{\}\[\]\\\|\:\"\;\'\<\>\?\,\.\/])[a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\{\}\[\]\\\|\:\"\;\'\<\>\?\,\.\/]{8,20}$/.test(wartoscHaslo)) 
                    {}
                    else
                    {
                        liczba_kom = liczba_kom + 1;
                        komunikat.className = 'komunikat_red';
                        komunikat.innerHTML = liczba_kom + ". Pole hasło musi zawierać od 8 do 20 znaków w tym: małą i dużą literę, cyfrę oraz znak specjalny!";
                        parent.appendChild(komunikat);
                        return;
                    }

                    var formdata = 'imie=' + wartoscImie + '&nazwisko=' + wartoscNazwisko + '&email=' + wartoscEmail + '&login=' + wartoscLogin + '&haslo=' + wartoscHaslo + '&edycja=0';
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () 
                    {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
                        {
                            if(xmlhttp.responseText === '1')
                            {
                                liczba_kom = liczba_kom + 1;
                                komunikat.className = 'komunikat_green';
                                komunikat.innerHTML = liczba_kom + ". Konto zostało pomyślnie założone. Za 5 sekund zostaniesz przekierowany na stronę logowania.";
                                parent.appendChild(komunikat);
                                setTimeout("window.location='login.php'", 5000);
                            }
                            if(xmlhttp.responseText === '2')
                            {
                                liczba_kom = liczba_kom + 1;
                                komunikat.className = 'komunikat_red';
                                komunikat.innerHTML = liczba_kom + ". Podany login jest już zajęty, podaj inny.";
                                parent.appendChild(komunikat);
                            }
                        }
                    };
                    xmlhttp.open("POST", "rejestracja_skrypt.php", true);
                    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    xmlhttp.send(formdata);
                }
                else
                {
                    liczba_kom = liczba_kom + 1;
                    komunikat.className = 'komunikat_red';
                    komunikat.innerHTML = liczba_kom + ". Nie wypełniono wszystkich pól.";
                    parent.appendChild(komunikat);
                }
            }
        </script>
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
            Rejestracja
            <a href="login.php">
                <span class="icon_account">account_circle</span>
            </a>
        </header>

        <nav>
            <ul>
                <li><a href="konto.php" class="menuItem aktywny">Konto</a></li>
                <li><a href="dysk.php" class="menuItem">Mój dysk</a></li>
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
            <div class="formularz75">
                <b>Formularz rejestracji:</b><br /><br />
                Wypełnij pola formularza żeby się zarejestrować.
                <form>
                    <label>Imie: <input type="text" id="imie"></label><br />
                    <label>Nazwisko: <input type="text" id="nazwisko"></label><br />
                    <label>Email: <input type="text" id="email"></label><br />
                    <label>Login: <input type="text" id="login"> <-- Loginu nie można później zmienić</label><br />
                    <label>Hasło: <input type="password" id="haslo"></label><br />
                    <input type="button" value="Zarejestruj się" class="przycisk" onclick="walidacja()">
                    <input type="reset" value="Wyczyść" class="przycisk">
                </form>
            </div>
            <div id="komunikaty_js"></div>
        </main>
    </div>

    <script type="text/javascript">
        if (localStorage.getItem('motyw') == 'ciemny')
        {
            motywy();
            document.querySelector(".formularz75").classList.toggle("formularz75_dark");
        }
    </script>
    
</body>
</html>