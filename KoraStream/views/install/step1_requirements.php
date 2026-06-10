<?php
/**
 * Installer Step 1 View - Requirements Check
 */
$allPassed = !in_array(false, $reqs, true);
?>

<div class="space-y-4">
    <h2 class="text-lg font-semibold text-white">System Requirements</h2>
    <p class="text-sm text-slate-400">Checking your server configuration before installing.</p>

    <div class="space-y-3 bg-slate-950/45 p-4 rounded-2xl border border-slate-800/40">
        <!-- PHP Version -->
        <div class="flex items-center justify-between text-sm">
            <span class="text-slate-300">PHP Version >= 7.4.0 <span class="text-xs text-slate-500">(Installed: <?php echo PHP_VERSION; ?>)</span></span>
            <span>
                <?php if ($reqs['php_version']): ?>
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <?php else: ?>
                    <i class="fa-solid fa-circle-xmark text-rose-500"></i>
                <?php endif; ?>
            </span>
        </div>

        <!-- PDO Extension -->
        <div class="flex items-center justify-between text-sm">
            <span class="text-slate-300">PDO PHP Extension</span>
            <span>
                <?php if ($reqs['pdo']): ?>
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <?php else: ?>
                    <i class="fa-solid fa-circle-xmark text-rose-500"></i>
                <?php endif; ?>
            </span>
        </div>

        <!-- PDO MySQL Extension -->
        <div class="flex items-center justify-between text-sm">
            <span class="text-slate-300">PDO MySQL PHP Extension</span>
            <span>
                <?php if ($reqs['pdo_mysql']): ?>
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <?php else: ?>
                    <i class="fa-solid fa-circle-xmark text-rose-500"></i>
                <?php endif; ?>
            </span>
        </div>

        <!-- Mbstring Extension -->
        <div class="flex items-center justify-between text-sm">
            <span class="text-slate-300">Mbstring PHP Extension</span>
            <span>
                <?php if ($reqs['mbstring']): ?>
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <?php else: ?>
                    <i class="fa-solid fa-circle-xmark text-rose-500"></i>
                <?php endif; ?>
            </span>
        </div>

        <!-- JSON Extension -->
        <div class="flex items-center justify-between text-sm">
            <span class="text-slate-300">JSON PHP Extension</span>
            <span>
                <?php if ($reqs['json']): ?>
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <?php else: ?>
                    <i class="fa-solid fa-circle-xmark text-rose-500"></i>
                <?php endif; ?>
            </span>
        </div>

        <!-- Env Writable -->
        <div class="flex items-center justify-between text-sm">
            <span class="text-slate-300">Root Directory Writable <span class="text-xs text-slate-500">(For .env setup)</span></span>
            <span>
                <?php if ($reqs['env_writable']): ?>
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <?php else: ?>
                    <i class="fa-solid fa-circle-xmark text-rose-500"></i>
                <?php endif; ?>
            </span>
        </div>

        <!-- Uploads Writable -->
        <div class="flex items-center justify-between text-sm">
            <span class="text-slate-300">Uploads Directory Writable <span class="text-xs text-slate-500">(For logos/images)</span></span>
            <span>
                <?php if ($reqs['uploads_writable']): ?>
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <?php else: ?>
                    <i class="fa-solid fa-circle-xmark text-rose-500"></i>
                <?php endif; ?>
            </span>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end pt-4">
        <?php if ($allPassed): ?>
            <a href="install.php?step=2" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm transition shadow-lg shadow-indigo-500/10">
                Continue <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
        <?php else: ?>
            <button disabled class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-slate-800 text-slate-600 font-medium text-sm cursor-not-allowed">
                Fix requirements to continue
            </button>
        <?php endif; ?>
    </div>
</div>
