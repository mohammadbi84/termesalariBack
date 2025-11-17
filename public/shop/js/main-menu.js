function initMainMenu() {
    let mainMenu = document.querySelector(".main-menu");

    const bookmarkToggle = document.getElementById("bookmarkToggle");
    const categoryMenu = document.getElementById("categoryMenu");
    const Bookmark = document.getElementById("bookmark");
    if (Bookmark && Bookmark.classList.contains("expanded")) {
        mainMenu.classList.add("with-bookmark");
    }

    if (mainMenu && !mainMenu.classList.contains("small")) {
        //region: make main-menu width same as search-bar width
        let screenWidth = document.body.clientWidth;
        let offerHeaderParentWidth = document.querySelector(".offer-header");
        if (offerHeaderParentWidth) {
            setCssVar(
                "--main-menu-margin",
                `${
                    (screenWidth -
                        offerHeaderParentWidth.parentElement.clientWidth) /
                        2 +
                    12
                }px`
            );
        } else {
            let containerParentWidth =
                document.querySelector("#navbar_container");

            setCssVar(
                "--main-menu-margin",
                `${(screenWidth - containerParentWidth.clientWidth) / 2}px`
            );
        }

        //endregion: make main-menu width same as search-bar width

        const scrollOffset = Bookmark?.clientHeight ?? 64;

        function scrollFunction(e) {
            if (
                document.body.scrollTop > scrollOffset || // For Safari
                document.documentElement.scrollTop > scrollOffset // For Chrome, Firefox, IE and Opera
            ) {
                mainMenu.classList.add("small");
                categoryMenu.classList.add("small");

                if (Bookmark && Bookmark.classList.contains("expanded")) {
                    mainMenu.classList.add("smallBookmark");
                }
                mainMenu.classList.remove("rounded-3");
            } else {
                mainMenu.classList.remove("small");
                categoryMenu.classList.remove("small");
                if (Bookmark && Bookmark.classList.contains("expanded")) {
                    mainMenu.classList.remove("smallBookmark");
                }
                mainMenu.classList.add("rounded-3");
            }
        }

        window.addEventListener("scroll", scrollFunction);
    }
    // تابع برای تغییر وضعیت بوکمارک
    function toggleBookmark() {
        if (Bookmark.classList.contains("expanded")) {
            // جمع کردن بوکمارک
            Bookmark.classList.remove("expanded");
            Bookmark.classList.add("collapsed");
            mainMenu.classList.remove("with-bookmark");
            mainMenu.classList.remove("smallBookmark");
        } else {
            // باز کردن بوکمارک
            Bookmark.classList.remove("collapsed");
            Bookmark.classList.add("expanded");
        }
    }

    // افزودن رویداد کلیک به دکمه بوکمارک
    bookmarkToggle.addEventListener("click", toggleBookmark);
}

window.addEventListener("DOMContentLoaded", () => {
    initMainMenu();
});
function setCssVar(name, value) {
    document.documentElement.style.setProperty(name, value);
}

document.addEventListener("DOMContentLoaded", function () {
    const categoryTrigger = document.getElementById("categoryTrigger");
    const categoryMenu = document.getElementById("categoryMenu");
    const mobileMenuToggle = document.getElementById("mobileMenuToggle");
    const mobileCategoryMenu = document.getElementById("mobileCategoryMenu");
    const closeMobileMenu = document.getElementById("closeMobileMenu");
    const overlay = document.getElementById("overlay");
    let menuTimeout;

    // باز کردن منو با هاور (دسکتاپ)
    categoryTrigger.addEventListener("mouseenter", function () {
        clearTimeout(menuTimeout);
        categoryMenu.classList.add("active");
    });

    // بستن منو وقتی هاور برداشته شد (دسکتاپ)
    categoryTrigger.addEventListener("mouseleave", function () {
        menuTimeout = setTimeout(function () {
            if (!categoryMenu.matches(":hover")) {
                categoryMenu.classList.remove("active");
            }
        }, 100);
    });

    // نگه داشتن منو وقتی هاور روی آن است (دسکتاپ)
    categoryMenu.addEventListener("mouseenter", function () {
        clearTimeout(menuTimeout);
    });

    // بستن منو وقتی هاور از روی آن برداشته شد (دسکتاپ)
    categoryMenu.addEventListener("mouseleave", function () {
        menuTimeout = setTimeout(function () {
            categoryMenu.classList.remove("active");
        }, 200);
    });

    // باز کردن منوی موبایل
    mobileMenuToggle.addEventListener("click", function () {
        mobileCategoryMenu.classList.add("active");
        overlay.classList.add("active");
        document.body.style.overflow = "hidden";
    });

    // بستن منوی موبایل
    function closeMobileCategoryMenu() {
        mobileCategoryMenu.classList.remove("active");
        overlay.classList.remove("active");
        document.body.style.overflow = "";
    }

    closeMobileMenu.addEventListener("click", closeMobileCategoryMenu);
    overlay.addEventListener("click", closeMobileCategoryMenu);

    // بستن منوی موبایل با کلید ESC
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            closeMobileCategoryMenu();
        }
    });
});
