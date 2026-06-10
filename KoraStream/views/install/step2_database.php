<?php
/**
 * Installer Step 2 View - Database Setup
 */
?>

<div class="space-y-4" id="db-step-container">
    <h2 class="text-lg font-semibold text-white">Database Settings</h2>
    <p class="text-sm text-slate-400">Configure your MySQL database connection coordinates.</p>

    <!-- Error Alert -->
    <div id="db-error-alert" class="hidden flex items-center p-4 mb-4 text-sm rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400">
        <i class="fa-solid fa-circle-exclamation mr-2"></i>
        <span id="db-error-msg"></span>
    </div>

    <!-- Form -->
    <form id="db-setup-form" class="space-y-4">
        <!-- DB Host -->
        <div>
            <label class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">Database Host</label>
            <input type="text" name="host" value="localhost" required 
                   class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
        </div>

        <!-- DB Name -->
        <div>
            <label class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">Database Name</label>
            <input type="text" name="name" value="korastream_db" required 
                   class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
        </div>

        <!-- DB User -->
        <div>
            <label class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">Database Username</label>
            <input type="text" name="user" value="root" required 
                   class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
        </div>

        <!-- DB Password -->
        <div>
            <label class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">Database Password</label>
            <input type="password" name="pass" placeholder="leave empty if none"
                   class="w-full bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-4">
            <a href="install.php?step=1" class="text-sm font-medium text-slate-500 hover:text-slate-300 transition">
                <i class="fa-solid fa-arrow-left mr-1.5 text-xs"></i> Back
            </a>
            
            <button type="submit" id="test-connection-btn" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm transition shadow-lg shadow-indigo-500/10">
                <span id="btn-text">Test & Connect</span>
                <i id="btn-spinner" class="fa-solid fa-spinner fa-spin ml-2 hidden"></i>
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('db-setup-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const btn = document.getElementById('test-connection-btn');
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');
    const alert = document.getElementById('db-error-alert');
    const errorMsg = document.getElementById('db-error-msg');

    // Show loading
    btn.disabled = true;
    btnText.textContent = 'Testing connection...';
    btnSpinner.classList.remove('hidden');
    alert.classList.add('hidden');

    const formData = new FormData(form);

    fetch('install.php?step=2&action=test_db', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            // Success, go to next step
            window.location.href = 'install.php?step=3';
        } else {
            // Error
            errorMsg.textContent = data.message;
            alert.classList.remove('hidden');
            
            // Reset button
            btn.disabled = false;
            btnText.textContent = 'Test & Connect';
            btnSpinner.classList.add('hidden');
        }
    })
    .catch(err => {
        errorMsg.textContent = 'A network error occurred. Please try again.';
        alert.classList.remove('hidden');
        
        btn.disabled = false;
        btnText.textContent = 'Test & Connect';
        btnSpinner.classList.add('hidden');
    });
});
</script>
