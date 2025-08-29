<?php
require_once '../config/config.php';

$page_title = 'Places to Visit';
include '../includes/header.php';

// Load places data
$places_data = file_get_contents('data/places.json');
$places = json_decode($places_data, true);
?>

<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">
                    <i class="fas fa-map-marker-alt mr-3"></i>Discover Nepal
                </h1>
                <p class="text-xl opacity-90">Explore amazing places and hidden gems</p>
            </div>
        </div>
    </div>

    <!-- Map Container -->
    <div class="relative">
        <div id="map" class="w-full h-[70vh]"></div>
        
        <!-- Map Controls -->
        <div class="absolute top-4 left-4 z-[1000]">
            <div class="bg-white rounded-lg shadow-lg p-3">
                <h3 class="font-semibold text-gray-800 mb-2">
                    <i class="fas fa-filter mr-2"></i>Filter Places
                </h3>
                <div class="space-y-2">
                    <button onclick="filterPlaces('all')" 
                            class="filter-btn block w-full text-left px-3 py-1 rounded text-sm hover:bg-gray-100 active"
                            data-category="all">
                        All Places
                    </button>
                    <button onclick="filterPlaces('Religious')" 
                            class="filter-btn block w-full text-left px-3 py-1 rounded text-sm hover:bg-gray-100"
                            data-category="Religious">
                        Religious Sites
                    </button>
                    <button onclick="filterPlaces('Heritage')" 
                            class="filter-btn block w-full text-left px-3 py-1 rounded text-sm hover:bg-gray-100"
                            data-category="Heritage">
                        Heritage Sites
                    </button>
                </div>
            </div>
        </div>

        <!-- Places List Toggle -->
        <div class="absolute top-4 right-4 z-[1000]">
            <button onclick="togglePlacesList()" 
                    class="bg-white rounded-lg shadow-lg p-3 hover:bg-gray-50 transition-colors">
                <i class="fas fa-list mr-2"></i>Places List
            </button>
        </div>
    </div>

    <!-- Places List Sidebar -->
    <div id="placesList" class="fixed right-0 top-0 h-full w-80 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-[1001] overflow-y-auto">
        <div class="p-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800">Places to Visit</h2>
                <button onclick="togglePlacesList()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <div class="p-4 space-y-4">
            <?php foreach ($places as $place): ?>
                <div class="place-card bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors cursor-pointer"
                     onclick="focusOnPlace(<?php echo $place['latitude']; ?>, <?php echo $place['longitude']; ?>)"
                     data-category="<?php echo $place['category']; ?>">
                    <img src="<?php echo htmlspecialchars($place['image']); ?>" 
                         alt="<?php echo htmlspecialchars($place['name']); ?>"
                         class="w-full h-32 object-cover rounded-lg mb-3">
                    <h3 class="font-semibold text-gray-800 mb-1"><?php echo htmlspecialchars($place['name']); ?></h3>
                    <p class="text-sm text-gray-600 mb-2"><?php echo htmlspecialchars($place['short_description']); ?></p>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-blue-600"><?php echo htmlspecialchars($place['district']); ?></span>
                        <span class="flex items-center text-yellow-500">
                            <i class="fas fa-star mr-1"></i>
                            <?php echo $place['rating']; ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Include place detail modal -->
<?php 
include 'includes/place-detail.php';
// Render modal for the first place (will be updated via JavaScript)
if (!empty($places)) {
    renderPlaceDetail($places[0]);
}
?>

<!-- Leaflet CSS and JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// Places data for JavaScript
const placesData = <?php echo json_encode($places); ?>;

// Initialize map
const map = L.map('map').setView([27.7172, 85.3240], 7.5);

// Add tile layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Store markers for filtering
let markers = [];

// Add markers for each place
placesData.forEach(place => {
    const marker = L.marker([place.latitude, place.longitude])
        .addTo(map)
        .bindPopup(createPopupContent(place));
    
    marker.placeData = place;
    markers.push(marker);
});

// Create popup content
function createPopupContent(place) {
    return `
        <div class="w-64">
            <img src="${place.image}" alt="${place.name}" class="w-full h-32 object-cover rounded-lg mb-3">
            <h3 class="font-bold text-lg mb-2">${place.name}</h3>
            <p class="text-sm text-gray-600 mb-3">${place.short_description}</p>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">${place.category}</span>
                <span class="flex items-center text-yellow-500 text-sm">
                    <i class="fas fa-star mr-1"></i>
                    ${place.rating}
                </span>
            </div>
            <button onclick="openPlaceDetail(${place.id})" 
                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 px-4 rounded-lg hover:shadow-lg transition-all">
                <i class="fas fa-info-circle mr-2"></i>Read More
            </button>
        </div>
    `;
}

// Filter places by category
function filterPlaces(category) {
    // Update filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-blue-100', 'text-blue-800');
        if (btn.dataset.category === category) {
            btn.classList.add('active', 'bg-blue-100', 'text-blue-800');
        }
    });

    // Filter markers
    markers.forEach(marker => {
        if (category === 'all' || marker.placeData.category === category) {
            marker.addTo(map);
        } else {
            map.removeLayer(marker);
        }
    });

    // Filter places list
    document.querySelectorAll('.place-card').forEach(card => {
        if (category === 'all' || card.dataset.category === category) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Toggle places list sidebar
function togglePlacesList() {
    const sidebar = document.getElementById('placesList');
    sidebar.classList.toggle('translate-x-full');
}

// Focus on specific place
function focusOnPlace(lat, lng) {
    map.setView([lat, lng], 15);
    togglePlacesList(); // Close sidebar
}

// Open place detail modal
function openPlaceDetail(placeId) {
    const place = placesData.find(p => p.id === placeId);
    if (place) {
        // Update modal content
        updateModalContent(place);
        document.getElementById('placeModal').classList.remove('hidden');
    }
}

// Update modal content
function updateModalContent(place) {
    // This would update the modal with the selected place data
    // For now, we'll just show the modal as it contains the first place data
    console.log('Opening details for:', place.name);
}

// Initialize filter
filterPlaces('all');
</script>

<style>
.filter-btn.active {
    background-color: #dbeafe;
    color: #1e40af;
}

.leaflet-popup-content-wrapper {
    border-radius: 12px;
}

.leaflet-popup-content {
    margin: 8px 12px;
}
</style>

<?php include '../includes/footer.php'; ?>