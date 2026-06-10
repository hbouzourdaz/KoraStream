<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KoraStream - Web Installer</title>
    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-[#0B0F19] text-slate-300 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Background abstract glowing orbs -->
    <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] rounded-full bg-indigo-500/10 blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-emerald-500/10 blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-xl bg-slate-900/70 border border-slate-800/80 rounded-3xl p-6 md:p-8 backdrop-blur-md shadow-2xl relative z-10">
        <!-- Brand Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600/20 text-indigo-400 border border-indigo-500/20 mb-4 shadow-lg shadow-indigo-500/5 animate-pulse">
                <i class="fa-solid fa-cloud-arrow-down text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-wide">KoraStream Installer</h1>
            <p class="text-xs text-slate-500 mt-1">Setup your live sports streaming platform in 4 simple steps</p>
        </div>

        <!-- Progress Indicator -->
        <div class="flex items-center justify-between mb-8 relative px-4">
            <!-- Background bar -->
            <div class="absolute left-10 right-10 top-1/2 h-1 bg-slate-800 -translate-y-1/2 z-0"></div>
            <!-- Active progress bar -->
            <div class="absolute left-10 top-1/2 h-1 bg-gradient-to-r from-indigo-500 to-emerald-500 -translate-y-1/2 z-0 transition-all duration-500" 
                 style="width: <?php echo (($step - 1) / 3) * 80; ?>%;"></div>

            <!-- Step Circles -->
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <?php 
                    $isActive = ($i === $step);
                    $isDone = ($i < $step);
                    $circleClass = 'w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm border-2 z-10 transition-all duration-300 ';
                    if ($isActive) {
                        $circleClass .= 'bg-indigo-600 border-indigo-400 text-white shadow-lg shadow-indigo-500/30 scale-110';
                    } elseif ($isDone) {
                        $circleClass .= 'bg-emerald-600 border-emerald-400 text-white';
                    } else {
                        $circleClass .= 'bg-slate-900 border-slate-800 text-slate-500';
                    }
                ?>
                <div class="<?php echo $circleClass; ?>">
                    <?php if ($isDone): ?>
                        <i class="fa-solid fa-check text-xs"></i>
                    <?php else: ?>
                        <?php echo $i; ?>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Dynamic Content Body -->
        <div class="mb-6">
            <?php 
                switch ($step) {
                    case 1:
                        require_once 'step1_requirements.php';
                        break;
                    case 2:
                        require_once 'step2_database.php';
                        break;
                    case 3:
                        require_once 'step3_admin.php';
                        break;
                    case 4:
                        require_once 'step4_finish.php';
                        break;
                }
            ?>
        </div>
    </div>
</body>
</html>
