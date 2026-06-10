<?php
/**
 * Admin Channels Add/Edit Form View
 */
$title = isset($title) ? $title : 'Channel Settings';
require_once dirname(dirname(__DIR__)) . '/views/layouts/header.php';

$channel = isset($channel) ? $channel : null;
?>

<div class="max-w-2xl mx-auto bg-slate-900/60 border border-slate-800/80 rounded-2xl p-6 shadow-sm">
    <div class="pb-6 border-b border-slate-800/80 mb-6">
        <h3 class="text-lg font-bold text-white"><?php echo $title; ?></h3>
        <p class="text-xs text-slate-500 mt-1">Configure TV streaming properties and logo credentials</p>
    </div>

    <form action="<?php echo $actionUrl; ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
        <!-- Channel Name -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Channel Name</label>
            <input type="text" name="name" value="<?php echo $channel ? htmlspecialchars($channel['name']) : ''; ?>" required placeholder="e.g. beIN Sports HD 1"
                   class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
        </div>

        <!-- Stream URL -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Stream Source URL (Direct m3u8 link)</label>
            <input type="text" name="stream_url" value="<?php echo $channel ? htmlspecialchars($channel['stream_url']) : ''; ?>" placeholder="https://domain.com/live.m3u8"
                   class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
        </div>

        <!-- Channel Status -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Status</label>
            <select name="status" class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
                <option value="active" <?php echo ($channel && $channel['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?php echo ($channel && $channel['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>

        <!-- Logo Upload -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Channel Logo</label>
            
            <?php if ($channel && !empty($channel['logo'])): ?>
                <div class="mb-3 flex items-center space-x-3 bg-slate-950/30 p-2 rounded-xl border border-slate-800">
                    <img src="../<?php echo htmlspecialchars($channel['logo']); ?>" class="w-12 h-12 object-contain rounded" alt="">
                    <span class="text-xs text-slate-500">Current Logo</span>
                </div>
            <?php endif; ?>

            <input type="file" name="logo" <?php echo $channel ? '' : 'required'; ?> accept="image/*"
                   class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2 text-white text-xs file:mr-4 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-indigo-600/20 file:text-indigo-400 hover:file:bg-indigo-600/30 file:cursor-pointer">
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-800/80">
            <a href="index.php?page=admin_channels" class="px-5 py-2.5 rounded-xl border border-slate-800 text-slate-400 hover:text-white hover:bg-slate-900 text-sm font-semibold transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition shadow-lg shadow-indigo-500/10">
                Save Channel
            </button>
        </div>
    </form>
</div>

<?php require_once dirname(dirname(__DIR__)) . '/views/layouts/footer.php'; ?>
