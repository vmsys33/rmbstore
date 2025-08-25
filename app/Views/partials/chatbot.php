<!-- RMB Store Chatbot Widget -->
<div id="chatbot-container"></div>

<!-- Load Font Awesome for chatbot icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Load Chatbot CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/chatbot.css') ?>">

<!-- Load Chatbot JS -->
<script src="<?= base_url('assets/js/chatbot.js') ?>"></script>

<!-- Initialize Chatbot -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize chatbot with configuration
        window.chatbot = new ChatbotWidget({
            apiBase: '<?= base_url('chatbot') ?>',
            headerTitle: 'RMB Store Assistant',
            placeholderText: 'Ask me anything about our products...',
            welcomeMessage: 'Hello! 👋 I\'m your RMB Store assistant. How can I help you today?',
            loadHistory: true,
            debug: false
        });
    });
</script>

<!-- Note: The toggle button is now handled by the ChatbotWidget class -->
<!-- The notification badge functionality is integrated into the widget -->
