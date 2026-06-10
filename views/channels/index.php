<?php
/**
 * Admin Channels Index View
 */
$title = 'Manage TV Channels';
require_once dirname(dirname(__DIR__)) . '/views/layouts/header.php';
?>

<div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-6 shadow-sm">
    <!-- Header Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-800/80 mb-6 gap-4">
        <div>
            <h3 class="text-lg font-bold text-white">Live Sports TV Channels</h3>
            <p class="text-xs text-slate-500 mt-1">Configure active channels for continuous streams (e.g. beIN Sports, SSC)</p>
        </div>
        
        <a href="index.php?page=admin_channels&action=create" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs tracking-wider uppercase transition shadow-lg shadow-indigo-500/10">
            <i class="fa-solid fa-plus mr-1.5 text-[10px]"></i> Add Channel
        </a>
    </div>

    <!-- Listings -->
    <?php if (empty($channels)): ?>
        <div class="text-center py-16 text-slate-500 border border-dashed border-slate-800 rounded-xl">
            <i class="fa-solid fa-tv text-4xl text-slate-700 mb-3 block"></i>
            <p class="text-sm">No channels found.</p>
            <p class="text-xs text-slate-600 mt-1">Get started by clicking the "Add Channel" button above.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-800/50 pb-3">
                        <th class="pb-3">Channel logo</th>
                        <th class="pb-3">Channel Name</th>
                        <th class="pb-3">Stream URL</th>
                        <th class="pb-3 text-center">Status</th>
                        <th class="pb-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50 text-sm">
                    <?php foreach ($channels as $c): ?>
                        <tr class="align-middle">
                            <!-- Logo -->
                            <td class="py-4">
                                <div class="w-12 h-12 rounded-lg bg-slate-950 flex items-center justify-center p-1.5 border border-slate-800">
                                    <?php if (!empty($c['logo'])): ?>
                                        <img src="../<?php echo htmlspecialchars($c['logo']); ?>" class="w-full h-full object-contain" alt="">
                                    <?php else: ?>
                                        <i class="fa-solid fa-tv text-slate-700"></i>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Name -->
                            <td class="py-4 font-semibold text-white">
                                <?php echo htmlspecialchars($c['name']); ?>
                            </td>

                            <!-- Stream URL -->
                            <td class="py-4 text-xs font-mono text-slate-400 max-w-xs truncate">
                                <?php echo htmlspecialchars(!empty($c['stream_url']) ? $c['stream_url'] : 'No default stream link'); ?>
                            </td>

                            <!-- Status Badge -->
                            <td class="py-4 text-center">
                                <?php if ($c['status'] === 'active'): ?>
                                    <span class="inline-flex items-center bg-emerald-500/15 text-emerald-400 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded border border-emerald-500/20">
                                        Active
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center bg-rose-500/15 text-rose-400 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded border border-rose-500/20">
                                        Inactive
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center space-x-2">
                                    <!-- Edit -->
                                    <a href="index.php?page=admin_channels&action=edit&id=<?php echo $c['id']; ?>" 
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-500/10 hover:bg-indigo-600 border border-indigo-500/20 text-indigo-400 hover:text-white transition">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <!-- Delete -->
                                    <a href="index.php?page=admin_channels&action=delete&id=<?php echo $c['id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this channel?');"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-500/10 hover:bg-rose-600 border border-rose-500/20 text-rose-400 hover:text-white transition">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once dirname(dirname(__DIR__)) . '/views/layouts/footer.php'; ?>
