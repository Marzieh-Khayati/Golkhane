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
            @auth
                <?php $username = auth()->user()->username;?>
                <div class="text-2xl font-bold">{{$username}}</div>
            @endauth
            <nav class="hidden md:flex space-x-8 space-x-reverse">
                <a href="{{route('welcome')}}" class="hover:text-emerald-200">خانه</a>
                <a href="/doctors" class="hover:text-emerald-200">متخصصان</a>
                <a href="/register" class="bg-emerald-600 px-4 py-2 rounded hover:bg-emerald-700">ورود/ثبت‌نام</a>
            </nav>
        </div>
    </header>
</body>