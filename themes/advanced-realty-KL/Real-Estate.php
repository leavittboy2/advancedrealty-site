<?php
/* Template Name: Advanced Realty - Real Estate */
get_header(); 
?>

<style>
    #admin-sync-panel { display: none; }
    body.logged-in #admin-sync-panel { display: block; }
    
    .sync-loading {
// ... existing code ...
    .agent-carousel-container {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<!-- Hero Section -->
<section class="relative flex items-center justify-center text-center px-4 min-h-[400px]">
    <!-- PERFORMANCE FIX: High Priority HTML Image -->
    <img src="http://advancedrealty.com/wp-content/uploads/sites/28/2026/02/R6KL1685-HDR-scaled.jpg" 
         alt="Real Estate Hero" 
         fetchpriority="high" 
         decoding="sync"
         class="absolute inset-0 w-full h-full object-cover z-0">
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-black/80 z-0"></div>

    <div class="relative max-w-4xl z-10">
        <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 drop-shadow-lg">
            Find Your Way Home.
        </h1>
        <p class="text-xl md:text-2xl text-gray-100 mb-8 font-medium drop-shadow-md">
            St. George's Premier Real Estate Brokerage Team
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#idx-search" class="bg-adv-teal hover:bg-adv-teal-dark text-white font-bold py-3 px-8 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                Search Listings
            </a>
            <a href="#agents" class="bg-white hover:bg-gray-100 text-gray-900 font-bold py-3 px-8 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                Meet Our Agents
            </a>
        </div>
    </div>
</section>

<!-- SECRET ADMIN PANEL -->
<div id="admin-sync-panel" class="bg-yellow-50 border-b border-yellow-200 p-6 shadow-inner">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <span class="bg-yellow-400 p-2 rounded-lg"><i data-lucide="zap" class="w-5 h-5 text-yellow-900"></i></span>
            <div>
                <p class="font-bold text-yellow-900 leading-none">Listing Power-Sync</p>
                <p class="text-xs text-yellow-700 mt-1">Enter the listing details below to manually add or update a property.</p>
            </div>
        </div>
        
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-[10px] uppercase font-bold text-yellow-700 mb-1">Address</label>
                    <input type="text" id="input-address" placeholder="123 Main St, St George, UT" class="w-full p-3 border border-yellow-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] uppercase font-bold text-yellow-700 mb-1">Price</label>
                    <input type="text" id="input-price" placeholder="$450,000" class="w-full p-3 border border-yellow-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] uppercase font-bold text-yellow-700 mb-1">Beds</label>
                    <input type="text" id="input-beds" placeholder="3" class="w-full p-3 border border-yellow-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] uppercase font-bold text-yellow-700 mb-1">Baths</label>
                    <input type="text" id="input-baths" placeholder="2" class="w-full p-3 border border-yellow-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] uppercase font-bold text-yellow-700 mb-1">Sq. Ft.</label>
                    <input type="text" id="input-sqft" placeholder="1,800" class="w-full p-3 border border-yellow-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 outline-none">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-[10px] uppercase font-bold text-yellow-700 mb-1">Image URL</label>
                    <input type="text" id="raw-image-input" placeholder="https://..." class="w-full p-3 border border-yellow-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] uppercase font-bold text-yellow-700 mb-1">Specific MLS Link</label>
                    <input type="text" id="raw-link-input" placeholder="https://my.flexmls.com/..." class="w-full p-3 border border-yellow-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 outline-none">
                </div>
                <div class="flex items-end">
                    <button id="sync-btn" onclick="processAutoListing()" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-200 flex items-center justify-center gap-2">
                        <i data-lucide="refresh-cw" class="w-4 h-4" id="sync-icon"></i>
                        <span id="sync-text">Sync Listing</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SECTION 1: AGENT CAROUSEL (DYNAMIC) -->
<section id="agents" class="py-16 bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900">Meet Our Experts</h2>
                <p class="text-gray-600 mt-2">Trusted advisors with deep roots in the Southern Utah community.</p>
            </div>
            <!-- Carousel Controls -->
            <div class="hidden sm:flex space-x-2">
                <button onclick="scrollCarousel(-1)" class="p-2 rounded-full border border-gray-300 hover:bg-adv-teal hover:text-white hover:border-adv-teal transition text-gray-500">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </button>
                <button onclick="scrollCarousel(1)" class="p-2 rounded-full border border-gray-300 hover:bg-adv-teal hover:text-white hover:border-adv-teal transition text-gray-500">
                    <i data-lucide="chevron-right" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <!-- Scrollable Container -->
        <div id="agent-container" class="agent-carousel-container flex gap-6 pb-4 px-1 overflow-x-auto snap-x snap-mandatory">
            
            <?php
            // Pull agents directly from the new Custom Post Type
            $agent_args = array(
                'post_type'      => 'agent',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order', // Changed to allow manual drag & drop / numbering
                'order'          => 'ASC' 
            );
            $agent_query = new WP_Query($agent_args);

            if ($agent_query->have_posts()) :
                while ($agent_query->have_posts()) : $agent_query->the_post();
                    
                    // Pull ACF Data using your specific field names
                    $agent_role  = get_post_meta(get_the_ID(), 'role', true);
                    $agent_phone = get_post_meta(get_the_ID(), 'phone', true);
                    $agent_email = get_post_meta(get_the_ID(), 'email', true);
                    
                    // Pull Featured Image, fallback to a placeholder with their name
                    $agent_photo = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    if (!$agent_photo) {
                        $encoded_name = urlencode(get_the_title());
                        $agent_photo = "https://placehold.co/400x500/00A699/ffffff?text=" . $encoded_name;
                    }
            ?>
                <!-- Dynamic Agent Card -->
                <div class="agent-card bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden flex-shrink-0 w-72 snap-center">
                    <div class="h-64 bg-gray-200 relative">
                        <img src="<?php echo esc_url($agent_photo); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-gray-900"><?php the_title(); ?></h3>
                        <p class="text-adv-teal font-semibold text-sm mb-4"><?php echo esc_html($agent_role ?: 'Realtor®'); ?></p>
                        <div class="flex justify-center space-x-3">
                            <a href="<?php echo $agent_phone ? 'tel:' . esc_attr($agent_phone) : '#'; ?>" class="p-2 bg-gray-100 rounded-full hover:bg-adv-teal hover:text-white transition"><i data-lucide="phone" class="w-4 h-4"></i></a>
                            <a href="<?php echo $agent_email ? 'mailto:' . esc_attr($agent_email) : '#'; ?>" class="p-2 bg-gray-100 rounded-full hover:bg-adv-teal hover:text-white transition"><i data-lucide="mail" class="w-4 h-4"></i></a>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile; 
                wp_reset_postdata(); 
            else : 
            ?>
                <div class="w-full text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500 font-medium">No agents added yet.</p>
                    <p class="text-sm text-gray-400">Go to "Agents" in your WordPress sidebar to add your team!</p>
                </div>
            <?php endif; ?>

        </div>
        <!-- Mobile "Swipe" Tip -->
        <p class="text-center text-xs text-gray-400 mt-4 sm:hidden">Swipe to see more agents</p>
    </div>
</section>

<!-- SECTION 2: DYNAMIC PROPERTY LISTINGS -->
<section id="idx-search" class="py-16 bg-gray-50 flex-grow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-gray-900">Current Listings</h2>
            <div class="w-16 h-1 bg-adv-teal mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $args = array('post_type' => 'listing', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'date', 'order' => 'DESC');
            $query = new WP_Query($args);
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    $price     = get_post_meta(get_the_ID(), 'price', true);
                    $bedrooms  = get_post_meta(get_the_ID(), 'bedrooms', true);
                    $bathrooms = get_post_meta(get_the_ID(), 'bathrooms', true);
                    $sq_ft     = get_post_meta(get_the_ID(), 'sq_ft', true);
                    $mls_link  = get_post_meta(get_the_ID(), 'mls_link', true);
                    
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    if(!$image_url) $image_url = get_post_meta(get_the_ID(), '_thumbnail_ext_url', true);
                    if(!$image_url) $image_url = 'https://placehold.co/600x400/eeeeee/999999?text=Property+Photo';
            ?>
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col group transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl border border-gray-100">
                        <div class="relative h-64 w-full overflow-hidden bg-gray-100">
                            <img src="<?php echo esc_url($image_url); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="<?php the_title(); ?>">
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-adv-teal shadow-sm">
                                Active
                            </div>
                            <div class="absolute bottom-4 left-4 bg-adv-teal text-white px-4 py-2 rounded-xl font-bold shadow-lg">
                                <?php echo esc_html($price ?: 'Contact for Price'); ?>
                            </div>
                        </div>
                        <div class="p-6 flex-grow flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 line-clamp-1"><?php the_title(); ?></h3>
                            
                            <div class="grid grid-cols-3 gap-2 mb-8 border-y border-gray-50 py-4">
                                <div class="text-center">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">Beds</p>
                                    <p class="text-gray-900 font-bold flex items-center justify-center gap-1">
                                        <i data-lucide="bed" class="w-3 h-3 text-adv-teal"></i> <?php echo $bedrooms ?: '-'; ?>
                                    </p>
                                </div>
                                <div class="text-center border-x border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">Baths</p>
                                    <p class="text-gray-900 font-bold flex items-center justify-center gap-1">
                                        <i data-lucide="bath" class="w-3 h-3 text-adv-teal"></i> <?php echo $bathrooms ?: '-'; ?>
                                    </p>
                                </div>
                                <div class="text-center">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">SqFt</p>
                                    <p class="text-gray-900 font-bold">
                                        <?php echo $sq_ft ?: '-'; ?>
                                    </p>
                                </div>
                            </div>
                            
                            <a href="<?php echo esc_url($mls_link ?: 'https://my.flexmls.com/advancedrealty'); ?>" target="_blank" class="block w-full text-center bg-gray-900 hover:bg-adv-teal text-white font-bold py-3 rounded-xl transition-colors duration-300">
                                View Full MLS Details
                            </a>
                        </div>
                    </div>
            <?php endwhile; wp_reset_postdata(); else : ?>
                <div class="col-span-full text-center py-24 bg-white rounded-3xl border border-dashed border-gray-300">
                    <i data-lucide="home" class="w-12 h-12 text-gray-300 mx-auto mb-4"></i>
                    <p class="text-gray-500 font-medium">No active listings found.</p>
                    <p class="text-xs text-gray-400 mt-1">Use the Admin Sync panel above to add your first property.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Dual Call to Action: Sales & Management -->
<section class="py-16 bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Sales CTA -->
            <div class="bg-adv-teal rounded-2xl p-10 text-center text-white shadow-xl flex flex-col justify-center items-center transform transition duration-300 hover:-translate-y-2">
                <div class="bg-white/20 p-4 rounded-full mb-6">
                    <i data-lucide="home" class="w-8 h-8 text-white"></i>
                </div>
                <h2 class="text-3xl font-extrabold mb-4">Ready to Sell?</h2>
                <p class="text-lg text-teal-50 mb-8 max-w-sm">
                    Our strategic marketing plans and local expertise ensure you get the best value for your property.
                </p>
                <a href="#agents" class="bg-white text-adv-teal hover:bg-gray-100 font-bold py-3 px-8 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                    Contact an Agent
                </a>
            </div>

            <!-- Property Management CTA -->
            <div class="bg-gray-800 rounded-2xl p-10 text-center text-white shadow-xl flex flex-col justify-center items-center transform transition duration-300 hover:-translate-y-2">
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
    </div>
</section>

<script>
    function scrollCarousel(direction) {
        const container = document.getElementById('agent-container');
        const scrollAmount = 300; 
        container.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    }

    function processAutoListing() {
        const address = document.getElementById('input-address').value;
        const price = document.getElementById('input-price').value;
        const beds = document.getElementById('input-beds').value;
        const baths = document.getElementById('input-baths').value;
        const sqft = document.getElementById('input-sqft').value;
        
        const image = document.getElementById('raw-image-input').value;
        const specificLink = document.getElementById('raw-link-input').value; 
        
        const btn = document.getElementById('sync-btn');
        const text = document.getElementById('sync-text');
        const icon = document.getElementById('sync-icon');

        if (!address) {
            alert("Please enter at least the property address.");
            return;
        }

        // Visual feedback
        btn.classList.add('sync-loading');
        text.innerText = "Processing...";
        icon.classList.add('animate-spin');

        // Determine which link to use
        let finalLink = specificLink;
        if (!finalLink || finalLink.trim() === '') {
            finalLink = 'https://my.flexmls.com/advancedrealty'; // The fallback
        }

        const formData = new FormData();
        formData.append('action', 'create_listing_auto');
        formData.append('address', address);
        formData.append('price', price);
        formData.append('beds', beds);
        formData.append('baths', baths);
        formData.append('sqft', sqft);
        formData.append('image', image);
        formData.append('link', finalLink);

        // Send to WordPress AJAX handler
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); 
        })
        .catch(error => {
            alert("Sync Error. Please check your functions.php file.");
            btn.classList.remove('sync-loading');
            text.innerText = "Sync Listing";
            icon.classList.remove('animate-spin');
        });
    }
</script>

<?php get_footer(); ?>