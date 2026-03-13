<?php
/* Template Name: Advanced Realty - Commercial Management */
get_header(); 
?>

<style>
    /* Optional: Minimal styling overrides to ensure Formidable fits well */
    .contact-form-wrapper .frm_style_formidable-style.with_frm_style .frm_submit button {
        background-color: #00A699 !important;
// ... existing code ...
    .contact-form-wrapper .frm_style_formidable-style.with_frm_style .frm_submit button:hover {
        background-color: #008f83 !important;
    }
</style>

<!-- Hero -->
<section class="relative flex items-center justify-center text-center px-4 min-h-[400px]">
    <!-- PERFORMANCE FIX: High Priority HTML Image -->
    <img src="https://advancedrealty.com/wp-content/uploads/2022/07/20220509202832632862000000-o.jpg" 
         alt="Commercial Management Hero" 
         fetchpriority="high" 
         decoding="sync"
         class="absolute inset-0 w-full h-full object-cover z-0">
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-black/80 z-0"></div>

    <div class="relative max-w-4xl z-10">
        <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 drop-shadow-lg">Commercial Real Estate Solutions</h1>
        <p class="text-xl md:text-2xl text-gray-100 mb-8 font-medium drop-shadow-md">Expert management for Retail, Office, and Industrial properties.</p>
    </div>
</section>

<!-- Content Split -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <!-- Left: Value Props -->
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Comprehensive Asset Management</h2>
            <div class="space-y-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 p-3 bg-teal-50 rounded-lg">
                        <i data-lucide="briefcase" class="w-6 h-6 text-adv-teal"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">Lease Administration</h3>
                        <p class="text-gray-600 mt-1">We handle complex lease negotiations, renewals, and escalations to maximize occupancy.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 p-3 bg-teal-50 rounded-lg">
                        <i data-lucide="pie-chart" class="w-6 h-6 text-adv-teal"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">CAM Reconciliation</h3>
                        <p class="text-gray-600 mt-1">Accurate calculation and billing of Common Area Maintenance charges to tenants.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 p-3 bg-teal-50 rounded-lg">
                        <i data-lucide="building" class="w-6 h-6 text-adv-teal"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">Facilities Management</h3>
                        <p class="text-gray-600 mt-1">Proactive maintenance of building systems, landscaping, and safety compliance.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Contact Form -->
        <div class="bg-gray-50 p-8 rounded-xl shadow-lg border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Commercial Inquiry</h3>
            <p class="text-gray-600 mb-6">Contact our commercial division for management or leasing.</p>
            
            <div class="contact-form-wrapper">
                <?php 
                    // Outputs your Formidable form. Replace "3" with your actual Commercial form ID!
                    echo do_shortcode('[formidable id="8"]'); 
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