<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Guide Booking Map</title>
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Leaflet CSS -->
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet/dist/leaflet.css"
  />

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  
  <style>
    #map {
      height: 100vh;
      width: 100%;
      z-index: 0;
    }
    
    /* Map Container Transitions */
    #mapContainer {
      transition: margin-left 0.3s ease-in-out;
      margin-left: 0;
    }
    
    #mapContainer.pushed {
      margin-left: 320px; /* Width of sidebar */
    }
    
    /* Sidebar Styles - slides from LEFT */
    .slide-panel {
      transform: translateX(-100%);
      transition: transform 0.3s ease-in-out;
      width: 320px;
    }
    .slide-panel.active {
      transform: translateX(0);
    }
    
    /* Toggle Button */
    .sidebar-toggle {
      position: fixed;
      top: 50%;
      left: 20px;
      transform: translateY(-50%);
      z-index: 25;
      transition: left 0.3s ease-in-out;
    }
    
    .sidebar-toggle.shifted {
      left: 340px; /* Sidebar width + 20px */
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
      #mapContainer.pushed {
        margin-left: 0; /* No push on mobile */
      }
      
      .sidebar-toggle.shifted {
        left: 20px; /* Keep button on left on mobile */
      }
      
      .slide-panel {
        width: 100%;
        max-width: 320px;
      }
    }
    
    .status-indicator {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      display: inline-block;
      margin-right: 4px;
    }
    .available { background-color: #10B981; }
    .busy { background-color: #F59E0B; }
    .offline { background-color: #EF4444; }
    
    .booking-modal {
      backdrop-filter: blur(4px);
    }
    
    .message-bubble {
      max-width: 80%;
      word-wrap: break-word;
    }
    .message-sent {
      margin-left: auto;
      background-color: #3B82F6;
      color: white;
    }
    .message-received {
      margin-right: auto;
      background-color: #F3F4F6;
      color: #374151;
    }
  </style>
</head>
<body class="bg-gray-100">

  <!-- Sidebar Toggle Button -->
  <button id="sidebarToggle" class="hidden">
    <svg id="toggleIcon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M3 12H21M3 6H21M3 18H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>

  <!-- Guide Sidebar (slides from left) -->
  <div id="guideSidebar" class="slide-panel fixed top-0 left-0 h-full bg-white shadow-xl z-20 overflow-y-auto">
    <div class="p-4 border-b bg-blue-50">
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Available Guides</h2>
        <button id="closeSidebar" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
      </div>
      <p class="text-sm text-gray-600 mt-1">Near your location</p>
      
      <!-- Filter buttons -->
      <div class="mt-3 flex space-x-2">
        <button onclick="filterGuides('all')" class="filter-btn active px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800">All</button>
        <button onclick="filterGuides('available')" class="filter-btn px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-700">Available Now</button>
        <button onclick="filterGuides('busy')" class="filter-btn px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-700">Busy</button>
      </div>
    </div>
    <div id="guideList" class="p-4 space-y-3">
      <!-- Guide cards will be populated here -->
    </div>
  </div>

  <!-- Main Content Container -->
  <div class="w-full overflow-hidden">
    
    <!-- Map Container -->
    <div id="mapContainer" class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
      <div id="map"></div>
    </div>

  </div>

  <!-- Rest of your modals remain the same -->
  <!-- Booking Modal -->
  <div id="bookingModal" class="booking-modal fixed inset-0 bg-black bg-opacity-50 z-30 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 m-4 max-w-md w-full max-h-[90vh] overflow-y-auto">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Book Your Guide</h2>
        <button id="closeBookingModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
      </div>
      
      <div id="bookingGuideInfo" class="mb-4 p-3 bg-gray-50 rounded">
        <!-- Guide info will be populated here -->
      </div>
      
      <form id="bookingForm">
        <div class="grid grid-cols-2 gap-3 mb-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
            <input type="date" id="bookingDate" class="w-full p-2 border border-gray-300 rounded-lg text-sm" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Time</label>
            <input type="time" id="bookingTime" class="w-full p-2 border border-gray-300 rounded-lg text-sm" required>
          </div>
        </div>
        
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
          <select id="bookingDuration" class="w-full p-2 border border-gray-300 rounded-lg" required>
            <option value="">Select duration</option>
            <option value="1">1 hour</option>
            <option value="2">2 hours</option>
            <option value="3">3 hours</option>
            <option value="4">4 hours</option>
            <option value="6">6 hours</option>
            <option value="8">Full day (8 hours)</option>
          </select>
        </div>
        
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Meeting Point</label>
          <input type="text" id="meetingPoint" placeholder="e.g., Hotel lobby, Train station..." 
                 class="w-full p-2 border border-gray-300 rounded-lg" required>
        </div>
        
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Your Contact</label>
          <input type="tel" id="contactNumber" placeholder="Phone number" 
                 class="w-full p-2 border border-gray-300 rounded-lg" required>
        </div>
        
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Special Requests (Optional)</label>
          <textarea id="specialRequests" rows="2" placeholder="Any specific interests or requirements..." 
                    class="w-full p-2 border border-gray-300 rounded-lg"></textarea>
        </div>
        
        <div id="costEstimate" class="mb-4 p-3 bg-blue-50 rounded-lg">
          <!-- Cost estimate will be shown here -->
        </div>
        
        <div class="flex space-x-3">
          <button type="button" id="cancelBooking" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
            Cancel
          </button>
          <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Send Booking Request
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Messaging Modal -->
  <div id="messagingModal" class="booking-modal fixed inset-0 bg-black bg-opacity-50 z-30 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg m-4 max-w-md w-full h-[600px] flex flex-col">
      <div class="p-4 border-b bg-blue-50 flex justify-between items-center">
        <div>
          <h2 class="text-xl font-bold text-gray-800">Message Guide</h2>
          <p id="messageGuideInfo" class="text-sm text-gray-600"></p>
        </div>
        <button id="closeMessagingModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
      </div>
      
      <div id="messageHistory" class="flex-1 p-4 overflow-y-auto space-y-3">
        <!-- Messages will be populated here -->
      </div>
      
      <div class="p-4 border-t">
        <div class="mb-3">
          <div class="flex flex-wrap gap-2">
            <button onclick="sendQuickMessage('When can we meet?')" class="quick-msg-btn px-3 py-1 text-xs bg-gray-100 rounded-full hover:bg-gray-200">When can we meet?</button>
            <button onclick="sendQuickMessage('What is included in the tour?')" class="quick-msg-btn px-3 py-1 text-xs bg-gray-100 rounded-full hover:bg-gray-200">What's included?</button>
            <button onclick="sendQuickMessage('Can you pick me up from my hotel?')" class="quick-msg-btn px-3 py-1 text-xs bg-gray-100 rounded-full hover:bg-gray-200">Hotel pickup?</button>
          </div>
        </div>
        <div class="flex space-x-2">
          <input type="text" id="messageInput" placeholder="Type your message..." 
                 class="flex-1 p-2 border border-gray-300 rounded-lg">
          <button onclick="sendMessage()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Send</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Report Modal -->
  <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 m-4 max-w-md w-full">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Report Guide</h2>
        <button id="closeReportModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
      </div>
      
      <div id="reportGuideInfo" class="mb-4 p-3 bg-gray-50 rounded">
        <!-- Guide info will be populated here -->
      </div>
      
      <form id="reportForm">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Report</label>
          <select id="reportReason" class="w-full p-2 border border-gray-300 rounded-lg" required>
            <option value="">Select a reason</option>
            <option value="inappropriate_behavior">Inappropriate Behavior</option>
            <option value="unsafe_practices">Unsafe Practices</option>
            <option value="fraud">Fraud/Scam</option>
            <option value="fake_profile">Fake Profile</option>
            <option value="poor_service">Poor Service</option>
            <option value="other">Other</option>
          </select>
        </div>
        
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
          <textarea id="reportDescription" rows="4" class="w-full p-2 border border-gray-300 rounded-lg" 
                    placeholder="Please provide details about your report..." required></textarea>
        </div>
        
        <div class="flex space-x-3">
          <button type="button" id="cancelReport" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
            Cancel
          </button>
          <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
            Submit Report
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Enhanced guide data with availability status
    const guidesData = [
      {
        id: 1,
        name: "Raj Sharma",
        specialty: "Historical Tours",
        rating: 4.8,
        price: 25,
        experience: "5 years",
        languages: ["English", "Hindi"],
        image: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face",
        description: "Expert in local history and cultural heritage",
        status: "available",
        responseTime: "Usually responds in 15 minutes",
        totalBookings: 156
      },
      {
        id: 2,
        name: "Priya Patel",
        specialty: "Food & Culture",
        rating: 4.9,
        price: 30,
        experience: "3 years",
        languages: ["English", "Gujarati", "Hindi"],
        image: "https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face",
        description: "Passionate about local cuisine and traditions",
        status: "available",
        responseTime: "Usually responds in 30 minutes",
        totalBookings: 89
      },
      {
        id: 3,
        name: "Ahmed Khan",
        specialty: "Adventure & Nature",
        rating: 4.7,
        price: 35,
        experience: "7 years",
        languages: ["English", "Urdu", "Hindi"],
        image: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face",
        description: "Outdoor enthusiast and nature expert",
        status: "busy",
        responseTime: "Usually responds in 2 hours",
        totalBookings: 203
      },
      {
        id: 4,
        name: "Sarah Wilson",
        specialty: "Art & Architecture",
        rating: 4.6,
        price: 28,
        experience: "4 years",
        languages: ["English", "French"],
        image: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face",
        description: "Art historian specializing in local architecture",
        status: "offline",
        responseTime: "Usually responds in 4 hours",
        totalBookings: 67
      },
      {
        id: 5,
        name: "Maria Garcia",
        specialty: "Photography Tours",
        rating: 4.8,
        price: 40,
        experience: "6 years",
        languages: ["English", "Spanish"],
        image: "https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&h=150&fit=crop&crop=face",
        description: "Professional photographer and city explorer",
        status: "available",
        responseTime: "Usually responds in 20 minutes",
        totalBookings: 134
      }
    ];

    // Initialize the map
    const map = L.map('map').setView([28.6139, 77.2090], 14);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let userMarker = null;
    let currentFilter = 'all';
    let currentGuideId = null;
    let messageHistory = {};
    let sidebarOpen = false;
    
    // DOM elements
    const guideSidebar = document.getElementById('guideSidebar');
    const closeSidebar = document.getElementById('closeSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mapContainer = document.getElementById('mapContainer');
    const toggleIcon = document.getElementById('toggleIcon');
    const guideList = document.getElementById('guideList');
    const bookingModal = document.getElementById('bookingModal');
    const closeBookingModal = document.getElementById('closeBookingModal');
    const cancelBooking = document.getElementById('cancelBooking');
    const bookingForm = document.getElementById('bookingForm');
    const bookingGuideInfo = document.getElementById('bookingGuideInfo');
    const messagingModal = document.getElementById('messagingModal');
    const closeMessagingModal = document.getElementById('closeMessagingModal');
    const messageHistoryDiv = document.getElementById('messageHistory');
    const messageInput = document.getElementById('messageInput');
    const reportModal = document.getElementById('reportModal');
    const closeReportModal = document.getElementById('closeReportModal');
    const cancelReport = document.getElementById('cancelReport');
    const reportForm = document.getElementById('reportForm');
    const reportGuideInfo = document.getElementById('reportGuideInfo');

    // Initialize message history for each guide
    guidesData.forEach(guide => {
      messageHistory[guide.id] = [];
    });

    // Toggle Sidebar Function
    function toggleSidebar() {
      const isMobile = window.innerWidth <= 768;
      
      if (sidebarOpen) {
        // Close sidebar
        guideSidebar.classList.remove('active');
        if (!isMobile) {
          mapContainer.classList.remove('pushed');
          sidebarToggle.classList.remove('shifted');
        }
        
        // Change icon to hamburger
        toggleIcon.innerHTML = `<path d="M3 12H21M3 6H21M3 18H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>`;
        
        sidebarOpen = false;
        
        // Invalidate map size after transition
        setTimeout(() => {
          map.invalidateSize();
        }, 300);
        
      } else {
        // Open sidebar
        createGuideCards();
        guideSidebar.classList.add('active');
        if (!isMobile) {
          mapContainer.classList.add('pushed');
          sidebarToggle.classList.add('shifted');
        }
        
        // Change icon to close X
        toggleIcon.innerHTML = `<path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>`;
        
        sidebarOpen = true;
        
        // Invalidate map size after transition
        setTimeout(() => {
          map.invalidateSize();
        }, 300);
      }
    }

    // Filter guides function
    function filterGuides(filter) {
      currentFilter = filter;
      
      // Update filter button styles
      document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-blue-100', 'text-blue-800');
        btn.classList.add('bg-gray-100', 'text-gray-700');
      });
      
      event.target.classList.remove('bg-gray-100', 'text-gray-700');
      event.target.classList.add('active', 'bg-blue-100', 'text-blue-800');
      
      createGuideCards();
    }

    // Get status display info
    function getStatusInfo(status) {
      switch(status) {
        case 'available':
          return { class: 'available', text: 'Available Now', color: 'text-green-600' };
        case 'busy':
          return { class: 'busy', text: 'Busy', color: 'text-yellow-600' };
        case 'offline':
          return { class: 'offline', text: 'Offline', color: 'text-red-600' };
        default:
          return { class: 'offline', text: 'Unknown', color: 'text-gray-600' };
      }
    }

    // Create guide cards HTML
    function createGuideCards() {
      let filteredGuides = guidesData;
      
      if (currentFilter !== 'all') {
        filteredGuides = guidesData.filter(guide => guide.status === currentFilter);
      }
      
      // Sort by status priority (available first) and then by rating
      filteredGuides.sort((a, b) => {
        const statusPriority = { available: 0, busy: 1, offline: 2 };
        if (statusPriority[a.status] !== statusPriority[b.status]) {
          return statusPriority[a.status] - statusPriority[b.status];
        }
        return b.rating - a.rating;
      });

      guideList.innerHTML = filteredGuides.map(guide => {
        const statusInfo = getStatusInfo(guide.status);
        const isAvailable = guide.status === 'available';
        
        return `
          <div class="border rounded-lg p-3 hover:shadow-md transition-shadow bg-white ${!isAvailable ? 'opacity-75' : ''}">
            <div class="flex items-start space-x-3">
              <div class="relative">
                <img src="${guide.image}" alt="${guide.name}" class="w-12 h-12 rounded-full object-cover">
                <div class="absolute -top-1 -right-1 w-4 h-4 bg-white rounded-full flex items-center justify-center">
                  <div class="status-indicator ${statusInfo.class}"></div>
                </div>
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between">
                  <h3 class="font-semibold text-gray-800">${guide.name}</h3>
                  <span class="text-xs ${statusInfo.color} font-medium">${statusInfo.text}</span>
                </div>
                <p class="text-sm text-blue-600 font-medium">${guide.specialty}</p>
                <p class="text-xs text-gray-600 mt-1">${guide.description}</p>
                
                <div class="flex items-center mt-2 text-sm">
                  <span class="text-yellow-500">⭐ ${guide.rating}</span>
                  <span class="mx-2">•</span>
                  <span class="text-green-600 font-semibold">$${guide.price}/hour</span>
                  <span class="mx-2">•</span>
                  <span class="text-gray-500 text-xs">${guide.totalBookings} tours</span>
                </div>
                
                <p class="text-xs text-gray-500 mt-1">${guide.responseTime}</p>
                
                <div class="flex flex-wrap gap-1 mt-2">
                  ${guide.languages.map(lang => `<span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">${lang}</span>`).join('')}
                </div>
                
                <div class="flex space-x-2 mt-3">
                  <button class="flex-1 bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700 transition-colors ${!isAvailable ? 'opacity-50 cursor-not-allowed' : ''}" 
                          onclick="bookGuide(${guide.id})" ${!isAvailable ? 'disabled' : ''}>
                    ${isAvailable ? 'Book Now' : 'Unavailable'}
                  </button>
                  <button class="bg-green-500 text-white px-3 py-2 rounded text-sm hover:bg-green-600 transition-colors" 
                          onclick="openMessaging(${guide.id})">
                    Message
                  </button>
                  <button class="bg-gray-200 text-gray-700 px-2 py-2 rounded text-sm hover:bg-gray-300 transition-colors" 
                          onclick="reportGuide(${guide.id})">
                    ⚠️
                  </button>
                </div>
              </div>
            </div>
          </div>
        `;
      }).join('');
    }

    // Show guide sidebar function (for location marker click)
    function showGuideSidebar() {
      if (!sidebarOpen) {
        toggleSidebar();
      }
    }

    // Hide guide sidebar function
    function hideGuideSidebar() {
      if (sidebarOpen) {
        toggleSidebar();
      }
    }

    // Book guide function
    function bookGuide(guideId) {
      const guide = guidesData.find(g => g.id === guideId);
      if (!guide || guide.status !== 'available') return;
      
      currentGuideId = guideId;
      
      // Populate guide info in booking modal
      bookingGuideInfo.innerHTML = `
        <div class="flex items-center space-x-3">
          <img src="${guide.image}" alt="${guide.name}" class="w-12 h-12 rounded-full object-cover">
          <div>
            <h4 class="font-semibold">${guide.name}</h4>
            <p class="text-sm text-gray-600">${guide.specialty}</p>
            <p class="text-sm text-green-600 font-medium">$${guide.price}/hour</p>
          </div>
        </div>
      `;
      
      // Set minimum date to today
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('bookingDate').min = today;
      document.getElementById('bookingDate').value = today;
      
      // Update cost estimate
      updateCostEstimate();
      
      bookingModal.classList.remove('hidden');
    }

    // Update cost estimate
    function updateCostEstimate() {
      const guide = guidesData.find(g => g.id === currentGuideId);
      const duration = document.getElementById('bookingDuration').value;
      
      if (guide && duration) {
        const total = guide.price * parseInt(duration);
        document.getElementById('costEstimate').innerHTML = `
          <div class="text-sm">
            <div class="flex justify-between">
              <span>Guide fee (${duration}h × $${guide.price}/h):</span>
              <span class="font-semibold">$${total}</span>
            </div>
            <div class="text-xs text-gray-600 mt-1">
              * Final price may vary based on specific requirements
            </div>
          </div>
        `;
      } else {
        document.getElementById('costEstimate').innerHTML = '<div class="text-sm text-gray-500">Select duration to see cost estimate</div>';
      }
    }

    // Open messaging
    function openMessaging(guideId) {
      const guide = guidesData.find(g => g.id === guideId);
      currentGuideId = guideId;
      
      document.getElementById('messageGuideInfo').textContent = `${guide.name} - ${guide.specialty}`;
      
      // Load message history
      loadMessageHistory(guideId);
      
      messagingModal.classList.remove('hidden');
    }

    // Load message history
    function loadMessageHistory(guideId) {
      const messages = messageHistory[guideId];
      
      if (messages.length === 0) {
        messageHistoryDiv.innerHTML = `
          <div class="text-center text-gray-500 text-sm">
            <p>Start a conversation with your guide!</p>
            <p class="text-xs mt-1">Use the quick message buttons below or type your own message.</p>
          </div>
        `;
      } else {
        messageHistoryDiv.innerHTML = messages.map(msg => `
          <div class="message-bubble p-3 rounded-lg ${msg.sender === 'user' ? 'message-sent' : 'message-received'}">
            <p class="text-sm">${msg.text}</p>
            <p class="text-xs opacity-75 mt-1">${msg.time}</p>
          </div>
        `).join('');
      }
      
      messageHistoryDiv.scrollTop = messageHistoryDiv.scrollHeight;
    }

    // Send message
    function sendMessage() {
      const messageText = messageInput.value.trim();
      if (!messageText || !currentGuideId) return;
      
      // Add user message
      const userMessage = {
        sender: 'user',
        text: messageText,
        time: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
      };
      
      messageHistory[currentGuideId].push(userMessage);
      messageInput.value = '';
      
      // Simulate guide response after a delay
      setTimeout(() => {
        const guide = guidesData.find(g => g.id === currentGuideId);
        const responses = [
          "Thanks for your message! I'd be happy to help.",
          "That sounds great! Let me know if you have any specific preferences.",
          "I'm available for that time. Shall we proceed with booking?",
          "Perfect! I can definitely accommodate that request.",
          "Great question! I'll include that in our tour."
        ];
        
        const guideResponse = {
          sender: 'guide',
          text: responses[Math.floor(Math.random() * responses.length)],
          time: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
        };
        
        messageHistory[currentGuideId].push(guideResponse);
        loadMessageHistory(currentGuideId);
      }, 1000 + Math.random() * 2000);
      
      loadMessageHistory(currentGuideId);
    }

    // Send quick message
    function sendQuickMessage(messageText) {
      messageInput.value = messageText;
      sendMessage();
    }

    // Report guide function
    function reportGuide(guideId) {
      const guide = guidesData.find(g => g.id === guideId);
      
      reportGuideInfo.innerHTML = `
        <div class="flex items-center space-x-3">
          <img src="${guide.image}" alt="${guide.name}" class="w-10 h-10 rounded-full object-cover">
          <div>
            <h4 class="font-semibold">${guide.name}</h4>
            <p class="text-sm text-gray-600">${guide.specialty}</p>
          </div>
        </div>
      `;
      
      reportForm.dataset.guideId = guideId;
      reportModal.classList.remove('hidden');
    }

    // Event listeners
    sidebarToggle.addEventListener('click', toggleSidebar);
    closeSidebar.addEventListener('click', hideGuideSidebar);
    closeBookingModal.addEventListener('click', () => bookingModal.classList.add('hidden'));
    cancelBooking.addEventListener('click', () => bookingModal.classList.add('hidden'));
    closeMessagingModal.addEventListener('click', () => messagingModal.classList.add('hidden'));
    closeReportModal.addEventListener('click', () => reportModal.classList.add('hidden'));
    cancelReport.addEventListener('click', () => reportModal.classList.add('hidden'));

    // Form event listeners
    document.getElementById('bookingDuration').addEventListener('change', updateCostEstimate);
    
    messageInput.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') sendMessage();
    });

    // Handle booking form submission
    bookingForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const guide = guidesData.find(g => g.id === currentGuideId);
      const formData = new FormData(this);
      const date = document.getElementById('bookingDate').value;
      const time = document.getElementById('bookingTime').value;
      const duration = document.getElementById('bookingDuration').value;
      const meetingPoint = document.getElementById('meetingPoint').value;
      const contact = document.getElementById('contactNumber').value;
      const total = guide.price * parseInt(duration);
      
      alert(`🎉 Booking Request Sent Successfully!

📋 Booking Details:
👤 Guide: ${guide.name}
📅 Date: ${date}
⏰ Time: ${time}
⏱️ Duration: ${duration} hours
📍 Meeting Point: ${meetingPoint}
💰 Estimated Cost: $${total}
📞 Your Contact: ${contact}

Your booking request has been sent to ${guide.name}. 
${guide.responseTime}

You'll receive a confirmation message shortly!`);
      
      bookingModal.classList.add('hidden');
      bookingForm.reset();
      
      // Add a booking confirmation message to the chat
      const confirmationMessage = {
        sender: 'guide',
        text: `Hi! I received your booking request for ${date} at ${time}. I'll confirm the details and get back to you soon!`,
        time: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
      };
      
      messageHistory[currentGuideId].push(confirmationMessage);
    });

    // Handle report form submission
    reportForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const guideId = this.dataset.guideId;
      const reason = document.getElementById('reportReason').value;
      const description = document.getElementById('reportDescription').value;
      const guide = guidesData.find(g => g.id == guideId);
      
      alert(`📝 Report Submitted Successfully!

🎯 Guide: ${guide.name}
⚠️ Reason: ${reason}
📄 Description: ${description.substring(0, 50)}${description.length > 50 ? '...' : ''}

Thank you for helping us maintain quality service. 
Our team will review this report within 24 hours.

Reference ID: RPT-${Date.now().toString().slice(-6)}`);
      
      reportModal.classList.add('hidden');
      reportForm.reset();
    });

    // Close modals when clicking outside
    [bookingModal, messagingModal, reportModal].forEach(modal => {
      modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.add('hidden');
      });
    });

    // Handle window resize
    window.addEventListener('resize', () => {
      setTimeout(() => {
        map.invalidateSize();
      }, 100);
    });

    // Request location and setup map
    if ("geolocation" in navigator) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const lat = position.coords.latitude;
          const lng = position.coords.longitude;

          // Set map view to current location
          map.setView([lat, lng], 15);

          // Add user location marker
          const userIcon = L.divIcon({
            html: `<div style="background-color: #3B82F6; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3); cursor: pointer; animation: pulse 2s infinite;"></div>
                   <style>
                     @keyframes pulse {
                       0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
                       70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
                       100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
                     }
                   </style>`,
            iconSize: [26, 26],
            className: 'custom-user-marker'
          });

          userMarker = L.marker([lat, lng], { icon: userIcon }).addTo(map);

          // Click event to show guides sidebar
          userMarker.on('click', () => {
            showGuideSidebar();
          });

          // Tooltip
          userMarker.bindTooltip("📍 Your Location - Click to find guides nearby", {
            permanent: false,
            direction: 'top',
            offset: [0, -15]
          });
        },
        (error) => {
          console.error("Location error:", error);
          // Use default location if permission denied
          map.setView([28.6139, 77.2090], 17);
          
          // Add default marker with same functionality
          const defaultIcon = L.divIcon({
            html: `<div style="background-color: #3B82F6; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3); cursor: pointer; animation: pulse 2s infinite;"></div>
                   <style>
                     @keyframes pulse {
                       0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
                       70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
                       100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
                     }
                   </style>`,
            iconSize: [26, 26],
            className: 'custom-user-marker'
          });

          userMarker = L.marker([28.6139, 77.2090], { icon: defaultIcon }).addTo(map);
          
          // Click event to show guides sidebar
          userMarker.on('click', () => {
            showGuideSidebar();
          });
          
          userMarker.bindTooltip("📍 Default Location (Delhi) - Click to find guides nearby", {
            permanent: false,
            direction: 'top',
            offset: [0, -15]
          });
        }
      );
    } else {
      // Fallback if geolocation is not supported
      map.setView([28.6139, 77.2090], 15);
      
      const fallbackIcon = L.divIcon({
        html: `<div style="background-color: #3B82F6; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3); cursor: pointer;"></div>`,
        iconSize: [26, 26],
        className: 'custom-user-marker'
      });

      userMarker = L.marker([28.6139, 77.2090], { icon: fallbackIcon }).addTo(map);
      
      // Click event to show guides sidebar
      userMarker.on('click', () => {
        showGuideSidebar();
      });
      
      userMarker.bindTooltip("📍 Click to find guides nearby", {
        permanent: false,
        direction: 'top',
        offset: [0, -15]
      });
    }

    // Make functions globally available
    window.bookGuide = bookGuide;
    window.reportGuide = reportGuide;
    window.openMessaging = openMessaging;
    window.sendMessage = sendMessage;
    window.sendQuickMessage = sendQuickMessage;
    window.filterGuides = filterGuides;
    window.toggleSidebar = toggleSidebar;
  </script>
</body>
</html>