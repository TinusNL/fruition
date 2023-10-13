<?php
// Destroy the session
session_destroy();

// Clear localStorage
echo '<script>localStorage.clear();</script>';

// Redirect to the homepage
echo '<script type="text/javascript">
    window.location = "/' . URL_PREFIX . '/"
</script>';