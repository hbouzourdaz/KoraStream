<?php
/**
 * Admin Leagues Form & List View
 */
$title = 'Manage Leagues';
require_once dirname(dirname(__DIR__)) . '/views/layouts/header.php';

$editLeague = isset($editLeague) ? $editLeague : null;
?>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- List Columns -->
    <div class="lg:col-span-8 bg-slate-900/60 border border-slate-800/80 rounded-2xl p-6 shadow-sm">
        <h3 class="text-base font-bold text-white mb-6 pb-3 border-b border-slate-800/80">Active Tournaments</h3>
        
        <?php if (empty($leagues)): ?>
            <div class="text-center py-12 text-slate-500 border border-dashed border-slate-800 rounded-xl">
                <i class="fa-solid fa-trophy text-3xl text-slate-700 mb-2 block"></i>
                <p class="text-sm">No leagues configured.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <?php foreach ($leagues as $l): ?>
                    <div class="bg-slate-950/40 border border-slate-800/60 p-4 rounded-xl flex items-center justify-between hover:border-indigo-500/50 transition">
                        <div class="flex items-center space-x-3.5 min-w-0">
                            <div class="w-12 h-12 rounded-lg bg-slate-900 flex items-center justify-center p-1.5 border border-slate-800 shrink-0">
                                <?php if (!empty($l['logo'])): ?>
                                    <img src="../<?php echo htmlspecialchars($l['logo']); ?>" class="w-full h-full object-contain" alt="">
                                <?php else: ?>
                                    <i class="fa-solid fa-trophy text-slate-600"></i>
                                <?php endif; ?>
                            </div>
                            <span class="font-semibold text-white text-sm truncate"><?php echo htmlspecialchars($l['name']); ?></span>
                        </div>

                        <div class="flex items-center space-x-2 shrink-0">
                            <!-- Edit -->
                            <a href="index.php?page=admin_leagues&edit_id=<?php echo $l['id']; ?>"
                               class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-500/10 hover:bg-indigo-600 text-indigo-400 hover:text-white transition">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <!-- Delete -->
                            <a href="index.php?page=admin_leagues&action=delete&id=<?php echo $l['id']; ?>"
                               onclick="return confirm('Are you sure you want to delete this tournament? All matches bound to this tournament will be deleted.');"
                               class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-rose-500/10 hover:bg-rose-600 text-rose-400 hover:text-white transition">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Form Column -->
    <div class="lg:col-span-4 bg-slate-900/60 border border-slate-800/80 rounded-2xl p-6 shadow-sm self-start">
        <h3 class="text-base font-bold text-white mb-6 pb-3 border-b border-slate-800/80">
            <?php echo $editLeague ? 'Edit Tournament' : 'Add Tournament'; ?>
        </h3>

        <form action="<?php echo $editLeague ? 'index.php?page=admin_leagues&action=update&id=' . $editLeague['id'] : 'index.php?page=admin_leagues&action=store'; ?>" 
              method="POST" enctype="multipart/form-data" class="space-y-4">
            
            <!-- League Name -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Tournament Name</label>
                <input type="text" name="name" value="<?php echo $editLeague ? htmlspecialchars($editLeague['name']) : ''; ?>" required placeholder="e.g. Champions League"
                       class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>

            <!-- Logo Upload -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Logo Image</label>
                
                <?php if ($editLeague && !empty($editLeague['logo'])): ?>
                    <div class="mb-3 flex items-center space-x-3 bg-slate-950/30 p-2 rounded-xl border border-slate-800">
                        <img src="../<?php echo htmlspecialchars($editLeague['logo']); ?>" class="w-10 h-10 object-contain rounded" alt="">
                        <span class="text-xs text-slate-500">Current Logo</span>
                    </div>
                <?php endif; ?>

                <input type="file" name="logo" <?php echo $editLeague ? '' : 'required'; ?> accept="image/*"
                       class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2 text-white text-xs file:mr-4 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-indigo-600/20 file:text-indigo-400 hover:file:bg-indigo-600/30 file:cursor-pointer">
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between">
                <?php if ($editLeague): ?>
                    <a href="index.php?page=admin_leagues" class="text-xs text-slate-400 hover:text-white transition">Cancel</a>
                <?php else: ?>
                    <div></div>
                <?php endif; ?>
                
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs tracking-wider uppercase transition shadow-lg shadow-indigo-500/10">
                    <?php echo $editLeague ? 'Save Changes' : 'Create'; ?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once dirname(dirname(__DIR__)) . '/views/layouts/footer.php'; ?>
