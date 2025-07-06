<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مشاوره گیاهپزشکی</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-emerald-50">
   <!--header-->
    <header class="bg-emerald-800 text-white p-4 shadow">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-2xl font-bold">گلخانه</div>
            <nav class="hidden md:flex space-x-8 space-x-reverse">
                <a href="#" class="hover:text-emerald-200">خانه</a>
                <a href="/doctors" class="hover:text-emerald-200">متخصصان</a>
                @auth
                    <?php $userId = auth()->id();?>
                    <a href="{{ route('user.sessions', ['user' => auth()->id()]) }}" class="hover:text-emerald-200">گفت‌وگو های من</a>
                @endauth
                <a href="#" class="hover:text-emerald-200">درباره ما</a>
                <a href="/register" class="bg-emerald-600 px-4 py-2 rounded hover:bg-emerald-700">ورود/ثبت‌نام</a>
            </nav>
        </div>
    </header>

    <!-- بنر اصلی -->
    <section class="bg-gradient-to-r from-emerald-700 to-emerald-500 text-white py-20">
        <div class="container mx-auto text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">ناجی گیاهان خانگی شما!</h1>
            <p class="text-xl mb-8">با بهترین گیاهپزشکان آنلاین مشورت کنید.</p>
            <!-- <button class="bg-white text-emerald-800 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100">
                شروع مشاوره
            </button> -->
        </div>
    </section>

    <!-- مراحل کار -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-emerald-800">چگونه کار می‌کند؟</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- کارت ۱ -->
                <div class="bg-emerald-50 p-6 rounded-lg border border-emerald-100 text-center">
                    <div class="text-emerald-600 text-4xl font-bold mb-4">۱</div>
                    <h3 class="font-bold text-lg mb-2">انتخاب متخصص</h3>
                    <p class="text-gray-600">یکی از گیاه‌پزشکان ما را انتخاب کنید.</p>
                </div>
                <!-- کارت ۲ -->
                <div class="bg-emerald-50 p-6 rounded-lg border border-emerald-100 text-center">
                    <div class="text-emerald-600 text-4xl font-bold mb-4">۲</div>
                    <h3 class="font-bold text-lg mb-2">آغاز مشاوره</h3>
                    <p class="text-gray-600">مشکل گیاه خود را شرح دهید یا تصویری از آن ارسال کنید.</p>
                </div>
                <!-- کارت ۳ -->
                <div class="bg-emerald-50 p-6 rounded-lg border border-emerald-100 text-center">
                    <div class="text-emerald-600 text-4xl font-bold mb-4">۳</div>
                    <h3 class="font-bold text-lg mb-2">دریافت راهکار</h3>
                    <p class="text-gray-600">پاسخ تخصصی دریافت کنید.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- فوتر -->
    <footer class="bg-emerald-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">گلخانه</h3>
                    <p>پلتفرم تخصصی مشاوره گیاهپزشکی</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">لینک‌های سریع</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-emerald-200">خانه</a></li>
                        <li><a href="/doctors" class="hover:text-emerald-200">متخصصان</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">تماس با ما</h3>
                    <p>info@giah-yar.ir</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>