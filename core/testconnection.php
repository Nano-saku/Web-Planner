<?php

require __DIR__ .'/firebase.php'; // Adjust path if needed

// Get database instance from FirebaseService
$db = $firebase->db();

try {
    // Write test data
    $db->getReference('test_connection')->set([
        'status' => 'Firebase is Connected',
        'timestamp' => date('Y-m-d H:i:s')
    ]);

    echo "✅ Data Inserted Successfully!\n";

    // Read back the data
    $snapshot = $db->getReference('test_connection')->getValue();
    print_r($snapshot);

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>