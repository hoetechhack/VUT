@component('layouts.public', ['title' => 'Contact Us'])
    <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1.5rem;">Contact Us</h1>
    <p style="font-size: 1.1rem; margin-bottom: 2rem;">We are here to help you with any issues or questions.</p>
    <div style="font-size: 1rem; color: var(--text); background: rgba(255,255,255,0.03); padding: 2.5rem; border-radius: 20px; border: 1px solid var(--glass-border); box-shadow: 0 15px 40px rgba(0,0,0,0.3);">
        <p style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;"><span style="font-size: 1.2rem;">📍</span> <strong>Address:</strong> 150 Agbani Road, Enugu South, Enugu State.</p>
        <p style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;"><span style="font-size: 1.2rem;">✉️</span> <strong>Email:</strong> info@codedragon.ng</p>
        <p style="margin-bottom: 2rem; display: flex; align-items: center; gap: 10px;"><span style="font-size: 1.2rem;">📞</span> <strong>Phone:</strong> +234 806 240 2415</p>
        
        <a href="https://wa.me/2348062402415" target="_blank" style="display: inline-flex; align-items: center; gap: 12px; background: #25D366; color: #fff; padding: 1rem 2rem; border-radius: 12px; text-decoration: none; font-weight: 800; font-size: 1rem; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            <svg style="width: 24px; height: 24px;" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12.031 6.172c-2.135 0-4.104 1.288-4.937 3.254-.37.884-.334 1.834.103 2.671l-.739 2.701 2.763-.724c.795.433 1.691.663 2.612.663 3.125 0 5.664-2.539 5.664-5.664s-2.539-5.664-5.664-5.664zM12.031 16.5c-1.071 0-2.106-.279-3.023-.809l-3.32.869 1.104-3.361c-.604-.984-.925-2.12-.925-3.292 0-3.568 2.906-6.474 6.474-6.474s6.474 2.906 6.474 6.474-2.906 6.474-6.474 6.474zM15.152 13.085c-.171-.085-1.012-.5-1.169-.557-.157-.057-.271-.085-.386.085-.114.171-.442.557-.542.671-.1.114-.2.128-.371.043-.171-.085-.722-.266-1.375-.849-.508-.453-.851-1.013-.951-1.185-.1-.171-.011-.264.075-.349.077-.077.171-.2.257-.3.085-.1.114-.171.171-.285.057-.114.028-.214-.014-.3-.043-.085-.386-.928-.528-1.271-.139-.335-.28-.289-.386-.294-.1-.005-.214-.006-.328-.006-.114 0-.3.043-.457.214-.157.171-.6.585-.6 1.428 0 .843.614 1.657.7 1.771.085.114 1.209 1.846 2.929 2.587.409.176.728.281.977.36.41.13.784.112 1.08.068.33-.049 1.012-.414 1.155-.814.143-.4.143-.743.1-.814-.043-.071-.157-.114-.328-.2z"/>
            </svg>
            Chat on WhatsApp
        </a>
    </div>
@endcomponent
