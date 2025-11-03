document.addEventListener("DOMContentLoaded", function () {
    // اسلایدر اصلی
    const slider = tns({
        container: ".top-slider",
        items: 1,
        slideBy: "page",
        loop: true,
        controls: false,
        autoplay: false,
        autoplayButtonOutput: false,
        nav: false,
        speed: 500,
    });

    const slides = document.querySelectorAll(".top-slider .item");
    const paginationItems = document.querySelectorAll(".pagination-item");
    const videos = document.querySelectorAll(".top-slider video");

    let timeoutId = null;
    let isVideoPlaying = false;

    function playNextSlide() {
        if (isVideoPlaying) return;
        const info = slider.getInfo();
        const currentSlide = slides[info.index % slides.length];
        const duration = parseInt(currentSlide.dataset.duration) || 5000;
        timeoutId = setTimeout(() => {
            slider.goTo("next");
        }, duration);
    }

    function updateActivePagination(index) {
        // حذف کلاس active از همه آیتم‌ها
        paginationItems.forEach(item => item.classList.remove("active"));
        
        // اضافه کردن کلاس active به آیتم فعلی
        if (paginationItems[index]) {
            paginationItems[index].classList.add("active");
        }
    }

    // کلیک روی پیجینیشن
    paginationItems.forEach((item, index) => {
        item.dataset.index = index;
        item.addEventListener("click", () => {
            clearTimeout(timeoutId);
            const itemIndex = parseInt(item.dataset.index);
            slider.goTo(itemIndex);
        });
    });

    // مدیریت ویدیوها (کد قبلی بدون تغییر)
    videos.forEach((video) => {
        const container = video.closest(".video-container");
        if (!container) return;

        const overlay = container.querySelector(".video-overlay");
        const cover = container.querySelector(".video-cover");
        const playBtn = container.querySelector(".btn-play");
        const stopButton = container.querySelector(".btn-stop");

        if (!overlay) return;

        const toggleVideo = () => {
            if (isVideoPlaying) {
                // توقف ویدیو
                if (playBtn) playBtn.style.display = "flex";
                if (cover) cover.style.display = "block";
                video.classList.add("d-none");
                video.pause();
                playNextSlide();
                isVideoPlaying = false;
            } else {
                // پخش ویدیو
                if (playBtn) playBtn.style.display = "none";
                if (cover) cover.style.display = "none";
                video.classList.remove("d-none");
                video.play().catch((e) => console.error("Video play error:", e));
                clearTimeout(timeoutId);
                isVideoPlaying = true;
            }
        };

        overlay.addEventListener("click", toggleVideo);
        video.addEventListener("click", toggleVideo);

        video.addEventListener("ended", () => {
            if (stopButton) stopButton.style.display = "none";
            if (playBtn) playBtn.style.display = "flex";
            if (cover) cover.style.display = "block";
            video.classList.add("d-none");
            isVideoPlaying = false;
            setTimeout(() => {
                slider.goTo("next");
            }, 500);
        });

        if (overlay) {
            overlay.addEventListener("mouseover", () => {
                if (isVideoPlaying && stopButton) {
                    stopButton.style.display = "flex";
                }
            });

            overlay.addEventListener("mouseleave", () => {
                if (stopButton) stopButton.style.display = "none";
            });
        }

        if (stopButton) {
            stopButton.addEventListener("click", function (e) {
                e.stopPropagation();
                toggleVideo();
            });
        }
    });

    // وقتی اسلاید اصلی تغییر کرد
    slider.events.on("indexChanged", (info) => {
        const index = info.displayIndex - 1;
        updateActivePagination(index);
        clearTimeout(timeoutId);
        playNextSlide();
    });

    // شروع اسلاید اول
    playNextSlide();
    updateActivePagination(0);
});