<?php

require_once 'db-helpers.php';
// Get the requested URL path
// Get the requested URL path
$requestUri = $_SERVER['REQUEST_URI'];

// Get the base path of the script
$basePath = dirname($_SERVER['SCRIPT_NAME']);

// Remove the base path from the request URI
$requestPath = substr($requestUri, strlen($basePath));

// Remove leading and trailing slashes
$requestPath = trim($requestPath, '/');

// Explode the request path into segments
$pathSegments = explode('/', $requestPath);

// Define the base directory for the routes
$baseDir = 'routes/';

// Check if the last segment is empty or represents a directory
if (end($pathSegments) === '' || is_dir($baseDir . $requestPath)) {
    array_push($pathSegments, 'index.php');
}

// Get the number of segments in the request path
$segmentCount = count($pathSegments);


// Determine the appropriate route file based on the request path
$routeFile = $baseDir . implode('/', $pathSegments);

// Output debugging information
var_dump('Request URI: ', $requestUri);
var_dump('Base Path: ', $basePath);
var_dump('Request Path: ', $requestPath);
var_dump('Path Segments: ', $pathSegments);
var_dump('Segment Count: ', $segmentCount);
var_dump('Route File: ', $routeFile);

// Check if a route file exists
if ($segmentCount > 0 && file_exists($routeFile)) {
    include $routeFile;
} else {
    // If no route file matches, display a 404 error
    http_response_code(404);
    echo '404 Page Not Found';
}


// Close the database connection
$db->close();
?>
