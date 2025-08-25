<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Error - Chatbot Conversations</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .error-card {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
        }
        .error-card h2 {
            margin-bottom: 20px;
        }
        .code-block {
            background: rgba(0,0,0,0.2);
            padding: 15px;
            border-radius: 10px;
            font-family: monospace;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1><i class="fas fa-exclamation-triangle"></i> Database Error</h1>
                    <a href="/admin/dashboard" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
                <hr>
            </div>
        </div>

        <!-- Error Message -->
        <div class="row">
            <div class="col-12">
                <div class="error-card">
                    <h2><i class="fas fa-database"></i> Database Connection Failed</h2>
                    <p>The system cannot connect to the database. Please check your database configuration.</p>
                    
                    <div class="alert alert-light">
                        <strong>Error Details:</strong><br>
                        <code><?= $error ?></code>
                    </div>
                </div>
            </div>
        </div>

        <!-- Troubleshooting Steps -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-tools"></i> Troubleshooting Steps</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5>1. Check XAMPP Services</h5>
                            <ul>
                                <li>Ensure MySQL service is running in XAMPP Control Panel</li>
                                <li>Check if Apache service is running</li>
                                <li>Verify the ports are not blocked</li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h5>2. Check Database Configuration</h5>
                            <p>Verify your database settings in <code>app/Config/Database.php</code>:</p>
                            <div class="code-block">
'hostname' => 'localhost',
'username' => 'root',
'password' => '',
'database' => 'your_database_name',
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5>3. Test Database Connection</h5>
                            <p>Try accessing phpMyAdmin to verify the database is accessible:</p>
                            <a href="http://localhost/phpmyadmin" class="btn btn-primary" target="_blank">
                                <i class="fas fa-external-link-alt"></i> Open phpMyAdmin
                            </a>
                        </div>

                        <div class="mb-4">
                            <h5>4. Check Error Logs</h5>
                            <p>Review XAMPP error logs for more details:</p>
                            <ul>
                                <li>MySQL error log: <code>xampp/mysql/data/mysql_error.log</code></li>
                                <li>Apache error log: <code>xampp/apache/logs/error.log</code></li>
                            </ul>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle"></i>
                            <strong>Note:</strong> If you're using a different database name, make sure to update the configuration file accordingly.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <button class="btn btn-success" onclick="location.reload()">
                                <i class="fas fa-refresh"></i> Retry Connection
                            </button>
                            <a href="/admin/dashboard" class="btn btn-secondary">
                                <i class="fas fa-home"></i> Go to Dashboard
                            </a>
                            <a href="http://localhost/phpmyadmin" class="btn btn-info" target="_blank">
                                <i class="fas fa-database"></i> Open phpMyAdmin
                            </a>
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
