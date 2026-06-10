<?php
/**
 * Installer Step 3 View - Administrator Credentials
 */
?>

<div class="space-y-4">
    <h2 class="text-lg font-semibold text-white">Administrator Account</h2>
    <p class="text-sm text-slate-400">Set up the administrative account credentials for managing KoraStream.</p>

    <form id="admin-setup-form" action="install.php?step=3" method="POST" class="space-y-4">
        <!-- Email -->
        <div>
            <label class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">Administrator Email</label>
            <input type="email" name="admin_email" placeholder="admin@domain.com" required
                   class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
        </div>

        <!-- Password -->
        <div>
            <label class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">Administrator Password</label>
            <input type="password" id="admin_password" name="admin_pass" required minlength="6"
                   class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            <!-- Strength meter -->
            <div class="mt-2 h-1 w-full bg-slate-800 rounded-full overflow-hidden">
                <div id="strength-bar" class="h-full w-0 bg-rose-500 transition-all duration-300"></div>
            </div>
            <p id="strength-text" class="text-[10px] text-slate-500 mt-1">Password must be at least 6 characters</p>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-4">
            <a href="install.php?step=2" class="text-sm font-medium text-slate-500 hover:text-slate-300 transition">
                <i class="fa-solid fa-arrow-left mr-1.5 text-xs"></i> Back
            </a>
            
            <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm transition shadow-lg shadow-indigo-500/10">
                Continue to Finalize <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('admin_password').addEventListener('input', function() {
    const val = this.value;
    const bar = document.getElementById('strength-bar');
    const txt = document.getElementById('strength-text');

    if (val.length === 0) {
        bar.style.width = '0%';
        txt.textContent = 'Password must be at least 6 characters';
        return;
    }

    if (val.length < 6) {
        bar.style.width = '25%';
        bar.className = 'h-full bg-rose-500 transition-all duration-300';
        txt.textContent = 'Weak (minimum 6 characters)';
        return;
    }

    // Determine strength
    let score = 0;
    if (val.match(/[a-z]/)) score++;
    if (val.match(/[A-Z]/)) score++;
    if (val.match(/[0-9]/)) score++;
    if (val.match(/[^a-zA-Z0-9]/)) score++;

    if (score <= 2) {
        bar.style.width = '50%';
        bar.className = 'h-full bg-orange-500 transition-all duration-300';
        txt.textContent = 'Moderate';
    } else if (score === 3) {
        bar.style.width = '75%';
        bar.className = 'h-full bg-blue-500 transition-all duration-300';
        txt.textContent = 'Strong';
    } else {
        bar.style.width = '100%';
        bar.className = 'h-full bg-emerald-500 transition-all duration-300';
        txt.textContent = 'Excellent strength';
    }
});

document.getElementById('admin-setup-form').addEventListener('submit', function(e) {
    // Save admin info temporarily in session before redirecting
    // (Standard POST form submit redirects to step 4, but we can pass fields via inputs, layout.php will carry over variables via POST, or we can handle it via hidden fields/session inside routes/install.php).
});
</script>
