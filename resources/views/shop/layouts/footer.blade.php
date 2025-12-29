<footer class="footer">
    <div class="container">
        <div class="footer-columns">

            <!-- ستون 1 -->
            <div class="footer-col about">
                <h3 class="site-title">{{ __('footer.site_title') }}</h3>
                <p>{{ __('footer.about_text') }}</p>
            </div>

            <!-- ستون 2 -->
            <div class="footer-col links">
                <h4>{{ __('footer.quick_access') }}</h4>
                <ul>
                    <li><a href="#">{{ __('footer.products_sample') }}</a></li>
                    <li><a href="#">{{ __('footer.order_product') }}</a></li>
                    <li><a href="http://www.termehsalari.com/store">{{ __('footer.enter_store') }}</a></li>
                    <li><a href="{{ route('terms') }}">{{ __('footer.terms') }}</a></li>
                    <li><a href="{{ route('privacy-policy') }}">{{ __('footer.privacy') }}</a></li>
                </ul>
            </div>

            <!-- ستون 3 -->
            <div class="footer-col contact">
                <h4>{{ __('footer.contact_us') }}</h4>
                <ul>
                    <li>{{ __('footer.shop_1') }}</li>
                    <li>{{ __('footer.shop_1_tel') }}</li>
                    <li>{{ __('footer.shop_2') }}</li>
                    <li>{{ __('footer.shop_2_tel') }}</li>
                    <li>{{ __('footer.email') }}:
                        <a href="mailto:Info@TermehSalari.com">Info@TermehSalari.com</a>
                    </li>
                    <li>{{ __('footer.mobile') }}: 09134577500</li>
                </ul>

                <div class="social-icons">
                    <a href="https://telegram.me/termeh_salari"><i class="fab fa-telegram"></i></a>
                    <a href="https://www.instagram.com/termehsalari/"><i class="fab fa-instagram"></i></a>
                    <a href="mailto:Info@TermehSalari.com"><i class="fas fa-envelope"></i></a>
                </div>
            </div>

            <!-- ستون 4 -->
            <div class="footer-col newsletter">
                <h4>{{ __('footer.newsletter') }}</h4>
                <p>{{ __('footer.newsletter_text') }}</p>

                <div class="newsletter-form">
                    <form action="{{ route('newsletter.store') }}" class="d-flex" method="post">
                        @csrf
                        <input type="email" name="email_join_newsletter"
                            placeholder="{{ __('footer.newsletter_placeholder') }}"
                            value="{{ old('email_join_newsletter') }}" />
                        <button type="submit">
                            {{ __('footer.newsletter_button') }}
                        </button>
                    </form>
                </div>

                <div class="footer-badges">
                    <img src="{{ asset('/storetemplate/dist/img/behpardakht.png') }}" alt="behpardakht" />
                    <a referrerpolicy="origin" target="_blank"
                        href="https://trustseal.enamad.ir/?id=210447&amp;Code=Anvxg4lW2ecEYh0W8QsV">
                        <img referrerpolicy="origin"
                            src="https://Trustseal.eNamad.ir/logo.aspx?id=210447&amp;Code=Anvxg4lW2ecEYh0W8QsV"
                            style="cursor:pointer;width:100px;filter:contrast(200%) brightness(150%);" />
                    </a>
                </div>
            </div>

        </div>
    </div>
</footer>


{{-- <footer id="site-footer" class="site-footer">
    <div id="footer">
        <div class="footer-top">
            <div class="footer-top_inner">
                <span class="footer-top_inner-bg" aria-hidden="true"></span>
                <div class="footer-about-us">
                    <div class="site-title">
                        <a href="#" class="site-title-inner text-reset">
                            <span id="site-logo">
                                <img src="{{ asset('hometemplate/img/logo.png') }}" alt="ترمه سالاری" width="55"
                                    height="55">
                                ترمه
                                سالاری</span>
                        </a>
                    </div>
                    <div class="footer-about-us-text">
                        <p>ترمه سالاری یزد با بیش از یک قرن تجربه و سیصد طرح متنوع، ارائه دهنده ی معروف ترین و مرغوب
                            ترین ترمه ها در ایران می باشد. شعار ما "ترمه سالاری برای هر ایرانی با کیفیتی عالی و
                            قیمتی مناسب" می باشد تا همه اقشار ملت بتوانند از آن بهره مند شوند.</p>
                    </div>
                </div>
                <nav class="footer-menu-wrap footer-menu1">
                    <div class="footer-heading-wrap luxina_heading_wrap">
                        <i class="luxina-icon-grid-fill luxina_heading_icon" aria-hidden="true"></i>
                        <div class="luxina_heading_title_inner">
                            <div class="luxina_heading_title">
                                دسترسی سریع </div>
                            <span class="luxina_heading_subtitle">
                                Quick access </span>
                        </div>
                    </div>
                    <div class="footer-menu">
                        <ul id="menu-%d9%81%d9%88%d8%aa%d8%b1-%db%b1" class="menu">
                            <li id="menu-item-852"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-837 current_page_item menu-item-852">
                                <a href="http://www.termehsalari.com/shop" aria-current="page"><span class="menu-item-title">ورود به فروشگاه</span></a>
                            </li>
                            <li id="menu-item-854"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-854"><a
                                    href="{{ route('terms') }}"><span class="menu-item-title">شرایط و قوانین</span></a>
                            </li>
                            <li id="menu-item-853"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-853">
                                <a href="{{ route('privacy-policy') }}"><span class="menu-item-title">حریم خصوصی</span></a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <nav class="footer-menu-wrap footer-menu2">
                    <div class="footer-heading-wrap luxina_heading_wrap">
                        <i class="luxina-icon-pencil-ruler-fill luxina_heading_icon" aria-hidden="true"></i>
                        <div class="luxina_heading_title_inner">
                            <div class="luxina_heading_title">
                                خدمات </div>
                            <span class="luxina_heading_subtitle">
                                Services </span>
                        </div>
                    </div>
                    <div class="footer-menu">
                        <ul id="menu-%d9%81%d9%88%d8%aa%d8%b1-%db%b2" class="menu">
                            <li id="menu-item-855"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-855"><a
                                    href="#"><span class="menu-item-title">ساخت و اجرا</span></a></li>
                            <li id="menu-item-856"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-856"><a
                                    href="#"><span class="menu-item-title">طراحی داخلی و دکوراسیون</span></a>
                            </li>
                            <li id="menu-item-857"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-857"><a
                                    href="#"><span class="menu-item-title">طراحی نقشه</span></a></li>
                            <li id="menu-item-858"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-858"><a
                                    href="#"><span class="menu-item-title">طراحی سه بعدی</span></a></li>
                            <li id="menu-item-859"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-859"><a
                                    href="#"><span class="menu-item-title">بازسازی و نوسازی</span></a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="footer-cta">
                <div class="footer-cta-content">
                    <span class="footer-cta-bg" aria-hidden="true"></span>
                    <span class="footer-cta-title">نیاز به راهنمایی دارید؟</span>
                    <span class="footer-cta-subtitle">Do you need help?</span>
                    <a href="tel:03536223880" class="footer-cta-btn button">
                        <span class="footer-cta-btn-text-1">مشاوره</span>
                        <span class="footer-cta-btn-text-2">03536223880</span>
                        <i class="footer-cta-btn-icon luxina-icon-customer-service-2-line"></i>
                    </a>
                </div>
                <span class="footer-cta-image-wrap">

                    <img src="{{ asset('shop/assets/sliders/l3.jpg') }}" alt="نیاز به راهنمایی دارید؟"
                        class="footer-cta-image">
                </span>
            </div>

        </div>
        <div class="footer-inner cols-3">
            <div class="footer-contact-info">
                <div class="footer-heading-wrap luxina_heading_wrap">
                    <i class="luxina-icon-question-answer-fill luxina_heading_icon" aria-hidden="true"></i>
                    <div class="luxina_heading_title_inner">
                        <div class="luxina_heading_title">
                            دیگر راه‌های ارتباطی </div>
                        <span class="luxina_heading_subtitle">
                            Other contact Methods </span>
                    </div>
                </div>
                <div class="footer-contact-info_inner">
                    <div class="footer-contact-info-item">
                        <i class="footer-contact-info-item-icon luxina-icon-map-pin-2-fill" aria-hidden="true"></i>
                        <div class="footer-contact-info-item_inner">
                            <span class="footer-contact-info-item-title">
                                آدرس </span>
                            <span class="footer-contact-info-item-text">
                                فروشگاه مرکزی: میدان امیرچخماق
                                فروشگاه شماره ۲: جنب شیرینی سازی حاج خلیفه، سرای ترمه
                             </span>
                        </div>
                    </div>
                    <div class="footer-contact-info-item">
                        <i class="footer-contact-info-item-icon luxina-icon-mail-fill" aria-hidden="true"></i>
                        <div class="footer-contact-info-item_inner">
                            <span class="footer-contact-info-item-title">
                                ایمیل </span>
                            <a href="mailto:Info@TermehSalari.com" class="footer-contact-info-item-text">
                                Info@TermehSalari.com </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-orgs">
                <div class="footer-heading-wrap luxina_heading_wrap">
                    <i class="luxina-icon-shield-keyhole-fill luxina_heading_icon" aria-hidden="true"></i>
                    <div class="luxina_heading_title_inner">
                        <div class="luxina_heading_title">
                            مجوز‌ها </div>
                        <span class="luxina_heading_subtitle">
                            Licenses </span>
                    </div>
                </div>
                <div class="footer-orgs_inner">
                    <div class="footer-orgs-item">
                        <a referrerpolicy="origin" target="_blank"
                        href="https://trustseal.enamad.ir/?id=210447&amp;Code=Anvxg4lW2ecEYh0W8QsV"><img
                            referrerpolicy="origin"
                            src="https://Trustseal.eNamad.ir/logo.aspx?id=210447&amp;Code=Anvxg4lW2ecEYh0W8QsV"
                            alt="" style="cursor:pointer;width: 100px;filter:contrast(200%) brightness(150%);"
                            id="Anvxg4lW2ecEYh0W8QsV"></a>
                    </div>
                    <div class="footer-orgs-item">
                        <img src="{{asset('shop/assets/logo/pardakht.png')}}">
                    </div>
                    <div class="footer-orgs-item">
                        <img src="wp-content/uploads/2025/10/org-3.png">
                    </div>
                </div>
            </div>
            <div class="footer-social">
                <div class="footer-heading-wrap luxina_heading_wrap">
                    <i class="luxina-icon-question-answer-fill luxina_heading_icon" aria-hidden="true"></i>
                    <div class="luxina_heading_title_inner">
                        <div class="luxina_heading_title">
                            شبکه های اجتماعی </div>
                        <span class="luxina_heading_subtitle">
                            Social media </span>
                    </div>
                </div>
                <div class="footer-social_inner">
                    <a class="footer-social-item" dir="ltr" href="https://telegram.me/termeh_salari">
                        <i class="footer-social-item-icon luxina-icon-telegram-2-fill" aria-hidden="true"></i>
                        <span class="footer-social-item-text">
                            termeh_salari </span>
                        <i class="fa-solid fa-arrow-up footer-social-item-arrow-icon"></i>
                    </a>
                    <a class="footer-social-item" dir="ltr" href="https://www.instagram.com/termehsalari">
                        <i class="footer-social-item-icon luxina-icon-instagram-fill" aria-hidden="true"></i>
                        <span class="footer-social-item-text">
                            termehsalari </span>
                        <i class="fa-solid fa-arrow-up footer-social-item-arrow-icon"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer> --}}
<div class="container-fluid text-light text-center py-4" style="background-color: #030f08;">
    <span class="fs-small">© Copyright <b>termehsalari</b>. All Rights Reserved <br>
        Designed by <a href="http://www.fazeledu.com/" class="text-success">FazelEdu</a></span>
</div>
