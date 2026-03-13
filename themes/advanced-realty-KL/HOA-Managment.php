<?php
/* Template Name: Advanced Realty - HOA Management */

// Handle form submission purely in PHP to completely bypass strict WAF firewalls
if ( isset( $_GET['hoa_url'] ) && ! empty( $_GET['hoa_url'] ) ) {
    // Sanitize and perform a safe redirect
    $redirect_url = esc_url_raw( $_GET['hoa_url'] );
    wp_redirect( $redirect_url );
    exit;
}

get_header(); 
?>

<style>
    /* Optional: Minimal styling overrides to ensure Formidable fits well */
    .contact-form-wrapper .frm_style_formidable-style.with_frm_style .frm_submit button {
        background-color: #00A699 !important;
    }
    .contact-form-wrapper .frm_style_formidable-style.with_frm_style .frm_submit button:hover {
        background-color: #008f83 !important;
    }
</style>

<!-- Hero -->
<section class="relative flex items-center justify-center text-center px-4 min-h-[400px]">
    <!-- PERFORMANCE FIX: High Priority HTML Image -->
    <img src="https://advancedrealty.com/wp-content/uploads/2026/02/HOAbg.jpg" 
         alt="HOA Management Hero" 
         fetchpriority="high" 
         decoding="sync"
         class="absolute inset-0 w-full h-full object-cover z-0">
    <div class="absolute inset-0 bg-gradient-to-b from-black/30 to-black/50 z-0"></div>

    <div class="relative max-w-4xl z-10">
        <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 drop-shadow-lg">Building Better Communities</h1>
        <p class="text-xl md:text-2xl text-gray-100 mb-8 font-medium drop-shadow-md">Professional governance, financial management, and maintenance for Utah HOAs.</p>
    </div>
</section>

<!-- Find Your Community Section -->
<!-- Increased bottom padding (pb-32) to give the browser room to drop the menu DOWN instead of UP -->
<section class="pt-12 pb-32 bg-white border-b border-gray-200">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Already a Resident? Find Your Community Website</h2>
        <p class="text-gray-600 mb-8">Select your association below to access your dedicated community portal, governing documents, and latest news.</p>
        
        <!-- Native HTML Form to bypass WAF JavaScript blocks -->
        <form method="GET" action="" target="_blank" class="flex flex-col sm:flex-row justify-center items-center gap-4 max-w-lg mx-auto w-full">
            <!-- Custom Select Dropdown -->
            <div class="relative w-full">
                <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i data-lucide="home" class="w-5 h-5"></i>
                </div>
                
                <!-- Added "required" so the browser handles validation natively -->
                <select name="hoa_url" required class="block w-full pl-10 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-adv-teal focus:border-adv-teal sm:text-sm rounded-lg shadow-sm appearance-none bg-gray-50 border text-gray-700 font-medium">
                    <option value="" disabled selected>Select your Community...</option>
                    
                    <?php
                    // Dynamic Dropdown using WP Menu Location 'hoa_menu'
                    $locations = get_nav_menu_locations();
                    if ( isset( $locations['hoa_menu'] ) && $locations['hoa_menu'] != 0 ) {
                        $menu_items = wp_get_nav_menu_items( $locations['hoa_menu'] );
                        if ( $menu_items ) {
                            foreach ( $menu_items as $item ) {
                                echo '<option value="' . esc_url($item->url) . '">' . esc_html($item->title) . '</option>';
                            }
                        } else {
                            echo '<option value="" disabled>No communities in menu.</option>';
                        }
                    } else {
                        echo '<option value="" disabled>Setup: Assign a menu to "HOA Communities Dropdown" in Appearance > Menus.</option>';
                    }
                    ?>
                    
                </select>
                <!-- Custom Arrow Icon -->
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            
            <button type="submit" class="w-full sm:w-auto bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-150 whitespace-nowrap flex items-center justify-center">
                Go to Page <i data-lucide="external-link" class="w-4 h-4 ml-2"></i>
            </button>
        </form>
    </div>
</section>

<!-- Lender & Title Requests Banner -->
<section class="bg-gray-900 border-y border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row items-center justify-between">
        <div class="mb-6 md:mb-0 flex items-center text-left w-full md:w-auto">
            <div class="bg-gray-800 p-4 rounded-full mr-5 border border-gray-700 hidden sm:block">
                <i data-lucide="file-check-2" class="w-8 h-8 text-adv-teal"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white mb-1">Lender & Mortgage Questionnaires</h2>
                <p class="text-gray-400">Need HOA forms or certifications filled out for a loan approval?</p>
            </div>
        </div>
        <a href="https://advr.twa.rentmanager.com/ApplyNow?propertyID=837&locations=1" target="_blank" class="w-full md:w-auto bg-adv-teal hover:bg-adv-teal-dark text-white font-bold py-3 px-8 rounded-xl shadow-lg transition duration-300 transform hover:scale-105 whitespace-nowrap flex items-center justify-center">
            Document Request <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
        </a>
    </div>
</section>

<!-- Content Split -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <!-- Left: Value Props & CTA -->
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Support for Your Board</h2>
            <div class="space-y-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 p-3 bg-white rounded-lg shadow-sm border border-gray-100">
                        <i data-lucide="scale" class="w-6 h-6 text-adv-teal"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">CCR Enforcement</h3>
                        <p class="text-gray-600 mt-1">Consistent and fair enforcement of community rules and regulations to protect property values.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 p-3 bg-white rounded-lg shadow-sm border border-gray-100">
                        <i data-lucide="calculator" class="w-6 h-6 text-adv-teal"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">Financial Management</h3>
                        <p class="text-gray-600 mt-1">Dues collection, budget preparation, reserve planning, and transparent bookkeeping.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 p-3 bg-white rounded-lg shadow-sm border border-gray-100">
                        <i data-lucide="calendar" class="w-6 h-6 text-adv-teal"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">Meeting Facilitation</h3>
                        <p class="text-gray-600 mt-1">We organize Annual Meetings, Board Meetings, and handle all association correspondence.</p>
                    </div>
                </div>
            </div>

            <!-- Added Property Management Advertisement CTA -->
            <div class="mt-12 bg-gray-800 rounded-2xl p-8 sm:p-10 text-center text-white shadow-xl flex flex-col justify-center items-center transform transition duration-300 hover:-translate-y-2">
                <div class="bg-gray-700 p-4 rounded-full mb-6">
                    <i data-lucide="key" class="w-8 h-8 text-adv-teal"></i>
                </div>
                <h2 class="text-3xl font-extrabold mb-4">Property Management</h2>
                <p class="text-lg text-gray-300 mb-8 max-w-sm">
                    Stop worrying about tenants and maintenance. We protect your investment and maximize returns.
                </p>
                <a href="https://advancedrealty.com/residential-management/" class="bg-adv-teal hover:bg-adv-teal-dark text-white font-bold py-3 px-8 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                    Get Management Quote
                </a>
            </div>
        </div>

        <!-- Right: Contact Form -->
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Request an HOA Proposal</h3>
            <p class="text-gray-600 mb-6">Are you a Board Member? Let's discuss your community's needs.</p>
            
            <div class="contact-form-wrapper">
                <?php 
                    // Outputs your Formidable form exactly as requested
                    echo do_shortcode('[formidable id="7"]'); 
                ?>
            </div>
            <!-- Opt-Out Disclaimer Dropdown -->
            <details class="mt-6 text-xs text-gray-600 group">
                <summary class="cursor-pointer font-medium text-gray-700 hover:text-gray-900 transition-colors list-none flex items-center">
                    <span class="mr-2 transition-transform group-open:rotate-90">▶</span>
                    Opt-Out disclaimer
                </summary>
                <div class="mt-3 p-4 bg-white border border-gray-200 rounded-lg shadow-sm leading-relaxed">
                    By providing your phone number, you agree to receive text messages from Advanced Realty for the purpose of communicating community news, urgent notifications, and events. Reply “STOP” to opt-out anytime or reply “HELP” for more information. Message and data rates may apply. Message frequency will vary. For more information, please read our <a href="https://advancedrealty.com/privacy-policy" class="text-teal-600 underline hover:text-teal-800" target="_blank" rel="noopener noreferrer">Privacy Policy</a> and <a href="https://advancedrealty.com/terms-and-conditions" class="text-teal-600 underline hover:text-teal-800" target="_blank" rel="noopener noreferrer">Terms and Conditions</a>.
                </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>