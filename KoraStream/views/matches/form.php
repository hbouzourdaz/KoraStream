<?php
/**
 * Admin Match Add/Edit Form View
 */
$title = isset($title) ? $title : 'Match Settings';
require_once dirname(dirname(__DIR__)) . '/views/layouts/header.php';

$match = isset($match) ? $match : null;
$servers = isset($servers) ? $servers : [];
?>

<div class="max-w-3xl mx-auto bg-slate-900/60 border border-slate-800/80 rounded-2xl p-6 shadow-sm">
    <div class="pb-6 border-b border-slate-800/80 mb-6">
        <h3 class="text-lg font-bold text-white"><?php echo $title; ?></h3>
        <p class="text-xs text-slate-500 mt-1">Fill out match coordinates and attach live stream server links</p>
    </div>

    <form action="<?php echo $actionUrl; ?>" method="POST" class="space-y-6">
        <!-- Teams Selectors Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Home Team -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Home Team</label>
                <select name="home_team_id" required class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
                    <option value="">Select Home Team</option>
                    <?php foreach ($teams as $t): ?>
                        <option value="<?php echo $t['id']; ?>" <?php echo ($match && $match['home_team_id'] == $t['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($t['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Away Team -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Away Team</label>
                <select name="away_team_id" required class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
                    <option value="">Select Away Team</option>
                    <?php foreach ($teams as $t): ?>
                        <option value="<?php echo $t['id']; ?>" <?php echo ($match && $match['away_team_id'] == $t['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($t['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- League & Channel Selector Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- League -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">League / Tournament</label>
                <select name="league_id" required class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
                    <option value="">Select League</option>
                    <?php foreach ($leagues as $l): ?>
                        <option value="<?php echo $l['id']; ?>" <?php echo ($match && $match['league_id'] == $l['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($l['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Default Broadcasting Channel -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Broadcasting TV Channel</label>
                <select name="channel_id" class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
                    <option value="">Select Channel (Optional)</option>
                    <?php foreach ($channels as $c): ?>
                        <option value="<?php echo $c['id']; ?>" <?php echo ($match && $match['channel_id'] == $c['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($c['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Time & Commentator Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Match Time -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Match Date & Time</label>
                <?php 
                    $matchTimeValue = '';
                    if ($match) {
                        $matchTimeValue = date('Y-m-d\TH:i', strtotime($match['match_time']));
                    } else {
                        $matchTimeValue = date('Y-m-d\TH:i');
                    }
                ?>
                <input type="datetime-local" name="match_time" value="<?php echo $matchTimeValue; ?>" required
                       class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>

            <!-- Commentator -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Match Commentator</label>
                <input type="text" name="commentator" value="<?php echo $match ? htmlspecialchars($match['commentator']) : ''; ?>" placeholder="e.g. Issam Chaouali"
                       class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>
        </div>

        <!-- Status & Score Row -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 bg-slate-950/40 p-4 rounded-2xl border border-slate-800/60">
            <!-- Match Status -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Match Status</label>
                <select name="status" id="match-status-select" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
                    <option value="upcoming" <?php echo ($match && $match['status'] === 'upcoming') ? 'selected' : ''; ?>>Upcoming</option>
                    <option value="live" <?php echo ($match && $match['status'] === 'live') ? 'selected' : ''; ?>>Live</option>
                    <option value="finished" <?php echo ($match && $match['status'] === 'finished') ? 'selected' : ''; ?>>Finished / Ended</option>
                </select>
            </div>

            <!-- Home Score -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Home Score</label>
                <input type="number" name="home_score" id="home-score-input" value="<?php echo $match ? $match['home_score'] : '0'; ?>" min="0"
                       class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>

            <!-- Away Score -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Away Score</label>
                <input type="number" name="away_score" id="away-score-input" value="<?php echo $match ? $match['away_score'] : '0'; ?>" min="0"
                       class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>
        </div>

        <!-- Server Links Repeater -->
        <div class="bg-slate-950/20 border border-slate-800/80 rounded-2xl p-5 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <div>
                    <h4 class="text-sm font-bold text-white">Streaming Server Sources</h4>
                    <p class="text-[10px] text-slate-500 mt-0.5">Attach multiple live streaming server links for client selection</p>
                </div>
                <button type="button" id="add-server-btn" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-indigo-600/10 hover:bg-indigo-600 border border-indigo-500/20 text-indigo-400 hover:text-white text-xs font-semibold transition">
                    <i class="fa-solid fa-plus mr-1"></i> Add Server
                </button>
            </div>

            <!-- Servers Row Container -->
            <div id="servers-container" class="space-y-4">
                <?php if (empty($servers)): ?>
                    <!-- Temporary empty template row for new matches -->
                <?php else: ?>
                    <?php foreach ($servers as $index => $srv): ?>
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 p-3 bg-slate-950/45 rounded-xl border border-slate-800/40 relative server-row items-end">
                            <!-- Server Name -->
                            <div class="sm:col-span-3">
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Server Title</label>
                                <input type="text" name="servers[<?php echo $index; ?>][name]" value="<?php echo htmlspecialchars($srv['server_name']); ?>" required placeholder="e.g. Server 1 - HD"
                                       class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-1.5 text-white text-xs focus:outline-none focus:border-indigo-500 transition">
                            </div>
                            
                            <!-- Server Link -->
                            <div class="sm:col-span-5">
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Stream URL / Embed Code</label>
                                <input type="text" name="servers[<?php echo $index; ?>][url]" value="<?php echo htmlspecialchars($srv['stream_url']); ?>" required placeholder="https://domain.com/live.m3u8"
                                       class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-1.5 text-white text-xs focus:outline-none focus:border-indigo-500 transition">
                            </div>

                            <!-- Player Type -->
                            <div class="sm:col-span-3">
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Player Type</label>
                                <select name="servers[<?php echo $index; ?>][player_type]" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-1.5 text-white text-xs focus:outline-none focus:border-indigo-500 transition">
                                    <option value="iframe" <?php echo ($srv['player_type'] === 'iframe') ? 'selected' : ''; ?>>Iframe Embed</option>
                                    <option value="m3u8" <?php echo ($srv['player_type'] === 'm3u8') ? 'selected' : ''; ?>>HLS (m3u8)</option>
                                    <option value="youtube" <?php echo ($srv['player_type'] === 'youtube') ? 'selected' : ''; ?>>YouTube</option>
                                    <option value="dash" <?php echo ($srv['player_type'] === 'dash') ? 'selected' : ''; ?>>MPEG-DASH (mpd)</option>
                                </select>
                            </div>

                            <!-- Remove Button -->
                            <div class="sm:col-span-1 text-center">
                                <button type="button" class="remove-server-btn inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-500/10 hover:bg-rose-600 text-rose-400 hover:text-white transition">
                                    <i class="fa-solid fa-xmark text-sm"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Submit Panel -->
        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-800/80">
            <a href="index.php?page=admin_matches" class="px-5 py-2.5 rounded-xl border border-slate-800 text-slate-400 hover:text-white hover:bg-slate-900 text-sm font-semibold transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition shadow-lg shadow-indigo-500/10">
                Save Match
            </button>
        </div>
    </form>
</div>

<!-- Repeater logic script -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('servers-container');
    const addBtn = document.getElementById('add-server-btn');
    
    // Track row indices to keep inputs unique
    let rowIndex = <?php echo count($servers); ?>;

    // Add row function
    addBtn.addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'grid grid-cols-1 sm:grid-cols-12 gap-3 p-3 bg-slate-950/45 rounded-xl border border-slate-800/40 relative server-row items-end';
        row.innerHTML = `
            <div class="sm:col-span-3">
                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Server Title</label>
                <input type="text" name="servers[${rowIndex}][name]" required placeholder="e.g. Server 1 - HD"
                       class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-1.5 text-white text-xs focus:outline-none focus:border-indigo-500 transition">
            </div>
            
            <div class="sm:col-span-5">
                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Stream URL / Embed Code</label>
                <input type="text" name="servers[${rowIndex}][url]" required placeholder="https://domain.com/live.m3u8"
                       class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-1.5 text-white text-xs focus:outline-none focus:border-indigo-500 transition">
            </div>

            <div class="sm:col-span-3">
                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Player Type</label>
                <select name="servers[${rowIndex}][player_type]" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-1.5 text-white text-xs focus:outline-none focus:border-indigo-500 transition">
                    <option value="iframe">Iframe Embed</option>
                    <option value="m3u8">HLS (m3u8)</option>
                    <option value="youtube">YouTube</option>
                    <option value="dash">MPEG-DASH (mpd)</option>
                </select>
            </div>

            <div class="sm:col-span-1 text-center">
                <button type="button" class="remove-server-btn inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-500/10 hover:bg-rose-600 text-rose-400 hover:text-white transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        rowIndex++;
    });

    // Remove row delegation
    container.addEventListener('click', (e) => {
        if (e.target.closest('.remove-server-btn')) {
            const row = e.target.closest('.server-row');
            if (row) row.remove();
        }
    });

    // Initial empty row check (only if creating a brand new match)
    if (rowIndex === 0) {
        addBtn.click();
    }
});
</script>

<?php require_once dirname(dirname(__DIR__)) . '/views/layouts/footer.php'; ?>
