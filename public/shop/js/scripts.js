document.addEventListener("DOMContentLoaded", function () {
    slider = document.getElementById("#events-slider");
    if (slider) {
        var splide = new Splide("#events-slider", {
            padding: "15px",
            direction: "rtl",
            perPage: 4,
            gap: "1.2rem",
            drag: "free",
            snap: true,
            arrows: false, // غیرفعال کردن arrows پیشفرض
            pagination: false, // غیرفعال کردن pagination پیشفرض
            breakpoints: {
                1200: {
                    perPage: 4,
                },
                900: {
                    perPage: 3,
                },
                600: {
                    perPage: 1,
                    focus: "start",
                    padding: { left: "150px" },
                },
            },
        });

        // mount اسلایدر
        splide.mount();
        // گرفتن دکمه‌های سفارشی
        const prevBtn = document.querySelector(".splide-offer-prev-btn");
        const nextBtn = document.querySelector(".splide-offer-next-btn");

        // اضافه کردن event listener برای دکمه‌ها
        if (prevBtn) {
            prevBtn.addEventListener("click", function () {
                splide.go("<");
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener("click", function () {
                splide.go(">");
            });
        }
        // بعد از mount شدن
        updateRangeDisplay(splide, "events-range");

        // به‌روزرسانی وضعیت دکمه‌ها هنگام تغییر اسلاید
        splide.on("moved", function () {
            updateButtonStates();
            updateRangeDisplay(splide, "events-range");
        });

        // تابع برای به‌روزرسانی وضعیت دکمه‌ها
        function updateButtonStates() {
            const index = splide.index;
            const length = splide.length;

            if (prevBtn) {
                prevBtn.disabled = index === 0;
            }

            if (nextBtn) {
                nextBtn.disabled = index >= length - splide.options.perPage;
            }
        }

        // مقداردهی اولیه وضعیت دکمه‌ها
        updateButtonStates();
    }


    // Hot===========================================================================================
    var HotSplide = new Splide("#hot_slider", {
        perPage: 4,
        padding: "20px",
        gap: "1.7rem",
        arrows: false,
        pagination: false,
        direction: "rtl",
        breakpoints: {
            1024: { perPage: 4 },
            768: { perPage: 2, focus: "start", padding: { left: "50px" } },
            480: { perPage: 1, focus: "start", padding: { left: "150px" } },
        },
    });
    HotSplide.mount();

    const prevBtnHot = document.querySelector(".splide-hot-prev-btn");
    const nextBtnHot = document.querySelector(".splide-hot-next-btn");

    // اضافه کردن event listener برای دکمه‌ها
    if (prevBtnHot) {
        prevBtnHot.addEventListener("click", function () {
            HotSplide.go("<");
        });
    }

    if (nextBtnHot) {
        nextBtnHot.addEventListener("click", function () {
            HotSplide.go(">");
        });
    }

    // به‌روزرسانی وضعیت دکمه‌ها هنگام تغییر اسلاید
    HotSplide.on("moved", function () {
        updateButtonStatesHot();
        updateRangeDisplay(HotSplide, "hot-range");
    });

    // تابع برای به‌روزرسانی وضعیت دکمه‌ها
    function updateButtonStatesHot() {
        const index = HotSplide.index;
        const length = HotSplide.length;

        if (prevBtnHot) {
            prevBtnHot.disabled = index === 0;
        }

        if (nextBtnHot) {
            nextBtnHot.disabled = index >= length - HotSplide.options.perPage;
        }
    }

    // مقداردهی اولیه وضعیت دکمه‌ها
    updateButtonStatesHot();
    updateRangeDisplay(HotSplide, "hot-range");

    // تابع برای به‌روزرسانی نمایش بازه
    function updateRangeDisplay(splide, rangeElementId) {
        const index = splide.index; // شماره اولین آیتم قابل مشاهده (صفر شروع)
        const perPage = splide.options.perPage;
        const total = splide.length;

        const start = index + 1; // چون index از 0 شروع میشه
        const end = Math.min(index + perPage, total);

        document.getElementById(rangeElementId).textContent = `${start}-${end}`;
    }


    // Article===========================================================================================
    var ArticleSplide = new Splide("#article_slider", {
        perPage: 4,
        padding: "20px",
        gap: "1.7rem",
        arrows: false,
        pagination: false,
        direction: "rtl",
        breakpoints: {
            1024: { perPage: 4 },
            768: { perPage: 2, focus: "start", padding: { left: "50px" } },
            480: { perPage: 1, focus: "start", padding: { left: "150px" } },
        },
    });
    ArticleSplide.mount();

    const prevBtnArticle = document.querySelector(".splide-article-prev-btn");
    const nextBtnArticle = document.querySelector(".splide-article-next-btn");

    // اضافه کردن event listener برای دکمه‌ها
    if (prevBtnArticle) {
        prevBtnArticle.addEventListener("click", function () {
            ArticleSplide.go("<");
        });
    }

    if (nextBtnArticle) {
        nextBtnArticle.addEventListener("click", function () {
            ArticleSplide.go(">");
        });
    }

    // به‌روزرسانی وضعیت دکمه‌ها هنگام تغییر اسلاید
    ArticleSplide.on("moved", function () {
        updateButtonStatesArticle();
        updateRangeDisplay(ArticleSplide, "article-range");
    });

    // تابع برای به‌روزرسانی وضعیت دکمه‌ها
    function updateButtonStatesArticle() {
        const index = ArticleSplide.index;
        const length = ArticleSplide.length;

        if (prevBtnArticle) {
            prevBtnArticle.disabled = index === 0;
        }

        if (nextBtnArticle) {
            nextBtnArticle.disabled = index >= length - ArticleSplide.options.perPage;
        }
    }

    // مقداردهی اولیه وضعیت دکمه‌ها
    updateButtonStatesArticle();
    updateRangeDisplay(ArticleSplide, "article-range");

    // تابع برای به‌روزرسانی نمایش بازه
    function updateRangeDisplay(splide, rangeElementId) {
        const index = splide.index; // شماره اولین آیتم قابل مشاهده (صفر شروع)
        const perPage = splide.options.perPage;
        const total = splide.length;

        const start = index + 1; // چون index از 0 شروع میشه
        const end = Math.min(index + perPage, total);

        document.getElementById(rangeElementId).textContent = `${start}-${end}`;
    }
});

$(document).ready(function () {
    // branch slider ==============================================================================================
    const rightSlider = new Swiper(".right-slider", {
        direction: "vertical",
        slidesPerView: "auto", // تغییر به auto برای اسکرول طبیعی
        spaceBetween: 15,
        watchSlidesProgress: true,
        slideToClickedSlide: true,
        freeMode: true, // فعال کردن حالت آزاد
        mousewheel: true, // امکان اسکرول با ماوس
        pagination: false, // غیرفعال کردن پیجینیشن
        navigation: false, // غیرفعال کردن ناوبری
        allowTouchMove: false, // غیرفعال کردن درگ
        simulateTouch: false, // غیرفعال کردن شبیه‌سازی تاچ
        breakpoints: {
            1200: {
                slidesPerView: "auto",
                spaceBetween: 15,
                allowTouchMove: false,
            },
            992: {
                slidesPerView: "auto",
                spaceBetween: 12,
                allowTouchMove: false,
            },
            768: {
                slidesPerView: "auto",
                spaceBetween: 10,
                allowTouchMove: false,
            },
            0: {
                slidesPerView: "auto",
                spaceBetween: 8,
                allowTouchMove: false,
            },
        },
    });

    // اسلایدر اصلی (بدون Drag یا Navigation)
    const leftSlider = new Swiper(".left-slider", {
        effect: "fade",
        fadeEffect: { crossFade: true },
        allowTouchMove: false,
        navigation: {
            nextEl: ".left-slider .swiper-button-next",
            prevEl: ".left-slider .swiper-button-prev",
        },
        pagination: {
            el: ".left-slider .swiper-pagination",
            clickable: true,
        },
        thumbs: {
            swiper: rightSlider,
        },
        breakpoints: {
            // در موبایل کنترل‌ها فعال شوند
            576: {
                allowTouchMove: true,
                navigation: {
                    nextEl: ".left-slider .swiper-button-next",
                    prevEl: ".left-slider .swiper-button-prev",
                },
            },
        },
    });

    // ✅ جلوگیری از انتشار کلیک‌های داخلی
    // مدیریت ریسپانسیو برای نمایش کنترل‌ها
    function handleResize() {
        const isMobile = window.innerWidth <= 576;

        if (isMobile) {
            // در موبایل: فعال کردن کنترل‌های اسلایدر اصلی
            leftSlider.params.allowTouchMove = true;
            leftSlider.update();

            // مخفی کردن اسلایدر سمت راست در موبایل (اگر نیاز باشد)
            document.querySelector(".right-slider").style.display = "none";
        } else {
            // در دسکتاپ: غیرفعال کردن کنترل‌های اسلایدر اصلی
            leftSlider.params.allowTouchMove = false;
            leftSlider.update();

            // نمایش اسلایدر سمت راست در دسکتاپ
            document.querySelector(".right-slider").style.display = "block";
        }
    }

    // افزودن event listener برای تغییر سایز
    window.addEventListener("resize", handleResize);
    handleResize(); // فراخوانی اولیه

    // ✅ کلیک روی اسلایدهای کوچک (تغییر فقط اسلایدر اصلی)
    document
        .querySelectorAll(".right-slider .swiper-slide")
        .forEach((slide, index) => {
            slide.addEventListener("click", () => {
                leftSlider.slideTo(index);
                // اضافه کردن کلاس active به اسلاید انتخاب شده
                document
                    .querySelectorAll(".right-slider .swiper-slide")
                    .forEach((s) => {
                        s.classList.remove("swiper-slide-thumb-active");
                    });
                slide.classList.add("swiper-slide-thumb-active");
            });
        });

    // ✅ اسلایدرهای داخلی (بدون تغییر)
    const innerSliders = [];
    document
        .querySelectorAll(".inner-image-slider")
        .forEach((sliderElement) => {
            const innerSwiper = new Swiper(sliderElement, {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: sliderElement.querySelector(".swiper-pagination"),
                    clickable: true,
                },
                navigation: {
                    nextEl: sliderElement.querySelector(".swiper-button-next"),
                    prevEl: sliderElement.querySelector(".swiper-button-prev"),
                },
            });
            innerSliders.push(innerSwiper);
        });

    // go to top button ===================================================================================
    // JavaScript
    const backToTopButton = document.getElementById("backToTop");

    // نمایش/مخفی کردن دکمه هنگام اسکرول
    if (backToTopButton) {
        window.addEventListener("scroll", function () {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add("show");
            } else {
                backToTopButton.classList.remove("show");
            }
        });

        // عملکرد کلیک دکمه
        backToTopButton.addEventListener("click", function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    }

    // map===========================================================================================
    let map;
    let currentMarker;

    // وقتی مدال باز می‌شود
    const mapModal = document.getElementById("mapModal");
    mapModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const locationName = button.getAttribute("data-location");
        const lat = parseFloat(button.getAttribute("data-lat"));
        const lng = parseFloat(button.getAttribute("data-lng"));

        // آپدیت عنوان مدال
        document.getElementById("mapModalLabel").textContent =
            `${locationName}`;

        // مقداردهی نقشه
        initializeMap(lat, lng, locationName);
    });

    // بعد از باز شدن کامل مدال (خیلی مهم)
    mapModal.addEventListener("shown.bs.modal", function () {
        if (map) {
            map.invalidateSize(); // 👈 ریفرش نقشه برای رفع مشکل رندر داخل مدال
            map.setView(currentMarker.getLatLng(), 15); // 👈 بازگرداندن مرکز دقیق روی marker
        }
    });

    // وقتی مدال بسته می‌شود
    mapModal.addEventListener("hidden.bs.modal", function () {
        if (map) {
            map.remove();
            map = null;
            currentMarker = null;
        }
    });

    // تابع مقداردهی نقشه
    function initializeMap(lat, lng, locationName) {
        map = L.map("map").setView([lat, lng], 15);

        // لایه پایه
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "© OpenStreetMap contributors",
            maxZoom: 18,
        }).addTo(map);

        // آیکون سفارشی
        const customIcon = L.icon({
            iconUrl: "/shop/assets/svgs/location-dot-solid-full.svg",
            iconSize: [40, 40],
            iconAnchor: [20, 40],
            popupAnchor: [0, -40],
        });

        // اضافه کردن marker
        currentMarker = L.marker([lat, lng], { icon: customIcon }).addTo(map);
    }

    // hover animation =======================================================================================================================
    const cards = document.querySelectorAll(".product-card");

    cards.forEach((card) => {
        card.addEventListener("mouseenter", () => {
            card.classList.add("hovered");
        });

        card.addEventListener("mouseleave", () => {
            card.classList.remove("hovered");
        });
    });
});

// نمایش خودکار پاپ‌آپ بعد از لود صفحه
