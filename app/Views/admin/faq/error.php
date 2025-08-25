<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ System Error - RMB Store Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .error-card {
            max-width: 600px;
            margin: 50px auto;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="error-card">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h3><i class="fas fa-exclamation-circle"></i> FAQ System Error</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i>
                        <strong>Error:</strong> <?= esc($error) ?>
                    </div>

                    <h4>🔧 Troubleshooting Steps:</h4>
                    <ol>
                        <li>Check if your database is running and accessible</li>
                        <li>Verify that the <code>chatbot_faq</code> table exists</li>
                        <li>Ensure proper database permissions</li>
                        <li>Check the application logs for more details</li>
                    </ol>

                    <div class="mt-4 text-center">
                        <a href="/admin/faq" class="btn btn-primary">
                            <i class="fas fa-refresh"></i> Try Again
                        </a>
                        <a href="/admin" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Admin Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
