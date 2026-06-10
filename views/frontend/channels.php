<?php
/**
 * Frontend TV Channels Page - Android App Style
 */
require_once dirname(dirname(__DIR__)) . '/views/frontend/header.php';
?>

<!-- Page Title -->
<div class="px-4 pt-5 pb-3">
    <h2 class="text-xl font-bold text-white">Live TV Channels</h2>
    <p class="text-xs text-slate-500 mt-1">Tap a channel to stream it directly</p>
</div>

<!-- Channels Grid -->
<div class="px-3 pb-4 space-y-3">
    <?php if (empty($channels)): ?>
        <div class="flex flex-col items-center justify-center py-24 text-center space-y-4">
            <div class="w-20 h-20 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-4xl text-slate-700">
                <i class="fa-solid fa-tv"></i>
            </div>
            <div>
                <p class="text-white font-semibold text-lg">No Channels Active</p>
                <p class="text-slate-500 text-sm mt-1">Check back later or contact the admin.</p>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($channels as $ch): ?>
            <?php
                // Build watch URL with the channel stream
                $channelUrl = !empty($ch['stream_url']) ? urlencode($ch['stream_url']) : '';
                // We open a dedicated watch page or stream directly via the URL
            ?>
            <div onclick="openChannelStream('<?php echo htmlspecialchars($ch['stream_url']); ?>', '<?php echo htmlspecialchars($ch['name']); ?>')"
                 class="bg-[#181E31] border border-slate-800/60 rounded-2xl p-4 flex items-center space-x-4 hover:border-emerald-500/40 active:scale-[0.98] transition-all duration-200 cursor-pointer group">
                
                <!-- Channel Logo -->
                <div class="w-16 h-16 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center p-2 shrink-0">
                    <?php if (!empty($ch['logo'])): ?>
                        <img src="uploads/<?php echo ltrim(htmlspecialchars($ch['logo']), 'uploads/'); ?>" class="w-full h-full object-contain" alt="">
                    <?php else: ?>
                        <i class="fa-solid fa-tv text-2xl text-slate-600"></i>
                    <?php endif; ?>
                </div>

                <!-- Channel Info -->
                <div class="flex-grow min-w-0">
                    <p class="font-bold text-white text-base leading-tight"><?php echo htmlspecialchars($ch['name']); ?></p>
                    <div class="flex items-center space-x-1.5 mt-1.5">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full live-glow"></span>
                        <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider">Live Now</span>
                    </div>
                </div>

                <!-- Play Button -->
                <div class="w-10 h-10 rounded-full bg-indigo-600/20 border border-indigo-500/25 flex items-center justify-center shrink-0 group-hover:bg-indigo-600 group-hover:border-indigo-400 transition-all duration-300">
                    <i class="fa-solid fa-play text-indigo-400 group-hover:text-white text-sm ml-0.5 transition-colors"></i>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Channel Player Bottom Sheet -->
<div id="channel-sheet-backdrop" data-sheet-id="channel-player-sheet"
     class="sheet-backdrop fixed inset-0 bg-black/70 backdrop-blur-sm z-40 hidden opacity-0 transition-opacity duration-300 max-w-md mx-auto"></div>

<div id="channel-player-sheet"
     class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-[#090D16] rounded-t-3xl border-t border-slate-800 z-50 transform translate-y-full transition-transform duration-300 ease-out">
    
    <!-- Grab Handle -->
    <div class="flex justify-center pt-3 pb-2">
        <div class="w-10 h-1 bg-slate-700 rounded-full"></div>
    </div>

    <!-- Sheet Header -->
    <div class="flex items-center justify-between px-5 py-3 border-b border-slate-800/60">
        <h4 id="channel-sheet-title" class="text-sm font-bold text-white">Channel Stream</h4>
        <button onclick="closeBottomSheet('channel-player-sheet', 'channel-sheet-backdrop'); stopChannelPlayer();"
                class="w-7 h-7 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition flex items-center justify-center">
            <i class="fa-solid fa-xmark text-xs"></i>
        </button>
    </div>

    <!-- Player Area -->
    <div class="p-4 pb-8">
        <div id="channel-player-wrap" class="aspect-video bg-black rounded-xl overflow-hidden border border-slate-800">
            <!-- Player injected by JS -->
        </div>
    </div>
</div>

<script>
let channelHls = null;

function openChannelStream(url, name) {
    if (!url) {
        alert('No stream link available for this channel.');
        return;
    }
    
    document.getElementById('channel-sheet-title').textContent = name;
    const wrap = document.getElementById('channel-player-wrap');
    
    // Determine type by URL extension
    if (url.includes('.m3u8')) {
        wrap.innerHTML = '<video id="channel-hls-player" class="w-full h-full" controls autoplay playsinline></video>';
        const video = document.getElementById('channel-hls-player');
        
        if (channelHls) { channelHls.destroy(); channelHls = null; }
        
        if (Hls.isSupported()) {
            channelHls = new Hls();
            channelHls.loadSource(url);
            channelHls.attachMedia(video);
            channelHls.on(Hls.Events.MANIFEST_PARSED, () => video.play().catch(() => {}));
        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            video.src = url;
            video.play().catch(() => {});
        }
    } else {
        wrap.innerHTML = `<iframe src="${url}" class="w-full h-full border-0" allowfullscreen allow="autoplay; encrypted-media"></iframe>`;
    }
    
    openBottomSheet('channel-player-sheet', 'channel-sheet-backdrop');
}

function stopChannelPlayer() {
    if (channelHls) { channelHls.destroy(); channelHls = null; }
    document.getElementById('channel-player-wrap').innerHTML = '';
}
</script>

<?php require_once dirname(dirname(__DIR__)) . '/views/frontend/footer.php'; ?>
