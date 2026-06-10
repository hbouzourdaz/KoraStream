<?php
/**
 * Frontend Watch Page - Android App Style
 * Match details, HLS/Iframe player, and Bottom Sheet server switcher
 */
require_once dirname(dirname(__DIR__)) . '/views/frontend/header.php';

$firstServer = !empty($servers) ? $servers[0] : null;
?>

<!-- MATCH HEADER CARD -->
<div class="px-4 pt-4 pb-2">
    <div class="bg-[#181E31] border border-slate-800/60 rounded-2xl p-4">
        <!-- League + Status Row -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-2">
                <div class="w-7 h-7 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center p-1">
                    <?php if (!empty($match['league_logo'])): ?>
                        <img src="uploads/<?php echo ltrim(htmlspecialchars($match['league_logo']), 'uploads/'); ?>" class="w-full h-full object-contain" alt="">
                    <?php else: ?>
                        <i class="fa-solid fa-trophy text-amber-500 text-[10px]"></i>
                    <?php endif; ?>
                </div>
                <span class="text-xs font-bold text-slate-300"><?php echo htmlspecialchars($match['league_name']); ?></span>
            </div>
            
            <?php if ($match['status'] === 'live'): ?>
                <span class="inline-flex items-center space-x-1.5 bg-emerald-500/15 border border-emerald-500/25 text-emerald-400 text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full live-glow shrink-0"></span>
                    <span>LIVE</span>
                </span>
            <?php elseif ($match['status'] === 'finished'): ?>
                <span class="inline-flex items-center bg-slate-800 border border-slate-700/50 text-slate-400 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full">Ended</span>
            <?php else: ?>
                <span class="inline-flex items-center bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full">
                    <?php echo date('H:i', strtotime($match['match_time'])); ?>
                </span>
            <?php endif; ?>
        </div>

        <!-- Teams & Score Row -->
        <div class="flex items-center justify-between">
            <!-- Home Team -->
            <div class="flex flex-col items-center space-y-2 flex-1 min-w-0">
                <div class="w-16 h-16 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center justify-center p-2">
                    <?php if (!empty($match['home_team_logo'])): ?>
                        <img src="uploads/<?php echo ltrim(htmlspecialchars($match['home_team_logo']), 'uploads/'); ?>" class="w-full h-full object-contain" alt="">
                    <?php else: ?>
                        <i class="fa-solid fa-futbol text-slate-600 text-2xl"></i>
                    <?php endif; ?>
                </div>
                <span class="text-sm font-bold text-white text-center leading-tight line-clamp-2">
                    <?php echo htmlspecialchars($match['home_team_name']); ?>
                </span>
            </div>

            <!-- Score -->
            <div class="flex flex-col items-center justify-center px-4 shrink-0">
                <?php if ($match['status'] !== 'upcoming'): ?>
                    <div class="flex items-center space-x-3">
                        <span class="text-4xl font-black text-white tabular-nums"><?php echo $match['home_score']; ?></span>
                        <span class="text-2xl font-bold text-slate-600">-</span>
                        <span class="text-4xl font-black text-white tabular-nums"><?php echo $match['away_score']; ?></span>
                    </div>
                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-1"><?php echo $match['status'] === 'live' ? 'LIVE SCORE' : 'FULL TIME'; ?></span>
                <?php else: ?>
                    <span class="text-2xl font-black text-slate-600 tracking-widest">VS</span>
                    <span class="text-[9px] text-slate-600 uppercase tracking-widest mt-1"><?php echo date('M d · H:i', strtotime($match['match_time'])); ?></span>
                <?php endif; ?>
            </div>

            <!-- Away Team -->
            <div class="flex flex-col items-center space-y-2 flex-1 min-w-0">
                <div class="w-16 h-16 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center justify-center p-2">
                    <?php if (!empty($match['away_team_logo'])): ?>
                        <img src="uploads/<?php echo ltrim(htmlspecialchars($match['away_team_logo']), 'uploads/'); ?>" class="w-full h-full object-contain" alt="">
                    <?php else: ?>
                        <i class="fa-solid fa-futbol text-slate-600 text-2xl"></i>
                    <?php endif; ?>
                </div>
                <span class="text-sm font-bold text-white text-center leading-tight line-clamp-2">
                    <?php echo htmlspecialchars($match['away_team_name']); ?>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- VIDEO PLAYER SECTION -->
<div class="px-4 py-3">
    <?php if (empty($servers)): ?>
        <!-- No streams available placeholder -->
        <div class="aspect-video bg-slate-900/80 border border-slate-800 rounded-2xl flex flex-col items-center justify-center text-slate-600 space-y-2">
            <i class="fa-solid fa-circle-xmark text-4xl text-slate-700"></i>
            <p class="text-sm font-semibold">No Streams Available</p>
            <p class="text-xs text-slate-600">Check back when the match goes live.</p>
        </div>
    <?php else: ?>
        <!-- Active Player Container -->
        <div class="relative">
            <div id="player-container" class="aspect-video bg-black rounded-2xl overflow-hidden border border-slate-800 shadow-2xl shadow-black/50">
                <?php if ($firstServer): ?>
                    <?php if ($firstServer['player_type'] === 'm3u8'): ?>
                        <video id="hls-video-player" class="w-full h-full" controls autoplay playsinline></video>
                    <?php elseif ($firstServer['player_type'] === 'youtube'): ?>
                        <iframe id="iframe-player" src="<?php echo htmlspecialchars($firstServer['stream_url']); ?>"
                                class="w-full h-full border-0" allowfullscreen allow="autoplay; encrypted-media"></iframe>
                    <?php else: ?>
                        <iframe id="iframe-player" src="<?php echo htmlspecialchars($firstServer['stream_url']); ?>"
                                class="w-full h-full border-0" allowfullscreen allow="autoplay; encrypted-media; fullscreen; picture-in-picture"></iframe>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Loading Overlay -->
            <div id="player-loading" class="hidden absolute inset-0 bg-black/80 rounded-2xl flex items-center justify-center">
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-10 h-10 border-2 border-indigo-500/20 border-t-indigo-400 rounded-full animate-spin"></div>
                    <p class="text-xs text-slate-400">Loading stream...</p>
                </div>
            </div>
        </div>

        <!-- SERVER SWITCHER TRIGGER BUTTON -->
        <?php if (count($servers) > 1): ?>
            <button onclick="openBottomSheet('servers-sheet', 'servers-backdrop')"
                    class="mt-3 w-full flex items-center justify-center space-x-2 px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 hover:border-indigo-500/50 hover:bg-slate-800 transition text-sm font-semibold text-slate-300">
                <i class="fa-solid fa-layer-group text-indigo-400"></i>
                <span>Switch Server</span>
                <span class="text-xs bg-indigo-600/20 text-indigo-400 border border-indigo-500/25 px-1.5 py-0.5 rounded font-bold"><?php echo count($servers); ?></span>
                <i class="fa-solid fa-chevron-up text-slate-500 text-xs ml-auto"></i>
            </button>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- Under-Player Banner Ad -->
<?php if (!empty($common['ads']['banner_player']['code'])): ?>
    <div class="px-4 pb-2">
        <?php echo $common['ads']['banner_player']['code']; ?>
    </div>
<?php endif; ?>

<!-- MATCH INFO CARD -->
<div class="px-4 pb-4 space-y-3">
    <div class="bg-[#181E31] border border-slate-800/60 rounded-2xl p-4 space-y-3">
        <h3 class="text-sm font-bold text-white">Match Details</h3>
        
        <div class="space-y-2 text-sm">
            <?php if (!empty($match['commentator'])): ?>
                <div class="flex items-center space-x-2.5 text-slate-400">
                    <i class="fa-solid fa-microphone text-indigo-400 w-4 text-center text-xs"></i>
                    <span>Commentator:</span>
                    <span class="text-white font-medium"><?php echo htmlspecialchars($match['commentator']); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($match['channel_name'])): ?>
                <div class="flex items-center space-x-2.5 text-slate-400">
                    <i class="fa-solid fa-tv text-sky-400 w-4 text-center text-xs"></i>
                    <span>Channel:</span>
                    <span class="text-white font-medium"><?php echo htmlspecialchars($match['channel_name']); ?></span>
                </div>
            <?php endif; ?>

            <div class="flex items-center space-x-2.5 text-slate-400">
                <i class="fa-regular fa-clock text-amber-400 w-4 text-center text-xs"></i>
                <span>Match Time:</span>
                <span class="text-white font-medium"><?php echo date('M d, Y · H:i', strtotime($match['match_time'])); ?></span>
            </div>
        </div>
    </div>
</div>

<!-- ANDROID BOTTOM SHEET — Server Switcher -->
<?php if (!empty($servers)): ?>
    <!-- Backdrop -->
    <div id="servers-backdrop" data-sheet-id="servers-sheet"
         class="sheet-backdrop fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden opacity-0 transition-opacity duration-300 max-w-md mx-auto"></div>

    <!-- Sheet Panel -->
    <div id="servers-sheet"
         class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-[#181E31] rounded-t-3xl border-t border-slate-800/80 z-50 transform translate-y-full transition-transform duration-300 ease-out">
        
        <!-- Grab Handle -->
        <div class="flex justify-center pt-3 pb-2">
            <div class="w-10 h-1 bg-slate-700 rounded-full"></div>
        </div>

        <!-- Sheet Header -->
        <div class="flex items-center justify-between px-5 py-3 border-b border-slate-800/60">
            <h4 class="text-sm font-bold text-white">Select Stream Server</h4>
            <button onclick="closeBottomSheet('servers-sheet', 'servers-backdrop')"
                    class="w-7 h-7 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition flex items-center justify-center">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>

        <!-- Server List -->
        <div class="p-4 space-y-2 max-h-64 overflow-y-auto no-scrollbar pb-24">
            <?php foreach ($servers as $index => $server): ?>
                <button onclick="loadServer('<?php echo htmlspecialchars($server['stream_url']); ?>', '<?php echo $server['player_type']; ?>', this)"
                        data-server-index="<?php echo $index; ?>"
                        class="server-item w-full flex items-center space-x-3.5 p-3.5 rounded-xl border transition-all text-left
                               <?php echo ($index === 0) ? 'bg-indigo-600/15 border-indigo-500/30 text-indigo-300' : 'bg-slate-900/60 border-slate-800/60 text-slate-300 hover:border-slate-700 hover:bg-slate-800/50'; ?>">
                    
                    <!-- Icon -->
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0
                                <?php echo ($index === 0) ? 'bg-indigo-600/20 text-indigo-400' : 'bg-slate-900 text-slate-500'; ?>">
                        <?php if ($server['player_type'] === 'm3u8'): ?>
                            <i class="fa-solid fa-satellite-dish text-sm"></i>
                        <?php elseif ($server['player_type'] === 'youtube'): ?>
                            <i class="fa-brands fa-youtube text-sm"></i>
                        <?php else: ?>
                            <i class="fa-solid fa-play text-sm"></i>
                        <?php endif; ?>
                    </div>

                    <!-- Server Name & Type -->
                    <div class="flex-grow min-w-0">
                        <p class="font-semibold text-sm leading-tight"><?php echo htmlspecialchars($server['server_name']); ?></p>
                        <p class="text-[10px] text-slate-500 mt-0.5 uppercase tracking-wider"><?php echo strtoupper($server['player_type']); ?> Stream</p>
                    </div>

                    <!-- Active Indicator -->
                    <?php if ($index === 0): ?>
                        <span class="shrink-0 w-2 h-2 bg-indigo-400 rounded-full live-glow"></span>
                    <?php endif; ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- HLS.js Player Initialization -->
<script>
// ── Server Data ──────────────────────────────────────────────
const servers = <?php echo json_encode($servers); ?>;
let currentHls = null;

function initHlsPlayer(url) {
    const video = document.getElementById('hls-video-player');
    if (!video) return;
    
    // Destroy previous HLS instance
    if (currentHls) {
        currentHls.destroy();
        currentHls = null;
    }

    if (Hls.isSupported()) {
        currentHls = new Hls({ startPosition: -1 });
        currentHls.loadSource(url);
        currentHls.attachMedia(video);
        currentHls.on(Hls.Events.MANIFEST_PARSED, () => {
            video.play().catch(() => {});
        });
    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
        // Native HLS (Safari iOS)
        video.src = url;
        video.play().catch(() => {});
    }
}

function loadServer(url, type, clickedBtn) {
    const container = document.getElementById('player-container');
    const loading = document.getElementById('player-loading');
    
    // Update active state on all buttons
    document.querySelectorAll('.server-item').forEach(btn => {
        btn.classList.remove('bg-indigo-600/15', 'border-indigo-500/30', 'text-indigo-300');
        btn.classList.add('bg-slate-900/60', 'border-slate-800/60', 'text-slate-300');
        const dot = btn.querySelector('.live-glow');
        if (dot) dot.remove();
        const icon = btn.querySelector('.w-10');
        if (icon) {
            icon.classList.remove('bg-indigo-600/20', 'text-indigo-400');
            icon.classList.add('bg-slate-900', 'text-slate-500');
        }
    });
    
    // Highlight clicked button
    clickedBtn.classList.add('bg-indigo-600/15', 'border-indigo-500/30', 'text-indigo-300');
    clickedBtn.classList.remove('bg-slate-900/60', 'border-slate-800/60', 'text-slate-300');

    // Show loading overlay
    if (loading) {
        loading.classList.remove('hidden');
        loading.classList.add('flex');
    }

    // Render the new player
    if (type === 'm3u8') {
        container.innerHTML = '<video id="hls-video-player" class="w-full h-full" controls autoplay playsinline></video>';
        initHlsPlayer(url);
    } else {
        container.innerHTML = `<iframe id="iframe-player" src="${url}" class="w-full h-full border-0" allowfullscreen allow="autoplay; encrypted-media; fullscreen; picture-in-picture"></iframe>`;
    }

    // Hide loading after a short delay
    setTimeout(() => {
        if (loading) {
            loading.classList.add('hidden');
            loading.classList.remove('flex');
        }
    }, 1500);

    // Close bottom sheet
    closeBottomSheet('servers-sheet', 'servers-backdrop');
}

// Initialize first server (if HLS type)
document.addEventListener('DOMContentLoaded', () => {
    <?php if ($firstServer && $firstServer['player_type'] === 'm3u8'): ?>
        initHlsPlayer('<?php echo htmlspecialchars($firstServer['stream_url']); ?>');
    <?php endif; ?>
});
</script>

<?php require_once dirname(dirname(__DIR__)) . '/views/frontend/footer.php'; ?>
