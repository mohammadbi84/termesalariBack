function initMainMenu() {
  let mainMenu = document.querySelector(".main-menu");

  const bookmarkToggle = document.getElementById("bookmarkToggle");
  const Bookmark = document.getElementById("bookmark");
  if (Bookmark && Bookmark.classList.contains("expanded")) {
    mainMenu.classList.add("with-bookmark");
  }

  if (mainMenu && !mainMenu.classList.contains("small")) {
    //region: make main-menu width same as search-bar width
    let screenWidth = document.body.clientWidth;

    //endregion: make main-menu width same as search-bar width

    const scrollOffset = Bookmark?.clientHeight ?? 64;

    function scrollFunction(e) {
      if (
        document.body.scrollTop > scrollOffset || // For Safari
        document.documentElement.scrollTop > scrollOffset // For Chrome, Firefox, IE and Opera
      ) {
        mainMenu.classList.add("small");
        if (Bookmark && Bookmark.classList.contains("expanded")) {
          mainMenu.classList.add("smallBookmark");
        }
        mainMenu.classList.remove("rounded-3");
      } else {
        mainMenu.classList.remove("small");
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
