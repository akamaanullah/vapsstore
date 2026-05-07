<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= \App\Core\Session::getCsrfToken() ?>">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Vape Admin Dashboard'; ?></title>
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Toastr & SweetAlert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom Style -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin_assets/css/style.css">

    <script>
        window.BASE_URL = '<?= BASE_URL ?>';
        window.MEDIA_BASE_URL = '<?= BASE_URL ?>';
    </script>
</head>
<body>
    <div class="app-container">
        <?php include __DIR__ . '/sidebar.php'; ?>
        
        <div class="main-wrapper">
            <header class="topbar">
                <div class="topbar-left" style="display: flex; align-items: center; gap: 20px;">
                    <button class="menu-toggle" id="sidebarToggle">
                        <i data-lucide="menu" class="icon-open"></i>
                        <i data-lucide="chevron-right" class="icon-closed"></i>
                    </button>
                    <span style="font-weight: 500; font-size: 14px;">Welcome to The Perfect Vape!</span>
                </div>
                
                <div class="topbar-right">
                    <?php 
                    $userName = \App\Core\Session::get('user_name') ?? 'Admin';
                    $userEmail = \App\Core\Session::get('user_email') ?? '';
                    $avatarName = urlencode($userName);
                    ?>
                    <div class="user-profile-container">
                        <div class="user-profile" id="userProfileToggle">
                            <img src="https://ui-avatars.com/api/?name=<?= $avatarName ?>&background=6f6af8&color=fff" alt="Profile">
                        </div>
                        
                        <div class="user-dropdown" id="userDropdown">
                            <div class="dropdown-header">
                                <img src="https://ui-avatars.com/api/?name=<?= $avatarName ?>&background=6f6af8&color=fff" alt="Profile">
                                <div class="user-meta">
                                    <p class="user-name"><?= htmlspecialchars($userName) ?></p>
                                    <p class="user-role"><?= htmlspecialchars($userEmail) ?></p>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="<?= BASE_URL ?>/admin/logout" class="dropdown-item logout-item">
                                <i data-lucide="log-out"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Sidebar Toggle
                const sidebarToggle = document.getElementById('sidebarToggle');
                const body = document.body;

                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', function() {
                        body.classList.toggle('collapsed-sidebar');
                    });
                }

                // Profile Dropdown
                const profileToggle = document.getElementById('userProfileToggle');
                const dropdown = document.getElementById('userDropdown');

                if (profileToggle && dropdown) {
                    profileToggle.addEventListener('click', function(e) {
                        e.stopPropagation();
                        dropdown.classList.toggle('show');
                    });

                    document.addEventListener('click', function(e) {
                        if (!dropdown.contains(e.target) && !profileToggle.contains(e.target)) {
                            dropdown.classList.remove('show');
                        }
                    });
                }
            });
            </script>

            <main class="content-body">
