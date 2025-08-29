<?php
require_once '../config/config.php';

// Get place ID from URL
$place_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Load places data
$places_data = file_get_contents('data/places.json');
$places = json_decode($places_data, true);

// Find the specific place
$current_place = null;
foreach ($places as $place) {
    if ($place['id'] === $place_id) {
        $current_place = $place;
        break;
    }
}

// If place not found, redirect or show error
if (!$current_place) {
    $current_place = $places[0]; // Default to first place
}

$page_title = $current_place['name'] . ' - Places to Visit';
include '../includes/header.php';
?>

<div class="min-h-screen bg-gray-50">
    <!-- Hero Section with Title -->
    <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-2">
                    <?php echo htmlspecialchars($current_place['name']); ?>
                </h1>
                <div class="flex items-center justify-center space-x-4 text-lg opacity-90">
                    <span class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <?php echo htmlspecialchars($current_place['district']); ?>
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-star mr-1 text-yellow-400"></i>
                        <?php echo $current_place['rating']; ?> (<?php echo $current_place['reviews_count']; ?> reviews)
                    </span>
                    <span class="bg-white/20 px-3 py-1 rounded-full text-sm">
                        <?php echo htmlspecialchars($current_place['category']); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Two Column Layout -->
        <div class="grid lg:grid-cols-3 gap-8 mb-8">
            <!-- Left Column - Description -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">About This Place</h2>
                    <p class="text-gray-700 leading-relaxed mb-6"><?php echo htmlspecialchars($current_place['description']); ?></p>
                    
                    <!-- Quick Info Grid -->
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-blue-800 mb-2">
                                <i class="fas fa-ticket-alt mr-2"></i>Entry Fee
                            </h3>
                            <p class="text-sm text-blue-700"><?php echo htmlspecialchars($current_place['entry_fee']); ?></p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-green-800 mb-2">
                                <i class="fas fa-clock mr-2"></i>Opening Hours
                            </h3>
                            <p class="text-sm text-green-700"><?php echo htmlspecialchars($current_place['opening_hours']); ?></p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-purple-800 mb-2">
                                <i class="fas fa-calendar mr-2"></i>Best Time
                            </h3>
                            <p class="text-sm text-purple-700"><?php echo htmlspecialchars($current_place['best_time']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Image and Map -->
            <div class="space-y-6">
                <!-- Main Image -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <img src="<?php echo htmlspecialchars($current_place['image']); ?>" 
                         alt="<?php echo htmlspecialchars($current_place['name']); ?>"
                         class="w-full h-64 object-cover">
                </div>
                
                <!-- Location Map -->
                <div class="bg-white rounded-xl shadow-lg p-4">
                    <h3 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-map mr-2"></i>Location
                    </h3>
                    <div id="detailMap" class="w-full h-48 rounded-lg"></div>
                </div>
            </div>
        </div>

        <!-- Horizontal Scrolling Tabs -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200 px-6">
                <div class="flex space-x-8 overflow-x-auto py-4">
                    <button onclick="showDetailTab('things-to-do')" 
                            class="detail-tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm active"
                            data-tab="things-to-do">
                        <i class="fas fa-list-check mr-2"></i>Things to Do
                    </button>
                    <button onclick="showDetailTab('events')" 
                            class="detail-tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                            data-tab="events">
                        <i class="fas fa-calendar-alt mr-2"></i>Events
                    </button>
                    <button onclick="showDetailTab('reviews')" 
                            class="detail-tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                            data-tab="reviews">
                        <i class="fas fa-star mr-2"></i>Reviews
                    </button>
                    <button onclick="showDetailTab('guides')" 
                            class="detail-tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                            data-tab="guides">
                        <i class="fas fa-user-guide mr-2"></i>Available Guides
                    </button>
                    <button onclick="showDetailTab('recommendations')" 
                            class="detail-tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                            data-tab="recommendations">
                        <i class="fas fa-thumbs-up mr-2"></i>Recommendations
                    </button>
                    <button onclick="showDetailTab('awareness')" 
                            class="detail-tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                            data-tab="awareness">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Awareness
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- Things to Do -->
                <div id="things-to-do" class="detail-tab-pane">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Things to Do</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <?php foreach ($current_place['things_to_do'] as $activity): ?>
                            <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg">
                                <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                <span class="text-gray-700"><?php echo htmlspecialchars($activity); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Events -->
                <div id="events" class="detail-tab-pane hidden">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Upcoming Events</h3>
                    <div class="space-y-4">
                        <?php foreach ($current_place['events'] as $event): ?>
                            <div class="border-l-4 border-blue-500 pl-6 py-4 bg-blue-50 rounded-r-lg">
                                <h4 class="font-semibold text-gray-800 text-lg"><?php echo htmlspecialchars($event['name']); ?></h4>
                                <p class="text-sm text-blue-600 mb-2 font-medium"><?php echo htmlspecialchars($event['date']); ?></p>
                                <p class="text-gray-600"><?php echo htmlspecialchars($event['description']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Reviews -->
                <div id="reviews" class="detail-tab-pane hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Reviews</h3>
                        <div class="flex space-x-2">
                            <button onclick="sortReviews('rating')" class="text-sm px-3 py-1 bg-gray-100 rounded-lg hover:bg-gray-200">
                                Sort by Rating
                            </button>
                            <button onclick="sortReviews('date')" class="text-sm px-3 py-1 bg-gray-100 rounded-lg hover:bg-gray-200">
                                Sort by Date
                            </button>
                        </div>
                    </div>
                    <div id="reviewsContainer" class="space-y-4">
                        <?php foreach ($current_place['reviews'] as $review): ?>
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-semibold text-gray-800"><?php echo htmlspecialchars($review['user']); ?></h4>
                                    <div class="flex items-center">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star text-sm <?php echo $i <= $review['rating'] ? 'text-yellow-400' : 'text-gray-300'; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-3"><?php echo htmlspecialchars($review['comment']); ?></p>
                                <p class="text-xs text-gray-500"><?php echo htmlspecialchars($review['date']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Available Guides -->
                <div id="guides" class="detail-tab-pane hidden">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Available Guides</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <?php foreach ($current_place['guides'] as $guide): ?>
                            <div class="bg-white border border-gray-200 p-4 rounded-lg">
                                <div class="flex items-center space-x-3 mb-3">
                                    <img src="<?php echo htmlspecialchars($guide['photo']); ?>" 
                                         alt="<?php echo htmlspecialchars($guide['name']); ?>"
                                         class="w-12 h-12 rounded-full object-cover">
                                    <div>
                                        <h4 class="font-semibold text-gray-800"><?php echo htmlspecialchars($guide['name']); ?></h4>
                                        <div class="flex items-center text-sm">
                                            <span class="flex items-center text-yellow-500 mr-2">
                                                <i class="fas fa-star mr-1"></i>
                                                <?php echo $guide['rating']; ?>
                                            </span>
                                            <span class="text-gray-500">(<?php echo $guide['tours_completed']; ?> tours)</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mb-3"><?php echo htmlspecialchars($guide['speciality']); ?></p>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-green-600">NPR <?php echo $guide['price_per_hour']; ?>/hour</span>
                                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                        Contact Guide
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Recommendations -->
                <div id="recommendations" class="detail-tab-pane hidden">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Recommendations</h3>
                    <div class="space-y-4">
                        <?php foreach ($current_place['recommendations'] as $recommendation): ?>
                            <div class="flex items-start space-x-4 p-4 bg-green-50 rounded-lg">
                                <i class="fas fa-lightbulb text-green-500 mt-1"></i>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-1"><?php echo htmlspecialchars($recommendation['title']); ?></h4>
                                    <p class="text-gray-600"><?php echo htmlspecialchars($recommendation['description']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Awareness -->
                <div id="awareness" class="detail-tab-pane hidden">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Important Awareness</h3>
                    <div class="space-y-3">
                        <?php foreach ($current_place['awareness'] as $tip): ?>
                            <div class="flex items-start space-x-3 p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-400">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-1"></i>
                                <span class="text-gray-700"><?php echo htmlspecialchars($tip); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Map Button -->
    <div class="fixed bottom-6 right-6">
        <button onclick="window.close()" 
                class="bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to Map
        </button>
    </div>
</div>

<!-- Leaflet CSS and JS for small map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
const placeData = <?php echo json_encode($current_place); ?>;

// Initialize detail map
const detailMap = L.map('detailMap').setView([placeData.latitude, placeData.longitude], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(detailMap);

// Add marker for current place
L.marker([placeData.latitude, placeData.longitude])
    .addTo(detailMap)
    .bindPopup(`<b>${placeData.name}</b><br>${placeData.short_description}`)
    .openPopup();

// Tab functionality
function showDetailTab(tabId) {
    // Hide all tab panes
    document.querySelectorAll('.detail-tab-pane').forEach(pane => {
        pane.classList.add('hidden');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.detail-tab-btn').forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab pane
    document.getElementById(tabId).classList.remove('hidden');
    
    // Add active class to selected button
    const activeButton = document.querySelector(`[data-tab="${tabId}"]`);
    activeButton.classList.add('active', 'border-blue-500', 'text-blue-600');
    activeButton.classList.remove('border-transparent', 'text-gray-500');
}

// Sort reviews
function sortReviews(sortBy) {
    const reviewsContainer = document.getElementById('reviewsContainer');
    const reviews = Array.from(reviewsContainer.children);
    
    reviews.sort((a, b) => {
        if (sortBy === 'rating') {
            const ratingA = a.querySelector('.fas.fa-star').parentElement.children.length;
            const ratingB = b.querySelector('.fas.fa-star').parentElement.children.length;
            return ratingB - ratingA;
        } else if (sortBy === 'date') {
            const dateA = new Date(a.querySelector('.text-xs').textContent);
            const dateB = new Date(b.querySelector('.text-xs').textContent);
            return dateB - dateA;
        }
        return 0;
    });
    
    reviewsContainer.innerHTML = '';
    reviews.forEach(review => reviewsContainer.appendChild(review));
}

// Initialize first tab as active
document.addEventListener('DOMContentLoaded', function() {
    showDetailTab('things-to-do');
});
</script>

<style>
.detail-tab-btn {
    border-color: transparent;
    color: #6b7280;
}

.detail-tab-btn.active {
    border-color: #3b82f6;
    color: #2563eb;
}

.detail-tab-btn:hover {
    color: #374151;
}
</style>

<?php include '../includes/footer.php'; ?>