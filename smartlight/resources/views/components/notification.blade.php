<div id="notification-container" class="fixed inset-x-0 top-4 flex items-center justify-center z-50 transform transition-transform duration-300 -translate-y-full">
    <div id="notification-content" class="flex items-center p-4 max-w-xs sm:max-w-sm md:max-w-md space-x-4 bg-white dark:bg-gray-700 rounded-lg shadow-lg border-l-4 border-green-500">
        <div id="notification-icon" class="text-green-500 dark:text-green-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="flex-1 pr-2">
            <p id="notification-title" class="text-sm font-medium text-gray-900 dark:text-white">Success</p>
            <p id="notification-message" class="text-sm text-gray-500 dark:text-gray-400">Operation completed successfully.</p>
        </div>
        <button id="notification-close" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<script>
    // Notification system
    const notification = {
        container: document.getElementById('notification-container'),
        content: document.getElementById('notification-content'),
        icon: document.getElementById('notification-icon'),
        title: document.getElementById('notification-title'),
        message: document.getElementById('notification-message'),
        closeBtn: document.getElementById('notification-close'),
        timeout: null,
        
        show: function(type, title, message, duration = 5000) {
            // Clear any existing timeout
            if (this.timeout) {
                clearTimeout(this.timeout);
            }
            
            // Set content
            this.title.textContent = title;
            this.message.textContent = message;
            
            // Set type-specific styling
            this.content.classList.remove('border-green-500', 'border-red-500', 'border-yellow-500', 'border-blue-500');
            this.icon.classList.remove('text-green-500', 'text-red-500', 'text-yellow-500', 'text-blue-500', 
                                     'dark:text-green-400', 'dark:text-red-400', 'dark:text-yellow-400', 'dark:text-blue-400');
            
            let iconSvgPath = '';
            switch (type) {
                case 'success':
                    this.content.classList.add('border-green-500');
                    this.icon.classList.add('text-green-500', 'dark:text-green-400');
                    iconSvgPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                    break;
                case 'error':
                    this.content.classList.add('border-red-500');
                    this.icon.classList.add('text-red-500', 'dark:text-red-400');
                    iconSvgPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                    break;
                case 'warning':
                    this.content.classList.add('border-yellow-500');
                    this.icon.classList.add('text-yellow-500', 'dark:text-yellow-400');
                    iconSvgPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>';
                    break;
                case 'info':
                default:
                    this.content.classList.add('border-blue-500');
                    this.icon.classList.add('text-blue-500', 'dark:text-blue-400');
                    iconSvgPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                    break;
            }
            
            this.icon.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">${iconSvgPath}</svg>`;
            
            // Show notification
            this.container.classList.remove('-translate-y-full');
            this.container.classList.add('translate-y-0');
            
            // Auto-hide after duration
            if (duration > 0) {
                this.timeout = setTimeout(() => this.hide(), duration);
            }
        },
        
        hide: function() {
            this.container.classList.remove('translate-y-0');
            this.container.classList.add('-translate-y-full');
        }
    };
    
    // Set up close button event listener
    notification.closeBtn.addEventListener('click', () => notification.hide());
    
    // Expose globally
    window.showNotification = function(type, title, message, duration) {
        notification.show(type, title, message, duration);
    };
</script>
