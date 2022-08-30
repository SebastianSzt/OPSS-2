<?php
session_start();
if (!isset($_SESSION['username']))
{
    header('Location: login.php');
}
if (isset($_GET['logout'])) 
{
    unset($_SESSION['username']);
    session_destroy();
    header('Location: login.php');
    exit;
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
        <script>
            var liczba_kom = 0;

            function dane()
            {
                if (localStorage.getItem('motyw') == 'ciemny')
                {
                    var dane = document.getElementById("dane_dark");
                }
                else
                {
                    var dane = document.getElementById("dane");
                }

                if (dane.style.display === "block")
                {
                    dane.style.display = "none";
                } 
                else 
                {
                    dane.style.display = "block";
                }
            }

            function zapis()
            {
                var komunikat = document.createElement('div');
                komunikat.style.width = '100%';
                var parent = document.getElementById('komunikaty_js');

                const motyw = document.getElementById('motyw').value;
                const dysk = document.getElementById('dysk').value;

                if (motyw != 0 && dysk != 0)
                {
                    if (localStorage.getItem('motyw') == 'ciemny')
                    {
                        var dane = document.getElementById("dane_dark");
                    }
                    else
                    {
                        var dane = document.getElementById("dane");
                    }

                    const login = document.getElementById('login_konta');
                    const wartoscLogin = login.innerHTML;

                    if (dane.style.display == "none" || dane.style.display == 0)
                    {
                        if (motyw == "Jasny")
                        {
                            if (localStorage.getItem('motyw') == 'ciemny')
                            {
                                motywy();
                                document.querySelector(".formularz100").classList.toggle("formularz100_dark");
                                document.querySelector(".rozwin_dane").classList.toggle("rozwin_dane_dark");
                                document.querySelector("#dane_dark").setAttribute("id", "dane");
                                document.querySelector(".wyloguj").classList.toggle("wyloguj_dark");
                                document.querySelector(".icon_logout").classList.toggle("icon_logout_dark");
                            }
                            localStorage.removeItem('motyw');
                            localStorage.setItem('motyw', 'jasny');
                        }
                        else
                        {
                            if (localStorage.getItem('motyw') == 'jasny' || localStorage.getItem('motyw') === null)
                            {
                                localStorage.removeItem('motyw');
                                localStorage.setItem('motyw', 'ciemny');
                                motywy();
                                document.querySelector(".formularz100").classList.toggle("formularz100_dark");
                                document.querySelector(".rozwin_dane").classList.toggle("rozwin_dane_dark");
                                document.querySelector("#dane").setAttribute("id", "dane_dark");
                                document.querySelector(".wyloguj").classList.toggle("wyloguj_dark");
                                document.querySelector(".icon_logout").classList.toggle("icon_logout_dark");
                            }
                        }

                        var formdata = 'login=' + wartoscLogin + '&dysk=' + dysk + '&edycja=2';
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function () 
                        {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
                            {
                                if(xmlhttp.responseText === '1')
                                {
                                    liczba_kom = liczba_kom + 1;
                                    komunikat.className = 'komunikat_green';
                                    komunikat.innerHTML = liczba_kom + ". Zmiany zostały pomyślnie zapisane.";
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
                        const imie = document.getElementById('imie');
                        const wartoscImie = imie.value;
                        const nazwisko = document.getElementById('nazwisko');
                        const wartoscNazwisko = nazwisko.value;
                        const email = document.getElementById('email');
                        const wartoscEmail = email.value;
                        const haslo = document.getElementById('haslo');
                        const wartoscHaslo = haslo.value;
                        
                        if (wartoscImie != 0 && wartoscNazwisko != 0 && wartoscEmail != 0 && wartoscHaslo != 0)
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

                            var formdata = 'imie=' + wartoscImie + '&nazwisko=' + wartoscNazwisko + '&email=' + wartoscEmail + '&login=' + wartoscLogin + '&haslo=' + wartoscHaslo + '&dysk=' + dysk + '&edycja=1';
                            var xmlhttp = new XMLHttpRequest();
                            xmlhttp.onreadystatechange = function () 
                            {
                                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
                                {
                                    if(xmlhttp.responseText === '1')
                                    {
                                        if (motyw == "Jasny")
                                        {
                                            if (localStorage.getItem('motyw') == 'ciemny')
                                            {
                                                motywy();
                                                document.querySelector(".formularz100").classList.toggle("formularz100_dark");
                                                document.querySelector(".rozwin_dane").classList.toggle("rozwin_dane_dark");
                                                document.querySelector("#dane_dark").setAttribute("id", "dane");
                                                document.querySelector(".wyloguj").classList.toggle("wyloguj_dark");
                                                document.querySelector(".icon_logout").classList.toggle("icon_logout_dark");
                                            }
                                            localStorage.removeItem('motyw');
                                            localStorage.setItem('motyw', 'jasny');
                                        }
                                        else
                                        {
                                            if (localStorage.getItem('motyw') == 'jasny' || localStorage.getItem('motyw') === null)
                                            {
                                                localStorage.removeItem('motyw');
                                                localStorage.setItem('motyw', 'ciemny');
                                                motywy();
                                                document.querySelector(".formularz100").classList.toggle("formularz100_dark");
                                                document.querySelector(".rozwin_dane").classList.toggle("rozwin_dane_dark");
                                                document.querySelector("#dane").setAttribute("id", "dane_dark");
                                                document.querySelector(".wyloguj").classList.toggle("wyloguj_dark");
                                                document.querySelector(".icon_logout").classList.toggle("icon_logout_dark");
                                            }
                                        }
                                        
                                        liczba_kom = liczba_kom + 1;
                                        komunikat.className = 'komunikat_green';
                                        komunikat.innerHTML = liczba_kom + ". Zmiany zostały pomyślnie zapisane.";
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
                            komunikat.innerHTML = liczba_kom + ". Nie wypełniono wszystkich pól, zmiany odrzucone.";
                            parent.appendChild(komunikat);
                        }
                    }
                }
                else
                {
                    if (motyw == 0)
                    {
                        liczba_kom = liczba_kom + 1;
                        komunikat.className = 'komunikat_red';
                        komunikat.innerHTML = liczba_kom + ". Nie wybrano motywu, zmiany odrzucone.";
                        parent.appendChild(komunikat);
                        return;
                    }
                    
                    if (dysk == 0)
                    {
                        liczba_kom = liczba_kom + 1;
                        komunikat.className = 'komunikat_red';
                        komunikat.innerHTML = liczba_kom + ". Nie wybrano typu dysku, zmiany odrzucone.";
                        parent.appendChild(komunikat);
                        return;
                    }
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
            <?php
                $login = $_SESSION['username'];
                echo '<span class="nazwa_konta">Konto użytkownika: <span id="login_konta">' . $login . '</span></span>';
            ?>
            <a href="login.php">
                <span class="icon_account">account_circle</span>
            </a>
            <a href="?logout">
                <span class="icon_logout">logout</span>
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
            <a href="?logout" class="wyloguj">Wyloguj</a>
            <div class="formularz100">
                <b>Ustawienia konta:</b><br /><br />
                <form>
                    <label>Motyw: 
                        <select id="motyw">
                            <option></option>
                            <option>Jasny</option>
                            <option>Ciemny</option>
                        </select>
                    </label><br />
                    <label>Typ dysku: 
                        <select id="dysk">
                            <option></option>
                            <option>Prywatny</option>
                            <option>Publiczny</option>
                        </select>
                    </label><br />
                </form>
                <div class="rozwin_dane" onclick="dane()">-->  Kliknij żeby edytować dane  <--</div>
                <div id="dane">
                    <form>
                        <label>Imie: <input type="text" id="imie"></label><br />
                        <label>Nazwisko: <input type="text" id="nazwisko"></label><br />
                        <label>Email: <input type="text" id="email"></label><br />
                        <label>Login: <input type="text" id="login" value="Nie można zmienić." disabled></label><br />
                        <label>Hasło: <input type="password" id="haslo"></label><br />
                    </form>
                </div>
                <input type="button" value="Zapisz" class="przycisk" onclick="zapis()">
            </div>
            <div id="komunikaty_js"></div>
        </main>
    </div>

    <script>
        if (localStorage.getItem('motyw') == 'ciemny')
        {
            motywy();
            document.querySelector(".formularz100").classList.toggle("formularz100_dark");
            document.querySelector(".rozwin_dane").classList.toggle("rozwin_dane_dark");
            document.querySelector("#dane").setAttribute("id", "dane_dark");
            document.querySelector(".wyloguj").classList.toggle("wyloguj_dark");
            document.querySelector(".icon_logout").classList.toggle("icon_logout_dark");
        }
    </script>

</body>
</html>