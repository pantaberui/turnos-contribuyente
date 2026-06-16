@props(['active'])

@php
$style = ($active ?? false)
    ? 'display:inline-flex;align-items:center;padding:8px 14px;border-bottom:2px solid #f59e0b;color:white;background:#1e293b;border-radius:6px 6px 0 0;font-size:14px;font-weight:700;'
    : 'display:inline-flex;align-items:center;padding:8px 14px;border-bottom:2px solid transparent;color:#e2e8f0;background:transparent;border-radius:6px 6px 0 0;font-size:14px;font-weight:600;';
@endphp

<a
    {{ $attributes->merge(['style' => $style]) }}
    onmouseover="this.style.background='#1e293b'; this.style.color='white'; this.style.borderBottomColor='#60a5fa';"
    onmouseout="this.style.background='{{ ($active ?? false) ? '#1e293b' : 'transparent' }}'; this.style.color='{{ ($active ?? false) ? 'white' : '#e2e8f0' }}'; this.style.borderBottomColor='{{ ($active ?? false) ? '#f59e0b' : 'transparent' }}';"
>
    {{ $slot }}
</a>
