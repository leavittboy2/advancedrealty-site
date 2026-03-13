<?php
/* Template Name: Advanced Realty - Residential Management */
get_header(); 
?>

<style>
    .hero-section-residential {
        background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.5)), 
                          url('https://advancedrealty.com/wp-content/uploads/2023/03/20230308220640065433000000-o-e1772320056680.jpg');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        height: 400px;
    }
    
    /* Optional: Minimal styling overrides to ensure Formidable fits well */
    .contact-form-wrapper .frm_style_formidable-style.with_frm_style .frm_submit button {
        background-color: #00A699 !important;
        border-color: #00A699 !important;
        width: 100%;
        border-radius: 0.5rem;
    }
    .contact-form-wrapper .frm_style_formidable-style.with_frm_style .frm_submit button:hover {
        background-color: #008f83 !important;
    }
</style>

<!-- Hero -->
<section class="hero-section-residential flex items-center justify-center text-center px-4">
    <div class="max-w-4xl z-10">
        <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 drop-shadow-lg">Maximize Your Rental Income</h1>
        <p class="text-xl md:text-2xl text-gray-100 mb-8 font-medium drop-shadow-md">Stress-free property management for St. George homeowners.</p>
    </div>
</section>

<!-- Content Split -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <!-- Left: Value Props -->
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Why Choose Advanced Realty?</h2>
            <div class="space-y-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 p-3 bg-teal-50 rounded-lg">
                        <i data-lucide="users" class="w-6 h-6 text-adv-teal"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">Rigorous Tenant Screening</h3>
                        <p class="text-gray-600 mt-1">We perform criminal, credit, and eviction checks to ensure high-quality residents.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 p-3 bg-teal-50 rounded-lg">
                        <i data-lucide="wrench" class="w-6 h-6 text-adv-teal"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">24/7 Maintenance Coordination</h3>
                        <p class="text-gray-600 mt-1">We handle late-night emergencies and coordinate repairs with trusted local vendors.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 p-3 bg-teal-50 rounded-lg">
                        <i data-lucide="bar-chart-3" class="w-6 h-6 text-adv-teal"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">Transparent Accounting</h3>
                        <p class="text-gray-600 mt-1">Access detailed financial reports and documents anytime via our Owner Portal.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Contact Form Placeholder -->
        <div class="bg-gray-50 p-8 rounded-xl shadow-lg border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Request a Management Proposal</h3>
            <p class="text-gray-600 mb-6">Fill out the form below to receive a free rental analysis.</p>
            
            <div class="contact-form-wrapper">
                <?php 
                    // Outputs your Formidable form. Replace "4" with your actual Residential form ID!
                    echo do_shortcode('[formidable id="9"]'); 
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
            </details>
        </div>
    </div>
</section>

<?php get_footer(); ?>