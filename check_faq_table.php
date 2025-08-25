<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=rmbstore', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Checking if chatbot_faq table exists...\n";
    
    $stmt = $db->query("SHOW TABLES LIKE 'chatbot_faq'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Table 'chatbot_faq' exists!\n\n";
        
        echo "Checking table structure...\n";
        $stmt = $db->query("DESCRIBE chatbot_faq");
        echo "Table structure:\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- {$row['Field']}: {$row['Type']} ({$row['Null']})\n";
        }
        
        echo "\nChecking content...\n";
        $stmt = $db->query("SELECT * FROM chatbot_faq LIMIT 5");
        if ($stmt->rowCount() > 0) {
            echo "Found " . $stmt->rowCount() . " FAQ entries:\n";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "\nID: {$row['id']}\n";
                echo "Query: {$row['query']}\n";
                echo "Response: " . substr($row['response'], 0, 100) . "...\n";
                echo "Category: {$row['category']}\n";
                echo "Priority: {$row['priority']}\n";
                echo "Active: {$row['is_active']}\n";
                echo "---\n";
            }
        } else {
            echo "Table is empty\n";
        }
        
    } else {
        echo "❌ Table 'chatbot_faq' does not exist\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
