<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پرداخت هزینه مشاوره</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }
        .card-header {
            font-weight: bold;
        }
    </style>
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
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">پرداخت هزینه مشاوره</h4>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-info">
                            <p>در حال پرداخت برای مشاوره با <strong>{{ $doctor->first_name }} {{$doctor->last_name}}</strong></p>
                            <p>مبلغ قابل پرداخت: <strong>{{ number_format($doctor->doctor_profile->consultation_fee) }} تومان</strong></p>
                            <p>موجودی کیف پول شما: <strong>{{ number_format(auth()->user()->credit) }} تومان</strong></p>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(auth()->user()->credit < $doctor->doctor_profile->consultation_fee)
                            <div class="alert alert-warning">
                                موجودی کیف پول شما کافی نیست. لطفاً حساب خود را شارژ کنید.
                            </div>
                        @else
                            <form action="{{ route('doctor.process-payment', $doctor->id) }}" method="POST">
                                @csrf
                                
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="confirm_payment" name="confirm_payment" required>
                                    <label class="form-check-label" for="confirm_payment">
                                        با پرداخت <strong>{{ number_format($doctor->doctor_profile->consultation_fee) }} تومان</strong> موافقت می‌کنم
                                    </label>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">انصراف</a>
                                    <button type="submit" class="btn btn-primary">تایید و پرداخت</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>