<?php
/**
 * Frontend Settings / Info Page - Android App Style
 */
require_once dirname(dirname(__DIR__)) . '/views/frontend/header.php';

$siteName    = $common['settings']['site_name'] ?? 'KoraStream';
$siteDesc    = $common['settings']['site_description'] ?? '';
$facebookUrl = $common['settings']['facebook_url'] ?? '#';
$telegramUrl = $common['settings']['telegram_url'] ?? '#';
?>

<!-- App Header Card -->
<div class="px-4 pt-6 pb-4">
    <div class="bg-[#181E31] border border-slate-800/60 rounded-2xl p-6 flex flex-col items-center text-center space-y-3">
        <!-- Logo -->
        <div class="w-20 h-20 rounded-2xl bg-indigo-600/10 border border-indigo-500/20 flex items-center justify-center shadow-lg shadow-indigo-500/5">
            <?php if (!empty($common['settings']['site_logo'])): ?>
                <img src="<?php echo htmlspecialchars($common['settings']['site_logo']); ?>" class="w-14 h-14 object-contain" alt="Logo">
            <?php else: ?>
                <i class="fa-solid fa-circle-play text-indigo-400 text-4xl"></i>
            <?php endif; ?>
        </div>
        <!-- Name & Version -->
        <div>
            <h2 class="text-xl font-bold text-white"><?php echo htmlspecialchars($siteName); ?></h2>
            <?php if (!empty($siteDesc)): ?>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed"><?php echo htmlspecialchars($siteDesc); ?></p>
            <?php endif; ?>
        </div>
        <!-- Version badge -->
        <span class="text-[10px] bg-slate-900 text-slate-500 border border-slate-800 px-2.5 py-1 rounded-full uppercase tracking-widest font-semibold">Version 1.0.0</span>
    </div>
</div>

<!-- Social Links & Quick Actions -->
<div class="px-4 space-y-3 pb-4">
    <!-- Section Title -->
    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-1 pb-1">Quick Links</p>

    <!-- Facebook -->
    <?php if ($facebookUrl && $facebookUrl !== '#'): ?>
        <a href="<?php echo htmlspecialchars($facebookUrl); ?>" target="_blank"
           class="bg-[#181E31] border border-slate-800/60 rounded-2xl p-4 flex items-center space-x-4 hover:border-blue-500/40 active:scale-[0.98] transition-all duration-200 group">
            <div class="w-11 h-11 rounded-xl bg-blue-600/10 border border-blue-500/20 flex items-center justify-center shrink-0">
                <i class="fa-brands fa-facebook text-blue-500 text-xl"></i>
            </div>
            <div class="flex-grow min-w-0">
                <p class="font-semibold text-white text-sm">Facebook Page</p>
                <p class="text-xs text-slate-500 mt-0.5 truncate"><?php echo htmlspecialchars($facebookUrl); ?></p>
            </div>
            <i class="fa-solid fa-arrow-up-right-from-square text-slate-600 group-hover:text-blue-400 transition text-xs"></i>
        </a>
    <?php endif; ?>

    <!-- Telegram -->
    <?php if ($telegramUrl && $telegramUrl !== '#'): ?>
        <a href="<?php echo htmlspecialchars($telegramUrl); ?>" target="_blank"
           class="bg-[#181E31] border border-slate-800/60 rounded-2xl p-4 flex items-center space-x-4 hover:border-sky-500/40 active:scale-[0.98] transition-all duration-200 group">
            <div class="w-11 h-11 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center shrink-0">
                <i class="fa-brands fa-telegram text-sky-400 text-xl"></i>
            </div>
            <div class="flex-grow min-w-0">
                <p class="font-semibold text-white text-sm">Telegram Channel</p>
                <p class="text-xs text-slate-500 mt-0.5 truncate"><?php echo htmlspecialchars($telegramUrl); ?></p>
            </div>
            <i class="fa-solid fa-arrow-up-right-from-square text-slate-600 group-hover:text-sky-400 transition text-xs"></i>
        </a>
    <?php endif; ?>
</div>

<!-- App Info Section -->
<div class="px-4 space-y-3 pb-8">
    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-1 pb-1">App Info</p>

    <!-- Stream Quality -->
    <div class="bg-[#181E31] border border-slate-800/60 rounded-2xl overflow-hidden divide-y divide-slate-800/50">
        <div class="flex items-center justify-between px-4 py-3.5">
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-tower-broadcast text-emerald-400 w-5 text-center"></i>
                <span class="text-sm text-slate-300">Stream Quality</span>
            </div>
            <span class="text-xs font-bold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2 py-0.5 rounded">HD</span>
        </div>
        <div class="flex items-center justify-between px-4 py-3.5">
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-mobile-screen text-indigo-400 w-5 text-center"></i>
                <span class="text-sm text-slate-300">PWA Mode</span>
            </div>
            <span class="text-xs font-bold text-indigo-400">Supported</span>
        </div>
        <div class="flex items-center justify-between px-4 py-3.5">
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-code text-slate-500 w-5 text-center"></i>
                <span class="text-sm text-slate-300">Powered by</span>
            </div>
            <span class="text-xs text-slate-500">PHP + Tailwind CSS</span>
        </div>
    </div>

    <!-- Admin Panel Shortcut -->
    <a href="index.php?page=admin"
       class="w-full flex items-center justify-center space-x-2 py-3 rounded-xl bg-slate-900 border border-slate-800 text-slate-500 hover:text-white hover:bg-slate-800 transition text-xs font-semibold tracking-wider uppercase">
        <i class="fa-solid fa-lock text-xs"></i>
        <span>Admin Dashboard</span>
    </a>
</div>

<?php require_once dirname(dirname(__DIR__)) . '/views/frontend/footer.php'; ?>
