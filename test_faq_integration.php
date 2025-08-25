<?php
/**
 * Test FAQ Integration with Chatbot
 * This script tests the chatbot's FAQ functionality
 */

// Database configuration
$host = 'localhost';
$dbname = 'rmbstore';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h1>🧪 Testing FAQ Integration</h1>";
    
    // Test 1: Check if chatbot_faq table has data
    echo "<h2>📊 Test 1: FAQ Table Data</h2>";
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM chatbot_faq WHERE is_active = 1");
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p>Active FAQ entries: <strong>{$count}</strong></p>";
    
    if ($count > 0) {
        echo "<p>✅ FAQ table has data</p>";
        
        // Show sample FAQ entries
        $stmt = $pdo->query("SELECT query, response, category, priority FROM chatbot_faq WHERE is_active = 1 ORDER BY priority DESC LIMIT 3");
        echo "<h3>Sample FAQ Entries:</h3>";
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>Query</th><th>Response</th><th>Category</th><th>Priority</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars(substr($row['query'], 0, 40)) . (strlen($row['query']) > 40 ? '...' : '') . "</td>";
            echo "<td>" . htmlspecialchars(substr($row['response'], 0, 60)) . (strlen($row['response']) > 60 ? '...' : '') . "</td>";
            echo "<td>{$row['category']}</td>";
            echo "<td>{$row['priority']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>❌ FAQ table is empty</p>";
    }
    
    // Test 2: Test FAQ search functionality
    echo "<h2>🔍 Test 2: FAQ Search Functionality</h2>";
    
    $testQueries = [
        'store hours',
        'return policy', 
        'laptops',
        'payment methods',
        'delivery'
    ];
    
    foreach ($testQueries as $testQuery) {
        echo "<h3>Testing query: '{$testQuery}'</h3>";
        
        // Simulate the searchFAQ method logic
        $stmt = $pdo->prepare("
            SELECT id, query, response, category, priority 
            FROM chatbot_faq 
            WHERE is_active = 1 
            AND (
                LOWER(query) LIKE :query1 
                OR LOWER(query) LIKE :query2 
                OR LOWER(query) LIKE :query3 
                OR LOWER(response) LIKE :query4
                OR LOWER(keywords) LIKE :query5
            )
            ORDER BY priority DESC, category ASC
        ");
        
        $stmt->execute([
            ':query1' => '%' . strtolower($testQuery) . '%',
            ':query2' => strtolower($testQuery) . '%',
            ':query3' => '%' . strtolower($testQuery),
            ':query4' => '%' . strtolower($testQuery) . '%',
            ':query5' => '%' . strtolower($testQuery) . '%'
        ]);
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($results)) {
            echo "<p>✅ Found " . count($results) . " matches:</p>";
            echo "<ul>";
            foreach ($results as $result) {
                echo "<li><strong>{$result['query']}</strong> ({$result['category']}, priority: {$result['priority']})</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>❌ No matches found</p>";
        }
    }
    
    // Test 3: Test chatbot API endpoints
    echo "<h2>🌐 Test 3: Chatbot API Endpoints</h2>";
    
    $baseUrl = 'http://localhost:8080';
    $endpoints = [
        '/chatbot/getQA' => 'GET',
        '/chatbot/searchQA?q=store+hours' => 'GET'
    ];
    
    foreach ($endpoints as $endpoint => $method) {
        echo "<h3>Testing {$method} {$endpoint}</h3>";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_error($ch)) {
            echo "<p>❌ cURL Error: " . curl_error($ch) . "</p>";
        } else {
            echo "<p>HTTP Status: <strong>{$httpCode}</strong></p>";
            
            if ($httpCode === 200) {
                $data = json_decode($response, true);
                if ($data && isset($data['status']) && $data['status'] === 'success') {
                    echo "<p>✅ API call successful</p>";
                    if (isset($data['data'])) {
                        echo "<p>Data count: " . count($data['data']) . "</p>";
                    }
                } else {
                    echo "<p>⚠️ API returned error: " . ($data['message'] ?? 'Unknown error') . "</p>";
                }
            } else {
                echo "<p>❌ API call failed with status {$httpCode}</p>";
            }
        }
        
        curl_close($ch);
    }
    
    echo "<h2>🎯 Summary</h2>";
    echo "<p>The FAQ integration test is complete. Check the results above to ensure everything is working correctly.</p>";
    
} catch (PDOException $e) {
    echo "<h2>❌ Database Error</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
} catch (Exception $e) {
    echo "<h2>❌ General Error</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
table { border-collapse: collapse; width: 100%; }
th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
th { background-color: #f2f2f2; }
h1, h2, h3 { color: #333; }
ul { margin: 10px 0; }
li { margin: 5px 0; }
</style>
