<?php
require_once 'config/config.php';

$page_title = 'Home';
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventra - Explore Nepal Like Never Before</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        nepal: {
                            red: '#DC2626',
                            gold: '#F59E0B',
                            blue: '#1E40AF'
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans">
    <!-- Navigation -->
    <!--<nav class="bg-white shadow-lg fixed w-full z-50">-->
    <!--    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">-->
    <!--        <div class="flex justify-between h-16">-->
    <!--            <div class="flex items-center">-->
    <!--                <div class="flex-shrink-0 flex items-center">-->
    <!--                    <i class="fas fa-mountain text-nepal-red text-2xl mr-2"></i>-->
    <!--                    <span class="text-xl font-bold text-gray-800">Eventra</span>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="hidden md:flex items-center space-x-8">-->
    <!--                <a href="#home" class="text-gray-700 hover:text-nepal-red transition duration-300">Home</a>-->
    <!--                <a href="#places" class="text-gray-700 hover:text-nepal-red transition duration-300">Places</a>-->
    <!--                <a href="#events" class="text-gray-700 hover:text-nepal-red transition duration-300">Events</a>-->
    <!--                <a href="#guides" class="text-gray-700 hover:text-nepal-red transition duration-300">Guides</a>-->
    <!--                <a href="#about" class="text-gray-700 hover:text-nepal-red transition duration-300">About</a>-->
    <!--                <button class="bg-nepal-red text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300">Login</button>-->
    <!--                <button class="bg-nepal-gold text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-300">Sign Up</button>-->
    <!--            </div>-->
    <!--            <div class="md:hidden flex items-center">-->
    <!--                <button class="mobile-menu-btn text-gray-700 hover:text-nepal-red">-->
    <!--                    <i class="fas fa-bars text-xl"></i>-->
    <!--                </button>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
        <!-- Mobile Menu -->
    <!--    <div class="mobile-menu hidden md:hidden bg-white border-t">-->
    <!--        <div class="px-2 pt-2 pb-3 space-y-1">-->
    <!--            <a href="#home" class="block px-3 py-2 text-gray-700 hover:text-nepal-red">Home</a>-->
    <!--            <a href="#places" class="block px-3 py-2 text-gray-700 hover:text-nepal-red">Places</a>-->
    <!--            <a href="#events" class="block px-3 py-2 text-gray-700 hover:text-nepal-red">Events</a>-->
    <!--            <a href="#guides" class="block px-3 py-2 text-gray-700 hover:text-nepal-red">Guides</a>-->
    <!--            <a href="#about" class="block px-3 py-2 text-gray-700 hover:text-nepal-red">About</a>-->
    <!--            <div class="flex space-x-2 px-3 py-2">-->
    <!--                <button class="bg-nepal-red text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300">Login</button>-->
    <!--                <button class="bg-nepal-gold text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-300">Sign Up</button>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</nav>-->

    <!-- Hero Section -->
    <section id="home" class="relative bg-gradient-to-r from-blue-900 to-purple-900 text-white pt-16">
        <div class="absolute inset-0 bg-black opacity-40"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Discover the Magic of <span class="text-nepal-gold">Nepal</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    Explore authentic places, experience vibrant festivals, and connect with local guides in the heart of the Himalayas
                </p>
                
                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto mb-12">
                    <div class="bg-white rounded-full p-2 shadow-2xl">
                        <div class="flex items-center">
                            <input type="text" placeholder="Search places, events, or guides..." class="flex-1 px-6 py-3 text-gray-700 bg-transparent outline-none">
                            <button class="bg-nepal-red text-white px-8 py-3 rounded-full hover:bg-red-700 transition duration-300">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-3 gap-4 md:gap-8 max-w-2xl mx-auto">
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold text-nepal-gold">500+</div>
                        <div class="text-sm md:text-base">Places</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold text-nepal-gold">50+</div>
                        <div class="text-sm md:text-base">Events</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold text-nepal-gold">100+</div>
                        <div class="text-sm md:text-base">Guides</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Why Choose Eventra?</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Your gateway to authentic Nepali experiences</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-2xl transition duration-300">
                    <div class="w-16 h-16 bg-nepal-red rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Discover Places</h3>
                    <p class="text-gray-600 mb-6">Explore historical sites, temples, restaurants, and hidden gems across Kathmandu Valley with rich cultural insights.</p>
                    <button class="text-nepal-red font-semibold hover:underline">Explore Places →</button>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-2xl transition duration-300">
                    <div class="w-16 h-16 bg-nepal-gold rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-calendar-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Live Events</h3>
                    <p class="text-gray-600 mb-6">Stay updated with current festivals, cultural events, and celebrations happening across Nepal.</p>
                    <button class="text-nepal-gold font-semibold hover:underline">View Events →</button>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-2xl transition duration-300">
                    <div class="w-16 h-16 bg-nepal-blue rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-friends text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Expert Guides</h3>
                    <p class="text-gray-600 mb-6">Connect with verified local guides who speak multiple languages and know Nepal's best-kept secrets.</p>
                    <button class="text-nepal-blue font-semibold hover:underline">Find Guides →</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Places -->
    <section id="places" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Popular Destinations</h2>
                <p class="text-xl text-gray-600">Must-visit places in Kathmandu Valley</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">
                    <div><img src="assets/images/Swayambhunath.jpg" alt="Swayambhunath (Monkey Temple)"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Swayambhunath (Monkey Temple)</h3>
                        <p class="text-gray-600 mb-4">Ancient Buddhist stupa with panoramic views of Kathmandu Valley</p>
                        <div class="flex items-center justify-between">
                            <span class="text-nepal-gold font-semibold">⭐ 4.8 (2.1k reviews)</span>
                            <button class="text-nepal-red hover:underline">View Details →</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">
                    <div><img src="assets/images/patan-durbar.webp" alt="Durbar Square"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Durbar Square</h3>
                        <p class="text-gray-600 mb-4">Historic royal palace complex with stunning architecture</p>
                        <div class="flex items-center justify-between">
                            <span class="text-nepal-gold font-semibold">⭐ 4.7 (1.8k reviews)</span>
                            <button class="text-nepal-red hover:underline">View Details →</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">
                    <div><img src="assets/images/pashupatinath.jpg" alt="Pashupatinath Temple"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Pashupatinath Temple</h3>
                        <p class="text-gray-600 mb-4">Sacred Hindu temple complex on the banks of Bagmati River</p>
                        <div class="flex items-center justify-between">
                            <span class="text-nepal-gold font-semibold">⭐ 4.9 (3.2k reviews)</span>
                            <button class="text-nepal-red hover:underline">View Details →</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section id="events" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Upcoming Events & Festivals</h2>
                <p class="text-xl text-gray-600">Don't miss these amazing cultural experiences</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-start space-x-4">
                        <div class="bg-nepal-red text-white rounded-lg p-3 text-center min-w-16">
                            <div class="text-lg font-bold">15</div>
                            <div class="text-xs">SEP</div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Indra Jatra Festival</h3>
                            <p class="text-gray-600 mb-3">Traditional festival celebrating Lord Indra with masked dances and cultural performances</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>Kathmandu Durbar Square</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-start space-x-4">
                        <div class="bg-nepal-gold text-white rounded-lg p-3 text-center min-w-16">
                            <div class="text-lg font-bold">22</div>
                            <div class="text-xs">SEP</div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Teej Festival</h3>
                            <p class="text-gray-600 mb-3">Women's festival celebrating marital bliss with traditional songs and dances</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>Pashupatinath Temple</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Guide Spotlight -->
    <section id="guides" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Meet Our Expert Guides</h2>
                <p class="text-xl text-gray-600">Experienced locals ready to show you the real Nepal</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                    <div class="w-20 h-20 bg-gray-300 rounded-full mx-auto mb-4"></div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Rajesh Shrestha</h3>
                    <p class="text-gray-600 mb-3">Cultural Heritage Expert</p>
                    <div class="flex justify-center mb-3">
                        <span class="text-nepal-gold">⭐⭐⭐⭐⭐</span>
                        <span class="text-gray-500 ml-2">(4.9)</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Languages: English, Hindi, Nepali</p>
                    <button class="bg-nepal-red text-white px-6 py-2 rounded-lg hover:bg-red-700 transition duration-300">Book Now</button>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                    <div class="w-20 h-20 bg-gray-300 rounded-full mx-auto mb-4"></div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Sita Tamang</h3>
                    <p class="text-gray-600 mb-3">Adventure & Trekking Guide</p>
                    <div class="flex justify-center mb-3">
                        <span class="text-nepal-gold">⭐⭐⭐⭐⭐</span>
                        <span class="text-gray-500 ml-2">(4.8)</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Languages: English, French, Nepali</p>
                    <button class="bg-nepal-red text-white px-6 py-2 rounded-lg hover:bg-red-700 transition duration-300">Book Now</button>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                    <div class="w-20 h-20 bg-gray-300 rounded-full mx-auto mb-4"></div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Aman Gurung</h3>
                    <p class="text-gray-600 mb-3">Food & Local Experience</p>
                    <div class="flex justify-center mb-3">
                        <span class="text-nepal-gold">⭐⭐⭐⭐⭐</span>
                        <span class="text-gray-500 ml-2">(4.7)</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Languages: English, German, Nepali</p>
                    <button class="bg-nepal-red text-white px-6 py-2 rounded-lg hover:bg-red-700 transition duration-300">Book Now</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">What Travelers Say</h2>
                <p class="text-xl text-gray-600">Real experiences from our community</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-300 rounded-full mr-4"></div>
                        <div>
                            <h4 class="font-bold text-gray-800">Sarah Johnson</h4>
                            <p class="text-gray-600 text-sm">USA</p>
                        </div>
                    </div>
                    <div class="text-nepal-gold mb-3">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-600">"Eventra made my trip unforgettable! The local guide was amazing and showed me places I never would have found on my own."</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-300 rounded-full mr-4"></div>
                        <div>
                            <h4 class="font-bold text-gray-800">Marco Rodriguez</h4>
                            <p class="text-gray-600 text-sm">Spain</p>
                        </div>
                    </div>
                    <div class="text-nepal-gold mb-3">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-600">"Perfect platform for exploring Nepal. The event calendar helped me experience authentic festivals during my visit."</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-300 rounded-full mr-4"></div>
                        <div>
                            <h4 class="font-bold text-gray-800">Priya Sharma</h4>
                            <p class="text-gray-600 text-sm">India</p>
                        </div>
                    </div>
                    <div class="text-nepal-gold mb-3">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-600">"Even as a local, I discovered so many hidden gems in Kathmandu. Great platform for everyone!"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">About Eventra</h2>
                    <p class="text-lg text-gray-600 mb-6">
                        We are passionate about showcasing the incredible beauty, rich culture, and warm hospitality of Nepal to the world. Our platform connects travelers with authentic experiences, from ancient temples and vibrant festivals to expert local guides who know every hidden corner of this magnificent country.
                    </p>
                    <p class="text-lg text-gray-600 mb-6">
                        Whether you're a curious local wanting to explore your own backyard or an international traveler seeking genuine cultural immersion, Eventra is your trusted companion for unforgettable journeys through the heart of the Himalayas.
                    </p>
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-nepal-red">10,000+</div>
                            <div class="text-gray-600">Happy Travelers</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-nepal-gold">5 Years</div>
                            <div class="text-gray-600">Experience</div>
                        </div>
                    </div>
                    <button class="bg-nepal-red text-white px-8 py-3 rounded-lg hover:bg-red-700 transition duration-300">
                        Start Your Journey
                    </button>
                </div>
                <div class="lg:order-last">
                    <div class="bg-gradient-to-r from-nepal-red to-nepal-gold rounded-2xl p-8 text-white">
                        <h3 class="text-2xl font-bold mb-6">Our Mission</h3>
                        <ul class="space-y-4">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle mr-3 text-nepal-gold"></i>
                                Promote sustainable tourism in Nepal
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle mr-3 text-nepal-gold"></i>
                                Support local communities and guides
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle mr-3 text-nepal-gold"></i>
                                Preserve cultural heritage and traditions
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle mr-3 text-nepal-gold"></i>
                                Create authentic travel experiences
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Our Team Section -->
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Meet Our Team</h2>
                <p class="text-xl text-gray-600">The passionate minds behind Eventra</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-lg text-center hover:shadow-2xl transition duration-300">
                    <div class="w-24 h-24 bg-gradient-to-r from-nepal-red to-red-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">AP</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Anshu Panthi</h3>
                    <p class="text-nepal-red font-semibold mb-3">Co-Founder & CEO</p>
                    <p class="text-gray-600 text-sm mb-4">Passionate about Nepal's tourism potential and creating meaningful travel experiences</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-nepal-red transition duration-300">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-nepal-red transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg text-center hover:shadow-2xl transition duration-300">
                    <div class="w-24 h-24 bg-gradient-to-r from-nepal-gold to-yellow-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">PS</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Prajwal Sitoula</h3>
                    <p class="text-nepal-gold font-semibold mb-3">Co-Founder & CTO</p>
                    <p class="text-gray-600 text-sm mb-4">Tech enthusiast dedicated to building innovative solutions for tourism industry</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg text-center hover:shadow-2xl transition duration-300">
                    <div class="w-24 h-24 bg-gradient-to-r from-nepal-blue to-blue-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">SB</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Saransha Basu</h3>
                    <p class="text-nepal-blue font-semibold mb-3">Head of Operations</p>
                    <p class="text-gray-600 text-sm mb-4">Ensures smooth operations and exceptional user experiences for all our travelers</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-nepal-blue transition duration-300">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-nepal-blue transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg text-center hover:shadow-2xl transition duration-300">
                    <div class="w-24 h-24 bg-gradient-to-r from-green-500 to-green-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">US</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Upendra Shahi</h3>
                    <p class="text-green-600 font-semibold mb-3">Community Manager</p>
                    <p class="text-gray-600 text-sm mb-4">Builds strong relationships with guides and travelers, fostering our community</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-green-600 transition duration-300">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-green-600 transition duration-300">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-nepal-red to-nepal-gold text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Discover Nepal?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Join thousands of travelers who have discovered the magic of Nepal through our platform
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <button class="bg-white text-nepal-red px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Sign Up as Traveler
                </button>
                <button class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-nepal-red transition duration-300">
                    Register as Guide
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-mountain text-nepal-red text-2xl mr-2"></i>
                        <span class="text-xl font-bold">Eventra</span>
                    </div>
                    <p class="text-gray-400 mb-4">Your gateway to authentic Nepali experiences. Discover places, events, and connect with local guides.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-nepal-gold transition duration-300">Home</a></li>
                        <li><a href="#places" class="text-gray-400 hover:text-nepal-gold transition duration-300">Places</a></li>
                        <li><a href="#events" class="text-gray-400 hover:text-nepal-gold transition duration-300">Events</a></li>
                        <li><a href="#guides" class="text-gray-400 hover:text-nepal-gold transition duration-300">Guides</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-nepal-gold transition duration-300">About Us</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">For Travelers</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">Sign Up</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">How It Works</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">Safety Guidelines</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">Travel Tips</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">Customer Support</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">For Guides</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">Register as Guide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">Guide Requirements</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">Earning Guidelines</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">Success Stories</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">Guide Support</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-12 pt-8">
                <div class="grid md:grid-cols-2 gap-4 items-center">
                    <div class="text-center md:text-left">
                        <p class="text-gray-400">&copy; 2024 Eventra. All rights reserved.</p>
                    </div>
                    <div class="flex justify-center md:justify-end space-x-6">
                        <a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">Terms of Service</a>
                        <a href="#" class="text-gray-400 hover:text-nepal-gold transition duration-300">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const mobileMenu = document.querySelector('.mobile-menu');
            
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });

            // Smooth scrolling for navigation links
            const navLinks = document.querySelectorAll('a[href^="#"]');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetSection = document.querySelector(targetId);
                    if (targetSection) {
                        targetSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        // Close mobile menu if open
                        mobileMenu.classList.add('hidden');
                    }
                });
            });

            // Search functionality
            const searchInput = document.querySelector('input[type="text"]');
            const searchButton = document.querySelector('button i.fa-search').parentElement;
            
            searchButton.addEventListener('click', function() {
                const searchTerm = searchInput.value.trim();
                if (searchTerm) {
                    alert(`Searching for: "${searchTerm}". This feature will be implemented soon!`);
                }
            });

            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const searchTerm = this.value.trim();
                    if (searchTerm) {
                        alert(`Searching for: "${searchTerm}". This feature will be implemented soon!`);
                    }
                }
            });

            // Login/Signup button functionality
            const loginBtns = document.querySelectorAll('button:contains("Login"), button[class*="Login"]');
            const signupBtns = document.querySelectorAll('button:contains("Sign Up"), button[class*="Sign Up"]');
            
            // Get all buttons and filter by text content
            const allButtons = document.querySelectorAll('button');
            
            allButtons.forEach(button => {
                if (button.textContent.includes('Login')) {
                    button.addEventListener('click', function() {
                        alert('Login functionality will be implemented soon!');
                    });
                }
                if (button.textContent.includes('Sign Up')) {
                    button.addEventListener('click', function() {
                        alert('Sign Up functionality will be implemented soon!');
                    });
                }
                if (button.textContent.includes('Book Now')) {
                    button.addEventListener('click', function() {
                        alert('Guide booking functionality will be implemented soon!');
                    });
                }
                if (button.textContent.includes('Register as Guide')) {
                    button.addEventListener('click', function() {
                        alert('Guide registration will be implemented soon!');
                    });
                }
            });

            // Add hover effects to cards
            const cards = document.querySelectorAll('.shadow-lg');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.transition = 'all 0.3s ease';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Animate stats on scroll
            const stats = document.querySelectorAll('.text-2xl.font-bold.text-nepal-gold, .text-2xl.font-bold.text-nepal-red');
            const animateStats = () => {
                stats.forEach(stat => {
                    const rect = stat.getBoundingClientRect();
                    if (rect.top < window.innerHeight && rect.bottom > 0) {
                        stat.style.animation = 'pulse 2s ease-in-out infinite';
                    }
                });
            };

            window.addEventListener('scroll', animateStats);
            animateStats(); // Run once on load
        });
    </script>

    <style>
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .hover\:shadow-2xl:hover {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #DC2626;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #B91C1C;
        }
        
        /* Smooth transitions for all interactive elements */
        * {
            transition: all 0.3s ease;
        }
    </style>
</body>
</html>
                