<footer class="footer">
    <div class="container">
        <div class="footer-columns">
            <!-- ستون 1 -->
            <div class="footer-col about">
                <h3 class="site-title">ترمه سالاری</h3>
                <p>
                    ترمه سالاری یزد با بیش از یک قرن تجربه و سیصد طرح متنوع، ارائه دهنده ی معروف ترین و مرغوب
                    ترین ترمه ها در ایران می باشد. شعار ما "ترمه سالاری برای هر ایرانی با کیفیتی عالی و قیمتی
                    مناسب" می باشد تا همه اقشار ملت بتوانند از آن بهره مند شوند.
                </p>
            </div>

            <!-- ستون 2 -->
            <div class="footer-col links">
                <h4>دسترسی سریع</h4>
                <ul>
                    <li><a href="#">نمونه محصولات</a></li>
                    <li><a href="#">سفارش محصول</a></li>
                    <li><a href="http://www.termehsalari.com/shop">ورود به فروشگاه</a></li>
                    <li><a href="{{ route('terms') }}">شرایط و قوانین</a></li>
                    <li><a href="{{ route('privacy-policy') }}">حریم خصوصی</a></li>
                </ul>
            </div>

            <!-- ستون 3 -->
            <div class="footer-col contact">
                <h4>ارتباط با ما</h4>
                <ul>
                    <li>فروشگاه مرکزی: میدان امیرچخماق</li>
                    <li>تلفن: 37 06 3626 035</li>
                    <li>فروشگاه شماره ۲: جنب شیرینی سازی حاج خلیفه، سرای ترمه</li>
                    <li>تلفن: 80 38 3622 035</li>
                    <li>ایمیل: <a href="mailto:Info@TermehSalari.com">Info@TermehSalari.com</a></li>
                    <li>موبایل: 09134577500</li>
                </ul>
                <div class="social-icons">
                    <a href="https://telegram.me/termeh_salari"><i class="fab fa-telegram"></i></a>
                    <a href="https://www.instagram.com/termehsalari/"><i class="fab fa-instagram"></i></a>
                    <a href="mailto:Info@TermehSalari.com"><i class="fas fa-envelope"></i></a>
                </div>
            </div>

            <!-- ستون 4 -->
            <div class="footer-col newsletter">
                <h4>خبرنامه</h4>
                <p>
                    کاربر گرامی: لطفاً برای اطلاع از تخفیف‌ها و جدیدترین‌های ترمه سالاری
                    در خبرنامه عضو شوید.
                </p>
                <div class="newsletter-form">
                    <form action="{{ route('newsletter.store') }}" class="d-flex" method="post">
                        @csrf
                        <input type="email" name="email_join_newsletter" id="email_join_newsletter"
                            placeholder="آدرس ایمیل خود را بنویسید" value="{{ old('email_join_newsletter') }}" />
                        <button type="submit">عضویت</button>
                    </form>
                </div>
                <div class="footer-badges">
                    <img src="assets/logo/pardakht.png" alt="behpardakht" />
                    <a referrerpolicy="origin" target="_blank"
                        href="https://trustseal.enamad.ir/?id=210447&amp;Code=Anvxg4lW2ecEYh0W8QsV"><img
                            referrerpolicy="origin"
                            src="https://Trustseal.eNamad.ir/logo.aspx?id=210447&amp;Code=Anvxg4lW2ecEYh0W8QsV"
                            alt="" style="cursor:pointer;width: 100px;filter:contrast(200%) brightness(150%);"
                            id="Anvxg4lW2ecEYh0W8QsV"></a>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="container-fluid text-light text-center py-4" style="background-color: #030f08;">
    <span class="fs-small">© Copyright <b>termehsalari</b>. All Rights Reserved <br>
        Designed by <a href="https://www.fazeledu.com/" class="text-success">FazelEdu</a></span>
</div>
