<?php
require_once 'config/config.php';

// Check if logged in
if (!isLoggedIn()) {
    header('Location: ' . url('/login.php'));
    exit();
}

$user = getCurrentUser();
if (!$user) {
    header('Location: ' . url('/logout.php'));
    exit();
}

$page_title = 'Dashboard';
include 'includes/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>
        
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-green-800 mb-2">Welcome!</h2>
            <p class="text-green-700">Hello <?php echo htmlspecialchars($user['username']); ?>! You are logged in as <?php echo htmlspecialchars($user['type']); ?>.</p>
        </div>

        <!-- User Info -->
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="font-semibold text-gray-800 mb-3">Your Profile:</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Username:</span>
                        <span class="font-semibold"><?php echo htmlspecialchars($user['username']); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Email:</span>
                        <span class="font-semibold"><?php echo htmlspecialchars($user['email']); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Type:</span>
                        <span class="font-semibold capitalize"><?php echo htmlspecialchars($user['type']); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Status:</span>
                        <span class="font-semibold text-green-600"><?php echo ucfirst($user['status']); ?></span>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="font-semibold text-gray-800 mb-3">Quick Links:</h3>
                <div class="space-y-2">
                    <a href="<?php echo url('/places/'); ?>" class="block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center">
                        View Places
                    </a>
                    <a href="<?php echo url('/events/'); ?>" class="block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-center">
                        View Events
                    </a>
                    <a href="<?php echo url('/guides/'); ?>" class="block bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 text-center">
                        View Guides
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>