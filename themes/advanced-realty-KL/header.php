<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class('min-h-screen antialiased flex flex-col'); ?>>

<!-- Navigation Bar -->
<header class="bg-white shadow-xl sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        
        <!-- Logo -->
        <a href="<?php echo home_url(); ?>" class="flex items-center space-x-2">
            <!-- Linked perfectly to your live media library -->
            <img src="https://advancedrealty.com/wp-content/uploads/2025/11/JPG-Advanced-Realty-Logo.jpg" 
                 onerror="this.style.display='none'; document.getElementById('logo-text-fallback').classList.remove('hidden');"
                 alt="Advanced Realty Logo" class="h-16 w-auto">
            <span id="logo-text-fallback" class="text-3xl font-extrabold text-adv-teal hidden">ADVANCED REALTY</span>
        </a>
        
        <!-- Desktop Navigation Links -->
        <nav class="hidden md:flex space-x-4 items-center h-full">
            
            <!-- Services Dropdown -->
            <div class="relative group h-full flex items-center">
                <button class="text-sm font-bold text-gray-700 hover:text-adv-teal py-2 px-4 rounded-lg flex items-center transition duration-150">
                    Services
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div class="dropdown-menu absolute left-0 top-full pt-2 w-64 opacity-0 invisible group-hover:opacity-100 group-hover:visible transform translate-y-2 group-hover:translate-y-0 transition-all duration-200 origin-top-left z-50">
                    <div class="bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden">
                        <a href="<?php echo home_url('/real-estate'); ?>" class="block px-5 py-3 text-gray-800 hover:bg-gray-50 hover:text-adv-teal transition-colors text-sm font-medium border-b border-gray-50">Real Estate (Buy/Sell)</a>
                        
                        <!-- Updated Temporary Link -->
                        <a href="https://old.advancedrealty.com/rental-listings/" class="block px-5 py-3 text-gray-800 hover:bg-gray-50 hover:text-adv-teal transition-colors text-sm font-medium border-b border-gray-50">Available Rentals</a>
                        
                        <a href="<?php echo home_url('/residential-management'); ?>" class="block px-5 py-3 text-gray-800 hover:bg-gray-50 hover:text-adv-teal transition-colors text-sm font-medium border-b border-gray-50">Residential Management</a>
                        <a href="<?php echo home_url('/hoa-management'); ?>" class="block px-5 py-3 text-gray-800 hover:bg-gray-50 hover:text-adv-teal transition-colors text-sm font-medium border-b border-gray-50">HOA Management</a>
                        <a href="<?php echo home_url('/commercial-management'); ?>" class="block px-5 py-3 text-gray-800 hover:bg-gray-50 hover:text-adv-teal transition-colors text-sm font-medium">Commercial Management</a>
                    </div>
                </div>
            </div>
            
            <!-- Storage Link -->
            <a href="https://stgeorgestorage.com" target="_blank" class="text-sm font-bold text-gray-700 hover:text-adv-teal transition duration-150 whitespace-nowrap px-2">
                Go to StGeorgeStorage.com &rarr;
            </a>
            
            <!-- Client Portals Dropdown -->
            <div class="relative group h-full flex items-center">
                <button class="bg-gray-100 text-sm font-bold text-gray-700 hover:text-adv-teal py-2 px-4 rounded-lg flex items-center transition duration-150">
                    Client Portals
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div class="dropdown-menu absolute right-0 top-full pt-2 w-48 opacity-0 invisible group-hover:opacity-100 group-hover:visible transform translate-y-2 group-hover:translate-y-0 transition-all duration-200 origin-top-right z-50">
                    <div class="bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden">
                        <a href="http://ownerwebaccess.rentmanager.com/OwnerLogin.aspx?CorpID=advr" target="_blank" class="block px-5 py-3 text-gray-800 hover:bg-gray-50 hover:text-adv-teal transition-colors text-sm font-medium border-b border-gray-50">Owner Portal</a>
                        <a href="<?php echo home_url('/Renter-resources'); ?>" class="block px-5 py-3 text-gray-800 hover:bg-gray-50 hover:text-adv-teal transition-colors text-sm font-medium border-b border-gray-50">Renter Portal</a>
                        <a href="https://advancedrealty.com/hoa-management/" class="block px-5 py-3 text-gray-800 hover:bg-gray-50 hover:text-adv-teal transition-colors text-sm font-medium">HOA Portal</a>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Mobile Menu Container -->
        <div class="md:hidden flex flex-col items-end space-y-2 w-48">
            <a href="<?php echo home_url('/contact'); ?>" class="bg-adv-teal hover:bg-adv-teal-dark text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 text-sm w-full text-center">
                Contact Us
            </a>
            
            <!-- Mobile Client Portals Dropdown (Tap to toggle) -->
            <div class="relative w-full">
                <button onclick="document.getElementById('mobile-client-portals').classList.toggle('hidden')" class="bg-gray-100 text-sm font-bold text-gray-700 hover:text-adv-teal py-2 px-4 rounded-lg flex items-center justify-between transition duration-150 w-full text-left">
                    <span>Client Portals</span>
                    <svg class="w-4 h-4 ml-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div id="mobile-client-portals" class="hidden absolute right-0 top-full mt-2 w-full bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden z-50">
                    <a href="http://ownerwebaccess.rentmanager.com/OwnerLogin.aspx?CorpID=advr" target="_blank" class="block px-4 py-3 text-gray-800 hover:bg-gray-50 hover:text-adv-teal transition-colors text-sm font-medium border-b border-gray-50">Owner Portal</a>
                    <a href="<?php echo home_url('/Renter-resources'); ?>" class="block px-4 py-3 text-gray-800 hover:bg-gray-50 hover:text-adv-teal transition-colors text-sm font-medium border-b border-gray-50">Renter Portal</a>
                    <a href="https://advancedrealty.com/hoa-management/" class="block px-4 py-3 text-gray-800 hover:bg-gray-50 hover:text-adv-teal transition-colors text-sm font-medium">HOA Portal</a>
                </div>
            </div>
        </div>
    </div>
</header>