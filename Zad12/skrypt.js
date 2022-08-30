document.addEventListener('click', przesunObrazek);
document.addEventListener('dblclick', zmienObrazek);

const obrazek = document.getElementById('obrazek');

function przesunObrazek(event)
{
    const szerokosc = obrazek.width;
    const wysokosc = obrazek.height;
    const pozycjaX = event.clientX - szerokosc / 2;
    const pozycjaY = event.clientY - wysokosc / 2;
    obrazek.style.left = pozycjaX + 'px';
    obrazek.style.top = pozycjaY + 'px';
}

function zmienObrazek()
{
    if (obrazek.src.indexOf('https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Hexahedron.svg/800px-Hexahedron.svg.png') >= 0)
    {
        obrazek.src = 'https://upload.wikimedia.org/wikipedia/commons/c/c0/Truncatedhexahedron.jpg';
    } 
    else 
    {
        obrazek.src = 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Hexahedron.svg/800px-Hexahedron.svg.png';
    }
}