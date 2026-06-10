<?php
/**
 * Admin Matches Index View
 */
$title = 'Manage Matches';
require_once dirname(dirname(__DIR__)) . '/views/layouts/header.php';
?>

<div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-6 shadow-sm">
    <!-- Header Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-800/80 mb-6 gap-4">
        <div>
            <h3 class="text-lg font-bold text-white">Matches & Streaming Streams</h3>
            <p class="text-xs text-slate-500 mt-1">Configure scheduled matches, commentators, channels, and active server streams</p>
        </div>
        
        <a href="index.php?page=admin_matches&action=create" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs tracking-wider uppercase transition shadow-lg shadow-indigo-500/10">
            <i class="fa-solid fa-plus mr-1.5 text-[10px]"></i> Add Match
        </a>
    </div>

    <!-- Match Lists -->
    <?php if (empty($matches)): ?>
        <div class="text-center py-16 text-slate-500 border border-dashed border-slate-800 rounded-xl">
            <i class="fa-solid fa-futbol text-4xl text-slate-700 mb-3 block"></i>
            <p class="text-sm">No matches found.</p>
            <p class="text-xs text-slate-600 mt-1">Get started by clicking the "Add Match" button above.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-800/50 pb-3">
                        <th class="pb-3 pr-4">League</th>
                        <th class="pb-3 text-right">Home Team</th>
                        <th class="pb-3 text-center px-4">VS / Score</th>
                        <th class="pb-3 text-left">Away Team</th>
                        <th class="pb-3">Match Date & Time</th>
                        <th class="pb-3">Commentator</th>
                        <th class="pb-3 text-center">Status</th>
                        <th class="pb-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50 text-sm">
                    <?php foreach ($matches as $match): ?>
                        <tr class="align-middle">
                            <!-- League Name -->
                            <td class="py-4 text-xs font-medium text-slate-400 max-w-[150px] truncate">
                                <?php echo htmlspecialchars($match['league_name']); ?>
                            </td>

                            <!-- Home Team -->
                            <td class="py-4 text-right pr-4 font-semibold text-white">
                                <span class="inline-flex items-center space-x-2">
                                    <span><?php echo htmlspecialchars($match['home_team_name']); ?></span>
                                    <?php if (!empty($match['home_team_logo'])): ?>
                                        <img src="../<?php echo htmlspecialchars($match['home_team_logo']); ?>" class="w-6 h-6 object-contain inline" alt="">
                                    <?php endif; ?>
                                </span>
                            </td>

                            <!-- Score / Separator -->
                            <td class="py-4 text-center px-4 font-bold whitespace-nowrap">
                                <?php if ($match['status'] !== 'upcoming'): ?>
                                    <span class="bg-slate-950/50 border border-slate-800 text-slate-200 px-3 py-1 rounded-lg">
                                        <?php echo $match['home_score'] . ' - ' . $match['away_score']; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-slate-600">VS</span>
                                <?php endif; ?>
                            </td>

                            <!-- Away Team -->
                            <td class="py-4 text-left font-semibold text-white">
                                <span class="inline-flex items-center space-x-2">
                                    <?php if (!empty($match['away_team_logo'])): ?>
                                        <img src="../<?php echo htmlspecialchars($match['away_team_logo']); ?>" class="w-6 h-6 object-contain inline" alt="">
                                    <?php endif; ?>
                                    <span><?php echo htmlspecialchars($match['away_team_name']); ?></span>
                                </span>
                            </td>

                            <!-- Match Time -->
                            <td class="py-4 text-slate-300 font-medium">
                                <?php echo date('M d, Y - H:i', strtotime($match['match_time'])); ?>
                            </td>

                            <!-- Commentator -->
                            <td class="py-4 text-slate-400">
                                <?php echo htmlspecialchars(!empty($match['commentator']) ? $match['commentator'] : 'None'); ?>
                            </td>

                            <!-- Status Badge -->
                            <td class="py-4 text-center">
                                <?php if ($match['status'] === 'live'): ?>
                                    <span class="inline-flex items-center space-x-1 bg-emerald-500/15 text-emerald-400 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full live-glow"></span>
                                        <span>Live</span>
                                    </span>
                                <?php elseif ($match['status'] === 'finished'): ?>
                                    <span class="inline-flex items-center bg-slate-800 text-slate-400 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded border border-slate-700/50">
                                        Ended
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center bg-blue-500/15 text-blue-400 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded border border-blue-500/20">
                                        Upcoming
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center space-x-2">
                                    <!-- Edit -->
                                    <a href="index.php?page=admin_matches&action=edit&id=<?php echo $match['id']; ?>" 
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-500/10 hover:bg-indigo-600 border border-indigo-500/20 text-indigo-400 hover:text-white transition">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <!-- Delete -->
                                    <a href="index.php?page=admin_matches&action=delete&id=<?php echo $match['id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this match? This will also remove all associated server links.');"
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
