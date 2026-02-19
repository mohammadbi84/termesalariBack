const swiper7 = new Swiper(".mySwiper", {
    loop: true,
    spaceBetween: 40,
    centeredSlides: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    //navigation: {
    //    nextEl: ".swiper-button-next",
    //    prevEl: ".swiper-button-prev",
    //}
});

// counter
const counters = document.querySelectorAll(".mission-number");

function animateCounter(counter) {
    let target = +counter.getAttribute("data-target");
    let current = 0;
    // let increment = Math.ceil(target / 100);
    let increment = 1;

    let interval = setInterval(() => {
        current += increment;
        if (current >= target) {
            counter.textContent = target;
            clearInterval(interval);
        } else {
            counter.textContent = current;
        }
    }, 20);
}

const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && !entry.target.started) {
                animateCounter(entry.target);
                entry.target.started = true; // مخصوص همان شمارنده
            }
        });
    },
    {
        threshold: 0.9,
    },
);

counters.forEach((counter) => observer.observe(counter));

// Hot===========================================================================================

var HotSplide = new Splide("#hot_slider", {
    type: "loop",
    perPage: 4,
    perMove: 1,
    padding: "20px",
    gap: "1.7rem",
    arrows: false,
    pagination: false,
    direction: "rtl",
    autoplay: false, // autoplay معمولی را غیرفعال می‌کنیم
    drag: false,
    focus: 0, // اولین اسلاید را فعال می‌کند
    trimSpace: false,
    breakpoints: {
        1024: { perPage: 4 },
        768: { perPage: 2 },
        480: { perPage: 1 },
    },
});

HotSplide.mount();

// شمارنده برای پیگیری اسلاید فعال کنونی
let currentActiveIndex = 0;
let perPage = 4; // تعداد اسلایدهای قابل مشاهده

// تابع برای تغییر اسلاید فعال
function changeActiveSlide() {
    const slides = document.querySelectorAll(
        "#hot_slider .splide__slide.is-visible",
    );

    // حذف کلاس active از همه اسلایدها
    slides.forEach((slide) => {
        slide.classList.remove("is-active");
    });

    // console.log(slides[currentActiveIndex]);
    // اضافه کردن کلاس active به اسلاید کنونی
    if (slides[currentActiveIndex]) {
        slides[currentActiveIndex].classList.add("is-active");
    }

    // افزایش شمارنده برای اسلاید بعدی
    currentActiveIndex++;

    // اگر به آخرین اسلاید در صفحه رسیدیم
    if (currentActiveIndex > perPage) {
        // حرکت اسلایدر به بعدی
        HotSplide.go("+4");
        // بازنشانی شمارنده
        currentActiveIndex = 0;

        // بعد از حرکت اسلایدر، اسلاید اول را فعال کن
        setTimeout(() => {
            const newSlides = document.querySelectorAll(
                "#hot_slider .splide__slide",
            );
            if (newSlides[0]) {
                newSlides[0].classList.add("is-active");
            }
        }, 500); // تاخیر برای حرکت اسلایدر
    }
}

// شروع تایمر برای تغییر اسلاید فعال
let slideInterval = setInterval(changeActiveSlide, 2000); // هر 2 ثانیه

// توقف هنگام هاور
document.querySelector("#hot_slider").addEventListener("mouseenter", () => {
    clearInterval(slideInterval);
});

// ادامه هنگام خروج
document.querySelector("#hot_slider").addEventListener("mouseleave", () => {
    slideInterval = setInterval(changeActiveSlide, 2000);
});

// به‌روزرسانی perPage هنگام تغییر سایز پنجره
window.addEventListener("resize", () => {
    const options = HotSplide.options;
    const breakpoints = options.breakpoints;
    const width = window.innerWidth;

    if (width < 480) {
        perPage = options.perPage || 1;
    } else if (width < 768) {
        perPage = breakpoints[480]?.perPage || 2;
    } else if (width < 1024) {
        perPage = breakpoints[768]?.perPage || 2;
    } else {
        perPage = breakpoints[1024]?.perPage || 4;
    }
});

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
document.querySelectorAll("#hot_slider .splide__slide img").forEach((img) => {
    img.style.cursor = "pointer";

    img.addEventListener("click", function () {
        const modalImg = document.getElementById("modalImage");
        modalImg.src = this.src;
        var modal = new bootstrap.Modal(document.getElementById("imgModal"));
        modal.show();
    });
});

var swiper2 = new Swiper(".branches-slider", {
    slidesPerView: 3,
    spaceBetween: 20,
    loop: true,
});

// map ============================================================================================
document.addEventListener("DOMContentLoaded", function () {
    
    const activeStates = Object.keys(branchesData);
    activeStates.forEach((stateId) => {
        if (simplemaps_countrymap_mapdata.state_specific[stateId]) {
            simplemaps_countrymap_mapdata.state_specific[stateId].color =
                "#4FBA6C";
            simplemaps_countrymap_mapdata.state_specific[stateId].hover_color =
                "#1f8717";
            simplemaps_countrymap_mapdata.state_specific[stateId].name =
                branchesData[stateId].province;
        }
    });

    const leftCol = document.getElementById("branch-labels-left");
    const rightCol = document.getElementById("branch-labels-right");

    let branchLabels = [];

    activeStates.forEach((stateId, index) => {
        const stateData = branchesData[stateId];

        const card = document.createElement("div");
        card.className = "map-label branch-card";
        card.id = `label-${stateId}`;

        // عنوان استان
        const title = document.createElement("div");
        title.className = "branch-card__title";
        title.innerText = `نمایندگی ${stateData.province}`;

        // لیست نمایندگی‌ها
        const list = document.createElement("div");
        list.className = "branch-card__list";

        stateData.offices.forEach((office, i) => {
            const item = document.createElement("div");
            item.className = "branch-card__item";

            item.innerHTML = `
          <div class="branch-card__manager">
            ${office.manager}
          </div>
          <div class="branch-card__address">
            ${office.address}
          </div>
          ${
              office.phone
                  ? `<a class="branch-card__phone" href="tel:${office.phone}">
                   ${office.phone}
                 </a>`
                  : ""
          }
        `;

            list.appendChild(item);
        });

        card.appendChild(title);
        card.appendChild(list);

        (index % 2 === 0 ? rightCol : leftCol).appendChild(card);

        branchLabels.push({
            stateId,
            labelId: card.id,
        });
    });

    function getStateElement(stateId) {
        return document.querySelector(`.sm_location_${stateId}`);
    }
    let lines = [];

    function drawLines() {
        lines.forEach((l) => l.remove());
        lines = [];

        branchLabels.forEach((b) => {
            const stateEl = getStateElement(b.stateId);
            const labelEl = document.getElementById(b.labelId);

            if (!stateEl || !labelEl) return;

            const line = new LeaderLine(
                LeaderLine.pointAnchor(stateEl, {
                    x: "60%",
                    y: "50%",
                }),
                labelEl,
                {
                    color: "#0d3b1e",
                    size: 2,
                    dash: { len: 6, gap: 4, animation: true },
                    startPlug: "disc",
                    endPlug: "arrow1",
                    endPlugSize: 1.5,
                },
            );

            lines.push(line);
        });
    }
    simplemaps_countrymap.hooks.complete = function () {
        setTimeout(() => {
            drawLines();
        }, 500); // زمان مکث - قابل تغییر
    };
});

// Office Map ============================================================================================
// مختصات دفتر مرکزی
const officeLocation = {
    lat: 31.894283399340488,
    lng: 54.36941244237667,
    title: "فروشگاه مرکزی ترمه سالاری",
};

// ساخت نقشه
const map = L.map("officeMap", {
    scrollWheelZoom: true,
    dragging: true,
    zoomControl: true,
}).setView([officeLocation.lat, officeLocation.lng], 16);

// لایه نقشه (OpenStreetMap)
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "&copy; OpenStreetMap",
}).addTo(map);

// آیکون سفارشی
const customIcon = L.icon({
    iconUrl: "/shop/assets/svgs/location-dot-solid-full.svg",
    iconSize: [40, 40],
    iconAnchor: [20, 40],
    popupAnchor: [0, -40],
});

// مارکر
const marker = L.marker([officeLocation.lat, officeLocation.lng], {
    icon: customIcon,
})
    .addTo(map)
    .bindPopup(`<strong>${officeLocation.title}</strong>`);

marker.openPopup();
