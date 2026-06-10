<?php
/**
 * Admin App Settings View
 */
$title = 'App Settings';
require_once dirname(dirname(__DIR__)) . '/views/layouts/header.php';
?>

<div class="max-w-2xl mx-auto bg-slate-900/60 border border-slate-800/80 rounded-2xl p-6 shadow-sm">
    <div class="pb-6 border-b border-slate-800/80 mb-6">
        <h3 class="text-lg font-bold text-white">General Site Settings</h3>
        <p class="text-xs text-slate-500 mt-1">Configure site identity, social links, and platform feature toggles</p>
    </div>

    <form action="index.php?page=admin_settings&action=save" method="POST" enctype="multipart/form-data" class="space-y-6">
        <!-- Site Name -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Site Name</label>
            <input type="text" name="site_name" value="<?php echo htmlspecialchars($settings['site_name'] ?? 'KoraStream'); ?>" required
                   class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
        </div>

        <!-- Site Description -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Site Description (SEO Meta)</label>
            <textarea name="site_description" rows="2"
                      class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition resize-none"><?php echo htmlspecialchars($settings['site_description'] ?? ''); ?></textarea>
        </div>

        <!-- Logo Upload -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Site Logo</label>
            <?php if (!empty($settings['site_logo'])): ?>
                <div class="mb-3 flex items-center space-x-3 bg-slate-950/30 p-2 rounded-xl border border-slate-800">
                    <img src="../<?php echo htmlspecialchars($settings['site_logo']); ?>" class="h-10 object-contain rounded" alt="Site Logo">
                    <span class="text-xs text-slate-500">Current Logo</span>
                </div>
            <?php endif; ?>
            <input type="file" name="site_logo" accept="image/*"
                   class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2 text-white text-xs file:mr-4 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-indigo-600/20 file:text-indigo-400 hover:file:bg-indigo-600/30 file:cursor-pointer">
        </div>

        <!-- Social Links -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">
                    <i class="fa-brands fa-facebook text-blue-500 mr-1"></i> Facebook URL
                </label>
                <input type="text" name="facebook_url" value="<?php echo htmlspecialchars($settings['facebook_url'] ?? '#'); ?>"
                       class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">
                    <i class="fa-brands fa-telegram text-sky-400 mr-1"></i> Telegram URL
                </label>
                <input type="text" name="telegram_url" value="<?php echo htmlspecialchars($settings['telegram_url'] ?? '#'); ?>"
                       class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>
        </div>

        <!-- Feature Toggles -->
        <div class="bg-slate-950/35 p-5 rounded-2xl border border-slate-800/60 space-y-4">
            <h4 class="text-sm font-bold text-white">Platform Feature Toggles</h4>
            
            <!-- Maintenance Mode -->
            <div class="flex items-center justify-between py-2 border-b border-slate-800/50">
                <div>
                    <p class="text-sm text-white font-medium">Maintenance Mode</p>
                    <p class="text-xs text-slate-500 mt-0.5">Disable all public frontend pages for users</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="maintenance_mode" value="1" class="sr-only peer"
                           <?php echo (isset($settings['maintenance_mode']) && $settings['maintenance_mode'] == '1') ? 'checked' : ''; ?>>
                    <div class="w-9 h-5 bg-slate-800 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-slate-400 after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-rose-600 peer-checked:after:bg-white"></div>
                </label>
            </div>
            
            <!-- Enable Channels -->
            <div class="flex items-center justify-between py-2">
                <div>
                    <p class="text-sm text-white font-medium">Enable TV Channels Section</p>
                    <p class="text-xs text-slate-500 mt-0.5">Show/hide the Channels screen on the frontend app</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="enable_channels" value="1" class="sr-only peer"
                           <?php echo (!isset($settings['enable_channels']) || $settings['enable_channels'] == '1') ? 'checked' : ''; ?>>
                    <div class="w-9 h-5 bg-slate-800 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-slate-400 after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600 peer-checked:after:bg-white"></div>
                </label>
            </div>
        </div>

        <!-- Custom Head Code (Google Analytics etc.) -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Custom Head Code</label>
            <p class="text-[10px] text-slate-500 mb-2">Injected into the &lt;head&gt; of all frontend pages. Use for analytics or tracking scripts.</p>
            <textarea name="custom_head_code" rows="4" placeholder="<!-- Google Analytics, Meta Pixel, etc. -->"
                      class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white font-mono text-xs focus:outline-none focus:border-indigo-500 transition resize-none"><?php echo htmlspecialchars($settings['custom_head_code'] ?? ''); ?></textarea>
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end pt-6 border-t border-slate-800/80">
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition shadow-lg shadow-indigo-500/10">
                Save Settings
            </button>
        </div>
    </form>
</div>

<?php require_once dirname(dirname(__DIR__)) . '/views/layouts/footer.php'; ?>
