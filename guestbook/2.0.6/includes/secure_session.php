<?php

if(!defined('IN_GB')) {
   die('Direct access not permitted');
}

// Secure Session Configuration
// This file should be included before any session_start() calls

// Configure secure session settings
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.entropy_length', 32);
ini_set('session.hash_function', 'sha256');

// Set session cookie parameters
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

/**
 * Start a secure session with regeneration
 */
function startSecureSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        
        // Regenerate session ID periodically for security
        if (!isset($_SESSION['last_regeneration'])) {
            $_SESSION['last_regeneration'] = time();
        } else if (time() - $_SESSION['last_regeneration'] > 300) { // 5 minutes
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        }
    }
}

/**
 * Regenerate session ID on login for security
 */
function regenerateSessionOnLogin() {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

/**
 * Destroy session securely
 */
function destroySecureSession() {
    $_SESSION = array();
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
}

?>