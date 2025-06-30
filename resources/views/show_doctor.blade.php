<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پروفایل گیاه پزشک</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .profile-card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
            background: white;
        }
        .profile-header {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            object-fit: cover;
            margin-bottom: 15px;
        }
        .specialty-badge {
            background-color: #f39c12;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            display: inline-block;
            margin: 5px;
        }
        .rating {
            color: #f1c40f;
            font-size: 24px;
            margin: 10px 0;
        }
        .section-title {
            color: #27ae60;
            border-bottom: 2px solid #27ae60;
            padding-bottom: 5px;
            margin-top: 20px;
        }
        .contact-btn {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: bold;
            transition: all 0.3s;
        }
        .contact-btn:hover {
            background-color: #2ecc71;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="profile-card">
                    <!-- هدر پروفایل -->
                    <div class="profile-header">
                        <!-- <img src="{{$doctor->profile_picture}}" alt="عکس پروفایل" class="profile-img"> -->
                         <img src="{{ $doctor->getProfileUrl() }}" alt="پروفایل {{ $doctor->username }}" class="profile-img">
                        <h2>{{$doctor->first_name}} {{$doctor->last_name}}</h2>
                        <div class="rating">
                            ★★★★★ <span style="color: #333; font-size: 16px;">({{$doctor->doctor_profile->average_rating}} از ۵)</span>
                        </div>
                        <div>
                            <span class="specialty-badge">گیاه پزشکی</span>
                            <span class="specialty-badge">حشره شناسی</span>
                        </div>
                    </div>

                    <!-- بدنه پروفایل -->
                    <div class="p-4">
                        <!-- اطلاعات کلی -->
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>آغاز كار</strong> {{$doctor->doctor_profile->career_start_year}}</p>
                                <!-- <p><strong>تعداد مشاوره:</strong> ۱,۲۴۵ مورد</p> -->
                            </div>
                            <div class="col-md-6">
                                <p><strong>هزینه مشاوره:</strong> {{$doctor->doctor_profile->consultation_fee}} تومان</p>
                                <!-- <p><strong>زمان پاسخگویی:</strong> کمتر از ۲ ساعت</p> -->
                            </div>
                        </div>

                        <!-- توضیحات تخصصی -->
                        <h4 class="section-title">تخصص‌ها</h4>
                        <p>
                            {{$doctor->doctor_profile->bio}}
                        </p>

                        <!-- تحصیلات -->
                        <h4 class="section-title">تحصیلات</h4>
                        <ul>
                            <li>{{$doctor->doctor_profile->education}}</li>
                            <!-- <li>کارشناسی ارشد حشره شناسی - دانشگاه شیراز (۱۳۹۰)</li> -->
                        </ul>

                        <!-- نظرات بیماران
                        <h4 class="section-title">نظرات مراجعین</h4>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex">
                                    <img src="https://via.placeholder.com/50" alt="کاربر" class="rounded-circle me-3" width="50" height="50">
                                    <div>
                                        <h6>محمد رضایی</h6>
                                        <div class="text-warning">★★★★★</div>
                                        <p>با راهنمایی دکتر احمدی گیاه آپارتمانی من که در حال خشک شدن بود دوباره سرحال شد. واقعا متشکرم!</p>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- دکمه اقدام -->
                        <div class="text-center mt-4">
                            <button class="contact-btn">درخواست مشاوره</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>