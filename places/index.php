<?php
require_once '../config/config.php';

$page_title = 'Places to Visit';
include '../includes/header.php';

// Load places data
$places_data = file_get_contents('data/places.json');
$places = json_decode($places_data, true);
?>

<!-- Search Box between header and map -->
<div class="bg-white border-b border-gray-200 py-3">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-center">
            <div class="relative max-w-md w-full">
                <input type="text" 
                       id="quickSearch"
                       placeholder="Search places..." 
                       class="w-full pl-10 pr-12 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <button onclick="toggleAdvancedSearch()" 
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-blue-600 hover:text-blue-800 px-2 py-1 text-sm">
                    <i class="fas fa-sliders-h mr-1"></i>Advanced
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Advanced Search Overlay -->
<div id="advancedSearchOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-[2000] hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl max-w-2xl w-full p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-search mr-2"></i>Advanced Search
                </h2>
                <button onclick="toggleAdvancedSearch()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="advancedCategory" class="w-full p-2 border border-gray-300 rounded-lg">
                        <option value="">All Categories</option>
                        <option value="Religious">Religious Sites</option>
                        <option value="Heritage">Heritage Sites</option>
                        <option value="Nature">Nature & Parks</option>
                        <option value="Adventure">Adventure</option>
                        <option value="Cultural">Cultural Sites</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">District</label>
                    <select id="advancedDistrict" class="w-full p-2 border border-gray-300 rounded-lg">
                        <option value="">All Districts</option>
                        <option value="Kathmandu">Kathmandu</option>
                        <option value="Lalitpur">Lalitpur</option>
                        <option value="Bhaktapur">Bhaktapur</option>
                        <option value="Pokhara">Pokhara</option>
                        <option value="Chitwan">Chitwan</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                    <select id="advancedRating" class="w-full p-2 border border-gray-300 rounded-lg">
                        <option value="">Any Rating</option>
                        <option value="4.5">4.5+ Stars</option>
                        <option value="4.0">4.0+ Stars</option>
                        <option value="3.5">3.5+ Stars</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Entry Fee</label>
                    <select id="advancedFee" class="w-full p-2 border border-gray-300 rounded-lg">
                        <option value="">Any Price</option>
                        <option value="free">Free</option>
                        <option value="paid">Paid Entry</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-6 flex space-x-3">
                <button onclick="applyAdvancedSearch()" 
                        class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                    Apply Search
                </button>
                <button onclick="clearAdvancedSearch()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Clear
                </button>
            </div>
        </div>
    </div>
</div>

<div class="relative">
    <!-- Full Screen Map -->
    <div id="map" class="w-full h-screen"></div>
    
    <!-- Map Controls -->
    <div class="absolute top-4 left-4 z-[1000]">
        <div class="bg-white rounded-lg shadow-lg p-3">
            <h3 class="font-semibold text-gray-800 mb-2">
                <i class="fas fa-filter mr-2"></i>Quick Filter
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
                <button onclick="filterPlaces('Nature')" 
                        class="filter-btn block w-full text-left px-3 py-1 rounded text-sm hover:bg-gray-100"
                        data-category="Nature">
                    Nature & Parks
                </button>
                <button onclick="filterPlaces('Adventure')" 
                        class="filter-btn block w-full text-left px-3 py-1 rounded text-sm hover:bg-gray-100"
                        data-category="Adventure">
                    Adventure
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
    
    <div class="p-4 space-y-4" id="placesContainer">
        <?php foreach ($places as $place): ?>
            <div class="place-card bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors cursor-pointer"
                 onclick="focusOnPlace(<?php echo $place['latitude']; ?>, <?php echo $place['longitude']; ?>)"
                 data-category="<?php echo $place['category']; ?>"
                 data-district="<?php echo $place['district']; ?>"
                 data-rating="<?php echo $place['rating']; ?>"
                 data-name="<?php echo strtolower($place['name']); ?>">
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

<!-- Hover Modal for Quick View -->
<div id="hoverModal" class="fixed bg-white rounded-xl shadow-2xl z-[1500] p-4 w-80 hidden pointer-events-none">
    <div class="relative">
        <img id="hoverImage" src="" alt="" class="w-full h-40 object-cover rounded-lg mb-3">
        <h3 id="hoverTitle" class="font-bold text-lg mb-2"></h3>
        <p id="hoverDescription" class="text-sm text-gray-600 mb-3"></p>
        <div class="flex items-center justify-between mb-3">
            <span id="hoverCategory" class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded"></span>
            <span id="hoverRating" class="flex items-center text-yellow-500 text-sm">
                <i class="fas fa-star mr-1"></i>
                <span></span>
            </span>
        </div>
        <button onclick="openPlaceDetailPage(window.currentHoverPlace.id)" 
                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 px-4 rounded-lg hover:shadow-lg transition-all pointer-events-auto">
            <i class="fas fa-external-link-alt mr-2"></i>View Details
        </button>
    </div>
</div>

<!-- Leaflet CSS and JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// Places data for JavaScript
const placesData = <?php echo json_encode($places); ?>;
let filteredPlaces = [...placesData];

// Initialize map
const map = L.map('map').setView([27.7172, 85.3240], 8);

// Add tile layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Store markers for filtering
let markers = [];
let hoverTimeout;
window.currentHoverPlace = null;

// Add markers for each place
function initializeMarkers() {
    markers.forEach(marker => map.removeLayer(marker));
    markers = [];
    
    filteredPlaces.forEach(place => {
        const marker = L.marker([place.latitude, place.longitude])
            .addTo(map);
        
        marker.placeData = place;
        markers.push(marker);
        
        // Hover events for markers
        marker.on('mouseover', function(e) {
            clearTimeout(hoverTimeout);
            showHoverModal(place, e.originalEvent);
        });
        
        marker.on('mouseout', function() {
            hoverTimeout = setTimeout(() => {
                hideHoverModal();
            }, 200);
        });
    });
}

// Show hover modal
function showHoverModal(place, event) {
    window.currentHoverPlace = place;
    const modal = document.getElementById('hoverModal');
    
    document.getElementById('hoverImage').src = place.image;
    document.getElementById('hoverTitle').textContent = place.name;
    document.getElementById('hoverDescription').textContent = place.short_description;
    document.getElementById('hoverCategory').textContent = place.category;
    document.getElementById('hoverRating').querySelector('span').textContent = place.rating;
    
    modal.style.left = (event.pageX + 20) + 'px';
    modal.style.top = (event.pageY - 100) + 'px';
    modal.classList.remove('hidden');
    
    // Keep modal visible when hovering over it
    modal.addEventListener('mouseenter', () => {
        clearTimeout(hoverTimeout);
    });
    
    modal.addEventListener('mouseleave', () => {
        hideHoverModal();
    });
}

// Hide hover modal
function hideHoverModal() {
    document.getElementById('hoverModal').classList.add('hidden');
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

    // Filter data
    if (category === 'all') {
        filteredPlaces = [...placesData];
    } else {
        filteredPlaces = placesData.filter(place => place.category === category);
    }
    
    initializeMarkers();
    updatePlacesList();
}

// Quick search functionality
document.getElementById('quickSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    
    if (searchTerm === '') {
        filteredPlaces = [...placesData];
    } else {
        filteredPlaces = placesData.filter(place => 
            place.name.toLowerCase().includes(searchTerm) ||
            place.description.toLowerCase().includes(searchTerm) ||
            place.district.toLowerCase().includes(searchTerm)
        );
    }
    
    initializeMarkers();
    updatePlacesList();
});

// Advanced search functions
function toggleAdvancedSearch() {
    document.getElementById('advancedSearchOverlay').classList.toggle('hidden');
}

function applyAdvancedSearch() {
    const category = document.getElementById('advancedCategory').value;
    const district = document.getElementById('advancedDistrict').value;
    const rating = document.getElementById('advancedRating').value;
    const fee = document.getElementById('advancedFee').value;
    
    filteredPlaces = placesData.filter(place => {
        if (category && place.category !== category) return false;
        if (district && place.district !== district) return false;
        if (rating && place.rating < parseFloat(rating)) return false;
        if (fee === 'free' && !place.entry_fee.toLowerCase().includes('free')) return false;
        if (fee === 'paid' && place.entry_fee.toLowerCase().includes('free')) return false;
        return true;
    });
    
    initializeMarkers();
    updatePlacesList();
    toggleAdvancedSearch();
}

function clearAdvancedSearch() {
    document.getElementById('advancedCategory').value = '';
    document.getElementById('advancedDistrict').value = '';
    document.getElementById('advancedRating').value = '';
    document.getElementById('advancedFee').value = '';
    document.getElementById('quickSearch').value = '';
    
    filteredPlaces = [...placesData];
    initializeMarkers();
    updatePlacesList();
}

// Update places list
function updatePlacesList() {
    const container = document.getElementById('placesContainer');
    container.innerHTML = '';
    
    filteredPlaces.forEach(place => {
        const placeCard = document.createElement('div');
        placeCard.className = 'place-card bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors cursor-pointer';
        placeCard.onclick = () => focusOnPlace(place.latitude, place.longitude);
        placeCard.innerHTML = `
            <img src="${place.image}" alt="${place.name}" class="w-full h-32 object-cover rounded-lg mb-3">
            <h3 class="font-semibold text-gray-800 mb-1">${place.name}</h3>
            <p class="text-sm text-gray-600 mb-2">${place.short_description}</p>
            <div class="flex items-center justify-between text-xs">
                <span class="text-blue-600">${place.district}</span>
                <span class="flex items-center text-yellow-500">
                    <i class="fas fa-star mr-1"></i>
                    ${place.rating}
                </span>
            </div>
        `;
        container.appendChild(placeCard);
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

// Open place detail in new tab
function openPlaceDetailPage(placeId) {
    window.open(`detail.php?id=${placeId}`, '_blank');
}

// Initialize
initializeMarkers();
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

#hoverModal {
    transition: opacity 0.2s ease-in-out;
}

/* Ensure hover modal is above everything */
#hoverModal {
    pointer-events: auto;
}
</style>

<?php include '../includes/footer.php'; ?>