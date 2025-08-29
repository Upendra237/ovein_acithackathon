<?php
// require_once '../config/config.php';

// $page_title = 'Events';
// include '../includes/header.php';
// ?>

<?php
require_once '../config/config.php';

$page_title = 'Home';
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NepalDiscovery - Events</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #ffffff;
            overflow-x: hidden;
        }

        .header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #FF6B35;
        }

        .nav-menu {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .nav-menu a:hover {
            color: #FF6B35;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn {
            padding: 0.5rem 1.5rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-login {
            background: #FF6B35;
            color: white;
        }

        .btn-signup {
            background: transparent;
            color: #FF6B35;
            border: 2px solid #FF6B35;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .mobile-menu-btn:hover {
            background: rgba(255, 107, 53, 0.3);
        }

        .main-container {
            display: flex;
            height: calc(100vh - 80px);
            position: relative;
        }

        .sidebar {
            width: 350px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 100;
        }

        .sidebar.collapsed {
            width: 0;
            padding: 0;
            opacity: 0;
        }

        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .sidebar-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #FF6B35;
        }

        .toggle-sidebar {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .toggle-sidebar:hover {
            background: rgba(255, 107, 53, 0.2);
        }

        .search-container {
            margin-bottom: 1.5rem;
        }

        .search-box {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 0.9rem;
        }

        .search-box::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .search-box:focus {
            outline: none;
            border-color: #FF6B35;
            box-shadow: 0 0 10px rgba(255, 107, 53, 0.3);
        }

        .filters {
            margin-bottom: 1.5rem;
        }

        .filter-group {
            margin-bottom: 1rem;
        }

        .filter-title {
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #FF6B35;
        }

        .category-filters {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .category-btn {
            padding: 0.5rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            font-size: 0.8rem;
        }

        .category-btn.active,
        .category-btn:hover {
            background: #FF6B35;
            border-color: #FF6B35;
        }

        .date-filter {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .date-btn {
            padding: 0.4rem 0.8rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.8rem;
        }

        .date-btn.active,
        .date-btn:hover {
            background: #FF6B35;
            border-color: #FF6B35;
        }

        .view-toggle {
            display: flex;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 0.2rem;
            margin-bottom: 1rem;
        }

        .view-btn {
            flex: 1;
            padding: 0.5rem;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .view-btn.active {
            background: #FF6B35;
        }

        .map-container {
            flex: 1;
            position: relative;
            transition: all 0.3s ease;
        }

        .map-container.expanded {
            margin-left: -350px;
        }

        #map {
            width: 100%;
            height: 100%;
            z-index:1;
        }

        .calendar-container {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 300px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            display: none;
            z-index: 500;
        }

        .calendar-container.active {
            display: block;
        }

        .calendar {
            color: #1a1a2e;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .calendar-nav {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: #FF6B35;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .calendar-nav:hover {
            background: rgba(255, 107, 53, 0.1);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
            text-align: center;
        }

        .calendar-day {
            padding: 0.5rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.8rem;
        }

        .calendar-day:hover {
            background: #FF6B35;
            color: white;
        }

        .calendar-day.has-event {
            background: rgba(255, 107, 53, 0.2);
            font-weight: bold;
        }

        .calendar-day.today {
            background: #FF6B35;
            color: white;
            font-weight: bold;
        }

        .event-list {
            max-height: 40vh;
            overflow-y: auto;
        }

        .event-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .event-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
            border-color: #FF6B35;
        }

        .event-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }

        .event-title {
            font-weight: bold;
            color: #FF6B35;
            margin-bottom: 0.25rem;
        }

        .event-date {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .event-actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            background: none;
            border: none;
            color: white;
            font-size: 0.9rem;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: rgba(255, 107, 53, 0.3);
        }

        .action-btn.favorited {
            color: #FF6B35;
        }

        .event-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 0.5rem;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .warning-indicator {
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: bold;
        }

        .warning-low {
            background: rgba(255, 193, 7, 0.3);
            color: #ffc107;
        }

        .warning-medium {
            background: rgba(255, 152, 0, 0.3);
            color: #ff9800;
        }

        .warning-high {
            background: rgba(244, 67, 54, 0.3);
            color: #f44336;
        }

        .floating-controls {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 1000;
        }

        .floating-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #FF6B35;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.4);
            transition: all 0.3s ease;
        }

        .floating-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.6);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            z-index: 2000;
        }

        .modal.active {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 15px;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #FF6B35;
        }

        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            background: rgba(255, 107, 53, 0.3);
        }

        .event-images {
            display: flex;
            gap: 10px;
            margin-bottom: 1rem;
            overflow-x: auto;
        }

        .event-image {
            width: 150px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .event-image:hover {
            transform: scale(1.05);
        }

        .event-details {
            margin-bottom: 1.5rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .warnings-list {
            margin-bottom: 1rem;
        }

        .warning-item {
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .emergency-contacts {
            margin-top: 1rem;
        }

        .emergency-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .book-btn {
            width: 100%;
            padding: 1rem;
            background: #FF6B35;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .book-btn:hover {
            background: #e55a2b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
        }

        .upload-section {
            margin-top: 1.5rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            border: 2px dashed rgba(255, 255, 255, 0.2);
        }

        .upload-area {
            text-align: center;
            padding: 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: #FF6B35;
            background: rgba(255, 107, 53, 0.1);
        }

        .reviews-section {
            margin-top: 1.5rem;
        }

        .review-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .reviewer-name {
            font-weight: bold;
            color: #FF6B35;
        }

        .review-date {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .rating-input .star {
            font-size: 1.5rem;
            color: #ccc;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .rating-input .star:hover,
        .rating-input .star.active {
            color: #FFD700;
        }

        .offline-indicator {
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: #f44336;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            z-index: 1500;
            display: none;
        }

        .offline-indicator.show {
            display: block;
        }

        .loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 3000;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-top: 5px solid #FF6B35;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .notification {
            position: fixed;
            top: 90px;
            right: 20px;
            padding: 1rem;
            border-radius: 8px;
            z-index: 3000;
            max-width: 300px;
            animation: slideIn 0.3s ease;
        }

        .notification.success {
            background: #4caf50;
            color: white;
        }

        .notification.error {
            background: #f44336;
            color: white;
        }

        .notification.info {
            background: #2196f3;
            color: white;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .leaflet-popup-content-wrapper {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 10px;
        }

        .leaflet-popup-content {
            color: white;
        }

        .popup-event-title {
            color: #FF6B35;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .popup-event-details {
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .popup-buttons {
            margin-top: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        .popup-btn {
            padding: 0.4rem 0.8rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .popup-btn.primary {
            background: #FF6B35;
            color: white;
        }

        .popup-btn.secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .popup-btn:hover {
            transform: translateY(-1px);
        }

        /* Mobile Responsive Design */
        @media (max-width: 768px) {
            .header {
                padding: 1rem;
            }

            .nav-menu {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .main-container {
                flex-direction: column;
            }

            .sidebar {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 70px);
                z-index: 1500;
                transition: left 0.3s ease;
                max-width: 350px;
            }

            .sidebar.active {
                left: 0;
            }

            .map-container {
                height: calc(100vh - 70px);
            }

            .calendar-container {
                width: 90%;
                max-width: 280px;
                right: 5%;
                left: 5%;
            }

            .category-filters {
                grid-template-columns: 1fr;
            }

            .date-filter {
                flex-wrap: wrap;
            }

            .modal-content {
                width: 95%;
                padding: 1rem;
                max-height: 90vh;
            }

            .event-images {
                flex-direction: column;
            }

            .event-image {
                width: 100%;
                height: 200px;
            }

            .floating-controls {
                bottom: 10px;
                right: 10px;
            }

            .floating-btn {
                width: 45px;
                height: 45px;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 0.5rem;
            }

            .logo {
                font-size: 1.2rem;
            }

            .auth-buttons {
                gap: 0.5rem;
            }

            .btn {
                padding: 0.4rem 1rem;
                font-size: 0.8rem;
            }

            .sidebar {
                padding: 1rem;
            }

            .event-card {
                padding: 0.75rem;
            }

            .modal-content {
                padding: 1rem;
            }

            .floating-controls {
                bottom: 5px;
                right: 5px;
            }
        }

        /* Accessibility Features */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .focus-visible {
            outline: 2px solid #FF6B35;
            outline-offset: 2px;
        }

        *:focus {
            outline: 2px solid #FF6B35;
            outline-offset: 2px;
        }

        button:focus,
        input:focus,
        select:focus,
        textarea:focus {
            outline: 2px solid #FF6B35;
            outline-offset: 2px;
        }

        /* High contrast mode */
        @media (prefers-contrast: high) {
            .event-card {
                border: 2px solid white;
            }
            
            .btn {
                border: 2px solid currentColor;
            }
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Sidebar toggle button when collapsed */
.sidebar-toggle-btn {
    position: fixed;
    top: 9%;
    left: 10px;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #FF6B35;
    border: none;
    color: white;
    font-size: 1.2rem;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(255, 107, 53, 0.4);
    transition: all 0.3s ease;
    z-index: 1001;
    display: none;
}

.sidebar-toggle-btn:hover {
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 6px 20px rgba(255, 107, 53, 0.6);
}

.sidebar-toggle-btn.show {
    display: block;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        left: -50px;
        opacity: 0;
    }
    to {
        left: 10px;
        opacity: 1;
    }
}

.header-toggle-btn {
    display: none;
    background: none;
    border: none;
    color: white;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    transition: all 0.3s ease;
    margin-left: 1rem;
}

.header-toggle-btn:hover {
    background: rgba(255, 107, 53, 0.3);
}

/* Show the header toggle button on desktop when not in mobile view */
@media (min-width: 769px) {
    .header-toggle-btn {
        display: block;
    }
}
    </style>
</head>
<body>
    <!-- Offline Indicator -->
    <div class="offline-indicator" id="offlineIndicator">
        <i class="fas fa-wifi"></i> You're offline. Some features may be limited.
    </div>

    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <div class="spinner"></div>
    </div>

    <!-- <header class="header">
        <div class="logo">
            <i class="fas fa-mountain" aria-hidden="true"></i>
            <span>NepalDiscovery</span>
        </div>
        <!-- Add this button inside the .header div, after the logo -->
<!-- <button class="header-toggle-btn" onclick="toggleSidebar()" aria-label="Toggle sidebar" title="Toggle sidebar">
    <i class="fas fa-bars" aria-hidden="true"></i> -->
</button>
        <!-- <nav class="nav-menu" role="navigation" aria-label="Main navigation">
            <a href="#home">Home</a>
            <a href="#places">Places</a>
            <a href="#events" style="color: #FF6B35;" aria-current="page">Events</a>
            <a href="#guides">Guides</a>
            <a href="#about">About</a>
        </nav> -->
        <!-- <div class="auth-buttons">
            <button class="btn btn-login" aria-label="Login to your account">Login</button>
            <button class="btn btn-signup" aria-label="Create new account">Sign Up</button>
            <button class="mobile-menu-btn" onclick="toggleSidebar()" aria-label="Toggle menu" aria-expanded="false">
                <i class="fas fa-bars" aria-hidden="true"></i>
            </button>

        </div> -->

    </header>

    <div class="main-container">
        <aside class="sidebar" id="sidebar" role="complementary" aria-label="Event filters and list">
            <div class="sidebar-header">
                <h2 class="sidebar-title">Discover Events</h2>
                <button class="toggle-sidebar" onclick="toggleSidebar()" aria-label="Close sidebar">
                    <i class="fas fa-times" aria-hidden="true"></i>
                </button>
            </div>

            <div class="search-container">
                <label for="searchInput" class="sr-only">Search events</label>
                <input type="text" class="search-box" placeholder="Search events, places, or guides..." 
                       id="searchInput" onkeyup="filterEvents()" aria-describedby="search-help">
                <div id="search-help" class="sr-only">Search through events by name, location, or description</div>
            </div>

            <div class="filters">
                <div class="filter-group">
                    <div class="filter-title">Categories</div>
                    <div class="category-filters" id="categoryFilters" role="group" aria-label="Event categories">
                        <!-- Categories will be populated by JavaScript -->
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-title">Time Period</div>
                    <div class="date-filter" role="group" aria-label="Time period filters">
                        <button class="date-btn active" data-days="7" aria-pressed="true">7 Days</button>
                        <button class="date-btn" data-days="30" aria-pressed="false">30 Days</button>
                        <button class="date-btn" data-days="100" aria-pressed="false">100 Days</button>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-title">View</div>
                    <div class="view-toggle" role="group" aria-label="View options">
                        <button class="view-btn active" data-view="list" aria-pressed="true">
                            <i class="fas fa-list" aria-hidden="true"></i> List
                        </button>
                        <button class="view-btn" data-view="calendar" aria-pressed="false">
                            <i class="fas fa-calendar" aria-hidden="true"></i> Calendar
                        </button>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-title">Price Range</div>
                    <div class="date-filter" role="group" aria-label="Price filters">
                        <button class="date-btn" data-price="free" aria-pressed="false">Free</button>
                        <button class="date-btn" data-price="paid" aria-pressed="false">Paid</button>
                        <button class="date-btn active" data-price="all" aria-pressed="true">All</button>
                    </div>
                </div>
            </div>

            <div class="event-list" id="eventList" role="region" aria-label="Event list" aria-live="polite">
                <!-- Events will be populated by JavaScript -->
            </div>

            <div class="emergency-contacts">
                <div class="filter-title">Emergency Contacts</div>
                <div id="emergencyList" role="list">
                    <!-- Emergency contacts will be populated by JavaScript -->
                </div>
            </div>
        </aside>

        <main class="map-container" id="mapContainer" role="main" aria-label="Interactive map">
            <div id="map" aria-label="Map showing event locations"></div>
            
            <div class="calendar-container" id="calendarContainer" role="dialog" aria-label="Event calendar">
                <div class="calendar">
                    <div class="calendar-header">
                        <button class="calendar-nav" onclick="changeMonth(-1)" aria-label="Previous month">‹</button>
                        <h3 id="currentMonth">September 2025</h3>
                        <button class="calendar-nav" onclick="changeMonth(1)" aria-label="Next month">›</button>
                    </div>
                    <div class="calendar-grid" id="calendarGrid" role="grid" aria-label="Calendar grid">
                        <!-- Calendar will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="floating-controls">
        <button class="floating-btn" onclick="getCurrentLocation()" title="My Location" aria-label="Get current location">
            <i class="fas fa-location-arrow" aria-hidden="true"></i>
        </button>
        <button class="floating-btn" onclick="openAddContentModal()" title="Add Content" aria-label="Add new content">
            <i class="fas fa-plus" aria-hidden="true"></i>
        </button>
        <button class="floating-btn" onclick="showFavorites()" title="My Favorites" aria-label="Show favorite events">
            <i class="fas fa-heart" aria-hidden="true"></i>
        </button>
    </div>

    <!-- Event Details Modal -->
    <div class="modal" id="eventModal" role="dialog" aria-labelledby="modalTitle" aria-modal="true">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Event Details</h2>
                <button class="close-btn" onclick="closeModal()" aria-label="Close modal">&times;</button>
            </div>
            <div id="modalContent">
                <!-- Modal content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Add Content Modal -->
    <div class="modal" id="addContentModal" role="dialog" aria-labelledby="addContentTitle" aria-modal="true">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="addContentTitle">Add Your Content</h2>
                <button class="close-btn" onclick="closeAddContentModal()" aria-label="Close modal">&times;</button>
            </div>
            <div class="upload-section">
                <div class="upload-area" onclick="document.getElementById('fileInput').click()" role="button" tabindex="0" 
                     onkeydown="if(event.key==='Enter'||event.key===' ') document.getElementById('fileInput').click()">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 3rem; color: #FF6B35; margin-bottom: 1rem;" aria-hidden="true"></i>
                    <h3>Upload Photos or Videos</h3>
                    <p>Click here or drag files to upload</p>
                </div>
                <input type="file" id="fileInput" style="display: none;" multiple accept="image/*,video/*" 
                       onchange="handleFileUpload(event)" aria-label="Upload files">
            </div>
            
            <div style="margin-top: 1.5rem;">
                <h3 style="color: #FF6B35; margin-bottom: 1rem;">Add a Review</h3>
                <div style="margin-bottom: 1rem;">
                    <label for="rating-input">Rating:</label>
                    <div class="rating-input" id="rating-input" style="margin-top: 0.5rem;" role="radiogroup" aria-label="Rate this event">
                        <span class="star" data-rating="1" role="radio" aria-checked="false" tabindex="0">★</span>
                        <span class="star" data-rating="2" role="radio" aria-checked="false" tabindex="0">★</span>
                        <span class="star" data-rating="3" role="radio" aria-checked="false" tabindex="0">★</span>
                        <span class="star" data-rating="4" role="radio" aria-checked="false" tabindex="0">★</span>
                        <span class="star" data-rating="5" role="radio" aria-checked="false" tabindex="0">★</span>
                    </div>
                </div>
                <label for="reviewText" class="sr-only">Review text</label>
                <textarea id="reviewText" placeholder="Write your review here..." 
                    style="width: 100%; height: 100px; padding: 1rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.2); 
                           background: rgba(255, 255, 255, 0.1); color: white; resize: vertical;" 
                    aria-describedby="review-help"></textarea>
                <div id="review-help" class="sr-only">Share your experience with this event</div>
                <button class="btn" style="margin-top: 1rem; background: #FF6B35; color: white; padding: 0.75rem 2rem;" 
                        onclick="submitReview()">Submit Review</button>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal" id="bookingModal" role="dialog" aria-labelledby="bookingTitle" aria-modal="true">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="bookingTitle">Book Event</h2>
                <button class="close-btn" onclick="closeBookingModal()" aria-label="Close modal">&times;</button>
            </div>
            <div id="bookingContent">
                <form id="bookingForm" novalidate>
                    <div style="margin-bottom: 1rem;">
                        <label for="fullName" style="display: block; margin-bottom: 0.5rem;">Full Name:</label>
                        <input type="text" id="fullName" name="fullName" required 
                               style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.2); 
                                      background: rgba(255, 255, 255, 0.1); color: white;"
                               aria-describedby="fullName-error">
                        <div id="fullName-error" class="error-message" style="display: none; color: #f44336; font-size: 0.8rem; margin-top: 0.25rem;"></div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="email" style="display: block; margin-bottom: 0.5rem;">Email:</label>
                        <input type="email" id="email" name="email" required 
                               style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.2); 
                                      background: rgba(255, 255, 255, 0.1); color: white;"
                               aria-describedby="email-error">
                        <div id="email-error" class="error-message" style="display: none; color: #f44336; font-size: 0.8rem; margin-top: 0.25rem;"></div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="phone" style="display: block; margin-bottom: 0.5rem;">Phone:</label>
                        <input type="tel" id="phone" name="phone" required 
                               style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.2); 
                                      background: rgba(255, 255, 255, 0.1); color: white;"
                               aria-describedby="phone-error">
                        <div id="phone-error" class="error-message" style="display: none; color: #f44336; font-size: 0.8rem; margin-top: 0.25rem;"></div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="numberOfPeople" style="display: block; margin-bottom: 0.5rem;">Number of People:</label>
                        <input type="number" id="numberOfPeople" name="numberOfPeople" min="1" value="1" required 
                               style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.2); 
                                      background: rgba(255, 255, 255, 0.1); color: white;"
                               aria-describedby="numberOfPeople-error">
                        <div id="numberOfPeople-error" class="error-message" style="display: none; color: #f44336; font-size: 0.8rem; margin-top: 0.25rem;"></div>
                    </div>
                    <button type="submit" class="book-btn">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Global variables
        let map;
        let eventsData = null;
        let currentEvents = [];
        let markers = [];
        let favorites = JSON.parse(localStorage.getItem('nepalDiscovery_favorites') || '[]');
        let userLocation = [27.7172, 85.3240]; // Default to Kathmandu
        let currentSelectedEvent = null;
        let currentMonth = new Date();
        let currentRating = 0;
        let isOnline = navigator.onLine;
        let dbCache = null;

        // Enhanced mock data with current user info
        const mockEventsData = {
            "currentUser": "CrypticLuminary",
            "currentDateTime": "2025-08-28 15:57:09",
            "events": [
                {
                    "id": 1,
                    "name": "Dashain Festival Celebration",
                    "category": "cultural",
                    "date": "2025-09-15",
                    "endDate": "2025-09-25",
                    "location": "Kathmandu Durbar Square",
                    "coordinates": [27.7045, 85.3075],
                    "description": "Nepal's biggest festival celebrating the victory of good over evil. Experience traditional dances, cultural performances, and local cuisine.",
                    "capacity": 500,
                    "available": 342,
                    "price": "Free",
                    "rating": 4.8,
                    "reviews": 127,
                    "images": [
                        "https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800",
                        "https://images.unsplash.com/photo-1586822803041-6ad2f5a6be0f?w=800"
                    ],
                    "videos": [
                        "https://sample-videos.com/zip/10/mp4/SampleVideo_1280x720_1mb.mp4"
                    ],
                    "warnings": [
                        {
                            "type": "crowd",
                            "level": "medium",
                            "message": "Large crowds expected. Keep belongings secure."
                        }
                    ],
                    "organizer": "Nepal Tourism Board",
                    "contact": "+977-1-4256909",
                    "userReviews": [
                        {
                            "id": 1,
                            "user": "Tourist123",
                            "rating": 5,
                            "comment": "Amazing cultural experience! The traditional dances were spectacular.",
                            "date": "2024-09-16",
                            "helpful": 12
                        },
                        {
                            "id": 2,
                            "user": "LocalGuide",
                            "rating": 4,
                            "comment": "Great festival but very crowded. Go early for the best experience.",
                            "date": "2024-09-18",
                            "helpful": 8
                        }
                    ]
                },
                {
                    "id": 2,
                    "name": "Everest Marathon",
                    "category": "adventure",
                    "date": "2025-09-02",
                    "endDate": "2025-09-02",
                    "location": "Namche Bazaar to Lukla",
                    "coordinates": [27.8047, 86.7126],
                    "description": "World's highest marathon starting from Everest Base Camp. Challenge yourself in the breathtaking Himalayas.",
                    "capacity": 200,
                    "available": 45,
                    "price": "$450",
                    "rating": 4.9,
                    "reviews": 89,
                    "images": [
                        "https://images.unsplash.com/photo-1464822759844-d150ad6d1a98?w=800",
                        "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800"
                    ],
                    "videos": [],
                    "warnings": [
                        {
                            "type": "altitude",
                            "level": "high",
                            "message": "High altitude event. Proper acclimatization required."
                        },
                        {
                            "type": "weather",
                            "level": "medium",
                            "message": "Weather conditions can change rapidly."
                        }
                    ],
                    "organizer": "Everest Marathon Committee",
                    "contact": "+977-1-4411234",
                    "userReviews": []
                },
                {
                    "id": 3,
                    "name": "Holi Color Festival",
                    "category": "religious",
                    "date": "2025-10-15",
                    "endDate": "2025-10-15",
                    "location": "Basantapur Durbar Square",
                    "coordinates": [27.7043, 85.3073],
                    "description": "Festival of colors! Join locals in this joyous celebration with organic colors, music, and traditional sweets.",
                    "capacity": 800,
                    "available": 623,
                    "price": "NPR 200",
                    "rating": 4.7,
                    "reviews": 203,
                    "images": [
                        "https://images.unsplash.com/photo-1583417319070-4a69db38a482?w=800",
                        "https://images.unsplash.com/photo-1615750185043-21ab10252d37?w=800"
                    ],
                    "videos": [],
                    "warnings": [
                        {
                            "type": "safety",
                            "level": "low",
                            "message": "Wear old clothes. Colors may stain."
                        }
                    ],
                    "organizer": "Local Community",
                    "contact": "+977-1-4445566",
                    "userReviews": []
                },
                {
                    "id": 4,
                    "name": "Traditional Newari Cooking Class",
                    "category": "cultural",
                    "date": "2025-09-01",
                    "endDate": "2025-09-01",
                    "location": "Bhaktapur",
                    "coordinates": [27.6710, 85.4298],
                    "description": "Learn authentic Newari cuisine from local grandmothers. Includes market tour and full meal preparation.",
                    "capacity": 25,
                    "available": 12,
                    "price": "$35",
                    "rating": 4.9,
                    "reviews": 67,
                    "images": [
                        "https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800",
                        "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800"
                    ],
                    "videos": [],
                    "warnings": [],
                    "organizer": "Bhaktapur Cultural Center",
                    "contact": "+977-1-4446677",
                    "userReviews": []
                },
                {
                    "id": 5,
                    "name": "Sunrise at Nagarkot",
                    "category": "nature",
                    "date": "2025-08-31",
                    "endDate": "2025-08-31",
                    "location": "Nagarkot View Tower",
                    "coordinates": [27.7172, 85.5206],
                    "description": "Witness breathtaking sunrise over the Himalayas including Mt. Everest. Transportation and breakfast included.",
                    "capacity": 50,
                    "available": 31,
                    "price": "$25",
                    "rating": 4.6,
                    "reviews": 94,
                    "images": [
                        "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800",
                        "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800"
                    ],
                    "videos": [],
                    "warnings": [
                        {
                            "type": "weather",
                            "level": "medium",
                            "message": "Early morning departure (4 AM). Dress warmly."
                        }
                    ],
                    "organizer": "Mountain View Tours",
                    "contact": "+977-1-4447788",
                    "userReviews": []
                },
                {
                    "id": 6,
                    "name": "Pottery Making Workshop",
                    "category": "cultural",
                    "date": "2025-09-03",
                    "endDate": "2025-09-03",
                    "location": "Pottery Square, Bhaktapur",
                    "coordinates": [27.6728, 85.4267],
                    "description": "Learn traditional pottery techniques from master craftsmen. Create your own souvenir to take home.",
                    "capacity": 15,
                    "available": 8,
                    "price": "$20",
                    "rating": 4.5,
                    "reviews": 42,
                    "images": [
                        "https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800"
                    ],
                    "videos": [],
                    "warnings": [
                        {
                            "type": "safety",
                            "level": "low",
                            "message": "Wear clothes you don't mind getting muddy."
                        }
                    ],
                    "organizer": "Bhaktapur Artisan Guild",
                    "contact": "+977-1-4448899",
                    "userReviews": []
                },
                {
                    "id": 7,
                    "name": "Kathmandu Street Food Tour",
                    "category": "food",
                    "date": "2025-08-30",
                    "endDate": "2025-08-30",
                    "location": "Thamel",
                    "coordinates": [27.7172, 85.3097],
                    "description": "Explore authentic Nepali street food with a local guide. Try momos, chatpate, and traditional sweets.",
                    "capacity": 20,
                    "available": 15,
                    "price": "$15",
                    "rating": 4.7,
                    "reviews": 156,
                    "images": [
                        "https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=800",
                        "https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800"
                    ],
                    "videos": [],
                    "warnings": [
                        {
                            "type": "health",
                            "level": "low",
                            "message": "Inform guide of any food allergies beforehand."
                        }
                    ],
                    "organizer": "Kathmandu Food Tours",
                    "contact": "+977-1-4449900",
                    "userReviews": []
                },
                {
                    "id": 8,
                    "name": "Traditional Music Concert",
                    "category": "cultural",
                    "date": "2025-09-05",
                    "endDate": "2025-09-05",
                    "location": "Patan Museum",
                    "coordinates": [27.6734, 85.3244],
                    "description": "Evening concert featuring traditional Nepali instruments including tabla, sitar, and flute.",
                    "capacity": 100,
                    "available": 67,
                    "price": "NPR 500",
                    "rating": 4.8,
                    "reviews": 73,
                    "images": [
                        "https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800"
                    ],
                    "videos": [],
                    "warnings": [],
                    "organizer": "Patan Cultural Society",
                    "contact": "+977-1-4441122",
                    "userReviews": []
                }
            ],
            "categories": [
                { "id": "all", "name": "All Events", "icon": "🎉" },
                { "id": "cultural", "name": "Cultural", "icon": "🏛️" },
                { "id": "religious", "name": "Religious", "icon": "🙏" },
                { "id": "adventure", "name": "Adventure", "icon": "🏔️" },
                { "id": "nature", "name": "Nature", "icon": "🌄" },
                { "id": "food", "name": "Food", "icon": "🍜" }
            ],
            "emergencyContacts": [
                {
                    "service": "Police",
                    "number": "100",
                    "description": "Nepal Police Emergency"
                },
                {
                    "service": "Tourist Police",
                    "number": "1144",
                    "description": "Tourist Police Helpline"
                },
                {
                    "service": "Fire Brigade",
                    "number": "101",
                    "description": "Fire Emergency"
                },
                {
                    "service": "Ambulance",
                    "number": "102",
                    "description": "Medical Emergency"
                },
                {
                    "service": "Nepal Tourism Board",
                    "number": "+977-1-4256909",
                    "description": "Tourism Information & Help"
                }
            ]
        };

        // Initialize the application
        async function initializeApp() {
            try {
                showLoading(true);
                
                // Initialize offline capabilities
                await initializeOfflineSupport();
                
                // Load events data (from cache if offline)
                eventsData = await loadEventsData();
                
                initializeMap();
                populateCategories();
                populateEmergencyContacts();
                setupEventListeners();
                generateCalendar();
                
                // Get user location automatically
                await getCurrentLocation();
                
                filterEvents();
                
                // Sync favorites across devices (if online)
                if (isOnline) {
                    await syncFavoritesWithServer();
                }
                
                showLoading(false);
                console.log('App initialized successfully');
                showNotification('Welcome to NepalDiscovery Events!', 'success');
            } catch (error) {
                console.error('Error initializing app:', error);
                showLoading(false);
                showNotification('Failed to initialize app. Some features may not work.', 'error');
            }
        }

        // Initialize offline support with IndexedDB
        async function initializeOfflineSupport() {
            return new Promise((resolve, reject) => {
                const request = indexedDB.open('NepalDiscoveryDB', 1);
                
                request.onerror = () => reject(request.error);
                request.onsuccess = () => {
                    dbCache = request.result;
                    resolve();
                };
                
                request.onupgradeneeded = (event) => {
                    const db = event.target.result;
                    
                    // Create object stores
                    if (!db.objectStoreNames.contains('events')) {
                        db.createObjectStore('events', { keyPath: 'id' });
                    }
                    if (!db.objectStoreNames.contains('favorites')) {
                        db.createObjectStore('favorites', { keyPath: 'userId' });
                    }
                    if (!db.objectStoreNames.contains('reviews')) {
                        db.createObjectStore('reviews', { keyPath: 'id', autoIncrement: true });
                    }
                };
            });
        }

        // Load events data (offline-first approach)
        async function loadEventsData() {
            try {
                if (isOnline) {
                    // In a real app, this would fetch from API
                    // For demo, we'll use mock data and cache it
                    await cacheEventsData(mockEventsData);
                    return mockEventsData;
                } else {
                    // Load from cache when offline
                    const cachedData = await getCachedEventsData();
                    return cachedData || mockEventsData;
                }
            } catch (error) {
                console.error('Error loading events data:', error);
                return mockEventsData;
            }
        }

        // Cache events data in IndexedDB
        async function cacheEventsData(data) {
            if (!dbCache) return;
            
            const transaction = dbCache.transaction(['events'], 'readwrite');
            const store = transaction.objectStore('events');
            
            // Clear existing data
            await store.clear();
            
            // Store new data
            data.events.forEach(event => {
                store.add(event);
            });
            
            // Store metadata
            localStorage.setItem('nepalDiscovery_categories', JSON.stringify(data.categories));
            localStorage.setItem('nepalDiscovery_emergencyContacts', JSON.stringify(data.emergencyContacts));
            localStorage.setItem('nepalDiscovery_lastUpdate', new Date().toISOString());
        }

        // Get cached events data from IndexedDB
        async function getCachedEventsData() {
            if (!dbCache) return null;
            
            return new Promise((resolve, reject) => {
                const transaction = dbCache.transaction(['events'], 'readonly');
                const store = transaction.objectStore('events');
                const request = store.getAll();
                
                request.onsuccess = () => {
                    const events = request.result;
                    const categories = JSON.parse(localStorage.getItem('nepalDiscovery_categories') || '[]');
                    const emergencyContacts = JSON.parse(localStorage.getItem('nepalDiscovery_emergencyContacts') || '[]');
                    
                    resolve({
                        events,
                        categories,
                        emergencyContacts
                    });
                };
                
                request.onerror = () => reject(request.error);
            });
        }

        // Show/hide loading spinner
        function showLoading(show) {
            const spinner = document.getElementById('loadingSpinner');
            spinner.style.display = show ? 'block' : 'none';
        }

        // Show notification
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }

        // Initialize map
        function initializeMap() {
            map = L.map('map').setView(userLocation, 17);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add user location marker
            updateUserLocationMarker();
        }

        // Update user location marker
        function updateUserLocationMarker() {
            const userIcon = L.divIcon({
                html: '<i class="fas fa-user" style="color: black; font-size: 16px;"></i>',
                iconSize: [20, 20],
                className: 'user-location-marker'
            });
            
            L.marker(userLocation, { icon: userIcon })
                .addTo(map)
                .bindPopup('<b>You are here</b>')
                .openPopup();
        }

        // Get current location automatically
        async function getCurrentLocation() {
            if (!navigator.geolocation) {
                showNotification('Geolocation is not supported by this browser.', 'error');
                return;
            }

            return new Promise((resolve) => {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userLocation = [position.coords.latitude, position.coords.longitude];
                        
                        // Update map center
                        map.setView(userLocation, 12);
                        
                        // Update user marker
                        updateUserLocationMarker();
                        
                        filterEvents(); // Refresh events based on new location
                        showNotification('Location updated successfully!', 'success');
                        resolve();
                                            },
                    (error) => {
                        console.error('Error getting location:', error);
                        showNotification('Could not get your location. Using default location.', 'error');
                        resolve();
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 300000 // 5 minutes
                    }
                );
            });
        }

        // Sync favorites with server (mock implementation)
        async function syncFavoritesWithServer() {
            try {
                // In a real app, this would sync with server
                const serverFavorites = JSON.parse(localStorage.getItem('nepalDiscovery_serverFavorites') || '[]');
                const localFavorites = JSON.parse(localStorage.getItem('nepalDiscovery_favorites') || '[]');
                
                // Merge favorites (simple approach - could be more sophisticated)
                const mergedFavorites = [...new Set([...serverFavorites, ...localFavorites])];
                
                localStorage.setItem('nepalDiscovery_favorites', JSON.stringify(mergedFavorites));
                localStorage.setItem('nepalDiscovery_serverFavorites', JSON.stringify(mergedFavorites));
                
                favorites = mergedFavorites;
            } catch (error) {
                console.error('Error syncing favorites:', error);
            }
        }

        // Populate categories
        function populateCategories() {
            const container = document.getElementById('categoryFilters');
            container.innerHTML = '';
            
            eventsData.categories.forEach(category => {
                const btn = document.createElement('button');
                btn.className = 'category-btn';
                btn.dataset.category = category.id;
                btn.innerHTML = `${category.icon} ${category.name}`;
                btn.setAttribute('aria-pressed', category.id === 'all' ? 'true' : 'false');
                if (category.id === 'all') btn.classList.add('active');
                btn.addEventListener('click', () => selectCategory(btn, category.id));
                container.appendChild(btn);
            });
        }

        // Select category
        function selectCategory(button, categoryId) {
            // Update button states
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('active');
                btn.setAttribute('aria-pressed', 'false');
            });
            button.classList.add('active');
            button.setAttribute('aria-pressed', 'true');
            
            filterEvents();
        }

        // Populate emergency contacts
        function populateEmergencyContacts() {
            const container = document.getElementById('emergencyList');
            container.innerHTML = '';
            
            eventsData.emergencyContacts.forEach(contact => {
                const item = document.createElement('div');
                item.className = 'emergency-item';
                item.setAttribute('role', 'listitem');
                item.innerHTML = `
                    <div>
                        <strong>${contact.service}</strong>
                        <br>
                        <small>${contact.description}</small>
                    </div>
                    <a href="tel:${contact.number}" style="color: #FF6B35; font-weight: bold;" 
                       aria-label="Call ${contact.service} at ${contact.number}">${contact.number}</a>
                `;
                container.appendChild(item);
            });
        }

        // Setup event listeners
        function setupEventListeners() {
            // Online/offline detection
            window.addEventListener('online', () => {
                isOnline = true;
                document.getElementById('offlineIndicator').classList.remove('show');
                showNotification('You are back online!', 'success');
                syncFavoritesWithServer();
            });

            window.addEventListener('offline', () => {
                isOnline = false;
                document.getElementById('offlineIndicator').classList.add('show');
                showNotification('You are now offline. Some features may be limited.', 'info');
            });

            // Date filter buttons
            document.querySelectorAll('.date-btn[data-days]').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.date-btn[data-days]').forEach(b => {
                        b.classList.remove('active');
                        b.setAttribute('aria-pressed', 'false');
                    });
                    btn.classList.add('active');
                    btn.setAttribute('aria-pressed', 'true');
                    filterEvents();
                });
            });

            // Price filter buttons
            document.querySelectorAll('.date-btn[data-price]').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.date-btn[data-price]').forEach(b => {
                        b.classList.remove('active');
                        b.setAttribute('aria-pressed', 'false');
                    });
                    btn.classList.add('active');
                    btn.setAttribute('aria-pressed', 'true');
                    filterEvents();
                });
            });

            // View toggle buttons
            document.querySelectorAll('.view-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.view-btn').forEach(b => {
                        b.classList.remove('active');
                        b.setAttribute('aria-pressed', 'false');
                    });
                    btn.classList.add('active');
                    btn.setAttribute('aria-pressed', 'true');
                    
                    const view = btn.dataset.view;
                    toggleView(view);
                });
            });

            // Rating input
            document.querySelectorAll('.rating-input .star').forEach(star => {
                star.addEventListener('click', () => {
                    currentRating = parseInt(star.dataset.rating);
                    updateRatingDisplay();
                });

                star.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        currentRating = parseInt(star.dataset.rating);
                        updateRatingDisplay();
                    }
                });
            });

            // Booking form
            document.getElementById('bookingForm').addEventListener('submit', handleBookingSubmit);

            // File upload drag and drop
            const uploadArea = document.querySelector('.upload-area');
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.style.background = 'rgba(255, 107, 53, 0.2)';
            });

            uploadArea.addEventListener('dragleave', () => {
                uploadArea.style.background = '';
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.style.background = '';
                const files = e.dataTransfer.files;
                handleFileUpload({ target: { files } });
            });

            // Close modals on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeModal();
                    closeAddContentModal();
                    closeBookingModal();
                }
            });

            // Close modals on backdrop click
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        closeModal();
                        closeAddContentModal();
                        closeBookingModal();
                    }
                });
            });

            // Add this inside your setupEventListeners function
window.addEventListener('resize', handleWindowResize);

// Also add keyboard support for the toggle button
document.addEventListener('keydown', (e) => {
    // Toggle sidebar with Ctrl+B or Cmd+B
    if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
        e.preventDefault();
        toggleSidebar();
    }
});
        }

        // Toggle view between list and calendar
        function toggleView(view) {
            const calendarContainer = document.getElementById('calendarContainer');
            const eventList = document.getElementById('eventList');
            
            if (view === 'calendar') {
                calendarContainer.classList.add('active');
                eventList.style.display = 'none';
                generateCalendar();
            } else {
                calendarContainer.classList.remove('active');
                eventList.style.display = 'block';
            }
        }

        // Filter events based on current criteria
        function filterEvents() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const selectedCategory = document.querySelector('.category-btn.active')?.dataset.category || 'all';
            const selectedDays = parseInt(document.querySelector('.date-btn.active[data-days]')?.dataset.days || '7');
            const selectedPrice = document.querySelector('.date-btn.active[data-price]')?.dataset.price || 'all';
            
            const today = new Date();
            const maxDate = new Date();
            maxDate.setDate(today.getDate() + selectedDays);
            
            currentEvents = eventsData.events.filter(event => {
                const eventDate = new Date(event.date);
                const matchesSearch = event.name.toLowerCase().includes(searchTerm) || 
                                    event.location.toLowerCase().includes(searchTerm) ||
                                    event.description.toLowerCase().includes(searchTerm);
                const matchesCategory = selectedCategory === 'all' || event.category === selectedCategory;
                const matchesDate = eventDate >= today && eventDate <= maxDate;
                const matchesPrice = selectedPrice === 'all' || 
                                   (selectedPrice === 'free' && (event.price === 'Free' || event.price === 'NPR 0')) ||
                                   (selectedPrice === 'paid' && event.price !== 'Free' && event.price !== 'NPR 0');
                
                // Filter by distance (within 50km for demo)
                const distance = calculateDistance(userLocation[0], userLocation[1], 
                                                 event.coordinates[0], event.coordinates[1]);
                const withinRadius = distance <= 50;
                
                return matchesSearch && matchesCategory && matchesDate && matchesPrice && withinRadius;
            });
            
            displayEvents();
            updateMapMarkers();
        }

        // Calculate distance between two coordinates
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of Earth in kilometers
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }

        // Display events in the sidebar
        function displayEvents() {
            const container = document.getElementById('eventList');
            container.innerHTML = '';
            
            if (currentEvents.length === 0) {
                container.innerHTML = '<div style="text-align: center; padding: 2rem; color: rgba(255, 255, 255, 0.6);">No events found matching your criteria.</div>';
                return;
            }
            
            currentEvents.forEach(event => {
                const eventCard = document.createElement('div');
                eventCard.className = 'event-card';
                eventCard.onclick = () => showEventDetails(event);
                eventCard.setAttribute('role', 'button');
                eventCard.setAttribute('tabindex', '0');
                eventCard.setAttribute('aria-label', `View details for ${event.name}`);
                
                eventCard.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        showEventDetails(event);
                    }
                });
                
                const isFavorited = favorites.includes(event.id);
                const warningLevel = getHighestWarningLevel(event.warnings);
                
                eventCard.innerHTML = `
                    <div class="event-header">
                        <div>
                            <div class="event-title">${event.name}</div>
                            <div class="event-date">${formatDate(event.date)} ${event.endDate !== event.date ? '- ' + formatDate(event.endDate) : ''}</div>
                        </div>
                        <div class="event-actions">
                            <button class="action-btn ${isFavorited ? 'favorited' : ''}" onclick="event.stopPropagation(); toggleFavorite(${event.id})" 
                                    aria-label="${isFavorited ? 'Remove from' : 'Add to'} favorites">
                                <i class="fas fa-heart"></i>
                            </button>
                            <button class="action-btn" onclick="event.stopPropagation(); shareEvent(${event.id})" aria-label="Share event">
                                <i class="fas fa-share"></i>
                            </button>
                        </div>
                    </div>
                    <div style="font-size: 0.9rem; color: rgba(255, 255, 255, 0.8); margin-bottom: 0.5rem;">
                        <i class="fas fa-map-marker-alt"></i> ${event.location}
                    </div>
                    <div style="font-size: 0.8rem; color: rgba(255, 255, 255, 0.7); margin-bottom: 1rem;">
                        ${event.description.substring(0, 100)}...
                    </div>
                    <div class="event-info">
                        <div class="rating">
                            <i class="fas fa-star" style="color: #FFD700;"></i>
                            <span>${event.rating} (${event.reviews})</span>
                        </div>
                        <div>
                            <span style="font-weight: bold; color: #FF6B35;">${event.price}</span>
                        </div>
                    </div>
                    ${warningLevel ? `<div class="warning-indicator warning-${warningLevel}" style="margin-top: 0.5rem;">
                        ⚠️ ${warningLevel.toUpperCase()} RISK
                    </div>` : ''}
                `;
                
                container.appendChild(eventCard);
            });
        }

        // Update map markers
        function updateMapMarkers() {
            // Clear existing markers (except user location)
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
            
            currentEvents.forEach(event => {
                const warningLevel = getHighestWarningLevel(event.warnings);
                const markerColor = warningLevel === 'high' ? 'red' : 
                                  warningLevel === 'medium' ? 'orange' : 'black';
                
                const marker = L.marker(event.coordinates, {
                    icon: L.divIcon({
                        html: `<i class="fas fa-calendar-alt" style="color: ${markerColor}; font-size: 16px;"></i>`,
                        iconSize: [20, 20],
                        className: 'event-marker'
                    })
                }).addTo(map);
                
                const popupContent = `
                    <div>
                        <div class="popup-event-title">${event.name}</div>
                        <div class="popup-event-details">
                            <strong>Date:</strong> ${formatDate(event.date)}<br>
                            <strong>Location:</strong> ${event.location}<br>
                            <strong>Price:</strong> ${event.price}<br>
                            <strong>Available:</strong> ${event.available}/${event.capacity}
                        </div>
                        <div class="popup-buttons">
                            <button class="popup-btn primary" onclick="showEventDetails(${JSON.stringify(event).replace(/"/g, '&quot;')})">
                                View Details
                            </button>
                            <button class="popup-btn secondary" onclick="bookEvent(${event.id})">
                                Book Now
                            </button>
                        </div>
                    </div>
                `;
                
                marker.bindPopup(popupContent);
                marker.on('click', () => {
                    currentSelectedEvent = event;
                });
                
                markers.push(marker);
            });
        }

        // Get highest warning level
        function getHighestWarningLevel(warnings) {
            if (!warnings || warnings.length === 0) return null;
            
            const levels = warnings.map(w => w.level);
            if (levels.includes('high')) return 'high';
            if (levels.includes('medium')) return 'medium';
            if (levels.includes('low')) return 'low';
            return null;
        }

        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        }

        // Show event details modal
        function showEventDetails(event) {
            currentSelectedEvent = event;
            const modal = document.getElementById('eventModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');
            
            modalTitle.textContent = event.name;
            
            const isFavorited = favorites.includes(event.id);
            
            modalContent.innerHTML = `
                <div class="event-images">
                    ${event.images.map(img => `
                        <img src="${img}" alt="${event.name}" class="event-image" 
                             onclick="openImageModal('${img}')" loading="lazy">
                    `).join('')}
                </div>
                
                <div class="event-details">
                    <div class="detail-row">
                        <strong>Date:</strong>
                        <span>${formatDate(event.date)} ${event.endDate !== event.date ? '- ' + formatDate(event.endDate) : ''}</span>
                    </div>
                    <div class="detail-row">
                        <strong>Location:</strong>
                        <span>${event.location}</span>
                    </div>
                    <div class="detail-row">
                        <strong>Price:</strong>
                        <span>${event.price}</span>
                    </div>
                    <div class="detail-row">
                        <strong>Capacity:</strong>
                        <span>${event.available}/${event.capacity} available</span>
                    </div>
                    <div class="detail-row">
                        <strong>Organizer:</strong>
                        <span>${event.organizer}</span>
                    </div>
                    <div class="detail-row">
                        <strong>Contact:</strong>
                        <a href="tel:${event.contact}" style="color: #FF6B35;">${event.contact}</a>
                    </div>
                    <div class="detail-row">
                        <strong>Rating:</strong>
                        <span>
                            <i class="fas fa-star" style="color: #FFD700;"></i>
                            ${event.rating} (${event.reviews} reviews)
                        </span>
                    </div>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <h4 style="color: #FF6B35; margin-bottom: 0.5rem;">Description</h4>
                    <p>${event.description}</p>
                </div>
                
                ${event.warnings && event.warnings.length > 0 ? `
                    <div class="warnings-list">
                        <h4 style="color: #FF6B35; margin-bottom: 0.5rem;">Safety Information</h4>
                        ${event.warnings.map(warning => `
                            <div class="warning-item warning-${warning.level}">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>${warning.message}</span>
                            </div>
                        `).join('')}
                    </div>
                ` : ''}
                
                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <button class="btn" style="background: ${isFavorited ? '#f44336' : '#FF6B35'}; color: white; padding: 0.75rem 1.5rem; flex: 1;" 
                            onclick="toggleFavorite(${event.id}); updateEventModal(${event.id});">
                        <i class="fas fa-heart"></i> ${isFavorited ? 'Remove Favorite' : 'Add to Favorites'}
                    </button>
                    <button class="btn" style="background: #4CAF50; color: white; padding: 0.75rem 1.5rem; flex: 1;" 
                            onclick="shareEvent(${event.id})">
                        <i class="fas fa-share"></i> Share Event
                    </button>
                </div>
                
                <button class="book-btn" onclick="bookEvent(${event.id})">
                    <i class="fas fa-ticket-alt"></i> Book This Event
                </button>
                
                ${event.userReviews && event.userReviews.length > 0 ? `
                    <div class="reviews-section">
                        <h4 style="color: #FF6B35; margin-bottom: 1rem;">Reviews</h4>
                        ${event.userReviews.map(review => `
                            <div class="review-item">
                                <div class="review-header">
                                    <span class="reviewer-name">${review.user}</span>
                                    <span class="review-date">${formatDate(review.date)}</span>
                                </div>
                                <div class="rating" style="margin-bottom: 0.5rem;">
                                    ${Array(5).fill().map((_, i) => `
                                        <i class="fas fa-star" style="color: ${i < review.rating ? '#FFD700' : '#ccc'};"></i>
                                    `).join('')}
                                </div>
                                <p>${review.comment}</p>
                                <div style="margin-top: 0.5rem; font-size: 0.8rem; color: rgba(255, 255, 255, 0.6);">
                                    ${review.helpful} people found this helpful
                                </div>
                            </div>
                        `).join('')}
                    </div>
                ` : ''}
            `;
            
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
            
            // Focus management
            modalTitle.focus();
        }

        // Update event modal (refresh favorite status)
        function updateEventModal(eventId) {
            if (currentSelectedEvent && currentSelectedEvent.id === eventId) {
                showEventDetails(currentSelectedEvent);
            }
        }

        // Toggle sidebar
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mapContainer = document.getElementById('mapContainer');
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    
    if (window.innerWidth <= 768) {
        // Mobile behavior
        sidebar.classList.toggle('active');
        mobileMenuBtn.setAttribute('aria-expanded', 
            sidebar.classList.contains('active') ? 'true' : 'false');
    } else {
        // Desktop behavior
        const isCollapsed = sidebar.classList.contains('collapsed');
        
        if (isCollapsed) {
            // Expand sidebar
            sidebar.classList.remove('collapsed');
            mapContainer.classList.remove('expanded');
            hideSidebarToggleButton();
        } else {
            // Collapse sidebar
            sidebar.classList.add('collapsed');
            mapContainer.classList.add('expanded');
            showSidebarToggleButton();
        }
    }
}

// Function to show the floating toggle button when sidebar is collapsed
function showSidebarToggleButton() {
    let toggleBtn = document.getElementById('sidebarToggleBtn');
    
    if (!toggleBtn) {
        // Create the button if it doesn't exist
        toggleBtn = document.createElement('button');
        toggleBtn.id = 'sidebarToggleBtn';
        toggleBtn.className = 'sidebar-toggle-btn';
        toggleBtn.innerHTML = '<i class="fas fa-bars" aria-hidden="true"></i>';
        toggleBtn.setAttribute('aria-label', 'Show sidebar');
        toggleBtn.setAttribute('title', 'Show sidebar');
        toggleBtn.onclick = toggleSidebar;
        document.body.appendChild(toggleBtn);
    }
    
    // Show the button
    toggleBtn.classList.add('show');
}

// Function to hide the floating toggle button
function hideSidebarToggleButton() {
    const toggleBtn = document.getElementById('sidebarToggleBtn');
    if (toggleBtn) {
        toggleBtn.classList.remove('show');
    }
}

// Handle window resize to manage button visibility
function handleWindowResize() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggleBtn');
    
    if (window.innerWidth <= 768) {
        // Mobile view - hide desktop toggle button
        if (toggleBtn) {
            toggleBtn.classList.remove('show');
        }
        // Reset sidebar classes for mobile
        sidebar.classList.remove('collapsed');
        document.getElementById('mapContainer').classList.remove('expanded');
    } else {
        // Desktop view - show toggle button if sidebar is collapsed
        if (sidebar.classList.contains('collapsed')) {
            showSidebarToggleButton();
        } else {
            hideSidebarToggleButton();
        }
    }
}

        // Toggle favorite
        function toggleFavorite(eventId) {
            const index = favorites.indexOf(eventId);
            if (index > -1) {
                favorites.splice(index, 1);
                showNotification('Removed from favorites', 'info');
            } else {
                favorites.push(eventId);
                showNotification('Added to favorites', 'success');
            }
            
            // Save to localStorage
            localStorage.setItem('nepalDiscovery_favorites', JSON.stringify(favorites));
            
            // Sync with server if online
            if (isOnline) {
                localStorage.setItem('nepalDiscovery_serverFavorites', JSON.stringify(favorites));
            }
            
            // Refresh display
            displayEvents();
        }

        // Share event
        function shareEvent(eventId) {
            const event = eventsData.events.find(e => e.id === eventId);
            if (!event) return;
            
            const shareData = {
                title: event.name,
                text: event.description,
                url: window.location.href + `?event=${eventId}`
            };
            
            if (navigator.share) {
                navigator.share(shareData).then(() => {
                    showNotification('Event shared successfully!', 'success');
                }).catch(err => {
                    console.error('Error sharing:', err);
                    fallbackShare(shareData);
                });
            } else {
                fallbackShare(shareData);
            }
        }

        // Fallback share method
        function fallbackShare(shareData) {
            const shareText = `${shareData.title}\n\n${shareData.text}\n\n${shareData.url}`;
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(shareText).then(() => {
                    showNotification('Event details copied to clipboard!', 'success');
                });
            } else {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = shareText;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showNotification('Event details copied to clipboard!', 'success');
            }
        }

        // Show favorites
        function showFavorites() {
            if (favorites.length === 0) {
                showNotification('No favorite events yet!', 'info');
                return;
            }
            
            const favoriteEvents = eventsData.events.filter(event => favorites.includes(event.id));
            currentEvents = favoriteEvents;
            displayEvents();
            updateMapMarkers();
            
            // Update search box to show "favorites"
            document.getElementById('searchInput').value = '';
            showNotification(`Showing ${favoriteEvents.length} favorite events`, 'info');
        }

        // Book event
        function bookEvent(eventId) {
            const event = eventsData.events.find(e => e.id === eventId);
            if (!event) return;
            
            if (event.available <= 0) {
                showNotification('Sorry, this event is fully booked!', 'error');
                return;
            }
            
            currentSelectedEvent = event;
            const modal = document.getElementById('bookingModal');
            const title = document.getElementById('bookingTitle');
            
            title.textContent = `Book: ${event.name}`;
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
            
            // Focus first input
            document.getElementById('fullName').focus();
        }

        // Handle booking form submission
        function handleBookingSubmit(e) {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const bookingData = {
                eventId: currentSelectedEvent.id,
                eventName: currentSelectedEvent.name,
                fullName: formData.get('fullName'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                numberOfPeople: parseInt(formData.get('numberOfPeople')),
                bookingDate: new Date().toISOString(),
                user: eventsData.currentUser || 'CrypticLuminary'
            };
            
            // Validate form
            if (!validateBookingForm(bookingData)) {
                return;
            }
            
            // Simulate booking process
            showLoading(true);
            
            setTimeout(() => {
                // Save booking locally
                const bookings = JSON.parse(localStorage.getItem('nepalDiscovery_bookings') || '[]');
                bookings.push(bookingData);
                localStorage.setItem('nepalDiscovery_bookings', JSON.stringify(bookings));
                
                // Update event availability
                currentSelectedEvent.available -= bookingData.numberOfPeople;
                
                showLoading(false);
                closeBookingModal();
                
                showNotification('Booking confirmed! Check your email for details.', 'success');
                
                // Refresh events display
                filterEvents();
            }, 2000);
        }

        // Validate booking form
        function validateBookingForm(data) {
            const errors = {};
            
            if (!data.fullName || data.fullName.trim().length < 2) {
                errors.fullName = 'Please enter a valid full name';
            }
            
            if (!data.email || !/\S+@\S+\.\S+/.test(data.email)) {
                errors.email = 'Please enter a valid email address';
            }
            
            if (!data.phone || !/^[\+]?[\d\s\-\(\)]{8,}$/.test(data.phone)) {
                errors.phone = 'Please enter a valid phone number';
            }
            
            if (!data.numberOfPeople || data.numberOfPeople < 1 || data.numberOfPeople > currentSelectedEvent.available) {
                errors.numberOfPeople = `Please enter a number between 1 and ${currentSelectedEvent.available}`;
            }
            
            // Display errors
            Object.keys(errors).forEach(field => {
                const errorElement = document.getElementById(`${field}-error`);
                const inputElement = document.getElementById(field);
                
                if (errorElement) {
                    errorElement.textContent = errors[field];
                    errorElement.style.display = 'block';
                }
                
                if (inputElement) {
                    inputElement.style.borderColor = '#f44336';
                }
            });
            
            // Clear previous errors for valid fields
            ['fullName', 'email', 'phone', 'numberOfPeople'].forEach(field => {
                if (!errors[field]) {
                    const errorElement = document.getElementById(`${field}-error`);
                    const inputElement = document.getElementById(field);
                    
                    if (errorElement) {
                        errorElement.style.display = 'none';
                    }
                    
                    if (inputElement) {
                        inputElement.style.borderColor = 'rgba(255, 255, 255, 0.2)';
                    }
                }
            });
            
            return Object.keys(errors).length === 0;
        }

        // Open add content modal
        function openAddContentModal() {
            const modal = document.getElementById('addContentModal');
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
        }

        // Handle file upload
        function handleFileUpload(event) {
            const files = event.target.files;
            if (!files || files.length === 0) return;
            
            Array.from(files).forEach(file => {
                if (file.type.startsWith('image/') || file.type.startsWith('video/')) {
                    // In a real app, this would upload to server
                    showNotification(`${file.name} uploaded successfully!`, 'success');
                } else {
                    showNotification(`${file.name} is not a valid image or video file`, 'error');
                }
            });
        }

        // Update rating display
        function updateRatingDisplay() {
            document.querySelectorAll('.rating-input .star').forEach((star, index) => {
                star.classList.toggle('active', index < currentRating);
                star.setAttribute('aria-checked', index < currentRating ? 'true' : 'false');
            });
        }

        // Submit review
        function submitReview() {
            const reviewText = document.getElementById('reviewText').value;
            
            if (currentRating === 0) {
                showNotification('Please select a rating', 'error');
                return;
            }
            
            if (!reviewText.trim()) {
                showNotification('Please write a review', 'error');
                return;
            }
            
            const review = {
                eventId: currentSelectedEvent?.id,
                user: eventsData.currentUser || 'CrypticLuminary',
                rating: currentRating,
                comment: reviewText,
                date: new Date().toISOString(),
                helpful: 0
            };
            
            // Save review locally
            const reviews = JSON.parse(localStorage.getItem('nepalDiscovery_reviews') || '[]');
            reviews.push(review);
            localStorage.setItem('nepalDiscovery_reviews', JSON.stringify(reviews));
            
            // Reset form
            currentRating = 0;
            updateRatingDisplay();
            document.getElementById('reviewText').value = '';
            
            closeAddContentModal();
            showNotification('Review submitted successfully!', 'success');
        }

        // Generate calendar
        function generateCalendar() {
            const calendarGrid = document.getElementById('calendarGrid');
            const currentMonthElement = document.getElementById('currentMonth');
            
            const year = currentMonth.getFullYear();
            const month = currentMonth.getMonth();
            
            currentMonthElement.textContent = currentMonth.toLocaleDateString('en-US', {
                month: 'long',
                year: 'numeric'
            });
            
            // Clear previous calendar
            calendarGrid.innerHTML = '';
            
            // Add day headers
            const dayHeaders = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            dayHeaders.forEach(day => {
                const header = document.createElement('div');
                header.textContent = day;
                header.style.fontWeight = 'bold';
                header.style.padding = '0.5rem';
                calendarGrid.appendChild(header);
            });
            
            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());
            
            // Generate calendar days
            for (let i = 0; i < 42; i++) { // 6 weeks × 7 days
                const date = new Date(startDate);
                date.setDate(startDate.getDate() + i);
                
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                dayElement.textContent = date.getDate();
                dayElement.setAttribute('role', 'gridcell');
                dayElement.setAttribute('tabindex', '0');
                
                // Check if day has events
                const hasEvents = eventsData.events.some(event => {
                    const eventDate = new Date(event.date);
                    return eventDate.toDateString() === date.toDateString();
                });
                
                if (hasEvents) {
                    dayElement.classList.add('has-event');
                    dayElement.setAttribute('aria-label', `${date.getDate()} - Has events`);
                }
                
                // Highlight today
                if (date.toDateString() === new Date().toDateString()) {
                    dayElement.classList.add('today');
                }
                
                // Dim days from other months
                if (date.getMonth() !== month) {
                    dayElement.style.opacity = '0.3';
                }
                
                dayElement.addEventListener('click', () => {
                    filterEventsByDate(date);
                });
                
                dayElement.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        filterEventsByDate(date);
                    }
                });
                
                calendarGrid.appendChild(dayElement);
            }
        }

        // Change calendar month
        function changeMonth(direction) {
            currentMonth.setMonth(currentMonth.getMonth() + direction);
            generateCalendar();
        }

        // Filter events by specific date
        function filterEventsByDate(date) {
            const dateStr = date.toDateString();
            const eventsOnDate = eventsData.events.filter(event => {
                const eventDate = new Date(event.date);
                return eventDate.toDateString() === dateStr;
            });
            
            if (eventsOnDate.length > 0) {
                currentEvents = eventsOnDate;
                displayEvents();
                updateMapMarkers();
                
                // Switch to list view
                document.querySelector('.view-btn[data-view="list"]').click();
                
                showNotification(`Found ${eventsOnDate.length} events on ${date.toLocaleDateString()}`, 'info');
            } else {
                showNotification('No events found on this date', 'info');
            }
        }

        // Close modals
        function closeModal() {
            const modal = document.getElementById('eventModal');
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
        }

        function closeAddContentModal() {
            const modal = document.getElementById('addContentModal');
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
        }

        function closeBookingModal() {
            const modal = document.getElementById('bookingModal');
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
            
            // Reset form
            document.getElementById('bookingForm').reset();
            
            // Clear error messages
            document.querySelectorAll('.error-message').forEach(error => {
                error.style.display = 'none';
            });
            
            // Reset input styles
            document.querySelectorAll('#bookingForm input').forEach(input => {
                input.style.borderColor = 'rgba(255, 255, 255, 0.2)';
            });
        }

        // Open image modal (for full-size image viewing)
        function openImageModal(imageSrc) {
            const modal = document.createElement('div');
            modal.className = 'modal active';
            modal.style.zIndex = '3000';
            modal.innerHTML = `
                <div class="modal-content" style="max-width: 90%; max-height: 90%; padding: 1rem;">
                    <div style="display: flex; justify-content: flex-end; margin-bottom: 1rem;">
                        <button class="close-btn" onclick="this.closest('.modal').remove()" aria-label="Close image">&times;</button>
                    </div>
                    <img src="${imageSrc}" style="width: 100%; height: auto; border-radius: 10px;" alt="Event image">
                </div>
            `;
            
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.remove();
                }
            });
            
            document.body.appendChild(modal);
        }

        // Initialize app when DOM is loaded
        document.addEventListener('DOMContentLoaded', initializeApp);

        // Handle browser back/forward
        window.addEventListener('popstate', (e) => {
            if (e.state && e.state.eventId) {
                const event = eventsData.events.find(e => e.id === e.state.eventId);
                if (event) {
                    showEventDetails(event);
                }
            }
        });

        // Service Worker registration for offline support
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('SW registered: ', registration);
                    })
                    .catch(registrationError => {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }
    </script>
</body>
</html>

<?php include '../includes/footer.php'; ?>