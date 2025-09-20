<?php

if(!defined('IN_GB')) {
   die('Direct access not permitted');
}

// Secure Session Configuration
// This file should be included before any session_start() calls

// Helper to detect HTTPS behind proxies/load balancers as well
function gb_is_https(): bool {
    if (!empty($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off') {
        return true;
    }
    if (!empty($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443) {
        return true;
    }
    // Common proxy headers (only trust if set by your infra)
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower((string)$_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
        return true;
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower((string)$_SERVER['HTTP_X_FORWARDED_SSL']) === 'on') {
        return true;
    }
    return false;
}

// Ensure a writable session save path exists if the system default is missing or not writable
$savePath = ini_get('session.save_path');
$needsOverride = true;
if (!empty($savePath)) {
    // session.save_path can be semicolon-delimited in some SAPIs; take last path portion
    $parts = explode(';', $savePath);
    $pathCandidate = trim(end($parts));
    if ($pathCandidate !== '' && @is_dir($pathCandidate) && @is_writable($pathCandidate)) {
        $needsOverride = false;
    }
}

if ($needsOverride) {
    $localSessionDir = __DIR__ . '/../data/sessions';
    if (!is_dir($localSessionDir)) {
        @mkdir($localSessionDir, 0755, true);
    }
    if (is_dir($localSessionDir) && is_writable($localSessionDir)) {
        // Prefer the dedicated API to set save path
        @session_save_path($localSessionDir);
        @ini_set('session.save_path', $localSessionDir);
    }
}

// Configure secure session settings (adjust cookie_secure dynamically based on HTTPS)
$secureCookie = gb_is_https();
ini_set('session.cookie_httponly', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.cookie_secure', $secureCookie ? '1' : '0');
ini_set('session.cookie_samesite', 'Strict');

// Deprecated in newer PHP, but harmless if ignored; keep for older environments
@ini_set('session.entropy_length', '32');
@ini_set('session.hash_function', 'sha256');

// Set session cookie parameters
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $secureCookie,
    'httponly' => true,
    'samesite' => 'Strict'
]);

/**
 * Start a secure session with regeneration
 */
function startSecureSession() {
    if (session_status() == PHP_SESSION_NONE) {
        // Ensure we don't try to start with an unwritable path
        $path = ini_get('session.save_path');
        if (!empty($path)) {
            $parts = explode(';', $path);
            $pathCandidate = trim(end($parts));
            if ($pathCandidate === '' || !@is_dir($pathCandidate) || !@is_writable($pathCandidate)) {
                // Fallback again just in case
                @session_save_path(__DIR__ . '/../data/sessions');
            }
        }
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