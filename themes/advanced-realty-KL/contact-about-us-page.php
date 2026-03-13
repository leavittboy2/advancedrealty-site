<?php
/* Template Name: Advanced Realty - Contact & About Us */
get_header(); 
?>

<style>
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

<!-- DEDICATED ABOUT US SECTION -->
<section id="about-us" class="py-16 bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:flex lg:items-center lg:gap-16">
            <!-- Image Placeholder for Team/Office Photo -->
            <div class="lg:w-1/2 mb-8 lg:mb-0">
                <div class="rounded-2xl overflow-hidden shadow-2xl relative h-96 bg-gray-200">
                    <img src="https://advancedrealty.com/wp-content/uploads/2023/09/Advanced-Realty-Office-e1761926141250.jpg" alt="Advanced Realty Team" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Text Content -->
            <div class="lg:w-1/2">
                <h4 class="text-adv-teal font-bold uppercase tracking-wider mb-2">Our Story</h4>
                <h2 class="text-4xl font-extrabold text-gray-900 mb-6">About Advanced Realty</h2>
                <div class="prose prose-lg text-gray-600 space-y-4">
                    <?php 
                        $about_us_content = get_field('about_us_text');
                        // Use strip_tags to ensure an empty invisible <p></p> doesn't trick the system
                        if ( !empty($about_us_content) && trim(strip_tags($about_us_content)) !== '' ) {
                            // Outputs the ACF WYSIWYG content
                            echo $about_us_content;
                        } else {
                            // Fallback text if the ACF field is completely empty
                    ?>
                        <p>
                            [Placeholder for About Us Text: Describe the history of Advanced Realty, how long you've been in business in St. George, and your core mission statement.]
                        </p>
                        <p>
                            Founded on the principles of integrity, transparency, and community service, we have grown from a small management company into a full-service brokerage handling residential, commercial, and HOA needs across Washington County.
                        </p>
                        <p>
                            <strong>Our Mission:</strong> To provide unparalleled real estate solutions that empower homeowners, investors, and communities to thrive.
                        </p>
                    <?php } ?>
                </div>
                
                <div class="mt-8 flex gap-4">
                    <div class="text-center">
                        <span class="block text-3xl font-bold text-gray-900">30+</span>
                        <span class="text-sm text-gray-500">Years Experience</span>
                    </div>
                    <div class="w-px bg-gray-300 h-12"></div>
                    <div class="text-center">
                        <span class="block text-3xl font-bold text-gray-900">500+</span>
                        <span class="text-sm text-gray-500">Properties Managed</span>
                    </div>
                    <div class="w-px bg-gray-300 h-12"></div>
                    <div class="text-center">
                        <span class="block text-3xl font-bold text-gray-900">100%</span>
                        <span class="text-sm text-gray-500">Local Focus</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Contact Grid -->
<section class="py-16 bg-f7fbfd">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Contact Info Cards -->
            <div class="space-y-6">
                <!-- Visit Us -->
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-adv-teal">
                    <div class="flex items-center mb-4">
                        <div class="bg-teal-50 p-3 rounded-full mr-4">
                            <i data-lucide="map-pin" class="w-6 h-6 text-adv-teal"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Visit Our Office</h3>
                    </div>
                    <p class="text-gray-600">
                        1156 E 700 S Ste. 1<br>
                        St. George, UT 84790
                    </p>
                    <a href="https://maps.app.goo.gl/22ZEV9jXHa3HFLQY8" target="_blank" class="text-adv-teal font-semibold text-sm mt-2 inline-block hover:underline">Get Directions &rarr;</a>
                </div>

                <!-- Call Us -->
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-adv-teal">
                    <div class="flex items-center mb-4">
                        <div class="bg-teal-50 p-3 rounded-full mr-4">
                            <i data-lucide="phone" class="w-6 h-6 text-adv-teal"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Call Us</h3>
                    </div>
                    <p class="text-gray-600 mb-1">
                        <strong class="text-gray-800">Main:</strong> 
                        <a href="tel:4356744343" class="hover:text-adv-teal transition duration-150">(435) 674-4343</a>
                    </p>
                    <p class="text-xs text-gray-400 mt-2">Mon-Fri: 9:00am - 5:00pm</p>
                </div>

                <!-- Email Us -->
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-adv-teal">
                    <div class="flex items-center mb-4">
                        <div class="bg-teal-50 p-3 rounded-full mr-4">
                            <i data-lucide="mail" class="w-6 h-6 text-adv-teal"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Email Us</h3>
                    </div>
                    <p class="text-gray-600 mb-2">General Inquiries:</p>
                    <a href="mailto:info@advancedrealty.com" class="text-lg font-bold text-adv-teal hover:underline">info@advancedrealty.com</a>
                </div>
            </div>

            <!-- Right Column: General Contact Form -->
            <div id="contact-form" class="lg:col-span-2 bg-white rounded-xl shadow-xl p-8 border border-gray-200 contact-form-wrapper">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Send us a Message</h2>
                <p class="text-gray-600 mb-8">Have a question about commercial, HOA, listings, rental, or storage? Fill out the form below and we'll get back to you shortly.</p>
                
                <?php 
                    // Outputs your Formidable form exactly as requested
                    echo do_shortcode('[formidable id="6"]'); 
                ?>
                
                <!-- Opt-Out Disclaimer Dropdown -->
                <details class="mt-4 text-xs text-gray-600 group">
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
    </div>
</section>

<!-- Embedded Google Map -->
<section class="h-96 w-full border-t border-gray-300">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d813.8062834682502!2d-113.55860000859712!3d37.09544122794794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80ca5ada5a12c32d%3A0xe1061f1e0f17a8be!2sAdvanced%20Realty!5e1!3m2!1sen!2sus!4v1772233829711!5m2!1sen!2sus" 
        class="w-full h-full" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</section>

<?php get_footer(); ?>