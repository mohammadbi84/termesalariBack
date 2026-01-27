{{-- resources/views/components/popup-modal.blade.php --}}
<div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="popupModalLabel" aria-hidden="true" dir="rtl">
    <div class="modal-dialog modal-dialog-centered modal-lg rounded-2">
        <div class="modal-content" style="border-radius: 12px !important">
            <div class="modal-body p-0">
                <!-- Slider section with close button -->
                <div class="position-relative">
                    <button type="button" class="btn btn-light position-absolute top-0 start-0 modal-close-btn"
                        data-bs-dismiss="modal" id="closePopup"
                        style="border-radius: 0 0 12px 0 !important;padding: 0 !important;z-index: 2;width: 41px;height: 41px;">
                        <i class="fa-solid fa-xmark" style="font-size: x-large;position: relative;top: 2.5px;"></i>
                    </button>

                    <div class="splide" id="popup-slider" style="direction: ltr;">
                        <div class="splide__track">
                            <ul class="splide__list" id="popup-slider-list">
                                <!-- Images will be loaded here dynamically -->
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Content section -->
                <div class="p-4 px-5" style="direction: ltr;" id="popup-content">
                    <!-- Title -->
                    <h2 class="fw-bold mb-3 text-center" dir="rtl" id="popup-title"></h2>

                    <!-- Description -->
                    <p class="text-muted text-center mb-4" dir="rtl" id="popup-description"></p>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-text-link px-4 py-2" data-bs-dismiss="modal" id="btn-later">
                            بعدا چک میکنم
                        </button>
                        <button type="button" class="btn btn-primary d-flex align-items-center px-4 py-2" id="btn-more-info">
                            اطلاعات بیشتر
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Don't show again checkbox -->
                    {{-- <div class="form-check mt-4 text-center">
                        <input class="form-check-input" type="checkbox" id="dontShowAgain">
                        <label class="form-check-label text-muted" for="dontShowAgain">
                            این پاپ‌آپ را مجدداً نشان نده
                        </label>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
