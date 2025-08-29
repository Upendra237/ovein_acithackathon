<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    <meta name="description" content="Hackathon System - Discover places, events, and guides">
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%23667eea'/><text x='50' y='65' font-size='50' text-anchor='middle' fill='white' font-family='Arial'>H</text></svg>">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Desktop Navigation */
        .desktop-nav {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            backdrop-filter: blur(20px);
            z-index:9999;
        }
        
        .nav-link {
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
        }
        
        .nav-link:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
        }
        
        .nav-active {
            background: rgba(255, 255, 255, 0.2) !important;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);
        }
        
        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }
        
        .profile-button {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }
        
        .profile-button:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
        }
        
        .profile-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 12px;
            z-index: 100000;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .profile-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }
        
        .profile-menu::before {
            content: '';
            position: absolute;
            top: -6px;
            right: 24px;
            width: 12px;
            height: 12px;
            background: white;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            border-bottom: none;
            border-right: none;
        }
        
        /* Mobile Navigation */
        @media (max-width: 768px) {
            .desktop-nav {
                display: none;
            }
            
            .mobile-nav {
                background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            }
            
            .mobile-menu {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border-top: 1px solid rgba(0, 0, 0, 0.1);
                z-index: 1000000;
                box-shadow: 0 -8px 32px rgba(0, 0, 0, 0.12);
            }
            
            .mobile-menu-item {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border-radius: 16px;
                margin: 6px;
                color: #6b7280;
            }
            
            .mobile-menu-item:hover,
            .mobile-menu-item.active {
                background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            }
            
            .mobile-menu-item i {
                font-size: 20px;
                margin-bottom: 4px;
            }
            
            body {
                padding-bottom: 90px;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-nav,
            .mobile-menu {
                display: none;
            }
        }
        
        /* Improved animations */
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Desktop Navigation -->
    <nav class="desktop-nav">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="<?php echo url('/'); ?>" class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-rocket mr-2"></i>
                        <?php echo SITE_NAME; ?>
                    </a>
                </div>
                
                <div class="flex items-center space-x-2">
                    <?php 
                    $current_page = basename($_SERVER['PHP_SELF'], '.php');
                    $current_dir = basename(dirname($_SERVER['PHP_SELF']));
                    ?>
                    
                    <a href="<?php echo url('/'); ?>" 
                       class="nav-link text-white px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition-all <?php echo ($current_page == 'index' && $current_dir != 'places' && $current_dir != 'events' && $current_dir != 'guides') ? 'nav-active' : ''; ?>">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                    <a href="<?php echo url('/places/'); ?>" 
                       class="nav-link text-white px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition-all <?php echo $current_dir == 'places' ? 'nav-active' : ''; ?>">
                        <i class="fas fa-map-marker-alt mr-2"></i>Places
                    </a>
                    <a href="<?php echo url('/events/'); ?>" 
                       class="nav-link text-white px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition-all <?php echo $current_dir == 'events' ? 'nav-active' : ''; ?>">
                        <i class="fas fa-calendar mr-2"></i>Events
                    </a>
                    <a href="<?php echo url('/guides/'); ?>" 
                       class="nav-link text-white px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition-all <?php echo $current_dir == 'guides' ? 'nav-active' : ''; ?>">
                        <i class="fas fa-book mr-2"></i>Guides
                    </a>
                    
                    <!-- Profile Dropdown -->
                    <div class="profile-dropdown">
                        <button class="profile-button flex items-center text-white px-5 py-2.5 rounded-xl transition-all">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <?php if (isLoggedIn()): ?>
                                <span class="font-medium"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            <?php else: ?>
                                <span class="font-medium">Account</span>
                            <?php endif; ?>
                            <i class="fas fa-chevron-down ml-3 text-xs opacity-70"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="profile-menu w-72 bg-white rounded-2xl shadow-2xl">
                            <?php if (isLoggedIn()): ?>
                                <!-- Logged In Menu -->
                                <div class="p-6 border-b border-gray-100">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                            <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                                        </div>
                                        <div class="ml-4">
                                            <p class="font-semibold text-gray-900 text-lg"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                                            <p class="text-sm text-gray-500 capitalize"><?php echo htmlspecialchars($_SESSION['user_type']); ?> Account</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-3">
                                    <a href="<?php echo url('/dashboard.php'); ?>" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 transition-all group">
                                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-tachometer-alt text-blue-600"></i>
                                        </div>
                                        <span class="font-medium">Dashboard</span>
                                    </a>
                                    <a href="<?php echo url('/logout.php'); ?>" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 hover:text-red-600 transition-all group">
                                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-red-200 transition-colors">
                                            <i class="fas fa-sign-out-alt text-red-600"></i>
                                        </div>
                                        <span class="font-medium">Sign Out</span>
                                    </a>
                                </div>
                            <?php else: ?>
                                <!-- Not Logged In Menu -->
                                <div class="p-6">
                                    <div class="text-center mb-6">
                                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-user text-white text-xl"></i>
                                        </div>
                                        <h3 class="font-bold text-gray-900 text-lg mb-2">Welcome Back!</h3>
                                        <p class="text-sm text-gray-600">Sign in to access your personalized dashboard</p>
                                    </div>
                                    <a href="<?php echo url('/login.php'); ?>" class="block w-full bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white text-center py-3 px-4 rounded-xl hover:shadow-lg hover:scale-105 transition-all font-medium">
                                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In Now
                                    </a>
                                </div>
                                <div class="px-6 pb-6">
                                    <div class="text-xs text-gray-500 bg-gray-50 p-4 rounded-xl">
                                        <div class="font-semibold text-gray-700 mb-2">Demo Accounts:</div>
                                        <div class="space-y-1">
                                            <div>👑 Admin: admin / password</div>
                                            <div>👤 User: user1 / password</div>
                                            <div>💻 Developer: developer / password</div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Top Navigation -->
    <nav class="mobile-nav md:hidden">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="<?php echo url('/'); ?>" class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-rocket mr-2"></i>
                        <?php echo SITE_NAME; ?>
                    </a>
                </div>
                
                <div class="profile-dropdown">
                    <button class="profile-button flex items-center text-white px-3 py-2 rounded-xl transition-all">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                        <?php if (isLoggedIn()): ?>
                            <span class="ml-2 font-medium text-sm"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        <?php endif; ?>
                        <i class="fas fa-chevron-down ml-2 text-xs opacity-70"></i>
                    </button>
                    
                    <!-- Mobile Dropdown Menu -->
                    <div class="profile-menu w-64 bg-white rounded-2xl shadow-2xl">
                        <?php if (isLoggedIn()): ?>
                            <!-- Mobile Logged In Menu -->
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                        <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-900"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                                        <p class="text-xs text-gray-500 capitalize"><?php echo htmlspecialchars($_SESSION['user_type']); ?> Account</p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-2">
                                <a href="<?php echo url('/dashboard.php'); ?>" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors">
                                    <i class="fas fa-tachometer-alt mr-3 text-blue-600"></i>
                                    <span class="font-medium">Dashboard</span>
                                </a>
                                <a href="<?php echo url('/logout.php'); ?>" class="flex items-center px-4 py-3 text-gray-700 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-3 text-red-600"></i>
                                    <span class="font-medium">Sign Out</span>
                                </a>
                            </div>
                        <?php else: ?>
                            <!-- Mobile Not Logged In Menu -->
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-2">Welcome!</h3>
                                <p class="text-sm text-gray-600 mb-4">Sign in to access your dashboard</p>
                                <a href="<?php echo url('/login.php'); ?>" class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white text-center py-2 px-4 rounded-lg hover:shadow-lg transition-all font-medium">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Bottom Navigation -->
    <div class="mobile-menu">
        <div class="flex justify-around py-4">
            <a href="<?php echo url('/'); ?>" 
               class="mobile-menu-item flex flex-col items-center py-2 px-4 <?php echo ($current_page == 'index' && $current_dir != 'places' && $current_dir != 'events' && $current_dir != 'guides') ? 'active' : ''; ?>">
                <i class="fas fa-home"></i>
                <span class="text-xs mt-1 font-medium">Home</span>
            </a>
            <a href="<?php echo url('/places/'); ?>" 
               class="mobile-menu-item flex flex-col items-center py-2 px-4 <?php echo $current_dir == 'places' ? 'active' : ''; ?>">
                <i class="fas fa-map-marker-alt"></i>
                <span class="text-xs mt-1 font-medium">Places</span>
            </a>
            <a href="<?php echo url('/events/'); ?>" 
               class="mobile-menu-item flex flex-col items-center py-2 px-4 <?php echo $current_dir == 'events' ? 'active' : ''; ?>">
                <i class="fas fa-calendar"></i>
                <span class="text-xs mt-1 font-medium">Events</span>
            </a>
            <a href="<?php echo url('/guides/'); ?>" 
               class="mobile-menu-item flex flex-col items-center py-2 px-4 <?php echo $current_dir == 'guides' ? 'active' : ''; ?>">
                <i class="fas fa-book"></i>
                <span class="text-xs mt-1 font-medium">Guides</span>
            </a>
            <?php if (isLoggedIn()): ?>
                <a href="<?php echo url('/dashboard.php'); ?>" 
                   class="mobile-menu-item flex flex-col items-center py-2 px-4 <?php echo $current_page == 'dashboard' ? 'active' : ''; ?>">
                    <i class="fas fa-user"></i>
                    <span class="text-xs mt-1 font-medium">Profile</span>
                </a>
            <?php else: ?>
                <a href="<?php echo url('/login.php'); ?>" 
                   class="mobile-menu-item flex flex-col items-center py-2 px-4 <?php echo $current_page == 'login' ? 'active' : ''; ?>">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="text-xs mt-1 font-medium">Login</span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Profile dropdown functionality
        document.addEventListener('DOMContentLoaded', () => {
            const profileButtons = document.querySelectorAll('.profile-button');
            const profileMenus = document.querySelectorAll('.profile-menu');
            
            profileButtons.forEach((button, index) => {
                const menu = profileMenus[index];
                if (button && menu) {
                    button.addEventListener('click', (e) => {
                        e.stopPropagation();
                        
                        // Close all other menus
                        profileMenus.forEach((otherMenu, otherIndex) => {
                            if (otherIndex !== index) {
                                otherMenu.classList.remove('show');
                            }
                        });
                        
                        // Toggle current menu
                        menu.classList.toggle('show');
                    });
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                let clickedInsideAny = false;
                profileButtons.forEach((button, index) => {
                    const menu = profileMenus[index];
                    if (button.contains(e.target) || menu.contains(e.target)) {
                        clickedInsideAny = true;
                    }
                });
                
                if (!clickedInsideAny) {
                    profileMenus.forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });
            
            // Close dropdown when pressing escape
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    profileMenus.forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });
        });
    </script>