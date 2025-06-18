<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SmartLight - Solusi Pencahayaan Pintar untuk Rumah Anda">

    <title>SmartLight - Smart Lighting Solution</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700|instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💡</text></svg>">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
            /* Minified CSS content here (same as original) */
        </style>
    @endif
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-900 dark:to-blue-950 text-gray-800 dark:text-white min-h-screen">
    <!-- Header Section -->
    <header class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-blue-600 dark:text-blue-400">SmartLight</span>
            </div>
            
            @if (Route::has('login'))
            <nav class="flex items-center space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium text-sm">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
            @endif
        </div>
    </header>

    <!-- Hero Section -->
    <section class="py-16 md:py-24">
        <div class="container max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <!-- Hero Text -->
                <div class="lg:w-1/2 space-y-6">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white leading-tight">
                        <span class="text-blue-600 dark:text-blue-400">Smart</span> Lighting Solution for Your Modern Home
                    </h1>
                    
                    <p class="text-lg text-gray-600 dark:text-gray-300">
                        Automate your home lighting with SmartLight - the intelligent lighting system that responds to natural light levels, saves energy, and can be controlled from anywhere.
                    </p>
                    
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-all shadow-lg hover:shadow-xl flex items-center space-x-2">
                            <span>Get Started</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        
                        <a href="#how-it-works" class="border border-blue-600 text-blue-600 hover:bg-blue-50 dark:border-blue-400 dark:text-blue-400 dark:hover:bg-blue-900/30 font-medium py-3 px-6 rounded-lg transition-all">
                            Learn More
                        </a>
                    </div>
                </div>
                
                <!-- Hero Image -->
                <div class="lg:w-1/2 mt-8 lg:mt-0">
                    <div class="relative">
                        <div class="absolute inset-0 bg-blue-600/20 dark:bg-blue-400/10 rounded-3xl blur-2xl transform rotate-6"></div>
                        <img src="https://images.unsplash.com/photo-1558002038-1055907df827?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3" 
                             alt="Smart home lighting system" 
                             class="relative z-10 w-full rounded-2xl shadow-2xl border border-white/20 dark:border-blue-500/10"
                             width="800" height="600" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section id="features" class="py-16 bg-white dark:bg-gray-800">
        <div class="container max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Smart Features</h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Our smart lighting system comes with advanced features to make your home more comfortable and energy-efficient.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1: Real-time Monitoring -->
                <div class="bg-blue-50 dark:bg-gray-700 p-8 rounded-xl border border-blue-100 dark:border-blue-900 transition-all hover:shadow-lg">
                    <div class="bg-blue-100 dark:bg-blue-900 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Real-time Monitoring</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Monitor light status, ambient light levels, and operation mode in real-time through our intuitive dashboard.
                    </p>
                </div>
                
                <!-- Feature 2: Manual Control -->
                <div class="bg-blue-50 dark:bg-gray-700 p-8 rounded-xl border border-blue-100 dark:border-blue-900 transition-all hover:shadow-lg">
                    <div class="bg-blue-100 dark:bg-blue-900 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Manual Control</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Take control of your lighting with manual override options when you need specific lighting regardless of ambient conditions.
                    </p>
                </div>
                
                <!-- Feature 3: Scheduling -->
                <div class="bg-blue-50 dark:bg-gray-700 p-8 rounded-xl border border-blue-100 dark:border-blue-900 transition-all hover:shadow-lg">
                    <div class="bg-blue-100 dark:bg-blue-900 rounded-full w-14 h-14 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Smart Scheduling</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Create custom schedules for your lights based on time of day, day of week, or special events.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- How it Works Section -->
    <section id="how-it-works" class="py-16 bg-gradient-to-b from-blue-50 to-white dark:from-gray-900 dark:to-gray-800">
        <div class="container max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">How It Works</h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    SmartLight uses advanced sensors and IoT technology to create the perfect lighting environment.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="order-2 md:order-1">
                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 rounded-full w-10 h-10 flex items-center justify-center mr-4 text-blue-600 dark:text-blue-400 font-bold">
                                1
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Light Detection</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    The LDR sensor continuously monitors ambient light levels in your space.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 rounded-full w-10 h-10 flex items-center justify-center mr-4 text-blue-600 dark:text-blue-400 font-bold">
                                2
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Smart Processing</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    The ESP32 microcontroller processes the data and makes lighting decisions based on your settings.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 rounded-full w-10 h-10 flex items-center justify-center mr-4 text-blue-600 dark:text-blue-400 font-bold">
                                3
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Automated Control</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Lights automatically turn on when it gets dark and off when there's sufficient ambient light.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 rounded-full w-10 h-10 flex items-center justify-center mr-4 text-blue-600 dark:text-blue-400 font-bold">
                                4
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Dashboard Monitoring</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Monitor and control everything through our intuitive web dashboard from anywhere.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="order-1 md:order-2">
                    <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=1000&auto=format&fit=crop" 
                         alt="SmartLight system diagram" 
                         class="rounded-xl shadow-xl border border-blue-100 dark:border-blue-900"
                         width="800" height="600" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-16 bg-blue-600 dark:bg-blue-800 text-white">
        <div class="container max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">90%</div>
                    <p class="text-blue-100">Energy Savings</p>
                </div>
                
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">24/7</div>
                    <p class="text-blue-100">Real-time Monitoring</p>
                </div>
                
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">5 min</div>
                    <p class="text-blue-100">Setup Time</p>
                </div>
                
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">100%</div>
                    <p class="text-blue-100">Customer Satisfaction</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="container max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-blue-50 dark:bg-gray-700 rounded-2xl p-8 md:p-12 shadow-xl border border-blue-100 dark:border-blue-900">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Ready to Upgrade Your Home?</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                        Join thousands of smart homeowners who are saving energy and enjoying the comfort of automated lighting.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg transition-all shadow-lg hover:shadow-xl">
                            Get Started Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <span class="font-bold text-lg">SmartLight</span>
                    </div>
                    <p class="text-gray-400 mb-4">Bringing intelligence to your lighting solutions.</p>
                </div>
                
                <div>
                    <h3 class="font-bold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-blue-400 transition-colors">Features</a></li>
                        <li><a href="#how-it-works" class="hover:text-blue-400 transition-colors">How It Works</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-bold text-lg mb-4">Support</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Contact Us</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-bold text-lg mb-4">Legal</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} SmartLight. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>