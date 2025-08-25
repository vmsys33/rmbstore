<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup Required - Chatbot Conversations</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .setup-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
        }
        .setup-card h2 {
            margin-bottom: 20px;
        }
        .code-block {
            background: rgba(0,0,0,0.2);
            padding: 15px;
            border-radius: 10px;
            font-family: monospace;
            margin: 15px 0;
        }
        .step-number {
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1><i class="fas fa-database"></i> Database Setup Required</h1>
                    <a href="/admin/dashboard" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
                <hr>
            </div>
        </div>

        <!-- Setup Instructions -->
        <div class="row">
            <div class="col-12">
                <div class="setup-card">
                    <h2><i class="fas fa-exclamation-triangle"></i> Database Tables Missing</h2>
                    <p>The following database tables are required for the Chatbot Conversations system:</p>
                    
                    <div class="alert alert-warning">
                        <strong>Missing Tables:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach ($missingTables as $table): ?>
                                <li><code><?= $table ?></code></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Setup Steps -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-tools"></i> Setup Instructions</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5><span class="step-number">1</span>Download Database Setup File</h5>
                            <p>Download the SQL file that contains all the necessary table structures:</p>
                            <a href="/database_chatbot_conversations.sql" class="btn btn-primary" download>
                                <i class="fas fa-download"></i> Download database_chatbot_conversations.sql
                            </a>
                        </div>

                        <div class="mb-4">
                            <h5><span class="step-number">2</span>Import to Database</h5>
                            <p>Import the SQL file into your MySQL database using one of these methods:</p>
                            
                            <h6>Option A: Using phpMyAdmin</h6>
                            <ol>
                                <li>Open phpMyAdmin in your browser</li>
                                <li>Select your database</li>
                                <li>Click on "Import" tab</li>
                                <li>Choose the downloaded SQL file</li>
                                <li>Click "Go" to import</li>
                            </ol>

                            <h6>Option B: Using MySQL Command Line</h6>
                            <div class="code-block">
                                mysql -u your_username -p your_database_name < database_chatbot_conversations.sql
                            </div>

                            <h6>Option C: Using XAMPP Control Panel</h6>
                            <ol>
                                <li>Open XAMPP Control Panel</li>
                                <li>Click "Admin" button next to MySQL</li>
                                <li>This will open phpMyAdmin</li>
                                <li>Follow Option A steps above</li>
                            </ol>
                        </div>

                        <div class="mb-4">
                            <h5><span class="step-number">3</span>Verify Setup</h5>
                            <p>After importing, refresh this page to verify the setup is complete.</p>
                            <button class="btn btn-success" onclick="location.reload()">
                                <i class="fas fa-refresh"></i> Refresh Page
                            </button>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Note:</strong> The database setup will create sample data for testing purposes. 
                            You can modify or remove this sample data after setup is complete.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alternative Setup -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-code"></i> Manual SQL Commands</h3>
                    </div>
                    <div class="card-body">
                        <p>If you prefer to run the SQL commands manually, here are the key table creation commands:</p>
                        
                        <div class="code-block">
-- Create chatbot_users table
CREATE TABLE IF NOT EXISTS chatbot_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) UNIQUE NOT NULL,
    user_name VARCHAR(100) NULL,
    user_email VARCHAR(255) NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create chatbot_sessions table
CREATE TABLE IF NOT EXISTS chatbot_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) UNIQUE NOT NULL,
    user_id INT NULL,
    status ENUM('active', 'completed', 'abandoned') DEFAULT 'active',
    total_messages INT DEFAULT 0,
    first_message_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_message_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create chatbot_messages table
CREATE TABLE IF NOT EXISTS chatbot_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    user_id INT NULL,
    message_type ENUM('user', 'bot', 'system') DEFAULT 'user',
    message_content TEXT NOT NULL,
    cici_ai_used BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
