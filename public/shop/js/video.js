document.addEventListener("DOMContentLoaded", function () {
    const video = document.getElementById("fullscreen-video");
    
    const playPauseBtn = document.querySelector(".play-pause-btn");
    const playIcon = playPauseBtn.querySelector("i");
    const videoContainer = document.querySelector(".video-full-container");
    const videoOverlay = document.querySelector(".video-overlay");

    
    // تابع پخش/توقف ویدیو
    function togglePlayPause() {
        if (video.paused) {
            video.play();
            playIcon.classList.remove("fa-play");
            playIcon.classList.add("fa-pause");
            videoContainer.classList.add("playing");
        } else {
            video.pause();
            playIcon.classList.remove("fa-pause");
            playIcon.classList.add("fa-play");
            videoContainer.classList.remove("playing");
        }
    }
    // وقتی ویدیو تموم شد
    video.addEventListener("ended", function () {
        playIcon.classList.remove("fa-pause");
        playIcon.classList.add("fa-play");
        videoContainer.classList.remove("playing");
        video.currentTime = 0; // برگرده اول ویدیو (اختیاری)
    });

    // رویداد کلیک روی دکمه پلی/پاز
    playPauseBtn.addEventListener("click", function (e) {
        e.stopPropagation();
        togglePlayPause();
    });

    // رویداد کلیک روی ویدیو
    videoOverlay.addEventListener("click", function () {
        togglePlayPause();
    });

    // رویداد کلیک روی خود ویدیو
    videoContainer.addEventListener("click", function () {
        togglePlayPause();
    });

    // تنظیم ویدیو برای حالت تمام صفحه در مرورگرهای مختلف
    function enterFullscreen() {
        if (videoContainer.requestFullscreen) {
            videoContainer.requestFullscreen();
        } else if (videoContainer.mozRequestFullScreen) {
            videoContainer.mozRequestFullScreen();
        } else if (videoContainer.webkitRequestFullscreen) {
            videoContainer.webkitRequestFullscreen();
        } else if (videoContainer.msRequestFullscreen) {
            videoContainer.msRequestFullscreen();
        }
    }

    // برای نمایش بهتر، ویدیو را در حالت بی‌صدا تنظیم کردم
    // اگر می‌خواهید صدا داشته باشد، ویژگی 'muted' را از تگ ویدیو حذف کنید
});
