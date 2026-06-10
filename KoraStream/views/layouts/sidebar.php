<?php
/**
 * Admin Sidebar Template
 */
$currentPage = isset($_GET['page']) ? trim($_GET['page']) : 'admin';

// Helper function to return active navigation style
function navLinkActive($pageKey, $currentPage) {
    if ($currentPage === $pageKey) {
        return 'bg-indigo-600 text-white font-medium shadow-md shadow-indigo-500/10 border-indigo-400';
    }
    return 'text-slate-400 hover:text-white hover:bg-slate-900 border-transparent';
}
?>

<div id="admin-sidebar" class="w-64 bg-[#090D16] border-r border-slate-900 flex flex-col justify-between shrink-0 fixed inset-y-0 left-0 lg:sticky z-30 transition-transform duration-300 lg:translate-x-0 -translate-x-full">
    <!-- Brand Header -->
    <div class="h-16 border-b border-slate-900 flex items-center justify-between px-6 bg-[#0F1322]">
        <a href="index.php?page=admin" class="flex items-center space-x-2">
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                <i class="fa-solid fa-circle-play text-sm"></i>
            </span>
            <span class="font-bold text-white tracking-wide text-lg">KoraStream</span>
            <span class="text-[9px] bg-indigo-600/20 text-indigo-400 border border-indigo-500/20 px-1.5 py-0.5 rounded uppercase font-semibold">Admin</span>
        </a>
    </div>

    <!-- Navigation links -->
    <nav class="flex-grow py-6 px-4 space-y-1 overflow-y-auto no-scrollbar">
        <!-- Dashboard -->
        <a href="index.php?page=admin" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border-l-2 text-sm transition <?php echo navLinkActive('admin', $currentPage); ?>">
            <i class="fa-solid fa-chart-pie text-base w-5 text-center"></i>
            <span>Overview</span>
        </a>

        <!-- Matches -->
        <a href="index.php?page=admin_matches" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border-l-2 text-sm transition <?php echo navLinkActive('admin_matches', $currentPage); ?>">
            <i class="fa-solid fa-futbol text-base w-5 text-center"></i>
            <span>Matches</span>
        </a>

        <!-- Leagues -->
        <a href="index.php?page=admin_leagues" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border-l-2 text-sm transition <?php echo navLinkActive('admin_leagues', $currentPage); ?>">
            <i class="fa-solid fa-trophy text-base w-5 text-center"></i>
            <span>Leagues</span>
        </a>

        <!-- Teams -->
        <a href="index.php?page=admin_teams" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border-l-2 text-sm transition <?php echo navLinkActive('admin_teams', $currentPage); ?>">
            <i class="fa-solid fa-people-group text-base w-5 text-center"></i>
            <span>Teams</span>
        </a>

        <!-- TV Channels -->
        <a href="index.php?page=admin_channels" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border-l-2 text-sm transition <?php echo navLinkActive('admin_channels', $currentPage); ?>">
            <i class="fa-solid fa-tv text-base w-5 text-center"></i>
            <span>TV Channels</span>
        </a>

        <div class="h-px bg-slate-900 my-4 mx-4"></div>

        <!-- Ad Settings -->
        <a href="index.php?page=admin_ads" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border-l-2 text-sm transition <?php echo navLinkActive('admin_ads', $currentPage); ?>">
            <i class="fa-solid fa-rectangle-ad text-base w-5 text-center"></i>
            <span>Ad Settings</span>
        </a>

        <!-- Settings -->
        <a href="index.php?page=admin_settings" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border-l-2 text-sm transition <?php echo navLinkActive('admin_settings', $currentPage); ?>">
            <i class="fa-solid fa-sliders text-base w-5 text-center"></i>
            <span>App Settings</span>
        </a>
        <div class="h-px bg-slate-900 my-4 mx-4"></div>

    </nav>

    <!-- Logout footer -->
    <div class="p-4 border-t border-slate-900">
        <a href="index.php?page=admin&action=logout" class="w-full flex items-center space-x-3 px-4 py-2.5 text-rose-400 hover:text-white hover:bg-rose-500/10 rounded-xl text-sm transition">
            <i class="fa-solid fa-power-off text-base w-5 text-center"></i>
            <span class="font-medium">Logout Session</span>
        </a>
    </div>
</div>
