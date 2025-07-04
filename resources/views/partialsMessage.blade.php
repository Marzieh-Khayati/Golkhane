@php
    $alignClass = $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start';
    $bgClass = $message->sender_id == auth()->id() ? 'bg-blue-100' : 'bg-gray-200';
@endphp

<div class="flex {{ $alignClass }} mb-2">
    <div class="p-3 rounded-lg max-w-xs lg:max-w-md {{ $bgClass }}">
        <p class="text-gray-800">{{ $message->message_text }}</p>
        <p class="text-xs text-gray-500 text-left mt-1">
            {{ \Carbon\Carbon::parse($message->created_at)->locale('fa')->isoFormat('HH:mm') }}
            <i class="fas fa-check text-gray-400 ml-1"></i>
        </p>
    </div>
</div>
