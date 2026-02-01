const menu = $(".main-menu");
menu.addClass("small");
const bookmarkFirst = $("#bookmark");
bookmarkFirst.removeClass("expanded");
bookmarkFirst.addClass("collapsed");
let cart_dropdown = document.querySelector(".cart-dropdown");
let favorites_dropdown = document.querySelector(".favorites-dropdown");
let compare_dropdown = document.querySelector(".compare-dropdown");
if (favorites_dropdown) {
    favorites_dropdown.style.top = "65px";
    favorites_dropdown.style.left = "1rem";
}
cart_dropdown.style.left = "1rem";
compare_dropdown.style.left = "1rem";
compare_dropdown.style.top = "65px";
cart_dropdown.style.top = "65px";
let categoriesMenu = document.querySelector("#categoryMenu");
categoriesMenu.style.top = "65px";
categoriesMenu.style.left = "1rem";
categoriesMenu.style.right = "1rem";
