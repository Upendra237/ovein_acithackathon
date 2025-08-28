<?php
require_once 'config/config.php';

$page_title = 'Home';
include 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Hackathon System</h1>
                <p class="text-xl mb-8">Discover places, events, and guides</p>
                <?php if (!isLoggedIn()): ?>
                    <a href="<?php echo url('/login.php'); ?>" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
                        Get Started
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <i class="fas fa-map-marker-alt text-4xl text-blue-600 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Places</h3>
                <p class="text-gray-600">Discover amazing places</p>
                <a href="<?php echo url('/places/'); ?>" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Explore Places
                </a>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <i class="fas fa-calendar text-4xl text-green-600 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Events</h3>
                <p class="text-gray-600">Find exciting events</p>
                <a href="<?php echo url('/events/'); ?>" class="inline-block mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    View Events
                </a>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <i class="fas fa-book text-4xl text-purple-600 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Guides</h3>
                <p class="text-gray-600">Read helpful guides</p>
                <a href="<?php echo url('/guides/'); ?>" class="inline-block mt-4 bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                    Read Guides
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>