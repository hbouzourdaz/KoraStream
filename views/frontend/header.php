<?php
/**
 * Frontend Android-Style App Header
 * Top App Bar with branding, search, and Telegram shortcut
 */
$siteName = $common['settings']['site_name'] ?? 'KoraStream';
$telegramUrl = $common['settings']['telegram_url'] ?? '#';
$currentPage = isset($_GET['page']) ? trim($_GET['page']) : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#090D16">
    <meta name="description" content="<?php echo htmlspecialchars($common['settings']['site_description'] ?? 'Watch live football matches in HD'); ?>">
    <title><?php echo htmlspecialchars($siteName); ?> - Live Sports Streaming</title>
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="../manifest.json">
    
    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'app-bg': '#0F1322',
                        'app-bar': '#090D16',
                        'app-card': '#181E31',
                        'app-border': '#1E293B',
                    },
                    fontFamily: {
                        'outfit': ['Outfit', 'sans-serif'],
                        'inter': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Hls.js -->
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/tailwind-custom.css">

    <?php if (!empty($common['settings']['custom_head_code'])): ?>
        <?php echo $common['settings']['custom_head_code']; ?>
    <?php endif; ?>

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5 { font-family: 'Outfit', sans-serif; }
        /* Safe area insets for Android PWA */
        .safe-top { padding-top: env(safe-area-inset-top); }
        .safe-bottom { padding-bottom: env(safe-area-inset-bottom); }
    </style>
</head>
<body class="bg-[#0F1322] text-slate-300 antialiased">

    <!-- Android App Shell Container (max-w-md centers it on desktop like a phone) -->
    <div class="max-w-md mx-auto min-h-screen flex flex-col relative shadow-2xl shadow-black/60 bg-[#0F1322]">
        
        <!-- Popunder Ad Injection (if active) -->
        <?php if (!empty($common['ads']['popunder']['code'])): ?>
            <?php echo $common['ads']['popunder']['code']; ?>
        <?php endif; ?>

        <!-- TOP APP BAR -->
        <header class="sticky top-0 z-40 bg-[#090D16]/95 backdrop-blur-md border-b border-slate-900/80 safe-top">
            <div class="flex items-center justify-between h-14 px-4">
                <!-- Left: Brand Logo + Name -->
                <div class="flex items-center space-x-2">
                    <?php if (!empty($common['settings']['site_logo'])): ?>
                        <img src="<?php echo htmlspecialchars($common['settings']['site_logo']); ?>" class="h-8 w-8 object-contain rounded-lg" alt="Logo">
                    <?php else: ?>
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/15 border border-emerald-500/25 flex items-center justify-center">
                            <i class="fa-solid fa-circle-play text-emerald-400 text-sm"></i>
                        </div>
                    <?php endif; ?>
                    <span class="font-bold text-white text-lg tracking-wide" style="font-family: 'Outfit', sans-serif;">
                        <?php echo htmlspecialchars($siteName); ?>
                    </span>
                </div>

                <!-- Right: Telegram + Search Buttons -->
                <div class="flex items-center space-x-1">
                    <!-- Telegram Badge -->
                    <a href="<?php echo htmlspecialchars($telegramUrl); ?>" target="_blank"
                       class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sky-400 hover:text-white hover:bg-sky-500/10 transition">
                        <i class="fa-brands fa-telegram text-lg"></i>
                    </a>
                    <!-- Search Toggle -->
                    <button id="search-toggle-btn" class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Expandable Search Bar (hidden by default) -->
            <div id="search-bar-container" class="hidden px-4 pb-3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-slate-500 text-sm"></i>
                    </div>
                    <input type="text" id="search-input" placeholder="Search matches, teams..."
                           class="w-full bg-slate-900 border border-slate-800 rounded-xl pl-9 pr-4 py-2 text-white text-sm focus:outline-none focus:border-indigo-500 transition placeholder-slate-600">
                </div>
            </div>
        </header>

        <!-- Banner Ad Header Slot -->
        <?php if (!empty($common['ads']['banner_header']['code'])): ?>
            <div class="px-4 py-2">
                <?php echo $common['ads']['banner_header']['code']; ?>
            </div>
        <?php endif; ?>

        <!-- Main Scrollable Page Content Starts Here -->
        <div class="flex-grow overflow-y-auto pb-20">
