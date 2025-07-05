<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جلسات مشاوره من</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; background-color: #f8f9fa; }
        .session-card { margin-bottom: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .status-badge { font-size: 0.8rem; padding: 3px 8px; border-radius: 12px; }
        .active-badge { background-color: #d4edda; color: #155724; }
        .completed-badge { background-color: #f8d7da; color: #721c24; }
        .tab-link { color: #6c757d; text-decoration: none; margin-left: 15px; }
        .tab-link.active { color: #0d6efd; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">جلسات مشاوره من</h1>
        
        <div class="mb-4">
            <a href="?status=active" class="tab-link {{ $currentStatus === 'active' ? 'active' : '' }}">جلسات فعال</a>
            <a href="?status=completed" class="tab-link {{ $currentStatus === 'completed' ? 'active' : '' }}">جلسات تکمیل شده</a>
        </div>
        
        @if($sessions->isEmpty())
            <div class="alert alert-info">
                هیچ جلسه‌ای با وضعیت "{{ $currentStatus === 'active' ? 'فعال' : 'تکمیل شده' }}" یافت نشد.
            </div>
        @else
            @foreach($sessions as $session)
                <div class="card session-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="card-title mb-0">جلسه #{{ $session->id }}</h5>
                            <span class="status-badge {{ $session->status === 'active' ? 'active-badge' : 'completed-badge' }}">
                                {{ $session->status === 'active' ? 'فعال' : 'تکمیل شده' }}
                            </span>
                        </div>
                        
                        <p class="card-text text-muted small mb-2">
                            <span>تاریخ ایجاد: {{ $session->created_at->format('Y/m/d H:i') }}</span>
                            <span class="mx-2">|</span>
                            <span>تعداد پیام‌ها: {{ $session->chat_messages_count }}</span>
                        </p>
                        
                        @if($session->messages->isNotEmpty())
                            <div class="last-message bg-light p-2 rounded mt-2">
                                <p class="mb-1"><strong>آخرین پیام:</strong></p>
                                <p class="mb-1">{{ Str::limit($session->messages->first()->message, 100) }}</p>
                                <p class="text-muted small mb-0">
                                    ارسال شده در: {{ $session->messages->first()->created_at->format('Y/m/d H:i') }}
                                </p>
                            </div>
                        @endif
                        
                        <a href="/doctors/{{ $session->id }}/chat" class="btn btn-sm btn-outline-primary mt-3">مشاهده گفتگو</a>
                    </div>
                </div>
            @endforeach
            
            <div class="mt-4">
                {{ $sessions->appends(['status' => $currentStatus])->links() }}
            </div>
        @endif
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>