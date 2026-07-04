@props(['height' => '56'])
@php($uid = uniqid())
<div style="height: {{ $height }}px; width: auto; display: flex; align-items: center;" {{ $attributes }}>
    <svg viewBox="0 0 380 140" style="height: 100%; width: auto;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="text-{{ $uid }}" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="50%" stop-color="#ffffff"/>
                <stop offset="50%" stop-color="#B91C1C"/>
            </linearGradient>

            <radialGradient id="badge-{{ $uid }}" cx="35%" cy="30%" r="75%">
                <stop offset="0%" stop-color="#E11D2E"/>
                <stop offset="55%" stop-color="#B91C1C"/>
                <stop offset="100%" stop-color="#5A0D0D"/>
            </radialGradient>

            <linearGradient id="scale-{{ $uid }}" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" stop-color="#FFD98A"/>
                <stop offset="45%" stop-color="#F5B942"/>
                <stop offset="100%" stop-color="#B9791E"/>
            </linearGradient>

            <linearGradient id="horn-{{ $uid }}" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#FFE9B8"/>
                <stop offset="100%" stop-color="#C8901F"/>
            </linearGradient>

            <radialGradient id="shine-{{ $uid }}" cx="32%" cy="24%" r="40%">
                <stop offset="0%" stop-color="#ffffff" stop-opacity="0.55"/>
                <stop offset="100%" stop-color="#ffffff" stop-opacity="0"/>
            </radialGradient>

            <filter id="depth-{{ $uid }}" x="-40%" y="-40%" width="180%" height="180%">
                <feDropShadow dx="0" dy="3" stdDeviation="2.5" flood-color="#000000" flood-opacity="0.45"/>
            </filter>
        </defs>

        <g filter="url(#depth-{{ $uid }})">
            <g transform="translate(18,26)">
                <!-- badge base -->
                <circle cx="42" cy="44" r="40" fill="url(#badge-{{ $uid }})"/>
                <circle cx="42" cy="44" r="40" fill="none" stroke="#3A0808" stroke-width="1.5" opacity="0.6"/>

                <!-- horns -->
                <path d="M22 12 L30 30 L14 27 Z" fill="url(#horn-{{ $uid }})"/>
                <path d="M62 12 L54 30 L70 27 Z" fill="url(#horn-{{ $uid }})"/>

                <!-- dragon head / snout -->
                <path d="M12 46 Q42 14 72 46 Q58 40 42 43 Q26 40 12 46 Z" fill="url(#scale-{{ $uid }})"/>
                <path d="M18 56 Q42 74 66 56 Q54 66 42 66 Q30 66 18 56 Z" fill="url(#scale-{{ $uid }})"/>

                <!-- nostrils/brow ridge for depth -->
                <path d="M28 44 Q42 38 56 44" stroke="#5A0D0D" stroke-width="2" fill="none" opacity="0.5"/>

                <!-- eyes -->
                <circle cx="31" cy="43" r="3.6" fill="#2A0505"/>
                <circle cx="53" cy="43" r="3.6" fill="#2A0505"/>
                <circle cx="32.2" cy="41.7" r="1.1" fill="#ffffff"/>
                <circle cx="54.2" cy="41.7" r="1.1" fill="#ffffff"/>

                <!-- fang -->
                <path d="M36 54 L42 64 L48 54 Z" fill="#FFF6E0"/>

                <!-- glossy highlight over the whole badge -->
                <circle cx="42" cy="44" r="40" fill="url(#shine-{{ $uid }})"/>
            </g>
        </g>

        <text x="112" y="85" font-family="Inter, Poppins, Arial, sans-serif" font-size="46" font-weight="900" letter-spacing="0.5" fill="url(#text-{{ $uid }})">CodeDragon</text>
    </svg>
</div>
