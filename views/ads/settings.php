<?php
/**
 * Admin Ad Settings View
 */
$title = 'Ad Settings';
require_once dirname(dirname(__DIR__)) . '/views/layouts/header.php';
?>

<div class="max-w-3xl mx-auto bg-slate-900/60 border border-slate-800/80 rounded-2xl p-6 shadow-sm">
    <div class="pb-6 border-b border-slate-800/80 mb-6">
        <h3 class="text-lg font-bold text-white">Manage Advertisements</h3>
        <p class="text-xs text-slate-500 mt-1">Configure advertisement placements, banner slots, and script tracking injection codes</p>
    </div>

    <form action="index.php?page=admin_ads&action=save" method="POST" class="space-y-6">
        <!-- Banner Header Slot -->
        <div class="bg-slate-950/35 p-5 rounded-2xl border border-slate-800/60 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-bold text-white">Homepage Header Banner</h4>
                    <p class="text-[10px] text-slate-500 mt-0.5">Displays at the top of the client main homepage screen</p>
                </div>
                <!-- Toggle Switch -->
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="banner_header_active" class="sr-only peer" 
                           <?php echo (isset($adNetworks['banner_header']) && $adNetworks['banner_header']['is_active'] == 1) ? 'checked' : ''; ?>>
                    <div class="w-9 h-5 bg-slate-800 rounded-full peer peer-focus:ring-0 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-slate-400 after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600 peer-checked:after:bg-white peer-checked:after:border-indigo-500"></div>
                </label>
            </div>
            <div>
                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">HTML Code / Script</label>
                <textarea name="banner_header_code" rows="4" placeholder="<!-- Paste Ad Code Here -->"
                          class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white font-mono text-xs focus:outline-none focus:border-indigo-500 transition"><?php echo isset($adNetworks['banner_header']) ? htmlspecialchars($adNetworks['banner_header']['settings']['code']) : ''; ?></textarea>
            </div>
        </div>

        <!-- Banner Player Slot -->
        <div class="bg-slate-950/35 p-5 rounded-2xl border border-slate-800/60 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-bold text-white">Watch Page Banner</h4>
                    <p class="text-[10px] text-slate-500 mt-0.5">Displays directly below the video player container</p>
                </div>
                <!-- Toggle Switch -->
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="banner_player_active" class="sr-only peer" 
                           <?php echo (isset($adNetworks['banner_player']) && $adNetworks['banner_player']['is_active'] == 1) ? 'checked' : ''; ?>>
                    <div class="w-9 h-5 bg-slate-800 rounded-full peer peer-focus:ring-0 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-slate-400 after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600 peer-checked:after:bg-white peer-checked:after:border-indigo-500"></div>
                </label>
            </div>
            <div>
                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">HTML Code / Script</label>
                <textarea name="banner_player_code" rows="4" placeholder="<!-- Paste Ad Code Here -->"
                          class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white font-mono text-xs focus:outline-none focus:border-indigo-500 transition"><?php echo isset($adNetworks['banner_player']) ? htmlspecialchars($adNetworks['banner_player']['settings']['code']) : ''; ?></textarea>
            </div>
        </div>

        <!-- Popunder Script Slot -->
        <div class="bg-slate-950/35 p-5 rounded-2xl border border-slate-800/60 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-bold text-white">Popunder / Direct Link Script</h4>
                    <p class="text-[10px] text-slate-500 mt-0.5">Triggers on visitor click to redirect to advertiser link</p>
                </div>
                <!-- Toggle Switch -->
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="popunder_active" class="sr-only peer" 
                           <?php echo (isset($adNetworks['popunder']) && $adNetworks['popunder']['is_active'] == 1) ? 'checked' : ''; ?>>
                    <div class="w-9 h-5 bg-slate-800 rounded-full peer peer-focus:ring-0 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-slate-400 after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600 peer-checked:after:bg-white peer-checked:after:border-indigo-500"></div>
                </label>
            </div>
            <div>
                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">HTML Code / Script</label>
                <textarea name="popunder_code" rows="4" placeholder="<!-- Paste Popunder script <script> tag here -->"
                          class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white font-mono text-xs focus:outline-none focus:border-indigo-500 transition"><?php echo isset($adNetworks['popunder']) ? htmlspecialchars($adNetworks['popunder']['settings']['code']) : ''; ?></textarea>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end pt-6 border-t border-slate-800/80">
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition shadow-lg shadow-indigo-500/10">
                Save Ad Configuration
            </button>
        </div>
    </form>
</div>

<?php require_once dirname(dirname(__DIR__)) . '/views/layouts/footer.php'; ?>
