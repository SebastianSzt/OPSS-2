function motywy()
{
    document.querySelector("html").classList.toggle("html_dark");
    document.querySelector("body").classList.toggle("body_dark");
    document.querySelector("mark").classList.toggle("mark_dark");
    document.querySelector("header").classList.toggle("header_dark");
    document.querySelector(".icon_home").classList.toggle("icon_home_dark");
    document.querySelector(".icon_menu").classList.toggle("icon_menu_dark");
    document.querySelector(".icon_account").classList.toggle("icon_account_dark");
    document.querySelector("nav").classList.toggle("nav_dark");
    const box_mI = document.querySelectorAll(".menuItem");
    for (const box of box_mI) 
    {
        box.classList.toggle("menuItem_dark");
    }
    document.querySelector(".mobile_menu").classList.toggle("mobile_menu_dark");
    const box_mI_m = document.querySelectorAll(".menuItem_mobile");
    for (const box of box_mI_m) 
    {
        box.classList.toggle("menuItem_mobile_dark");
    }
    document.querySelector(".aktywny").classList.toggle("aktywny_dark");
    document.querySelector("main").classList.toggle("main_dark");
}

function mobileMenu()
{
    var menu = document.querySelector(".mobile_menu");
    var icon = document.querySelector(".icon_menu");
    if (menu.style.display === "block") 
    {
        menu.style.display = "none";
        icon.textContent = 'menu';
    } 
    else 
    {
        menu.style.display = "block";
        icon.textContent = 'close';
    }
    document.querySelector(".icon_menu").classList.toggle("icon_menu_exit");
}