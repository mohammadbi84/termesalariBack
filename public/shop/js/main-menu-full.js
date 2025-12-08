const menu = $(".main-menu");
menu.addClass("small");
const bookmarkFirst = $("#bookmark");
bookmarkFirst.removeClass("expanded");
bookmarkFirst.addClass("collapsed");
let cart_dropdown = document.querySelector(".cart-dropdown");
let favorites_dropdown = document.querySelector(".favorites-dropdown");
let compare_dropdown = document.querySelector(".compare-dropdown");
if (favorites_dropdown) {
    favorites_dropdown.style.top = "51px";
    favorites_dropdown.style.left = "-192px";
    cart_dropdown.style.left = "-113px";
    compare_dropdown.style.left = "-150px";
} else {
    compare_dropdown.style.left = "-177px";
    cart_dropdown.style.left = "-137px";
}
compare_dropdown.style.top = "51px";
cart_dropdown.style.top = "51px";
categoriesMenu.style.top = "65px";
categoriesMenu.style.left = "1rem";
categoriesMenu.style.right = "1rem";
