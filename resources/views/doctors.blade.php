<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>متخصصان</title>
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
                @auth
                    <a href="{{ route('user.sessions', ['user' => auth()->id()]) }}" class="hover:text-emerald-200">گفت‌وگو های من</a>
                    <?php $usertype = auth()->user()->user_type;?>
                    @if($usertype == 'admin')
                        <a href="{{route('admin-pannel')}}" class="hover:text-emerald-200">پنل ادمین</a>
                    @endif
                @endauth
                <a href="#" class="hover:text-emerald-200">درباره ما</a>
                <a href="/register" class="bg-emerald-600 px-4 py-2 rounded hover:bg-emerald-700">ورود/ثبت‌نام</a>
            </nav>
        </div>
    </header>
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-emerald-800">گیاهپزشکان ما</h2>
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($doctors as $doctor)
                <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                    <a href="/doctors/{{$doctor->id}}">
                        <img src="{{$doctor->profile_picture }}" alt="گیاهپزشک" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-4">
                        <h3 class="font-bold text-lg">{{$doctor->first_name}} {{$doctor->last_name}}</h3>
                        <p class="text-sm text-gray-500 mt-1">متخصص بیماری‌های گل‌های آپارتمانی</p>
                        
                        <button 
                            class="mt-4 w-full bg-emerald-100 text-emerald-800 py-2 rounded hover:bg-emerald-200 message-btn"
                            data-doctor-id="{{ $doctor->id }}"
                        >
                            ارسال پیام
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <script>
        document.querySelectorAll('.message-btn').forEach(button => {
            button.addEventListener('click', async function() {
                const doctorId = this.dataset.doctorId;
                
                try {
                    const response = await fetch(`/doctors/${doctorId}/check-auth`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({})
                    });

                    const data = await response.json();
                    
                    if (!response.ok) throw new Error(data.message || 'خطای سرور');

                    if (data.success) {
                        window.location.href = data.payment_url;
                    } else {
                        alert(data.message);
                        if (data.login_url) {
                            window.location.href = data.login_url;
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('خطا: ' + error.message);
                }
            });
        });
    </script>
</body>
</html>