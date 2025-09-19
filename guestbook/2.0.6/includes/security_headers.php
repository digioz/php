<?php

if(!defined('IN_GB')) {
   die('Direct access not permitted');
}

/**
 * Set security headers to protect against common web vulnerabilities
 */
function setSecurityHeaders() {
    // Prevent MIME type sniffing
    header('X-Content-Type-Options: nosniff');
    
    // Prevent clickjacking
    header('X-Frame-Options: DENY');
    
    // Enable XSS filtering
    header('X-XSS-Protection: 1; mode=block');
    
    // Content Security Policy - adjust based on your needs
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://www.google.com https://www.gstatic.com; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; connect-src 'self'; frame-src https://www.google.com;");
    
    // Referrer Policy
    header('Referrer-Policy: strict-origin-when-cross-origin');
    
    // Strict Transport Security (HTTPS only)
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
    
    // Feature Policy
    header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
}

// Set headers automatically when this file is included
setSecurityHeaders();

?>