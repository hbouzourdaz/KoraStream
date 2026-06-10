<?php
/**
 * Frontend Leagues / Tournaments Grid Page - Android App Style
 */
require_once dirname(dirname(__DIR__)) . '/views/frontend/header.php';
?>

<!-- Page Title -->
<div class="px-4 pt-5 pb-3">
    <h2 class="text-xl font-bold text-white">Leagues & Tournaments</h2>
    <p class="text-xs text-slate-500 mt-1">Tap a league to view its upcoming matches</p>
</div>

<!-- Leagues Grid -->
<div class="px-3 pb-4">
    <?php if (empty($leagues)): ?>
        <div class="flex flex-col items-center justify-center py-24 text-center space-y-4">
            <div class="w-20 h-20 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-4xl text-slate-700">
                <i class="fa-solid fa-trophy"></i>
            </div>
            <div>
                <p class="text-white font-semibold text-lg">No Leagues Found</p>
                <p class="text-slate-500 text-sm mt-1">Leagues will appear here once configured.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-2 gap-3">
            <?php foreach ($leagues as $league): ?>
                <a href="index.php?page=home&league_id=<?php echo $league['id']; ?>"
                   class="bg-[#181E31] border border-slate-800/60 rounded-2xl p-4 flex flex-col items-center justify-center space-y-3
                          hover:border-amber-500/40 hover:bg-[#1e2438] active:scale-[0.97] transition-all duration-200 text-center group">
                    
                    <!-- League Logo -->
                    <div class="w-16 h-16 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center p-2.5 group-hover:border-amber-500/30 transition">
                        <?php if (!empty($league['logo'])): ?>
                            <img src="uploads/<?php echo ltrim(htmlspecialchars($league['logo']), 'uploads/'); ?>" class="w-full h-full object-contain" alt="">
                        <?php else: ?>
                            <i class="fa-solid fa-trophy text-3xl text-amber-500/50"></i>
                        <?php endif; ?>
                    </div>

                    <!-- League Name -->
                    <p class="text-sm font-bold text-white leading-tight group-hover:text-amber-300 transition-colors">
                        <?php echo htmlspecialchars($league['name']); ?>
                    </p>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once dirname(dirname(__DIR__)) . '/views/frontend/footer.php'; ?>
