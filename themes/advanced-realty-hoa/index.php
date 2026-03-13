<?php get_header(); ?>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            <?php if(get_hoa_var('announcement_text') !== ''): ?>
            <!-- Dynamic Announcement Banner -->
            <div class="bg-hoa-amber text-white p-4 rounded-xl shadow-lg mb-8 text-center text-base font-semibold">
                ANNOUNCEMENT: <?php echo get_hoa_var('announcement_text'); ?>
            </div>
            <?php endif; ?>
            
            <!-- Hero Section -->
            <section class="bg-white rounded-xl shadow-2xl mb-12 border-t-8 border-adv-teal overflow-hidden flex flex-col md:flex-row">
                
                <!-- Text Content (Left Side) -->
                <div class="p-8 md:p-12 md:w-3/5 flex flex-col justify-center">
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Welcome, <?php echo get_hoa_var('hoa_name'); ?> Homeowners</h2>
                    <p class="text-lg text-gray-600 mb-8 max-w-2xl">
                        Your hub for community documents, payment options, meeting schedules, and direct management contact.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="<?php echo esc_url(get_hoa_var('owner_portal_url')); ?>" target="_blank" class="inline-block w-full sm:w-auto text-center px-8 py-4 bg-adv-teal text-white font-bold text-lg rounded-xl shadow-xl hover:bg-hoa-blue-dark transition duration-300 transform hover:scale-[1.01]">
                            Owner Portal / Payments &rarr;
                        </a>
                    </div>
                </div>

                <!-- Dynamic Image loaded from WordPress Customizer -->
                <div class="md:w-2/5 bg-gray-200 min-h-[250px] md:min-h-full">
                    <img src="<?php echo esc_url(get_hoa_var('hero_image_url')); ?>" 
                         alt="HOA Community" 
                         class="w-full h-full object-cover">
                </div>
            </section>
            
            <!-- Meeting Date Banner -->
            <div class="bg-blue-50 text-blue-700 p-4 rounded-xl shadow-md mb-10 text-center text-base font-medium border border-blue-200">
                Most Recent Annual Meeting: <span class="font-bold text-gray-800"><?php echo esc_html(get_hoa_var('annual_meeting_date')); ?></span>
            </div>

            <!-- Documents Section -->
            <section id="documents" class="mb-12">
                <h3 class="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-2">Community Resources</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-hoa-amber hover:shadow-xl transition duration-300">
                        <h4 class="text-xl font-bold text-gray-900 mb-2">Architectural Change (ACC)</h4>
                        <p class="text-gray-600 mb-4 text-sm">Download the required form for all exterior home improvements, landscaping, and changes.</p>
                        <!-- Dynamic ACC Form Link -->
                        <a href="<?php echo esc_url(get_hoa_var('acc_form_url')); ?>" target="_blank" class="text-adv-teal font-semibold hover:underline text-base flex items-center">
                            Download ACC Request Form &rarr;
                        </a>
                    </div>
                    
                    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-hoa-amber hover:shadow-xl transition duration-300">
                        <h4 class="text-xl font-bold text-gray-900 mb-2">Governing Documents</h4>
                        <p class="text-gray-600 mb-4 text-sm">Access the CC&Rs, By-Laws, community rules, and other official documents.</p>
                        <a href="<?php echo esc_url(get_hoa_var('documents_url')); ?>" target="_blank" class="text-adv-teal font-semibold hover:underline text-base flex items-center">View All Documents &rarr;</a>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-hoa-amber hover:shadow-xl transition duration-300">
                        <h4 class="text-xl font-bold text-gray-900 mb-2">Utah HOA Registry Search</h4>
                        <p class="text-gray-600 mb-4 text-sm">Find official registration and contact information for the association through the state database.</p>
                        <a href="https://services.commerce.utah.gov/hoa/" target="_blank" class="text-adv-teal font-semibold hover:underline text-base flex items-center">Search Utah Registry &rarr;</a>
                    </div>
                </div>
            </section>

            <!-- Upsell Section (Now with 3 Services) -->
            <section class="mt-14 mb-14 bg-[#005a87] p-8 md:p-10 rounded-2xl shadow-2xl border-l-8 border-adv-teal transition-all duration-300 hover:shadow-lg">
                <h3 class="text-2xl font-extrabold text-white mb-4"><?php echo get_hoa_var('management_name'); ?> Additional Services</h3>
                <p class="text-blue-100 mb-6 max-w-2xl">
                    As your community manager, <?php echo esc_html(get_hoa_var('management_name')); ?> offers additional trusted services, including full-service rental property management, real estate services, and secure local storage units.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Property Management Quote -->
                    <a href="<?php echo esc_url(get_hoa_var('rental_quote_url')); ?>" target="_blank" 
                       class="flex flex-col justify-center text-center px-4 py-3 bg-adv-teal text-white font-bold rounded-xl hover:bg-adv-teal-dark transition duration-300 text-base shadow-md">
                        Get a Property Management Quote
                    </a>
                    
                    <!-- Real Estate Services -->
                    <a href="https://advancedrealty.com" target="_blank" 
                       class="flex flex-col justify-center text-center px-4 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition duration-300 text-base shadow-md">
                        Real Estate Services
                    </a>

                    <!-- Local Storage Units -->
                    <a href="<?php echo esc_url(get_hoa_var('storage_url')); ?>" target="_blank" 
                       class="flex flex-col justify-center text-center px-4 py-3 border-2 border-white text-white font-bold rounded-xl hover:bg-white hover:text-[#005a87] transition duration-300 text-base shadow-md">
                        Find Local Storage Units
                    </a>
                </div>
            </section>
            
            <!-- Contact Section -->
            <section id="contact" class="mt-12 bg-white p-8 rounded-xl shadow-lg">
                 <h3 class="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-2">HOA Management Contact</h3>
                 <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-base">
                    <div>
                        <p class="font-semibold text-gray-700">Phone:</p>
                        <p class="text-gray-600 font-bold">
                            <?php $phone = get_hoa_var('contact_phone'); ?>
                            <a href="tel:<?php echo preg_replace('/[^0-9]/', '', (string)$phone); ?>" class="hover:text-adv-teal transition duration-200">
                                <?php echo esc_html($phone); ?>
                            </a>
                        </p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700">Email:</p>
                        <p class="text-gray-600 break-words font-bold">
                            <?php $email = get_hoa_var('contact_email'); ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="hover:text-adv-teal transition duration-200">
                                <?php echo esc_html($email); ?>
                            </a>
                        </p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700">Office:</p>
                        <p class="text-gray-600 font-medium">
                            <a href="https://maps.app.goo.gl/a5ziFRdUFV7eYis97" target="_blank" rel="noopener noreferrer" class="hover:text-adv-teal transition duration-200">
                                <?php echo esc_html(get_hoa_var('contact_address')); ?>
                            </a>
                        </p>
                    </div>
                 </div>
            </section>
        </div>

<?php get_footer(); ?>