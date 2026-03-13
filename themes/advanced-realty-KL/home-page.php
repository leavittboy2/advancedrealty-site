<?php
/* Template Name: Advanced Realty - Home */
get_header(); 
?>

<!-- PERFORMANCE FIX: Removed the CSS background tag and moved it directly into the HTML below -->

<!-- Hero Section -->
<section class="relative text-white text-center py-20 lg:py-32 flex flex-col justify-center min-h-[450px]">
    
    <!-- PERFORMANCE FIX: High Priority HTML Image. This tells the browser to download this FIRST -->
    <img src="https://advancedrealty.com/wp-content/uploads/2026/02/R6KL6998-Pano-scaled.jpg" 
         alt="St George Real Estate Hero" 
         fetchpriority="high" 
         decoding="sync"
         class="absolute inset-0 w-full h-full object-cover z-0">
    
    <!-- This is the dark overlay gradient that makes your text readable -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/30 to-black/60 z-0"></div>

    <!-- Hero Content (Wrapped in z-10 so it sits on top of the image) -->
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-5xl sm:text-6xl font-extrabold tracking-tight mb-4 drop-shadow-lg">
            Your Single Partner for St. George Real Estate.
        </h1>
        <p class="text-xl sm:text-2xl font-medium mb-8 opacity-95 drop-shadow-md">
            Full-service brokerage and expert property management covering Residential, Rentals, HOA, Commercial, and various Storage Facilities.
        </p>
        <a href="#service-hub" class="bg-adv-teal hover:bg-adv-teal-dark text-white font-bold text-lg py-3 px-10 rounded-xl shadow-2xl transition duration-300 transform hover:scale-105 inline-block border-2 border-adv-teal hover:border-white">
            Explore Our Core Services &darr;
        </a>
    </div>
</section>

<!-- Core Service Hub Section -->
<section id="service-hub" class="py-16 bg-f7fbfd">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-extrabold text-gray-900 text-center mb-4">
            Advanced Realty's Six Pillars
        </h2>
        <p class="text-xl text-gray-600 text-center mb-12 max-w-3xl mx-auto">
            Select your area of interest to get started with our dedicated, expert teams.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Pillar 1: Real Estate (Row 1, Item 1) -->
            <a href="<?php echo home_url('/real-estate'); ?>" class="service-card p-6 sm:p-8 block">
                <div class="text-6xl text-adv-teal mb-4">
                    <i data-lucide="key" class="w-12 h-12"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Buy & Sell Real Estate</h3>
                <p class="text-gray-600 mb-4 text-sm">
                    Connect with our licensed brokerage team for buying, selling, and investment consultation.
                </p>
                <p class="font-semibold text-adv-teal text-sm flex items-center">
                    Contact a Broker &rarr;
                </p>
            </a>

            <!-- Pillar 2: Available Rentals (Row 1, Item 2) -->
            <!-- Updated Temporary Link -->
            <a href="https://old.advancedrealty.com/rental-listings/" class="service-card p-6 sm:p-8 block">
                <div class="text-6xl text-adv-teal mb-4">
                    <i data-lucide="home" class="w-12 h-12"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Available Rentals</h3>
                <p class="text-gray-600 mb-4 text-sm">
                    View our current availability of houses, condos, and apartments. Apply online easily.
                </p>
                <p class="font-semibold text-adv-teal text-sm flex items-center">
                    Search available rentals &rarr;
                </p>
            </a>
            
            <!-- Pillar 3: Residential Management (Row 1, Item 3) -->
            <a href="<?php echo home_url('/residential-management'); ?>" class="service-card p-6 sm:p-8 block">
                <div class="text-6xl text-adv-teal mb-4">
                    <i data-lucide="users" class="w-12 h-12"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Residential Management</h3>
                <p class="text-gray-600 mb-4 text-sm">
                    Maximize returns on your investment property with our comprehensive management service.
                </p>
                <p class="font-semibold text-adv-teal text-sm flex items-center">
                    Get Your Management Quote &rarr;
                </p>
            </a>
            
            <!-- Pillar 4: HOA Management (Row 2, Item 1) -->
            <a href="<?php echo home_url('/hoa-management'); ?>" class="service-card p-6 sm:p-8 block">
                <div class="text-6xl text-adv-teal mb-4">
                    <i data-lucide="building-2" class="w-12 h-12"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">HOA Management</h3>
                <p class="text-gray-600 mb-4 text-sm">
                    Trusted administrative, financial, and maintenance management for community associations.
                </p>
                <p class="font-semibold text-adv-teal text-sm flex items-center">
                    Inquire About HOA Services &rarr;
                </p>
            </a>

            <!-- Pillar 5: Commercial Management (Row 2, Item 2) -->
            <a href="<?php echo home_url('/commercial-management'); ?>" class="service-card p-6 sm:p-8 block">
                <div class="text-6xl text-adv-teal mb-4">
                    <i data-lucide="briefcase" class="w-12 h-12"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Commercial Management</h3>
                <p class="text-gray-600 mb-4 text-sm">
                    Specialized leasing, accounting, and management for office, retail, and industrial properties.
                </p>
                <p class="font-semibold text-adv-teal text-sm flex items-center">
                    View Commercial Services &rarr;
                </p>
            </a>

            <!-- Pillar 6: Storage (Row 2, Item 3) -->
            <a href="https://stgeorgestorage.com" target="_blank" class="group p-6 sm:p-8 bg-adv-teal text-white border-t-8 border-adv-teal rounded-xl shadow-md hover:bg-white transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_15px_30px_rgba(0,166,153,0.3)] block cursor-pointer">
                <div class="text-white group-hover:text-[#00A699] mb-4 transition-colors duration-300">
                    <i data-lucide="archive" class="w-12 h-12"></i>
                </div>
                <h3 class="text-2xl font-bold mb-2 group-hover:text-gray-900 transition-colors duration-300">Dedicated Storage Facilities</h3>
                <p class="text-teal-100 group-hover:text-gray-600 mb-4 text-sm transition-colors duration-300">
                    Find climate-controlled, commercial-grade, or drive-up units across multiple local sites.
                </p>
                <p class="font-semibold text-white group-hover:text-[#00A699] text-sm flex items-center transition-colors duration-300">
                    Visit StGeorgeStorage.com &rarr;
                </p>
            </a>

        </div>
    </div>
</section>

<!-- CTA / Investor Focus Section -->
<section id="quote" class="py-16 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row justify-between items-center text-center lg:text-left">
        <div class="mb-8 lg:mb-0 max-w-2xl">
            <h2 class="text-4xl font-extrabold mb-2">
                Start Managing Your Assets Today
            </h2>
            <p class="text-xl text-gray-300 opacity-90">
                Get a personalized consultation on maximizing your property's performance.
            </p>
        </div>
        <a href="<?php echo home_url('/contact'); ?>" class="bg-adv-teal hover:bg-adv-teal-dark text-white font-bold text-xl py-4 px-10 rounded-xl shadow-2xl transition duration-300 transform hover:scale-105">
            Contact Management Team
        </a>
    </div>
</section>

<?php get_footer(); ?>