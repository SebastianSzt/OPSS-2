// Zadanie 15 313061
function runAjax()
        {
            var imienazwisko = document.getElementById("imienazwisko").value;
            var email = document.getElementById("email").value;
            var wiadomosc = document.getElementById("wiadomosc").value;

            var formdata = 'imienazwisko=' + imienazwisko + '&email=' + email + '&wiadomosc=' + wiadomosc;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () 
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
                {
                    if(xmlhttp.responseText === '1')
                    {
                        document.getElementById("odp2").style.display = "none";
                        document.getElementById("odp1").style.display = "block";
                    }
                    else
                    {
                        document.getElementById("odp1").style.display = "none";
                        document.getElementById("odp2").style.display = "block";
                    }
                }
            };
                xmlhttp.open("POST", "email-sending-script.php", true);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xmlhttp.send(formdata);
        }