<?php
/* Template Name: Advanced Realty - Renter Resources */
get_header(); 
?>

<!-- Hero -->
<section class="relative flex items-center justify-center text-center px-4 min-h-[350px]">
    <!-- PERFORMANCE FIX: High Priority HTML Image -->
    <img src="https://advancedrealty.com/wp-content/uploads/2023/05/B0A8079-scaled.jpg" 
         alt="Renter Resources Hero" 
         fetchpriority="high" 
         decoding="sync"
         class="absolute inset-0 w-full h-full object-cover z-0">
    <div class="absolute inset-0 bg-gradient-to-b from-black/30 to-black/50 z-0"></div>

    <div class="relative max-w-4xl z-10">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 drop-shadow-lg">Resident Resources</h1>
        <p class="text-xl text-gray-100 font-medium drop-shadow-md">Everything you need to manage your home with Advanced Realty.</p>
    </div>
</section>

<!-- Quick Actions Cards -->
<section class="py-12 -mt-16 relative z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- 1. Combined Portal Access -->
            <a href="http://residentwebaccess.rentmanager.com/CustomerLogin.aspx?corpid=advr" target="_blank" class="bg-white p-8 rounded-xl shadow-xl border-t-8 border-adv-teal hover:transform hover:-translate-y-2 transition duration-300 group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-bold text-gray-900 group-hover:text-adv-teal">Resident Portal</h3>
                        <div class="flex space-x-2">
                            <div class="bg-teal-50 p-2 rounded-full">
                                <i data-lucide="credit-card" class="w-6 h-6 text-adv-teal"></i>
                            </div>
                            <div class="bg-teal-50 p-2 rounded-full">
                                <i data-lucide="wrench" class="w-6 h-6 text-adv-teal"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Log in to your secure account to pay rent, set up auto-pay, or submit maintenance requests.
                    </p>
                </div>
                <span class="text-adv-teal font-bold text-lg flex items-center mt-2 group-hover:text-adv-teal-dark">
                    Access Portal <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
                </span>
            </a>

            <!-- 2. HOA Governing Documents -->
            <a href="https://services.commerce.utah.gov/hoa/" target="_blank" class="bg-white p-8 rounded-xl shadow-xl border-t-8 border-blue-600 hover:transform hover:-translate-y-2 transition duration-300 group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-bold text-gray-900 group-hover:text-blue-600">HOA Documents</h3>
                        <div class="bg-blue-50 p-2 rounded-full">
                            <i data-lucide="file-check" class="w-6 h-6 text-blue-600"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Live in an HOA and would like to receive the governing documents?
                    </p>
                </div>
                <span class="text-blue-600 font-bold text-lg flex items-center mt-2 group-hover:text-blue-800">
                    View Registry <i data-lucide="external-link" class="w-5 h-5 ml-2"></i>
                </span>
            </a>

            <!-- 3. Emergency Info -->
            <div class="bg-white p-8 rounded-xl shadow-xl border-t-8 border-red-500 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-bold text-gray-900">Emergency Support</h3>
                        <div class="bg-red-50 p-2 rounded-full">
                            <i data-lucide="phone-call" class="w-6 h-6 text-red-500"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-2"><strong>Life Safety:</strong> Call 911 immediately.</p>
                    <p class="text-gray-600 mb-4 text-sm">Active leaks or HVAC failure? Call our 24/7 line.</p>
                </div>
                <a href="tel:4356744343" class="text-red-600 hover:text-red-800 font-bold text-lg flex items-center mt-2">
                    Call (435) 674-4343
                </a>
            </div>

        </div>
    </div>
</section>

<!-- Main Content Split -->
<section class="py-12 bg-f7fbfd">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Left Column: Utilities & Info -->
            <div class="lg:col-span-2 space-y-10">
                
                <!-- Utility Providers -->
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i data-lucide="zap" class="w-6 h-6 mr-3 text-adv-teal"></i> Utility Provider Contacts
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        
                        <!-- City of St. George -->
                        <div class="border p-4 rounded-lg bg-gray-50">
                            <h4 class="font-bold text-gray-800">City of St. George</h4>
                            <p class="text-sm text-gray-500 mb-3">Power & Water</p>
                            <div class="space-y-2">
                                <a href="tel:4356274000" class="text-gray-700 hover:text-adv-teal text-sm font-medium flex items-center transition">
                                    <i data-lucide="phone" class="w-4 h-4 mr-2 text-adv-teal"></i> (435) 627-4000
                                </a>
                                <a href="https://sgcityutah.gov/departments/utilities.php" target="_blank" class="text-gray-700 hover:text-adv-teal text-sm font-medium flex items-center transition">
                                    <i data-lucide="external-link" class="w-4 h-4 mr-2 text-adv-teal"></i> Visit Website
                                </a>
                            </div>
                        </div>

                        <!-- Dixie Power -->
                        <div class="border p-4 rounded-lg bg-gray-50">
                            <h4 class="font-bold text-gray-800">Dixie Power</h4>
                            <p class="text-sm text-gray-500 mb-3">Electricity (County)</p>
                            <div class="space-y-2">
                                <a href="tel:4356733297" class="text-gray-700 hover:text-adv-teal text-sm font-medium flex items-center transition">
                                    <i data-lucide="phone" class="w-4 h-4 mr-2 text-adv-teal"></i> (435) 673-3297
                                </a>
                                <a href="https://www.dixiepower.com/" target="_blank" class="text-gray-700 hover:text-adv-teal text-sm font-medium flex items-center transition">
                                    <i data-lucide="external-link" class="w-4 h-4 mr-2 text-adv-teal"></i> Visit Website
                                </a>
                            </div>
                        </div>

                        <!-- Enbridge Gas -->
                        <div class="border p-4 rounded-lg bg-gray-50">
                            <h4 class="font-bold text-gray-800">Enbridge Gas</h4>
                            <p class="text-sm text-gray-500 mb-3">Natural Gas</p>
                            <div class="space-y-2">
                                <a href="tel:8003235517" class="text-gray-700 hover:text-adv-teal text-sm font-medium flex items-center transition">
                                    <i data-lucide="phone" class="w-4 h-4 mr-2 text-adv-teal"></i> (800) 323-5517
                                </a>
                                <a href="https://www.enbridgegas.com/utwyid" target="_blank" class="text-gray-700 hover:text-adv-teal text-sm font-medium flex items-center transition">
                                    <i data-lucide="external-link" class="w-4 h-4 mr-2 text-adv-teal"></i> Visit Website
                                </a>
                            </div>
                        </div>

                        <!-- WashCo Solid Waste -->
                        <div class="border p-4 rounded-lg bg-gray-50">
                            <h4 class="font-bold text-gray-800">WashCo Solid Waste</h4>
                            <p class="text-sm text-gray-500 mb-3">Trash / Recycling</p>
                            <div class="space-y-2">
                                <a href="tel:4356282821" class="text-gray-700 hover:text-adv-teal text-sm font-medium flex items-center transition">
                                    <i data-lucide="phone" class="w-4 h-4 mr-2 text-adv-teal"></i> (435) 628-2821
                                </a>
                                <a href="https://www.washcosolidwasteut.gov/" target="_blank" class="text-gray-700 hover:text-adv-teal text-sm font-medium flex items-center transition">
                                    <i data-lucide="external-link" class="w-4 h-4 mr-2 text-adv-teal"></i> Visit Website
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- FAQs -->
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i data-lucide="help-circle" class="w-6 h-6 mr-3 text-adv-teal"></i> Frequently Asked Questions
                    </h2>
                    <div class="space-y-4">
                        <details class="group p-4 border rounded-lg bg-gray-50 open:bg-white open:shadow-sm">
                            <summary class="flex justify-between items-center font-medium cursor-pointer list-none text-gray-800">
                                <span>When is rent considered late?</span>
                                <span class="transition group-open:rotate-180">
                                    <i data-lucide="chevron-down" class="w-5 h-5"></i>
                                </span>
                            </summary>
                            <p class="text-gray-600 mt-3 group-open:animate-fadeIn">
                                Rent is due on the 1st of every month. It is considered late if not received by 5:00 PM on the 5th. Late fees will apply automatically as per your lease agreement.
                            </p>
                        </details>
                        
                        <details class="group p-4 border rounded-lg bg-gray-50 open:bg-white open:shadow-sm">
                            <summary class="flex justify-between items-center font-medium cursor-pointer list-none text-gray-800">
                                <span>Can I get a pet?</span>
                                <span class="transition group-open:rotate-180">
                                    <i data-lucide="chevron-down" class="w-5 h-5"></i>
                                </span>
                            </summary>
                            <p class="text-gray-600 mt-3 group-open:animate-fadeIn">
                                Pet policies vary by property owner. You must submit a "Pet Request" in writing before bringing an animal into the home. Unauthorized pets are a lease violation and may result in fines or eviction.
                            </p>
                        </details>

                        <details class="group p-4 border rounded-lg bg-gray-50 open:bg-white open:shadow-sm">
                            <summary class="flex justify-between items-center font-medium cursor-pointer list-none text-gray-800">
                                <span>How do I give notice to move out?</span>
                                <span class="transition group-open:rotate-180">
                                    <i data-lucide="chevron-down" class="w-5 h-5"></i>
                                </span>
                            </summary>
                            <p class="text-gray-600 mt-3 group-open:animate-fadeIn">
                                A written "Notice to Vacate" is required at least 30 days prior to your move-out date. You can submit this form through your tenant portal or drop it off at our office.
                            </p>
                        </details>
                    </div>
                </div>
            </div>

            <!-- Right Column: Documents & Forms -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Important Documents</h3>
                    
                    <?php
                        // ------------------------------------------------------------------
                        // PDF URL PLACEHOLDERS
                        // Paste the link to your PDFs between the quote marks below.
                        // Example: $link_move_in = "https://advancedrealty.com/wp-content/uploads/.../MoveIn.pdf";
                        // ------------------------------------------------------------------
                        $link_move_in   = "#";
                        $link_cleaning  = "https://advancedrealty.com/wp-content/uploads/2024/02/MOVE-OUT-Check-list.pdf";
                        $link_vacate    = "#";
                        $link_lease     = "#";
                    ?>

                    <ul class="space-y-3">
                        <li>
                            <a href="<?php echo esc_url($link_move_in); ?>" target="_blank" class="flex items-center p-3 rounded-lg hover:bg-teal-50 text-gray-700 hover:text-adv-teal transition group">
                                <i data-lucide="file-text" class="w-5 h-5 mr-3 text-gray-400 group-hover:text-adv-teal"></i>
                                <span class="font-medium">Move-In Checklist PDF</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url($link_cleaning); ?>" target="_blank" class="flex items-center p-3 rounded-lg hover:bg-teal-50 text-gray-700 hover:text-adv-teal transition group">
                                <i data-lucide="file-text" class="w-5 h-5 mr-3 text-gray-400 group-hover:text-adv-teal"></i>
                                <span class="font-medium">Cleaning Checklist PDF</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url($link_vacate); ?>" target="_blank" class="flex items-center p-3 rounded-lg hover:bg-teal-50 text-gray-700 hover:text-adv-teal transition group">
                                <i data-lucide="file-text" class="w-5 h-5 mr-3 text-gray-400 group-hover:text-adv-teal"></i>
                                <span class="font-medium">Notice to Vacate Form</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url($link_lease); ?>" target="_blank" class="flex items-center p-3 rounded-lg hover:bg-teal-50 text-gray-700 hover:text-adv-teal transition group">
                                <i data-lucide="file-text" class="w-5 h-5 mr-3 text-gray-400 group-hover:text-adv-teal"></i>
                                <span class="font-medium">Sample Lease Agreement</span>
                            </a>
                        </li>
                    </ul>
                    
                    <div class="mt-8 bg-gray-100 p-4 rounded-lg">
                        <h4 class="font-bold text-gray-800 mb-2">Office Hours</h4>
                        <p class="text-sm text-gray-600">Monday - Friday</p>
                        <p class="text-sm text-gray-800 font-semibold mb-2">9:00 AM - 5:00 PM</p>
                        <p class="text-sm text-gray-600">Closed Weekends & Holidays</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>