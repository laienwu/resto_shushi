document.addEventListener('DOMContentLoaded', function () {
    var menuToggle = document.querySelector('[data-menu-toggle]');
    var menu = document.getElementById('primary-menu');

    if (menuToggle && menu) {
        menuToggle.addEventListener('click', function () {
            var isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';

            menuToggle.setAttribute('aria-expanded', String(!isExpanded));
            menu.classList.toggle('is-open', !isExpanded);
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 920) {
                menu.classList.remove('is-open');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
});
