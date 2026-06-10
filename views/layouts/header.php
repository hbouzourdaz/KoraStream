<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KoraStream Admin Dashboard</title>
    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: {
                            bg: '#0B0F19',
                            card: '#111827',
                            border: '#1F2937',
                            surface: '#1E293B'
                        },
                        brand: {
                            primary: '#10B981', // Emerald
                            accent: '#6366F1' // Indigo
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#0B0F19] text-slate-300 antialiased overflow-x-hidden">
    <div class="flex min-h-screen">
        <!-- Sidebar Navigation -->
        <?php require_once 'sidebar.php'; ?>
        
        <!-- Main Content Area -->
        <div class="flex-grow flex flex-col min-w-0">
            <!-- Admin Topbar -->
            <header class="h-16 border-b border-slate-900 bg-[#0F1322] flex items-center justify-between px-6 z-20 sticky top-0">
                <div class="flex items-center space-x-3">
                    <button id="sidebar-toggle" class="lg:hidden text-slate-400 hover:text-white transition">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wider hidden sm:block">
                        <?php echo htmlspecialchars(isset($title) ? $title : 'Control Panel'); ?>
                    </h2>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Front-end Site Button -->
                    <a href="index.php" target="_blank" class="inline-flex items-center justify-center px-4 py-1.5 rounded-xl border border-slate-800 text-xs text-slate-400 hover:text-white transition hover:bg-slate-900">
                        <i class="fa-solid fa-globe mr-1.5 text-indigo-400"></i> View Site
                    </a>
                    
                    <!-- Admin Avatar Dropdown -->
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center border border-slate-700 text-slate-300 font-semibold text-sm">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <div class="hidden md:block">
                            <p class="text-xs font-semibold text-white"><?php echo htmlspecialchars($_SESSION['admin_email'] ?? 'Admin'); ?></p>
                            <p class="text-[10px] text-slate-500 capitalize"><?php echo htmlspecialchars($_SESSION['admin_role'] ?? 'super_admin'); ?></p>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Dynamic Content Wrapper -->
            <main class="flex-grow p-6">
                <!-- Status Notifications -->
                <?php if (isset($_GET['status'])): ?>
                    <?php 
                        $status = $_GET['status'];
                        $alertMsg = '';
                        $alertColor = '';
                        if ($status === 'created') {
                            $alertMsg = 'Resource added successfully.';
                            $alertColor = 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400';
                        } elseif ($status === 'updated') {
                            $alertMsg = 'Resource updated successfully.';
                            $alertColor = 'bg-indigo-500/10 border-indigo-500/20 text-indigo-400';
                        } elseif ($status === 'deleted') {
                            $alertMsg = 'Resource deleted successfully.';
                            $alertColor = 'bg-rose-500/10 border-rose-500/20 text-rose-400';
                        } elseif ($status === 'saved') {
                            $alertMsg = 'Settings saved successfully.';
                            $alertColor = 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400';
                        } elseif ($status === 'error') {
                            $alertMsg = 'An error occurred during submission. Please try again.';
                            $alertColor = 'bg-rose-500/10 border-rose-500/20 text-rose-400';
                        }
                    ?>
                    <?php if (!empty($alertMsg)): ?>
                        <div class="flex items-center p-4 mb-6 text-sm rounded-xl border <?php echo $alertColor; ?> alert-box">
                            <i class="fa-solid fa-circle-check mr-2 text-base"></i>
                            <span class="flex-grow font-medium"><?php echo $alertMsg; ?></span>
                            <button type="button" class="alert-close text-slate-400 hover:text-white transition">
                                <i class="fa-solid fa-xmark text-xs"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
