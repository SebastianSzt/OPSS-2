// Zadanie 13 313061
const imageArray = ['http://fizyka.umk.pl/~313061/Hexahedron.png', 'http://fizyka.umk.pl/~313061/Dodecahedron.png', 'http://fizyka.umk.pl/~313061/Icosahedron.png', 'http://fizyka.umk.pl/~313061/Octahedron.png'];
const imageWidth = 200;
const imageHeight = 200;
let intervalID = null;

document.addEventListener('mouseup', (event) => 
{
    switch (event.button) 
    {
        case 0:
            appendImageAtMouseClickPosition(event);
            break;
        case 1:
            if (intervalID === null) 
            {
                intervalID = setInterval(automaticImageAppend, 250);
            } 
            else 
            {
                clearInterval(intervalID);
                intervalID = null;
            }
            break;
        case 2:
            const imageContainer = document.getElementById('image-container');
            while(imageContainer.firstChild !== null)
            {
                deleteImage(imageContainer);
            }
            break;
        default:
            alert(`Nie rozpoznano przycisku myszy: ${event.button}`);
    }
});

function appendImageAtMouseClickPosition(event) 
{
    appendImage(event.clientX, event.clientY);
}

function appendImage(x, y)
{
    const imageElement = document.createElement('img');
    const imageContainer = document.getElementById('image-container');
    imageContainer.appendChild(imageElement);
    const imageIndex = Math.floor(Math.random() * imageArray.length);
    imageElement.src = imageArray[imageIndex];
    const pozycjaX = x - imageWidth / 2;
    const pozycjaY = y - imageHeight / 2;
    imageElement.style.position = 'absolute';
    imageElement.style.left = pozycjaX + 'px';
    imageElement.style.top = pozycjaY + 'px';
}

function automaticImageAppend() 
{
    const screenWidth = window.innerWidth - imageWidth;
    const screenHeight = window.innerHeight - imageHeight;
    const positionX = imageWidth / 2 + Math.floor(Math.random() * screenWidth);
    const positionY = imageHeight / 2 + Math.floor(Math.random() * screenHeight);
    appendImage(positionX, positionY);
}

function deleteImage(imageContainer)
{
    imageContainer.removeChild(imageContainer.firstChild);
}

document.addEventListener('contextmenu', (event) => 
{
    event.preventDefault();
});