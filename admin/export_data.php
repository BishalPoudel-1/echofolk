<?php

session_start();
require_once '../config.php'; // Also loads log_activity() function

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

function clean_utf8_array($input) {
    if (is_array($input)) {
        return array_map('clean_utf8_array', $input);
    } elseif (is_string($input)) {
        return mb_convert_encoding($input, 'UTF-8', 'UTF-8');
    }
    return $input;
}

try {
    $format = $_POST['format'] ?? 'json';
    $filter = $_POST['filter'] ?? 'approved';
    $timestamp = date('Y-m-d_H-i-s');
    $filenameBase = '';
    $data = [];

    switch ($filter) {
        case 'approved':
            $stmt = $pdo->query("SELECT * FROM stories WHERE verified = 1");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $filenameBase = "approved_posts";
            break;
        case 'pending':
            $stmt = $pdo->query("SELECT * FROM stories WHERE verified = 0");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $filenameBase = "pending_posts";
            break;
        case 'users':
            $stmt = $pdo->query("SELECT id, name, email, country, role, created_at FROM users");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $filenameBase = "all_users";
            break;
        default:
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Invalid data filter selected.'];
            header("Location: index.php#export-data-content");
            exit;
    }

    $exportDir = __DIR__ . '/exports';
    if (!is_dir($exportDir)) {
        mkdir($exportDir, 0777, true);
    }

    $extension = ($format === 'csv') ? 'csv' : 'json';
    $fileName = "{$filenameBase}_{$timestamp}.{$extension}";
    $fullPath = $exportDir . '/' . $fileName;

    if ($format === 'csv') {
        $fp = fopen($fullPath, 'w');
        if (!empty($data)) {
            fputcsv($fp, array_keys($data[0]));
            foreach ($data as $row) fputcsv($fp, $row);
        }
        fclose($fp);
    } else {
        $data = clean_utf8_array($data);
        $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_INVALID_UTF8_IGNORE);
        if ($jsonData === false) throw new Exception("Failed to encode JSON: " . json_last_error_msg());
        if (file_put_contents($fullPath, $jsonData) === false) throw new Exception("Failed to write JSON file.");
    }

    $fileSize = filesize($fullPath);
    $stmt = $pdo->prepare("INSERT INTO exports (file_name, format, filter_used, file_size, created_at) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$fileName, strtoupper($format), $filter, $fileSize, date('Y-m-d H:i:s')]);

    // Log this activity
    log_activity($pdo, 'export_generated', "Admin generated a data export: {$fileName}.");

    $_SESSION['flash_message'] = ['type' => 'success', 'text' => "Export generated successfully: {$fileName}"];

} catch (Exception $e) {
    error_log('Export Error: ' . $e->getMessage());
    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'An error occurred while generating the export.'];
}

header("Location: index.php#export-data-content");
exit;