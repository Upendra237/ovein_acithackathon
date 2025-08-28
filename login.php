<?php
require_once 'config/config.php';

// Process login FIRST - before any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if ($username && $password) {
        $users = loadJsonData(USERS_FILE);
        
        foreach ($users as $user) {
            if ($user['username'] === $username && 
                $user['password'] === $password && 
                $user['status'] === 'active') {
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_type'] = $user['type'];
                $_SESSION['username'] = $user['username'];
                
                // Immediate redirect
                header('Location: ' . url('/dashboard.php'));
                exit();
            }
        }
        
        $error = 'Invalid username or password';
    } else {
        $error = 'Please fill in all fields';
    }
}

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: ' . url('/dashboard.php'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo SITE_NAME; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900">Sign in</h2>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="space-y-6">
                <div>
                    <input name="username" type="text" required 
                           value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="Username">
                </div>
                <div>
                    <input name="password" type="password" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="Password">
                </div>
                <div>
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Sign in
                    </button>
                </div>
            </form>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm">
                <div class="text-blue-800 font-semibold mb-2">Demo Credentials:</div>
                <div class="text-blue-700 space-y-1">
                    <div>Admin: admin / password</div>
                    <div>User: user1 / password</div>
                    <div>Developer: developer / password</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>