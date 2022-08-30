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

            function ajax()
            {
                var temat = document.getElementById("temat").value;
                var email = document.getElementById("email").value;
                var wiadomosc = document.getElementById("wiadomosc").value;

                var komunikat = document.createElement('div'); 
                var parent = document.getElementById('komunikaty_js');

                if (/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test(email)) 
                {}
                else
                {
                    liczba_kom = liczba_kom + 1;
                    komunikat.className = 'komunikat_red';
                    komunikat.innerHTML = liczba_kom + ". Pole email może składać się z dużych i małych liter, liczb oraz musi miec jedną litere/cyfre po @ i od 2 do 4 liter po kropce!";
                    parent.appendChild(komunikat);
                    return;
                }

                var formdata = 'temat=' + temat + '&email=' + email + '&wiadomosc=' + wiadomosc;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () 
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
                    {
                        if(xmlhttp.responseText === '1')
                        {
                            liczba_kom = liczba_kom + 1;
                            komunikat.className = 'komunikat_green';
                            komunikat.innerHTML = liczba_kom + ". Twoja wiadomość została wysłana";
                            parent.appendChild(komunikat);
                        }
                        else
                        {
                            liczba_kom = liczba_kom + 1;
                            komunikat.className = 'komunikat_red';
                            komunikat.innerHTML = liczba_kom + ". Wystąpił błąd podczas wysyłania wiadomości";
                            parent.appendChild(komunikat);
                        }
                    }
                };
                xmlhttp.open("POST", "email_skrypt.php", true);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xmlhttp.send(formdata);
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
            Strona kontaktowa
            <a href="login.php">
                <span class="icon_account">account_circle</span>
            </a>
        </header>

        <nav>
            <ul>
                <li><a href="konto.php" class="menuItem">Konto</a></li>
                <li><a href="dysk.php" class="menuItem">Mój dysk</a></li>
                <li><a href="udostepnione.php" class="menuItem">Udostępnione</a></li>
                <li><a href="komentarze.php" class="menuItem">Komentarze</a></li>
                <li><a href="kontakt.php" class="menuItem aktywny">Kontakt</a></li>
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
                <b>Formularz kontaktowy:</b><br /><br />
                Wypełnij pola formularza żeby wysłać wiadomość do pomocy technicznej.<br /><br />
                <form>
                    <label>Temat wiadomości: <input type="text" id="temat"></label><br />
                    <label>Adres email (zwrotny): <input type="text" id="email"></label><br /><br />
                    <label>Treść wiadomości: <br /><textarea id="wiadomosc"></textarea></label> <br />
                    <input type="button" value="Wyślij" class="przycisk" onclick="ajax()">
                    <input type="reset" value="Wyczyść" class="przycisk">
                </form>
            </div>
            <div id="komunikaty_js"></div>
        </main>
    </div>

    <script>
        if (localStorage.getItem('motyw') == 'ciemny')
        {
            motywy();
            document.querySelector(".formularz75").classList.toggle("formularz75_dark");
        }
    </script>

</body>
</html>