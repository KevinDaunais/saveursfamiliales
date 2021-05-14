(function($){

    $(window).scroll(function() {

        // selectors
        var $window = $(window),
            $body = $('body'),
            $panel = $('[data-bg-color]');

        // Change 33% earlier than scroll position so colour is there when you arrive.
        var scroll = $window.scrollTop() + ($window.height() / 5);

        $panel.each(function () {
            var $this = $(this);

            var root = document.documentElement;
            
            // if position is within range of this panel.
            // So position of (position of top of div <= scroll position) && (position of bottom of div > scroll position).
            // Remember we set the scroll to 33% earlier in scroll var.
            if ($this.position().top <= scroll && $this.position().top + $this.height() > scroll) {
                
            // Remove all classes on body with color-
            $body.removeClass(function (index, css) {
                return (css.match (/(^|\s)color-\S+/g) || []).join(' ');
            });

            root.style.setProperty('--bg', $(this).data('bg-color'));
            root.style.setProperty('--text-color', $(this).data('text-color'));
            }
        });    

    }).scroll();


    const toggleSwitch = document.querySelector('.theme__switcher.switcher--desktop input[type="checkbox"]');
    const MobileSwitch = document.querySelector('.switcher--mobile input[type="checkbox"]');

    const currentTheme = localStorage.getItem('theme');

    if (currentTheme) {
        document.documentElement.setAttribute('data-theme', currentTheme);
    
        if (currentTheme === 'dark') {
            toggleSwitch.checked = true;
            MobileSwitch.checked = true;

            $('body').addClass('disable--theme-transition');
        } else {
            toggleSwitch.checked = false;
            MobileSwitch.checked = false;
        }
    }

    function switchTheme(e) {
        
        $('body').removeClass('disable--theme-transition');
        
        if (e.target.checked) {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');

            toggleSwitch.checked = true;
            MobileSwitch.checked = true;
        }
        else {        
            document.documentElement.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
            toggleSwitch.checked = false;
            MobileSwitch.checked = false;
        }    
    }

    toggleSwitch.addEventListener('change', switchTheme, false);
    MobileSwitch.addEventListener('change', switchTheme, false);

})(jQuery);