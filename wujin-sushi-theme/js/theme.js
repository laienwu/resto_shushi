document.addEventListener('DOMContentLoaded', function () {
    var menuToggle = document.querySelector('[data-menu-toggle]');
    var menu = document.getElementById('primary-menu');
    var categoryLinks = Array.prototype.slice.call(document.querySelectorAll('[data-category-link]'));
    var categoryPanels = Array.prototype.slice.call(document.querySelectorAll('[data-category-panel]'));

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

    if (!categoryLinks.length || !categoryPanels.length) {
        return;
    }

    function setActiveCategory(targetId) {
        categoryLinks.forEach(function (link) {
            var linkTarget = link.getAttribute('href');
            link.classList.toggle('active', linkTarget === '#' + targetId);
        });
    }

    categoryLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            var targetId = link.getAttribute('href');

            if (targetId) {
                setActiveCategory(targetId.replace('#', ''));
            }
        });
    });

    if ('IntersectionObserver' in window) {
        var categoryObserver = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        setActiveCategory(entry.target.id);
                    }
                });
            },
            {
                rootMargin: '-28% 0px -58% 0px',
                threshold: 0,
            }
        );

        categoryPanels.forEach(function (panel) {
            categoryObserver.observe(panel);
        });
    }
});
