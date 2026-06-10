<?php
/**
 * Admin Dashboard Index View
 */
$title = 'Dashboard Overview';
require_once dirname(__DIR__) . '/layouts/header.php';
?>

<!-- Stat Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-8">
    <!-- Total Matches -->
    <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div class="space-y-1">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Matches</span>
            <h3 class="text-2xl font-bold text-white"><?php echo $stats['matches']; ?></h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 flex items-center justify-center text-xl">
            <i class="fa-solid fa-futbol"></i>
        </div>
    </div>

    <!-- Live Matches -->
    <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div class="space-y-1">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Live Now</span>
            <h3 class="text-2xl font-bold text-emerald-400 flex items-center">
                <?php echo $stats['live_matches']; ?>
                <?php if ($stats['live_matches'] > 0): ?>
                    <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full ml-2 live-glow inline-block"></span>
                <?php endif; ?>
            </h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-xl">
            <i class="fa-solid fa-tower-broadcast"></i>
        </div>
    </div>

    <!-- Total Leagues -->
    <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div class="space-y-1">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Leagues</span>
            <h3 class="text-2xl font-bold text-white"><?php echo $stats['leagues']; ?></h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center text-xl">
            <i class="fa-solid fa-trophy"></i>
        </div>
    </div>

    <!-- Total Teams -->
    <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div class="space-y-1">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Teams</span>
            <h3 class="text-2xl font-bold text-white"><?php echo $stats['teams']; ?></h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-sky-500/10 text-sky-400 border border-sky-500/20 flex items-center justify-center text-xl">
            <i class="fa-solid fa-people-group"></i>
        </div>
    </div>

    <!-- Live TV Channels -->
    <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div class="space-y-1">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">TV Channels</span>
            <h3 class="text-2xl font-bold text-white"><?php echo $stats['channels']; ?></h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-400 border border-purple-500/20 flex items-center justify-center text-xl">
            <i class="fa-solid fa-tv"></i>
        </div>
    </div>
</div>

<!-- Score Updater Panel for Live Matches -->
<div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-6 shadow-sm mb-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between pb-4 border-b border-slate-800/80 mb-6 gap-3">
        <div>
            <h3 class="text-lg font-bold text-white flex items-center">
                Live Score Center
                <span class="w-2 h-2 bg-emerald-500 rounded-full ml-2 live-glow inline-block"></span>
            </h3>
            <p class="text-xs text-slate-500 mt-1">Quickly update scores for matches currently in progress</p>
        </div>
        <span class="text-xs font-semibold bg-emerald-500/15 text-emerald-400 px-3 py-1 rounded-full border border-emerald-500/20">
            Realtime Actions
        </span>
    </div>

    <!-- Notification toast -->
    <div id="toast-notify" class="hidden fixed bottom-6 right-6 z-50 flex items-center p-4 text-sm rounded-xl text-white shadow-xl max-w-sm transition-all duration-300"></div>

    <?php 
    $liveMatches = array_filter($todayMatches, function($m) { return $m['status'] === 'live'; });
    if (empty($liveMatches)): 
    ?>
        <div class="text-center py-12 text-slate-500 border border-dashed border-slate-800 rounded-xl">
            <i class="fa-solid fa-futbol-bounce text-3xl text-slate-700 mb-3 block"></i>
            <p class="text-sm">There are no live matches matches playing right now.</p>
            <p class="text-xs text-slate-600 mt-1">Change match status to 'Live' under Matches CRUD to edit scores here.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-800/50 pb-3">
                        <th class="pb-3 pr-4">League</th>
                        <th class="pb-3 text-right">Home Team</th>
                        <th class="pb-3 text-center px-4">Score</th>
                        <th class="pb-3 text-left">Away Team</th>
                        <th class="pb-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50 text-sm">
                    <?php foreach ($liveMatches as $match): ?>
                        <tr class="align-middle">
                            <!-- League -->
                            <td class="py-4 text-xs font-medium text-slate-400 max-w-[150px] truncate">
                                <?php echo htmlspecialchars($match['league_name']); ?>
                            </td>
                            
                            <!-- Home Team -->
                            <td class="py-4 text-right pr-4 font-semibold text-white">
                                <span class="inline-flex items-center space-x-2">
                                    <span><?php echo htmlspecialchars($match['home_team_name']); ?></span>
                                    <?php if (!empty($match['home_team_logo'])): ?>
                                        <img src="<?php echo '../' . htmlspecialchars($match['home_team_logo']); ?>" class="w-6 h-6 object-contain inline" alt="">
                                    <?php endif; ?>
                                </span>
                            </td>

                            <!-- Score Inputs -->
                            <td class="py-4 text-center px-4 whitespace-nowrap">
                                <div class="inline-flex items-center space-x-2 bg-slate-950/40 p-1.5 rounded-xl border border-slate-800">
                                    <input type="number" id="home-<?php echo $match['id']; ?>" value="<?php echo $match['home_score']; ?>" min="0"
                                           class="w-12 bg-slate-900 border border-slate-800 rounded-lg py-1 text-center font-bold text-white focus:outline-none focus:border-indigo-500">
                                    <span class="text-slate-600 font-semibold">:</span>
                                    <input type="number" id="away-<?php echo $match['id']; ?>" value="<?php echo $match['away_score']; ?>" min="0"
                                           class="w-12 bg-slate-900 border border-slate-800 rounded-lg py-1 text-center font-bold text-white focus:outline-none focus:border-indigo-500">
                                </div>
                            </td>

                            <!-- Away Team -->
                            <td class="py-4 text-left font-semibold text-white">
                                <span class="inline-flex items-center space-x-2">
                                    <?php if (!empty($match['away_team_logo'])): ?>
                                        <img src="<?php echo '../' . htmlspecialchars($match['away_team_logo']); ?>" class="w-6 h-6 object-contain inline" alt="">
                                    <?php endif; ?>
                                    <span><?php echo htmlspecialchars($match['away_team_name']); ?></span>
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 text-center">
                                <button onclick="saveQuickScore(<?php echo $match['id']; ?>)" 
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-600/20 hover:bg-indigo-600 border border-indigo-500/25 text-indigo-400 hover:text-white transition">
                                    <i class="fa-regular fa-floppy-disk"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
function saveQuickScore(matchId) {
    const homeScore = document.getElementById('home-' + matchId).value;
    const awayScore = document.getElementById('away-' + matchId).value;
    const toast = document.getElementById('toast-notify');

    const formData = new FormData();
    formData.append('id', matchId);
    formData.append('home_score', homeScore);
    formData.append('away_score', awayScore);

    fetch('index.php?page=admin_update_score', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        toast.classList.remove('hidden', 'bg-rose-600', 'bg-emerald-600');
        if (data.status === 'success') {
            toast.classList.add('bg-emerald-600');
            toast.innerHTML = `<i class="fa-solid fa-circle-check mr-2 text-base"></i> Match score updated successfully.`;
        } else {
            toast.classList.add('bg-rose-600');
            toast.innerHTML = `<i class="fa-solid fa-triangle-exclamation mr-2 text-base"></i> Score update failed.`;
        }
        
        // Hide toast after 3s
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    })
    .catch(err => {
        toast.classList.remove('hidden', 'bg-emerald-600');
        toast.classList.add('bg-rose-600');
        toast.innerHTML = `<i class="fa-solid fa-triangle-exclamation mr-2 text-base"></i> Network connection error.`;
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    });
}
</script>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
