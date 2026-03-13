</main> <!-- Closes the <main> tag from header.php -->

    <!-- Footer -->
    <footer class="bg-gray-800 mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-400 text-sm">
            <p>&copy; <?php echo date("Y"); ?> <?php echo get_hoa_var('hoa_name'); ?>. Managed Exclusively by <?php echo get_hoa_var('management_name'); ?>.</p>
            <p class="mt-2 text-gray-500">
                <a href="<?php echo get_hoa_var('tos_url'); ?>" class="hover:text-adv-teal">Terms of Service</a> | 
                <a href="<?php echo get_hoa_var('privacy_url'); ?>" class="hover:text-adv-teal">Privacy Policy</a> | 
                <a href="<?php echo get_hoa_var('owner_portal_url'); ?>" target="_blank" class="hover:text-adv-teal">Member Login</a>
            </p>
        </div>
    </footer>
    
    <!-- Custom JavaScript for image fallback -->
    <script>
        window.onload = function() {
            const img = document.querySelector('img[alt="Management Logo"]');
            const fallback = document.getElementById('logo-text-fallback-hoa');

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

    <!-- IMPORTANT: This hook lets WordPress load plugins and the admin bar -->
    <?php wp_footer(); ?>
</body>
</html>