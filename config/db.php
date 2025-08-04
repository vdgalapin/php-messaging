<?php

$host = 'aws-0-us-west-1.pooler.supabase.com';
$db = 'postgres';
$user = 'postgres.achaofrjkmdxoroyiasf';
$pass = 'ProjectMania2025!'; 
$port = '6543';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass); 
    // $pdo->setAttribute(PDO::AFTER_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

?>