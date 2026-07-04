@props(['height' => '56'])
@php($gid = 'splitColor' . uniqid())
<div style="height: {{ $height }}px; width: auto; display: flex; align-items: center;" {{ $attributes }}>
    <svg viewBox="0 0 380 140" style="height: 100%; width: auto;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="{{ $gid }}" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="50%" stop-color="#ffffff"/>
                <stop offset="50%" stop-color="#B91C1C"/>
            </linearGradient>
        </defs>
        <g>
            <g transform="translate(20,28)">
                <circle cx="40" cy="42" r="34" fill="#7A0E17"/>
                <path fill="#F5B942" d="M22 14 L28 26 L18 24 Z"/>
                <path fill="#F5B942" d="M58 14 L52 26 L62 24 Z"/>
                <path fill="#B91C1C" d="M12 44 Q40 18 68 44 Q54 40 40 42 Q26 40 12 44 Z"/>
                <path fill="#B91C1C" d="M18 52 Q40 66 62 52 Q52 60 40 60 Q28 60 18 52 Z"/>
                <circle cx="30" cy="40" r="3.4" fill="#F5B942"/>
                <circle cx="50" cy="40" r="3.4" fill="#F5B942"/>
                <path fill="#B91C1C" d="M34 50 L40 58 L46 50 Z"/>
            </g>
            <text x="110" y="85" font-family="Inter, Poppins, Arial, sans-serif" font-size="46" font-weight="900" letter-spacing="0.5" fill="url(#{{ $gid }})">CodeDragon</text>
        </g>
    </svg>
</div>
