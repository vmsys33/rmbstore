<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Conversations - Admin Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .stats-card h3 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .stats-card p {
            margin: 0;
            opacity: 0.9;
        }
        .conversation-modal .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }
        .message-bubble {
            margin: 10px 0;
            padding: 10px 15px;
            border-radius: 15px;
            max-width: 80%;
        }
        .message-user {
            background-color: #007bff;
            color: white;
            margin-left: auto;
        }
        .message-bot {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #dee2e6;
        }
        .message-system {
            background-color: #ffc107;
            color: #333;
            text-align: center;
            font-style: italic;
        }
        .status-badge {
            font-size: 0.8rem;
            padding: 5px 10px;
        }
        .export-btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
        }
        .export-btn:hover {
            background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1><i class="fas fa-comments"></i> Chatbot Conversations</h1>
                    <div>
                        <button class="btn export-btn me-2" onclick="exportConversations()">
                            <i class="fas fa-download"></i> Export CSV
                        </button>
                        <a href="/admin/dashboard" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
                <hr>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4" id="statsRow">
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <h3 id="totalConversations">-</h3>
                    <p>Total Conversations</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <h3 id="activeConversations">-</h3>
                    <p>Active Conversations</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <h3 id="totalMessages">-</h3>
                    <p>Total Messages</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <h3 id="totalUsers">-</h3>
                    <p>Total Users</p>
                </div>
            </div>
        </div>

        <!-- Conversations Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-table"></i> Conversation History</h5>
                    </div>
                    <div class="card-body">
                        <table id="conversationsTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Session ID</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>IP Address</th>
                                    <th>Messages</th>
                                    <th>Status</th>
                                    <th>First Message</th>
                                    <th>Last Message</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conversation Details Modal -->
    <div class="modal fade" id="conversationModal" tabindex="-1" aria-labelledby="conversationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl conversation-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="conversationModalLabel">Conversation Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Conversation Info -->
                        <div class="col-md-6">
                            <h6>Conversation Information</h6>
                            <div id="conversationInfo"></div>
                        </div>
                        <!-- User Info -->
                        <div class="col-md-6">
                            <h6>User Information</h6>
                            <div id="userInfo"></div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Messages -->
                    <div class="row">
                        <div class="col-12">
                            <h6>Conversation Messages</h6>
                            <div id="messagesContainer"></div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Product Inquiries -->
                    <div class="row">
                        <div class="col-12">
                            <h6>Product Inquiries</h6>
                            <div id="inquiriesContainer"></div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- AI Interactions Logs -->
                    <div class="row">
                        <div class="col-12">
                            <h6>AI Interactions (Hugging Face)</h6>
                            <div id="ciciLogsContainer"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Conversation Modal -->
    <div class="modal fade" id="editConversationModal" tabindex="-1" aria-labelledby="editConversationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editConversationModalLabel">Edit Conversation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editConversationForm">
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-select" id="editStatus" name="status" required>
                                <option value="active">Active</option>
                                <option value="completed">Completed</option>
                                <option value="abandoned">Abandoned</option>
                            </select>
                        </div>
                        <input type="hidden" id="editSessionId" name="sessionId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveConversationEdit()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let conversationsTable;
        let currentSessionId;

        $(document).ready(function() {
            initializeDataTable();
            loadStatistics();
        });

        function initializeDataTable() {
            conversationsTable = $('#conversationsTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/admin/chatbot-conversations/getConversations',
                    type: 'GET',
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'id' },
                    { data: 'session_id' },
                    { data: 'user_name' },
                    { data: 'user_email' },
                    { data: 'ip_address' },
                    { data: 'total_messages' },
                    { data: 'status' },
                    { data: 'first_message_at' },
                    { data: 'last_message_at' },
                    { data: 'actions', orderable: false }
                ],
                order: [[0, 'desc']],
                pageLength: 25,
                responsive: true,
                language: {
                    search: "Search conversations:",
                    lengthMenu: "Show _MENU_ conversations per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ conversations",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        }

        function loadStatistics() {
            fetch('/admin/chatbot-conversations/getStatistics')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('totalConversations').textContent = data.data.total_conversations;
                        document.getElementById('activeConversations').textContent = data.data.active_conversations;
                        document.getElementById('totalMessages').textContent = data.data.total_messages;
                        document.getElementById('totalUsers').textContent = data.data.total_users;
                    }
                })
                .catch(error => {
                    console.error('Error loading statistics:', error);
                });
        }

        function viewConversation(sessionId) {
            currentSessionId = sessionId;
            
            fetch(`/admin/chatbot-conversations/getConversationDetails/${sessionId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        displayConversationDetails(data);
                        $('#conversationModal').modal('show');
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error loading conversation details:', error);
                    Swal.fire('Error', 'Failed to load conversation details', 'error');
                });
        }

        function displayConversationDetails(data) {
            const conv = data.conversation;
            
            // Display conversation info
            document.getElementById('conversationInfo').innerHTML = `
                <table class="table table-sm">
                    <tr><td><strong>Session ID:</strong></td><td>${conv.session_id}</td></tr>
                    <tr><td><strong>Status:</strong></td><td>${getStatusBadge(conv.status)}</td></tr>
                    <tr><td><strong>Total Messages:</strong></td><td>${conv.total_messages}</td></tr>
                    <tr><td><strong>Started:</strong></td><td>${formatDate(conv.first_message_at)}</td></tr>
                    <tr><td><strong>Last Activity:</strong></td><td>${formatDate(conv.last_message_at)}</td></tr>
                </table>
            `;
            
            // Display user info
            document.getElementById('userInfo').innerHTML = `
                <table class="table table-sm">
                    <tr><td><strong>Name:</strong></td><td>${conv.user_name || 'Anonymous'}</td></tr>
                    <tr><td><strong>Email:</strong></td><td>${conv.user_email || 'N/A'}</td></tr>
                    <tr><td><strong>IP Address:</strong></td><td>${conv.ip_address || 'N/A'}</td></tr>
                    <tr><td><strong>User Agent:</strong></td><td>${conv.user_agent || 'N/A'}</td></tr>
                    <tr><td><strong>First Visit:</strong></td><td>${formatDate(conv.user_created)}</td></tr>
                </table>
            `;
            
            // Display messages
            let messagesHtml = '';
            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(message => {
                    const messageClass = message.message_type === 'user' ? 'message-user' : 
                                      message.message_type === 'bot' ? 'message-bot' : 'message-system';
                    const icon = message.message_type === 'user' ? 'fa-user' : 
                               message.message_type === 'bot' ? 'fa-robot' : 'fa-cog';
                    
                    messagesHtml += `
                        <div class="message-bubble ${messageClass}">
                            <div class="d-flex align-items-start">
                                <i class="fas ${icon} me-2 mt-1"></i>
                                <div class="flex-grow-1">
                                    <div class="message-content">${escapeHtml(message.message_content)}</div>
                                    <small class="text-muted">${formatDate(message.created_at)}</small>
                                    ${message.cici_ai_used ? '<span class="badge badge-info ms-2">CICI AI</span>' : ''}
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                messagesHtml = '<p class="text-muted">No messages found.</p>';
            }
            document.getElementById('messagesContainer').innerHTML = messagesHtml;
            
            // Display product inquiries
            let inquiriesHtml = '';
            if (data.inquiries && data.inquiries.length > 0) {
                inquiriesHtml = '<div class="table-responsive"><table class="table table-sm">';
                inquiriesHtml += '<thead><tr><th>Query</th><th>Status</th><th>Date</th></tr></thead><tbody>';
                data.inquiries.forEach(inquiry => {
                    inquiriesHtml += `
                        <tr>
                            <td>${escapeHtml(inquiry.product_query)}</td>
                            <td>${getInquiryStatusBadge(inquiry.inquiry_status)}</td>
                            <td>${formatDate(inquiry.created_at)}</td>
                        </tr>
                    `;
                });
                inquiriesHtml += '</tbody></table></div>';
            } else {
                inquiriesHtml = '<p class="text-muted">No product inquiries found.</p>';
            }
            document.getElementById('inquiriesContainer').innerHTML = inquiriesHtml;
            
            // Display CICI AI logs
            let ciciHtml = '';
            if (data.cici_logs && data.cici_logs.length > 0) {
                ciciHtml = '<div class="table-responsive"><table class="table table-sm">';
                ciciHtml += '<thead><tr><th>Query</th><th>Response</th><th>Response Time</th><th>Date</th></tr></thead><tbody>';
                data.cici_logs.forEach(log => {
                    ciciHtml += `
                        <tr>
                            <td>${escapeHtml(log.user_query)}</td>
                            <td>${escapeHtml(log.cici_ai_response)}</td>
                            <td>${log.response_time_ms}ms</td>
                            <td>${formatDate(log.created_at)}</td>
                        </tr>
                    `;
                });
                ciciHtml += '</tbody></table></div>';
            } else {
                ciciHtml = '<p class="text-muted">No CICI AI interactions found.</p>';
            }
            document.getElementById('ciciLogsContainer').innerHTML = ciciHtml;
        }

        function editConversation(id) {
            // For now, we'll just show the edit modal with status update
            // You can expand this to edit more fields
            $('#editConversationModal').modal('show');
        }

        function saveConversationEdit() {
            const status = document.getElementById('editStatus').value;
            const sessionId = currentSessionId;
            
            fetch('/admin/chatbot-conversations/updateStatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    sessionId: sessionId,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Success', 'Conversation status updated successfully', 'success');
                    $('#editConversationModal').modal('hide');
                    conversationsTable.ajax.reload();
                    loadStatistics();
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error updating conversation:', error);
                Swal.fire('Error', 'Failed to update conversation', 'error');
            });
        }

        function deleteConversation(sessionId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the conversation and all related data. This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/admin/chatbot-conversations/deleteConversation', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            sessionId: sessionId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Deleted!', 'Conversation has been deleted successfully.', 'success');
                            conversationsTable.ajax.reload();
                            loadStatistics();
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting conversation:', error);
                        Swal.fire('Error', 'Failed to delete conversation', 'error');
                    });
                }
            });
        }

        function exportConversations() {
            window.open('/admin/chatbot-conversations/exportConversations', '_blank');
        }

        function getStatusBadge(status) {
            const badges = {
                'active': '<span class="badge bg-success">Active</span>',
                'completed': '<span class="badge bg-info">Completed</span>',
                'abandoned': '<span class="badge bg-warning">Abandoned</span>'
            };
            return badges[status] || '<span class="badge bg-secondary">Unknown</span>';
        }

        function getInquiryStatusBadge(status) {
            const badges = {
                'pending': '<span class="badge bg-warning">Pending</span>',
                'responded': '<span class="badge bg-info">Responded</span>',
                'followed_up': '<span class="badge bg-primary">Followed Up</span>',
                'closed': '<span class="badge bg-success">Closed</span>'
            };
            return badges[status] || '<span class="badge bg-secondary">Unknown</span>';
        }

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleString();
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>
</html>
