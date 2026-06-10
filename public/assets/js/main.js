/**
 * KoraStream Main JS Handler
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. PWA Service Worker Registration
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('../sw.js')
                .then(reg => console.log('Service Worker registered successfully.'))
                .catch(err => console.log('Service Worker registration failed:', err));
        });
    }

    // 2. Front-end Date Slider Clicks
    const datePills = document.querySelectorAll('.date-pill');
    datePills.forEach(pill => {
        pill.addEventListener('click', () => {
            const selectedDate = pill.getAttribute('data-date');
            if (selectedDate) {
                window.location.href = `index.php?date=${selectedDate}`;
            }
        });
    });

    // 3. Admin Sidebar Toggle for Desktop/Tablet
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const adminSidebar = document.getElementById('admin-sidebar');
    if (sidebarToggle && adminSidebar) {
        sidebarToggle.addEventListener('click', () => {
            adminSidebar.classList.toggle('-translate-x-full');
        });
    }

    // 4. Alert close triggers
    const closeButtons = document.querySelectorAll('.alert-close');
    closeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const alert = btn.closest('.alert-box');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        });
    });
});
