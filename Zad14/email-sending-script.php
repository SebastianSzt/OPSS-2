<?php
    //Zadanie 14 313061
    error_reporting(E_ALL|E_STRICT);
    ini_set('display_errors', 1);

    $adresat = '313061@stud.umk.pl';

    $temat = 'Wiadomość ze strony WWW';
    $temat = '=?UTF-8?B?' . base64_encode($temat) . '?=';

    $protokol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
    $strona = "$protokol://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $imienazwisko = trim($_POST['imienazwisko']);
    $email = trim($_POST['email']);
    $wiadomosc = $_POST['wiadomosc'];

    $data = date('d.m.Y');
    $czas = date('H:i:s');

    $tresc = 'Wiadomość ze strony: ' . $strona . '<br>';
    $tresc .= 'Imię i nazwisko: ' . $imienazwisko . '<br>';
    $tresc .= 'Adres email: ' . $email . '<br>';
    $tresc .= 'Treść wiadomości: <br>';
    $tresc .= $wiadomosc . '<br>';
    $tresc .= 'Wiadomość wysłana dnia ' . $data . ' o godz. ' . $czas . '.';

    $naglowki  = 'Content-type: text/html; charset=UTF-8' . PHP_EOL;
    $naglowki .= 'From: =?UTF-8?B?' . base64_encode($imienazwisko) . "?= <$email>" . PHP_EOL;
    $naglowki .= 'Reply-To: '. "<$email>" . PHP_EOL;
    $naglowki .= 'Return-Path: ' . "<$email>" . PHP_EOL;
    $naglowki .= 'X-Mailer: PHP/' . phpversion() . PHP_EOL;
    $naglowki .= 'X-Priority: 1 (Highest)' . PHP_EOL;

    if (mail($adresat, $temat, $tresc, $naglowki)) {
        echo 'Twoja wiadomość została wysłana!';
    } else {
        echo 'Wystąpił błąd podczas wysyłania!';
    }
?>