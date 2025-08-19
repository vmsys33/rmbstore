<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .error { background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Server Error (500)</h1>
    <div class="error">
        <h2>An error occurred:</h2>
        <p><?= $message ?? 'Unknown error' ?></p>
    </div>
    <p><a href="<?= base_url() ?>">Go back to home</a></p>
</body>
</html>
