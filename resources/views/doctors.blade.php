<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>متخصصان</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-emerald-50">
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-emerald-800">گیاهپزشکان ما</h2>
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6">
                <!-- کارت متخصص ۱ -->
                    @foreach($doctors as $doctor) 
                <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                   <a href="/doctors/{{$doctor->id}}"> <img src="{{$doctor->profile_picture }}" alt="گیاهپزشک" class="w-full h-48 object-cover"></a>
                    <div class="p-4">
                        <h3 class="font-bold text-lg">{{$doctor->first_name}} {{$doctor->last_name}}</h3>
                        <p class="text-sm text-gray-500 mt-1">متخصص بیماری‌های گل‌های آپارتمانی</p>
                        <button class="mt-4 w-full bg-emerald-100 text-emerald-800 py-2 rounded hover:bg-emerald-200">
                            ارسال پیام
                        </button>
                    </div>
                </div>
                @endforeach
                <!-- ۳ کارت دیگر -->
            </div>
        </div>
    </section>
    </body>
</html>
