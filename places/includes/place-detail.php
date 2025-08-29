<?php
function renderPlaceDetail($place) {
    ?>
    <div class="place-detail-modal fixed inset-0 bg-black bg-opacity-50 z-50 hidden" id="placeModal">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl max-w-6xl w-full max-h-[90vh] overflow-hidden">
                <!-- Header -->
                <div class="relative">
                    <img src="<?php echo htmlspecialchars($place['image']); ?>" 
                         alt="<?php echo htmlspecialchars($place['name']); ?>"
                         class="w-full h-64 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <button onclick="closePlaceModal()" 
                            class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm text-white p-2 rounded-full hover:bg-white/30 transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h1 class="text-3xl font-bold mb-2"><?php echo htmlspecialchars($place['name']); ?></h1>
                        <div class="flex items-center space-x-4 text-sm">
                            <span class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                <?php echo htmlspecialchars($place['district']); ?>
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-star mr-1 text-yellow-400"></i>
                                <?php echo $place['rating']; ?> (<?php echo $place['reviews_count']; ?> reviews)
                            </span>
                            <span class="bg-blue-500 px-2 py-1 rounded text-xs">
                                <?php echo htmlspecialchars($place['category']); ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <!-- Description -->
                    <div class="mb-6">
                        <p class="text-gray-700 leading-relaxed"><?php echo htmlspecialchars($place['description']); ?></p>
                    </div>

                    <!-- Quick Info -->
                    <div class="grid md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-blue-800 mb-2">
                                <i class="fas fa-ticket-alt mr-2"></i>Entry Fee
                            </h3>
                            <p class="text-sm text-blue-700"><?php echo htmlspecialchars($place['entry_fee']); ?></p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-green-800 mb-2">
                                <i class="fas fa-clock mr-2"></i>Opening Hours
                            </h3>
                            <p class="text-sm text-green-700"><?php echo htmlspecialchars($place['opening_hours']); ?></p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-purple-800 mb-2">
                                <i class="fas fa-calendar mr-2"></i>Best Time
                            </h3>
                            <p class="text-sm text-purple-700"><?php echo htmlspecialchars($place['best_time']); ?></p>
                        </div>
                    </div>

                    <!-- Horizontal Scrollable Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <div class="flex space-x-8 overflow-x-auto pb-2">
                            <button onclick="showTab('things-to-do')" 
                                    class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm active"
                                    data-tab="things-to-do">
                                Things to Do
                            </button>
                            <button onclick="showTab('events')" 
                                    class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                                    data-tab="events">
                                Events
                            </button>
                            <button onclick="showTab('reviews')" 
                                    class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                                    data-tab="reviews">
                                Reviews
                            </button>
                            <button onclick="showTab('awareness')" 
                                    class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                                    data-tab="awareness">
                                Awareness
                            </button>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content max-h-64 overflow-y-auto">
                        <!-- Things to Do -->
                        <div id="things-to-do" class="tab-pane">
                            <div class="grid md:grid-cols-2 gap-4">
                                <?php foreach ($place['things_to_do'] as $activity): ?>
                                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                        <span class="text-gray-700"><?php echo htmlspecialchars($activity); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Events -->
                        <div id="events" class="tab-pane hidden">
                            <div class="space-y-4">
                                <?php foreach ($place['events'] as $event): ?>
                                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                                        <h4 class="font-semibold text-gray-800"><?php echo htmlspecialchars($event['name']); ?></h4>
                                        <p class="text-sm text-blue-600 mb-1"><?php echo htmlspecialchars($event['date']); ?></p>
                                        <p class="text-gray-600"><?php echo htmlspecialchars($event['description']); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Reviews -->
                        <div id="reviews" class="tab-pane hidden">
                            <div class="space-y-4">
                                <?php foreach ($place['reviews'] as $review): ?>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-gray-800"><?php echo htmlspecialchars($review['user']); ?></h4>
                                            <div class="flex items-center">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fas fa-star text-xs <?php echo $i <= $review['rating'] ? 'text-yellow-400' : 'text-gray-300'; ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <p class="text-gray-700 text-sm mb-2"><?php echo htmlspecialchars($review['comment']); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($review['date']); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Awareness -->
                        <div id="awareness" class="tab-pane hidden">
                            <div class="space-y-3">
                                <?php foreach ($place['awareness'] as $tip): ?>
                                    <div class="flex items-start space-x-3 p-3 bg-yellow-50 rounded-lg">
                                        <i class="fas fa-exclamation-triangle text-yellow-500 mt-1"></i>
                                        <span class="text-gray-700"><?php echo htmlspecialchars($tip); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            // Hide all tab panes
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.add('hidden');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(button => {
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

        function closePlaceModal() {
            document.getElementById('placeModal').classList.add('hidden');
        }

        // Initialize first tab as active
        document.addEventListener('DOMContentLoaded', function() {
            showTab('things-to-do');
        });
    </script>

    <style>
        .tab-button {
            border-color: transparent;
            color: #6b7280;
        }
        
        .tab-button.active {
            border-color: #3b82f6;
            color: #2563eb;
        }
        
        .tab-button:hover {
            color: #374151;
        }
    </style>
    <?php
}
?>