<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KoraStream - Admin Login</title>
    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-6px); }
            75% { transform: translateX(6px); }
        }
        .shake-err {
            animation: shake 0.4s ease-in-out;
        }
    </style>
</head>
<body class="bg-[#0B0F19] text-slate-300 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Decorative background blobs -->
    <div class="absolute top-[-15%] right-[-10%] w-[55%] h-[55%] rounded-full bg-indigo-600/10 blur-[130px] pointer-events-none"></div>
    <div class="absolute bottom-[-15%] left-[-10%] w-[55%] h-[55%] rounded-full bg-emerald-500/10 blur-[130px] pointer-events-none"></div>

    <div class="w-full max-w-md bg-slate-900/75 border border-slate-800 rounded-3xl p-8 backdrop-blur-md shadow-2xl relative z-10">
        <!-- Logo Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-indigo-600/20 text-indigo-400 border border-indigo-500/25 mb-4 shadow-lg shadow-indigo-500/5">
                <i class="fa-solid fa-user-shield text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-wide">Admin Portal</h1>
            <p class="text-xs text-slate-500 mt-1">Access the KoraStream management dashboard</p>
        </div>

        <!-- Alert Error -->
        <?php if (isset($error)): ?>
            <div class="flex items-center p-4 mb-5 text-sm rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 shake-err alert-box">
                <i class="fa-solid fa-triangle-exclamation mr-2.5"></i>
                <span class="flex-grow"><?php echo htmlspecialchars($error); ?></span>
                <button type="button" class="alert-close text-rose-400 hover:text-white transition">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="index.php?page=admin&action=login" method="POST" class="space-y-5">
            <!-- Email -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <input type="email" name="email" required placeholder="admin@domain.com"
                           class="w-full bg-slate-950/60 border border-slate-800 rounded-xl pl-10 pr-4 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
                </div>
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400">Password</label>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <input type="password" id="login-pass" name="password" required placeholder="••••••••"
                           class="w-full bg-slate-950/60 border border-slate-800 rounded-xl pl-10 pr-10 py-2.5 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
                    <button type="button" id="toggle-pass-visibility" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-300 transition">
                        <i class="fa-regular fa-eye" id="pass-icon"></i>
                    </button>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition shadow-lg shadow-indigo-500/25">
                Sign In
            </button>
        </form>
    </div>

    <!-- Alert Dismiss Script -->
    <script>
        document.querySelectorAll('.alert-close').forEach(btn => {
            btn.addEventListener('click', () => {
                const box = btn.closest('.alert-box');
                if (box) box.remove();
            });
        });

        // Pass visibility
        const toggleBtn = document.getElementById('toggle-pass-visibility');
        const passInput = document.getElementById('login-pass');
        const passIcon = document.getElementById('pass-icon');

        if (toggleBtn && passInput) {
            toggleBtn.addEventListener('click', () => {
                if (passInput.type === 'password') {
                    passInput.type = 'text';
                    passIcon.className = 'fa-regular fa-eye-slash';
                } else {
                    passInput.type = 'password';
                    passIcon.className = 'fa-regular fa-eye';
                }
            });
        }
    </script>
</body>
</html>
