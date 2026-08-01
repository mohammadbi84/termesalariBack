const menu = $(".main-menu");
menu.addClass("small");
const bookmarkFirst = $("#bookmark");
bookmarkFirst.removeClass("expanded");
bookmarkFirst.addClass("collapsed");
const Bookmark2 = document.getElementById("bookmark");
Bookmark2.style.background = "var(--primary-color)";
Bookmark2.innerHTML = "";
let cart_dropdown = document.querySelector(".cart-dropdown");
let favorites_dropdown = document.querySelector(".favorites-dropdown");
let compare_dropdown = document.querySelector(".compare-dropdown");
let profile_dropdown = document.querySelector(".profile-dropdown");
if (favorites_dropdown) {
    favorites_dropdown.style.top = "65px";
    favorites_dropdown.style.right = "1rem";
}
if (profile_dropdown) {
    profile_dropdown.style.right = "1rem";
    profile_dropdown.style.top = "65px";
}
cart_dropdown.style.right = "1rem";
compare_dropdown.style.right = "1rem";
compare_dropdown.style.top = "65px";
cart_dropdown.style.top = "65px";
let categoriesMenu = document.querySelector("#categoryMenu");
categoriesMenu.style.top = "65px";
categoriesMenu.style.right = "1rem";
categoriesMenu.style.right = "1rem";
