<?php
/**
 * Frontend Android-Style Bottom Navigation Bar + Closing Tags
 */
$currentPage = isset($activeTab) ? $activeTab : 'home';

function navItem($page, $icon, $label, $currentPage) {
    $href = "index.php?page={$page}";
    $isActive = ($currentPage === $page);
    $pillClass = $isActive
        ? 'flex flex-col items-center justify-center px-4 py-1 rounded-2xl bg-indigo-600/20 text-indigo-400 transition-all duration-300'
        : 'flex flex-col items-center justify-center px-4 py-1 rounded-2xl text-slate-500 hover:text-slate-300 transition-all duration-300';
    $labelClass = $isActive ? 'text-indigo-400 font-semibold' : 'text-slate-500';
    return <<<HTML
        <a href="{$href}" class="{$pillClass}">
            <i class="{$icon} text-lg"></i>
            <span class="text-[10px] mt-0.5 {$labelClass}">{$label}</span>
        </a>
    HTML;
}
?>
        </div><!-- End page content scrollable area -->

        <!-- ANDROID BOTTOM NAVIGATION BAR -->
        <nav class="fixed bottom-0 left-0 right-0 max-w-md mx-auto z-50 safe-bottom">
            <div class="h-16 bg-[#090D16]/95 backdrop-blur-md border-t border-slate-900/80 flex items-center justify-around px-2">
                <?php echo navItem('home', 'fa-solid fa-futbol', 'Home', $currentPage); ?>
                <?php echo navItem('channels', 'fa-solid fa-tv', 'Channels', $currentPage); ?>
                <?php echo navItem('leagues', 'fa-solid fa-trophy', 'Leagues', $currentPage); ?>
                <?php echo navItem('settings', 'fa-solid fa-circle-info', 'Info', $currentPage); ?>
            </div>
        </nav>

    </div><!-- End max-w-md app shell -->

    <!-- JS Scripts -->
    <script src="assets/js/bottom-sheet.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
    // Search bar toggle
    const searchBtn = document.getElementById('search-toggle-btn');
    const searchBar = document.getElementById('search-bar-container');
    const searchInput = document.getElementById('search-input');
    if (searchBtn && searchBar) {
        searchBtn.addEventListener('click', () => {
            searchBar.classList.toggle('hidden');
            if (!searchBar.classList.contains('hidden')) {
                searchInput?.focus();
            }
        });
    }
    </script>
</body>
</html>
