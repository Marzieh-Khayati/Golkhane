<?php
// دریافت داده‌های لازم از کنترلر
$consultationSession = $consultationSession ?? null; // جلسه مشاوره
$doctor = $doctor ?? null; // اطلاعات پزشک
$user = auth()->user(); // کاربر لاگین کرده
$messages = $messages ?? []; // پیام‌های چت
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>چت با پزشک</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <style>
        .chat-container {
            height: calc(100vh - 400px);
        }
        .message-input {
            border-radius: 25px;
        }
        .unread {
            background-color: #f0fdf4;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

<div class="container mx-auto px-4 py-8">
    <!-- هدر صفحه -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img src="{{ $doctor->getProfileUrl() }}" alt="پروفایل {{ $doctor->username }}" 
                     class="w-16 h-16 rounded-full object-cover border-2 border-emerald-500" />
                <div class="mr-4">
                    <h2 class="text-xl font-bold text-gray-800">دکتر <?php echo e($doctor->first_name); ?> <?php echo e($doctor->last_name); ?></h2>
                    <p class="text-gray-600"><?php echo e($doctor->specialty ?? 'پزشکی عمومی'); ?></p>
                </div>
            </div>
            <div class="text-left">
                <p class="text-gray-500"><i class="far fa-clock ml-1"></i></p>
                <p class="text-gray-500"><i class="far fa-calendar-alt ml-1"></i></p>
            </div>
        </div>
    </div>

   <!-- بخش اطلاعات مشاوره -->
<div class="bg-white rounded-lg shadow-md p-4 mt-4">
    <div class="flex justify-between items-center">
        <div>
            <h3 class="font-bold text-gray-800">مشاوره آنلاین</h3>
            <p class="text-gray-600">
                وضعیت: 
                @if($consultationSession->status === 'active')
                    <span class="text-green-500">در حال انجام</span>
                @else
                    <span class="text-red-500">پایان یافته</span>
                    <span class="text-xs text-gray-500">
                        (در تاریخ {{ $consultationSession->ended_at->format('Y/m/d H:i') }})
                    </span>
                @endif
            </p>
        </div>
        @if($consultationSession->status === 'active' && auth()->id() == $consultationSession->doctor_id)
            <button id="end-session-btn" 
                    class="bg-red-100 hover:bg-red-200 text-red-600 px-4 py-2 rounded-lg">
                پایان مشاوره
            </button>
        @endif
    </div>
</div>

<script>
// پایان جلسه توسط پزشک
document.getElementById('end-session-btn')?.addEventListener('click', async function() {
    if(confirm('آیا از پایان این جلسه مشاوره اطمینان دارید؟')) {
        try {
            const response = await fetch('/sessions/{{ $consultationSession->id }}/end', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if(data.success) {
                location.reload();
            }
        } catch (error) {
            alert('خطا در پایان جلسه');
            console.error(error);
        }
    }
});
// غیرفعال کردن ارسال پیام اگر جلسه پایان یافته
@if($consultationSession->status !== 'active')
    document.querySelector('#chat-form input[name="message"]').disabled = true;
    document.querySelector('#chat-form button').disabled = true;
@endif
</script>

<!-- بخش پیام‌های چت -->
<div id="chat-messages" class="overflow-y-auto h-96 p-2 border border-gray-300 rounded-lg mb-4">
<?php if(!empty($messages)): ?>
    <?php foreach($messages as $msg): ?>
        <?php
            // فرض بر این است که $msg->sender_id و $msg->content و $msg->created_at موجود هستند
            $alignClass = $msg->sender_id == $user->id ? 'justify-end' : 'justify-start';
        ?>
        <div class="flex <?= $alignClass ?> mb-2">
            <div class="bg-gray-200 p-3 rounded-lg max-w-xs lg:max-w-md <?= $msg->sender_id == $user->id ? 'bg-blue-100' : '' ?>">
                <p class="text-gray-800"><?= e($msg->message_text) ?></p>
                <p class="text-xs text-gray-500 text-left mt-1">
                    <?= e(\Carbon\Carbon::parse($msg->created_at)->locale('fa')->isoFormat('HH:mm')) ?>
                    <i class="fas fa-check text-gray-400 ml-1"></i>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>

<!-- فیلد ارسال پیام -->
    <div class="bg-white rounded-lg shadow-md p-4">
        <form id="chat-form" class="flex items-center">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="session_id" value="<?php echo e($consultationSession->id); ?>">
            <input type="text" 
                   name="message" 
                   placeholder="پیام خود را بنویسید..." 
                   class="flex-grow message-input border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-transparent py-2 px-4">
            <button type="submit" 
                    class="bg-emerald-500 hover:bg-emerald-600 text-white rounded-full p-2 ml-2 w-10 h-10 flex items-center justify-center">
                <i class="far fa-paper-plane"></i>
            </button>
        </form>
    </div>

<!-- اطلاعات مشاوره -->
<div class="bg-white rounded-lg shadow-md p-4 mt-4">
    <div class="flex justify-between items-center">
        <div>
            <h3 class="font-bold text-gray-800">مشاوره آنلاین</h3>
            <p class="text-gray-600">
                مدت زمان باقیمانده: 
                <?php
                    $remaining = strtotime($consultationSession->end_time) - time();
                    $minutes = floor($remaining / 60);
                    echo $minutes > 0 ? $minutes . ' دقیقه' : 'زمان به پایان رسیده';
                ?>
            </p>
            <p class="text-gray-600 mt-1">
                مبلغ پرداختی: <?php echo e(number_format($consultationSession->payment_amount)); ?> تومان
            </p>
        </div>
        <button class="bg-red-100 hover:bg-red-200 text-red-600 px-4 py-2 rounded-lg">
            پایان مشاوره
        </button>
    </div>
</div>

<!-- اسکریپت های جاوااسکریپت برای ارسال پیام -->
<script>
    document.getElementById('chat-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const input = form.querySelector('input[name="message"]');
        const message = input.value.trim();
        if(message) {
            try {
                const response = await fetch("{{ url('send-message') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        session_id: form.querySelector('input[name="session_id"]').value,
                        message: message
                    })
                });
                const data = await response.json();
                if(data.success) {
                    input.value = '';
                    // افزودن پیام به بخش پیام‌ها
                    const chatContainer = document.getElementById('chat-messages');
                    const newMessageDiv = document.createElement('div');
                    newMessageDiv.className = 'flex justify-end mb-2';
                    newMessageDiv.innerHTML = `
                        <div class="bg-blue-100 p-3 rounded-lg max-w-xs lg:max-w-md">
                            <p class="text-gray-800">${message}</p>
                            <p class="text-xs text-gray-500 text-left mt-1">
                                ${new Date().toLocaleTimeString('fa-IR', {hour: '2-digit', minute:'2-digit'})}
                                <i class="fas fa-check text-gray-400 ml-1"></i>
                            </p>
                        </div>
                    `;
                    chatContainer.appendChild(newMessageDiv);
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('خطا در ارسال پیام');
            }
        }
    });
    // اسکرول به پایین هنگام لود صفحه
    window.onload = function() {
        const chatContainer = document.getElementById('chat-messages');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    };
    
</script>
</body>
</html>