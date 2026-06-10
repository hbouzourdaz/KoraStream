            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile Sidebar Toggle
            const toggleBtn = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('admin-sidebar');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle('-translate-x-full');
                });
                
                // Close sidebar when clicking outside of it on mobile
                document.addEventListener('click', (e) => {
                    if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                        sidebar.classList.add('-translate-x-full');
                    }
                });
            }

            // Alert dismissals
            document.querySelectorAll('.alert-close').forEach(btn => {
                btn.addEventListener('click', () => {
                    const alert = btn.closest('.alert-box');
                    if (alert) {
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 300);
                    }
                });
            });
        });
    </script>
</body>
</html>
