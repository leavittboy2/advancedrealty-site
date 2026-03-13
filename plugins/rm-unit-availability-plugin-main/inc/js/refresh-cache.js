function refreshCachedUA() {
    if (confirm('Are you sure you want to clear the cached UA?')) {
        jQuery.ajax({
            url: refreshCacheAjax.ajax_url,
            type: 'post',
            data: {
                action: 'refresh_cached_ua',
                nonce: refreshCacheAjax.nonce
            },
            success: function(response) {
                alert(response.data.message);
            },
            error: function() {
                alert('Error clearing the cache. Please try again.');
            }
        });
    }
}
