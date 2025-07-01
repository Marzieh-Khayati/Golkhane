<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پرداخت هزینه مشاوره</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
<body>
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
                                 <a href="#" class="btn btn-sm btn-outline-primary mr-2">شارژ کیف پول</a> 
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