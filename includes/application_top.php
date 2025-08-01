<?php  
require_once __DIR__ . '/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//For use with SessionDebugger.php
if (isset($_GET['reset'])) {
    // Clear all session data
    $_SESSION = [];

    // Delete the PHPSESSID cookie with proper flags
    setcookie(session_name(), '', time() - 42000, '/', 'hub.haskris.com', true, true);

    // Destroy the session
    session_destroy();

    // Start fresh session and regenerate ID
    session_start();
    session_regenerate_id(true);

    echo "<p>Session destroyed and new session started. Refresh the page.</p>";
    exit;
}

$dbCon = [
	'server' => '10.251.3.5',
	'user' => 'hubUser',
	'password' => 'LateLlama@830',
	'database' => 'hub'
];

$dbTestData = [
	'server' => '10.251.3.5',
	'user' => 'testDataUser',
	'password' => 'SilkyStorm*808',
	'database' => 'testData'
];

$config = [
	'base' => 'https://hub.haskris.com/',
	'timeoutDuration' => 36000,
	'version' => 1
];