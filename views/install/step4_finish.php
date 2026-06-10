<?php
/**
 * Installer Step 4 View - Finalize & Execute
 * Admin credentials are pulled from $_SESSION['install_admin']
 */
$adminEmail = isset($_SESSION['install_admin']['email']) ? $_SESSION['install_admin']['email'] : '';
$dbInfo     = isset($_SESSION['install_db'])             ? $_SESSION['install_db']             : null;

// Guard — session expired or skipped step
if (empty($adminEmail) || !$dbInfo) {
    echo '<div class="p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm rounded-xl">
        <i class="fa-solid fa-triangle-exclamation mr-2"></i>
        Session data is missing. Please 
        <a href="install.php?step=2" class="underline">go back to step 2</a> and restart the process.
    </div>';
    return; // Don't render the rest
}
?>

<div class="space-y-4" id="finalize-step-container">
    <!-- ── Execution view ──────────────────────────────── -->
    <div id="execution-view">
        <h2 class="text-lg font-semibold text-white">Review & Install</h2>
        <p class="text-sm text-slate-400">Confirm the details below then click Execute Installation.</p>

        <!-- Configuration Summary -->
        <div class="space-y-2.5 bg-slate-950/45 p-4 rounded-2xl border border-slate-800/40 text-sm mt-4">
            <div class="flex items-center justify-between border-b border-slate-800/60 pb-2.5">
                <span class="text-slate-500">Database Host</span>
                <span class="text-white font-medium"><?php echo htmlspecialchars($dbInfo['host']); ?></span>
            </div>
            <div class="flex items-center justify-between border-b border-slate-800/60 pb-2.5">
                <span class="text-slate-500">Database Name</span>
                <span class="text-white font-medium"><?php echo htmlspecialchars($dbInfo['name']); ?></span>
            </div>
            <div class="flex items-center justify-between border-b border-slate-800/60 pb-2.5">
                <span class="text-slate-500">Database User</span>
                <span class="text-white font-medium"><?php echo htmlspecialchars($dbInfo['user']); ?></span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-slate-500">Administrator Email</span>
                <span class="text-white font-medium"><?php echo htmlspecialchars($adminEmail); ?></span>
            </div>
        </div>

        <!-- Error Alert -->
        <div id="install-error-alert" class="hidden flex items-center p-4 mt-4 text-sm rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400">
            <i class="fa-solid fa-circle-exclamation mr-2"></i>
            <span id="install-error-msg"></span>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-6">
            <a href="install.php?step=3" class="text-sm font-medium text-slate-500 hover:text-slate-300 transition">
                <i class="fa-solid fa-arrow-left mr-1.5 text-xs"></i> Back
            </a>

            <button type="button" id="install-execute-btn"
                    onclick="executeInstall()"
                    class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm transition shadow-lg shadow-emerald-500/10">
                <span id="install-btn-text">Execute Installation</span>
                <i id="install-spinner" class="fa-solid fa-circle-notch fa-spin ml-2 hidden"></i>
            </button>
        </div>
    </div>

    <!-- ── Success view (shown after install) ──────────── -->
    <div id="success-view" class="hidden text-center py-6 space-y-6">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-600/10 text-emerald-400 border border-emerald-500/20 shadow-lg animate-bounce">
            <i class="fa-solid fa-check text-4xl"></i>
        </div>

        <div>
            <h2 class="text-2xl font-bold text-white tracking-wide">Installation Successful!</h2>
            <p class="text-sm text-slate-400 mt-2">KoraStream is ready. Log in with your admin credentials.</p>
        </div>

        <div class="bg-slate-950/40 p-4 rounded-xl border border-slate-800 text-xs text-slate-500 inline-block">
            <i class="fa-solid fa-shield-halved mr-1.5 text-indigo-400"></i>
            The installer is now blocked from rerunning for security.
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
            <a href="index.php" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm transition shadow-lg shadow-indigo-500/10">
                <i class="fa-solid fa-globe mr-2"></i> Visit Homepage
            </a>
            <a href="index.php?page=admin&action=login" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700/60 text-white font-medium text-sm transition">
                <i class="fa-solid fa-lock mr-2"></i> Admin Login
            </a>
        </div>
    </div>
</div>

<script>
function executeInstall() {
    const btn     = document.getElementById('install-execute-btn');
    const btnText = document.getElementById('install-btn-text');
    const spinner = document.getElementById('install-spinner');
    const alert   = document.getElementById('install-error-alert');
    const errMsg  = document.getElementById('install-error-msg');

    btn.disabled = true;
    btnText.textContent = 'Installing…';
    spinner.classList.remove('hidden');
    alert.classList.add('hidden');

    // No body needed — credentials are in $_SESSION on the server
    fetch('install.php?step=4&action=execute', {
        method: 'POST',
        body: new FormData()   // empty body; server reads session
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            document.getElementById('execution-view').classList.add('hidden');
            document.getElementById('success-view').classList.remove('hidden');
        } else {
            errMsg.textContent = data.message;
            alert.classList.remove('hidden');
            btn.disabled = false;
            btnText.textContent = 'Execute Installation';
            spinner.classList.add('hidden');
        }
    })
    .catch(() => {
        errMsg.textContent = 'A network error occurred. Check your server logs.';
        alert.classList.remove('hidden');
        btn.disabled = false;
        btnText.textContent = 'Execute Installation';
        spinner.classList.add('hidden');
    });
}
</script>
