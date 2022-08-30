<?php
    $temat = $_POST['temat'];
    $email = trim($_POST['email']);
    $wiadomosc = $_POST['wiadomosc'];

    $adresat = '313061@stud.umk.pl';
    $tytul = '=?UTF-8?B?' . base64_encode($temat) . '?=';

    $protokol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
    $strona = "$protokol://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    date_default_timezone_set("Europe/Warsaw");
    $data = date("d.m.Y", time());
    $czas = date("H:i:s", time());

    $tresc = 'Wiadomość ze strony: ' . $strona . '<br><br>';
    $tresc .= 'Temat: ' . $temat . '<br>';
    $tresc .= 'Adres email: ' . $email . '<br><br>';
    $tresc .= 'Treść wiadomości: <br>';
    $tresc .= $wiadomosc . '<br><br>';
    $tresc .= 'Wiadomość wysłana dnia ' . $data . ' o godz. ' . $czas . '.';

    $naglowki  = 'Content-type: text/html; charset=UTF-8' . PHP_EOL;
    $naglowki .= 'From: =?UTF-8?B?' . base64_encode($imienazwisko) . "?= <$email>" . PHP_EOL;
    $naglowki .= 'Reply-To: '. "<$email>" . PHP_EOL;
    $naglowki .= 'Return-Path: ' . "<$email>" . PHP_EOL;
    $naglowki .= 'X-Mailer: PHP/' . phpversion() . PHP_EOL;
    $naglowki .= 'X-Priority: 1 (Highest)' . PHP_EOL;

    if (mail($adresat, $tytul, $tresc, $naglowki)) 
    {
        echo '1';
    } 
    else 
    {
        echo '2';
    }
?>