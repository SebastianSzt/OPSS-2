function walidacja()
{
    const poleImie = document.getElementById('imie');
    const wartoscImie = poleImie.value;
    if (/^[a-z]{2,}$/i.test(wartoscImie)) 
    {}
    else
    {
        alert('Pole imię może składać się tylko z liter i musi mieć przynajmniej dwa znaki!');
        return;
    }

    const poleNazwisko = document.getElementById('nazwisko');
    const wartoscNazwisko = poleNazwisko.value;
    if (/^[a-z\-\s]{2,}$/i.test(wartoscNazwisko)) 
    {}
    else
    {
        alert('Pole nazwisko może składać się tylko z liter, myślnika i spacji oraz musi mieć przynajmniej dwa znaki!');
        return;
    }

    const poleHaslo = document.getElementById('haslo');
    const wartoscHaslo = poleHaslo.value;
    if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\!\@\#\$\%\^\&\*\(\)\{\}\[\]\\\|\:\"\;\'\<\>\?\,\.\/])[a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\{\}\[\]\\\|\:\"\;\'\<\>\?\,\.\/]{8,}$/.test(wartoscHaslo)) 
    {
        alert('Walidacja poprawna!');
    }
    else
    {
        alert('Pole hasło musi zawierać co najmniej 8 znaków w tym: małą i dużą literę, cyfrę oraz znak specjalny!');
    }
}