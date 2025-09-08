jQuery(document).ready(function($) {
    // Password toggle functionality
    $('.password-toggle').on('click', function() {
        const input = $(this).siblings('input');
        const type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);
        
        // Toggle eye icon
        $(this).find('svg').toggleClass('hidden');
    });
    
    // Form submission animation
    $('form.login, form.register').on('submit', function() {
        $(this).find('button[type="submit"]').addClass('loading');
    });
    
    // Floating label effect
    $('.custom-input-wrapper input').each(function() {
        if ($(this).val() !== '') {
            $(this).siblings('label').addClass('active');
        }
    });
    
    // Background particles effect
    if ($('.custom-login-background').length) {
        for (let i = 0; i < 10; i++) {
            const particle = document.createElement('div');
            particle.className = 'login-particle';
            $('.custom-login-overlay').append(particle);
            
            // Random position and size
            const size = Math.random() * 20 + 5;
            const posX = Math.random() * 100;
            const posY = Math.random() * 100;
            const delay = Math.random() * 5;
            const duration = Math.random() * 10 + 10;
            
            $(particle).css({
                'width': `${size}px`,
                'height': `${size}px`,
                'left': `${posX}%`,
                'top': `${posY}%`,
                'animation-delay': `${delay}s`,
                'animation-duration': `${duration}s`,
                'opacity': Math.random() * 0.3 + 0.1
            });
        }
    }
});