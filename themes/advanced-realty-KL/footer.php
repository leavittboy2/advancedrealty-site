<footer class="bg-gray-800 text-white py-12 mt-auto flex-shrink-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            
            <div class="col-span-2 md:col-span-1">
                <h4 class="text-lg font-bold mb-4 text-adv-teal">Advanced Realty</h4>
                <p class="text-sm text-gray-400">
                    Full-service property management and real estate brokerage partner in St. George, Utah.
                </p>
            </div>
            
            <div>
                <h4 class="text-lg font-bold mb-4 text-adv-teal">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo home_url('/'); ?>#service-hub" class="text-gray-400 hover:text-adv-teal transition duration-150">All Services</a></li>
                    <li><a href="https://stgeorgestorage.com" target="_blank" class="text-gray-400 hover:text-adv-teal transition duration-150">Storage Facilities</a></li>
                    <li><a href="<?php echo home_url('/contact'); ?>" class="text-gray-400 hover:text-adv-teal transition duration-150">Contact Us</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-lg font-bold mb-4 text-adv-teal">Client Portals</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="http://ownerwebaccess.rentmanager.com/OwnerLogin.aspx?CorpID=advr" target="_blank" class="text-gray-400 hover:text-adv-teal transition duration-150">Owner Portal</a></li>
                    <li><a href="https://test.advancedrealty.com/renter-resources/" target="_blank" class="text-gray-400 hover:text-adv-teal transition duration-150">Renter Portal</a></li>
                    <li><a href="http://residentwebaccess.rentmanager.com/CustomerLogin.aspx?corpid=advr" target="_blank" class="text-gray-400 hover:text-adv-teal transition duration-150">HOA Portal</a></li>
                </ul>
            </div>

            <div>
    <h4 class="text-lg font-bold mb-4 text-adv-teal">Office</h4>
    <ul class="space-y-2 text-sm">
        <li><a href="tel:4356744343" class="text-gray-400 hover:text-adv-teal transition duration-150 font-semibold">(435) 674-4343</a></li>
        <li><a href="mailto:info@advancedrealty.com" class="text-gray-400 hover:text-adv-teal transition duration-150">info@advancedrealty.com</a></li>
        <li class="mt-4">
            <a href="https://maps.app.goo.gl/xvcs4HZL6zqiY3rT8" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="text-gray-500 hover:text-adv-teal transition duration-150">
               1156 E 700 S Ste. 1, St. George, UT 84790
            </a>
        </li>
    </ul>
</div>
        </div>
        
        <div class="mt-8 pt-6 border-t border-gray-700 text-center text-xs text-gray-500">
            &copy; <?php echo date('Y'); ?> Advanced Realty. All Rights Reserved. Utah Brokerage License #5472064-CN00. | 
            <a href="<?php echo home_url('/privacy-policy'); ?>" class="hover:text-adv-teal">Privacy Policy</a> | 
            <a href="<?php echo home_url('/terms-and-conditions'); ?>" class="hover:text-adv-teal">Terms & Conditions</a>
        </div>
    </div>
</footer>

<!-- Global Initialization Scripts -->
<script>
    // Initialize Lucide Icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Logo Fallback Logic
    window.onload = function() {
        const img = document.querySelector('img[alt="Advanced Realty Logo"]');
        const fallback = document.getElementById('logo-text-fallback');

        if (img) {
            img.onerror = function() {
                img.classList.add('hidden');
                fallback.classList.remove('hidden');
            };

            if (!img.complete || img.naturalHeight === 0) {
                img.classList.add('hidden');
                fallback.classList.remove('hidden');
            } else {
                 img.classList.remove('hidden');
                 fallback.classList.add('hidden');
            }
        }
    };
</script>

<?php wp_footer(); ?>
</body>
</html>