<?php
/**
 * Frontend Homepage View - Android App Style
 * Shows match list grouped by league with day selector tabs
 */
require_once dirname(dirname(__DIR__)) . '/views/frontend/header.php';

// Date navigation helpers
$today     = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
$tomorrow  = date('Y-m-d', strtotime('+1 day'));

$selectedDate = isset($_GET['date']) ? trim($_GET['date']) : $today;

// Build day labels
$datePills = [
    ['date' => $yesterday, 'label' => 'Yesterday'],
    ['date' => $today,     'label' => 'Today'],
    ['date' => $tomorrow,  'label' => 'Tomorrow'],
];
?>

<!-- DATE SELECTOR TABS (Horizontal scroll) -->
<div class="flex items-center space-x-2 overflow-x-auto no-scrollbar px-4 py-3 bg-[#090D16]/60 border-b border-slate-900/50">
    <?php foreach ($datePills as $pill): ?>
        <?php $isActive = ($pill['date'] === $selectedDate); ?>
        <a href="index.php?page=home&date=<?php echo $pill['date']; ?>"
           class="flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-semibold transition-all duration-200
                  <?php echo $isActive
                      ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/25 ring-1 ring-indigo-400/40'
                      : 'bg-slate-900 text-slate-400 hover:text-white hover:bg-slate-800 border border-slate-800/80'; ?>">
            <?php echo $pill['label']; ?>
        </a>
    <?php endforeach; ?>
    <!-- Custom Date Picker -->
    <div class="flex-shrink-0">
        <input type="date" id="custom-date-picker" value="<?php echo htmlspecialchars($selectedDate); ?>"
               class="bg-slate-900 border border-slate-800 rounded-full px-3 py-1.5 text-slate-400 text-xs focus:outline-none focus:border-indigo-500 transition cursor-pointer">
    </div>
</div>

<!-- MATCHES CONTENT AREA -->
<div class="px-3 pt-4 space-y-5">
    <?php if (empty($groupedMatches)): ?>
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-24 text-center space-y-4">
            <div class="w-20 h-20 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-4xl text-slate-700">
                <i class="fa-solid fa-futbol"></i>
            </div>
            <div>
                <p class="text-white font-semibold text-lg">No Matches Today</p>
                <p class="text-slate-500 text-sm mt-1">Check back tomorrow or select another date above.</p>
            </div>
            <a href="index.php?page=home&date=<?php echo $tomorrow; ?>"
               class="px-5 py-2 rounded-xl bg-indigo-600/20 border border-indigo-500/25 text-indigo-400 text-sm font-medium hover:bg-indigo-600 hover:text-white transition">
                View Tomorrow's Matches
            </a>
        </div>
    <?php else: ?>
        <?php foreach ($groupedMatches as $group): ?>
            <!-- League Group Header -->
            <div class="space-y-2">
                <div class="flex items-center space-x-2.5 px-1 mb-3">
                    <div class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800/80 flex items-center justify-center p-1 shrink-0">
                        <?php if (!empty($group['league_logo'])): ?>
                            <img src="uploads/<?php echo ltrim(htmlspecialchars($group['league_logo']), 'uploads/'); ?>" class="w-full h-full object-contain" alt="">
                        <?php else: ?>
                            <i class="fa-solid fa-trophy text-amber-500 text-xs"></i>
                        <?php endif; ?>
                    </div>
                    <span class="text-sm font-bold text-white tracking-wide"><?php echo htmlspecialchars($group['league_name']); ?></span>
                    <div class="flex-grow h-px bg-slate-800/60"></div>
                </div>

                <!-- Match Cards -->
                <?php foreach ($group['matches'] as $match): ?>
                    <a href="index.php?page=watch&id=<?php echo $match['id']; ?>"
                       class="block bg-[#181E31] border border-slate-800/60 rounded-2xl p-4 hover:border-indigo-500/50 hover:bg-[#1a2040] active:scale-[0.98] transition-all duration-200 shadow-sm">
                        <!-- Match Meta Row -->
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">
                                <?php if (!empty($match['commentator'])): ?>
                                    <i class="fa-solid fa-microphone text-[8px] mr-1"></i><?php echo htmlspecialchars($match['commentator']); ?>
                                <?php endif; ?>
                            </span>

                            <!-- Status Badge -->
                            <?php if ($match['status'] === 'live'): ?>
                                <span class="inline-flex items-center space-x-1.5 bg-emerald-500/15 border border-emerald-500/25 text-emerald-400 text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full live-glow shrink-0"></span>
                                    <span>LIVE</span>
                                </span>
                            <?php elseif ($match['status'] === 'finished'): ?>
                                <span class="inline-flex items-center bg-slate-800 border border-slate-700/50 text-slate-400 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full">
                                    Ended
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full">
                                    <?php echo date('H:i', strtotime($match['match_time'])); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Teams Row -->
                        <div class="flex items-center justify-between">
                            <!-- Home Team -->
                            <div class="flex flex-col items-center space-y-2 flex-1 min-w-0">
                                <div class="w-14 h-14 rounded-xl bg-slate-900/80 border border-slate-800/60 flex items-center justify-center p-2">
                                    <?php if (!empty($match['home_team_logo'])): ?>
                                        <img src="uploads/<?php echo ltrim(htmlspecialchars($match['home_team_logo']), 'uploads/'); ?>" class="w-full h-full object-contain" alt="">
                                    <?php else: ?>
                                        <i class="fa-solid fa-futbol text-slate-600 text-xl"></i>
                                    <?php endif; ?>
                                </div>
                                <span class="text-xs font-semibold text-white text-center leading-tight line-clamp-2 px-1">
                                    <?php echo htmlspecialchars($match['home_team_name']); ?>
                                </span>
                            </div>

                            <!-- Center Score / VS -->
                            <div class="flex flex-col items-center justify-center px-3 shrink-0">
                                <?php if ($match['status'] !== 'upcoming'): ?>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-2xl font-extrabold text-white tabular-nums"><?php echo $match['home_score']; ?></span>
                                        <span class="text-lg font-bold text-slate-600">-</span>
                                        <span class="text-2xl font-extrabold text-white tabular-nums"><?php echo $match['away_score']; ?></span>
                                    </div>
                                    <?php if ($match['status'] === 'live'): ?>
                                        <span class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest mt-0.5">Live</span>
                                    <?php else: ?>
                                        <span class="text-[9px] text-slate-600 uppercase tracking-widest mt-0.5">FT</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-sm font-bold text-slate-500 tracking-widest">VS</span>
                                <?php endif; ?>
                            </div>

                            <!-- Away Team -->
                            <div class="flex flex-col items-center space-y-2 flex-1 min-w-0">
                                <div class="w-14 h-14 rounded-xl bg-slate-900/80 border border-slate-800/60 flex items-center justify-center p-2">
                                    <?php if (!empty($match['away_team_logo'])): ?>
                                        <img src="uploads/<?php echo ltrim(htmlspecialchars($match['away_team_logo']), 'uploads/'); ?>" class="w-full h-full object-contain" alt="">
                                    <?php else: ?>
                                        <i class="fa-solid fa-futbol text-slate-600 text-xl"></i>
                                    <?php endif; ?>
                                </div>
                                <span class="text-xs font-semibold text-white text-center leading-tight line-clamp-2 px-1">
                                    <?php echo htmlspecialchars($match['away_team_name']); ?>
                                </span>
                            </div>
                        </div>

                        <!-- Bottom Meta: Channel Name -->
                        <?php if (!empty($match['channel_name'])): ?>
                            <div class="mt-3 pt-3 border-t border-slate-800/50 flex items-center space-x-1.5">
                                <i class="fa-solid fa-tv text-[9px] text-slate-600"></i>
                                <span class="text-[10px] text-slate-500"><?php echo htmlspecialchars($match['channel_name']); ?></span>
                            </div>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
// Custom date picker redirect
document.getElementById('custom-date-picker')?.addEventListener('change', function() {
    if (this.value) {
        window.location.href = 'index.php?page=home&date=' + this.value;
    }
});
</script>

<?php require_once dirname(dirname(__DIR__)) . '/views/frontend/footer.php'; ?>
