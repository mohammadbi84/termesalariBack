const swiper = new Swiper(".mySwiper", {
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
let started = false;

function animateCounters() {
    counters.forEach((counter) => {
        let target = +counter.getAttribute("data-target");
        let current = 0;
        let increment = Math.ceil(target / 75);

        let interval = setInterval(() => {
            current += increment;
            if (current >= target) {
                counter.textContent = target;
                clearInterval(interval);
            } else {
                counter.textContent = current;
            }
        }, 50);
    });
}

// مشاهده المان
const observer = new IntersectionObserver(
    (entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && !started) {
                animateCounters();
                started = true;
                observer.disconnect(); // برای یک‌بار اجرا
            }
        });
    },
    {
        threshold: 0.9, // حداقل ۴۰٪ المان دیده شود تا شروع شود
    }
);

// المانی که باید دیده شود
observer.observe(document.querySelector(".mission-row"));

// Hot===========================================================================================

var HotSplide = new Splide("#hot_slider", {
    type: "loop",
    perPage: 4,
    padding:{right:'20px'},
    gap: "1.7rem",
    arrows: false,
    pagination: false,
    direction: "rtl",
    autoplay: true,
    focus: "right", // این باعث میشه اسلاید وسط اکتیو باشه
    breakpoints: {
        1024: { perPage: 4 },
        768: { perPage: 2 },
        480: { perPage: 1 },
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
const branches = [
    { stateId: "IR07", labelId: "label-tehran", name: "تهران" },
    { stateId: "IR04", labelId: "label-isfahan", name: "اصفهان" },
    { stateId: "IR30", labelId: "label-mashhad", name: "مشهد" },
    { stateId: "IR15", labelId: "label-kerman", name: "کرمان" },
    { stateId: "IR28", labelId: "label-ghazvin", name: "قزوین" },
    { stateId: "IR18", labelId: "label-yasoj", name: "یاسوج" },
];

// branches.forEach((b) => {
//     simplemaps_countrymap_mapdata.state_specific[b.stateId].color = "#4FBA6C";
//     simplemaps_countrymap_mapdata.state_specific[b.stateId].name = b.name;
//     simplemaps_countrymap_mapdata.state_specific[b.stateId].hover_color =
//         "#1f8717";
// });

// simplemaps_countrymap_mapdata.main_settings.zoom = "no";
// simplemaps_countrymap_mapdata.main_settings.manual_zoom = "no";
// simplemaps_countrymap_mapdata.main_settings.all_states_zoomable = "no";

// function getStateElement(stateId) {
//     return document.querySelector(`.sm_state_${stateId}`);
// }

// let lines = [];

// function drawLines() {
//     lines.forEach((l) => l.remove());
//     lines = [];

//     branches.forEach((b) => {
//         const stateEl = getStateElement(b.stateId);
//         const labelEl = document.getElementById(b.labelId);
//         if (!stateEl || !labelEl) return;

//         lines.push(
//             new LeaderLine(
//                 LeaderLine.pointAnchor(stateEl, { x: "60%", y: "50%" }),
//                 labelEl,
//                 {
//                     startPlug: "square",
//                     endPlug: "square",
//                     endPlugSize: 2,
//                     color: "#061f10",
//                     size: 2,
//                     dash: { len: 8, gap: 5, animation: true },
//                 }
//             )
//         );
//     });
// }

// simplemaps_countrymap.hooks.complete = function () {
//     drawLines();
//     $("#map a").addClass("d-none");
// };

// window.addEventListener("resize", () => {
//     lines.forEach((l) => l.position());
// });
document.addEventListener("DOMContentLoaded", function () {
    const branchesData = {
        IR07: {
            province: "تهران",
            offices: [
                {
                    manager: "آقای صفائی",
                    address: "بازار کفاش‌ها - خانه ترمه ایران",
                    phone: "",
                },
                {
                    manager: "آقای میرزایی",
                    address: "مینی سیتی - شهرک شهید محلاتی",
                    phone: "",
                },
            ],
        },

        IR30: {
            province: "مشهد",
            offices: [
                {
                    manager: "آقای شفاجو",
                    address: "چهارراه خسروی - پاساژ جواد - طبقه اول",
                    phone: "05132253572",
                },
            ],
        },

        IR04: {
            province: "اصفهان",
            offices: [
                {
                    manager: "آقای شجائی",
                    address: "میدان نقش جهان",
                    phone: "",
                },
                {
                    manager: "خانم اکبری",
                    address: "نجف آباد - مجتمع تجاری فردوسی - صنایع ترمه",
                    phone: "",
                },
            ],
        },

        IR15: {
            province: "کرمان",
            offices: [
                {
                    manager: "آقای نیک نفس",
                    address:
                        "سه‌راهی شمالی جنوبی - جنب مسجد شیخ‌ها - ترمه ابریشم",
                    phone: "03432239460",
                },
            ],
        },

        IR28: {
            province: "قزوین",
            offices: [
                {
                    manager: "خانم حاتمی",
                    address:
                        "خیابان فردوسی - بعد از چهارراه بوعلی - جنب تالار فرهنگیان - ترمه سیان",
                    phone: "02833359101",
                },
            ],
        },

        IR18: {
            province: "یاسوج",
            offices: [
                {
                    manager: "خانم کیانوش",
                    address: "خیابان ۳۰ متری معاد",
                    phone: "",
                },
            ],
        },
    };
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
                }
            );

            lines.push(line);
        });
    }
    simplemaps_countrymap.hooks.complete = function () {
    setTimeout(() => {
        drawLines();
    }, 500); // زمان مکث - قابل تغییر
};

    // window.addEventListener("resize", () => {
    //     lines.forEach((line) => line.position());
    // });
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
