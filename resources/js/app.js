import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const currentPath = window.location.pathname;
    document.querySelectorAll('.sidebar-menu a').forEach((link) => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
            const parentDropdown = link.closest('.collapse');
            if (parentDropdown) {
                parentDropdown.classList.add('show');
            }
        }
    });
});
