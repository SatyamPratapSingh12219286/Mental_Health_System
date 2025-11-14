<?php
// Display all errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration
require_once 'config/database.php';

try {
    // Test database connection
    $test_query = $pdo->query("SELECT DATABASE() AS dbname");
    $db_info = $test_query->fetch(PDO::FETCH_ASSOC);
    
    // Test table exists
    $table_check = $pdo->query("SHOW TABLES LIKE 'assessment_results'");
    $table_exists = $table_check->rowCount() > 0;
    
    // Get column information
    $columns = [];
    if ($table_exists) {
        $stmt = $pdo->query("DESCRIBE assessment_results");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    // Display results
    echo "<h2 style='color: green;'>✅ Database Connection Successful!</h2>";
    echo "<p>Connected to database: <strong>" . htmlspecialchars($db_info['dbname']) . "</strong></p>";
    
    if ($table_exists) {
        echo "<p style='color: green;'>✓ Table 'assessment_results' exists</p>";
        echo "<h4>Table Structure:</h4>";
        echo "<ul>";
        foreach ($columns as $column) {
            echo "<li>" . htmlspecialchars($column) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color: red;'>✗ Table 'assessment_results' does not exist</p>";
    }
    
    // Test insert
    try {
        $test_insert = $pdo->prepare("INSERT INTO assessment_results (assessment_type, score, severity, recommendation, created_at) VALUES (?, ?, ?, ?, NOW())");
        $test_insert->execute(['test', 0, 'test', 'Test recommendation']);
        $last_id = $pdo->lastInsertId();
        echo "<p style='color: green;'>✓ Test record inserted successfully (ID: $last_id)</p>";
        
        // Clean up
        $pdo->exec("DELETE FROM assessment_results WHERE id = $last_id");
    } catch (PDOException $e) {
        echo "<p style='color: orange;'>⚠️ Could not insert test record: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Database Connection Failed</h2>";
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    
    // Show connection details for debugging
    echo "<h4>Connection Details:</h4>";
    echo "<ul>";
    echo "<li>Host: " . DB_HOST . "</li>";
    echo "<li>Database: " . DB_NAME . "</li>";
    echo "<li>User: " . DB_USER . "</li>";
    echo "</ul>";
    
    // Common solutions
    echo "<h4>Common Solutions:</h4>";
    echo "<ol>";
    echo "<li>Make sure MySQL is running in XAMPP</li>";
    echo "<li>Verify the database name is correct</li>";
    echo "<li>Check your database credentials in config/database.php</li>";
    echo "<li>Make sure the database user has proper permissions</li>";
    echo "</ol>";
}
?>
