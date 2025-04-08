<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | Chat Responses</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Admin CSS -->
    <link href="css/admin.css" rel="stylesheet">
    <style>
        /* Responsive table styles */
        @media (max-width: 991.98px) {
            .admin-main {
                padding-left: 0;
            }
            
            .admin-table-container {
                overflow-x: auto;
                margin: 0 -15px;
                padding: 0 15px;
            }
            
            /* Ensure table doesn't overflow container */
            .table-responsive {
                min-width: 100%;
            }
            
            /* Add spacing between pagination components */
            .pagination {
                margin-top: 10px;
            }
        }
        
        /* Mobile specific styles */
        @media (max-width: 767.98px) {
            .admin-table thead {
                display: none; /* Hide table headers on mobile */
            }
            
            .admin-table tbody tr {
                display: block;
                border: 1px solid rgba(0,0,0,.125);
                border-radius: 0.25rem;
                margin-bottom: 1rem;
                padding: 0.5rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
            }
            
            .admin-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: none;
                padding: 0.5rem 0.5rem;
                text-align: right;
            }
            
            /* Create column headers on mobile */
            .admin-table tbody td:before {
                content: attr(data-label);
                font-weight: 600;
                text-align: left;
                padding-right: 0.5rem;
            }
            
            /* Special styling for image column */
            .admin-table td:first-child {
                display: block;
                text-align: center;
                justify-content: center;
            }
            
            .admin-table td:first-child:before {
                display: none;
            }
            
            /* Special styling for status badges */
            .admin-table td .stock-badge {
                margin-left: auto;
            }
            
            /* Action buttons centered */
            .admin-table td.action-buttons {
                justify-content: center;
            }
            
            .admin-table td.action-buttons:before {
                display: none;
            }
            
            /* Chat card specific styles - mobile first approach */
            .chat-card {
                display: block;
                border: 1px solid rgba(0,0,0,.125);
                border-radius: 0.25rem;
                margin-bottom: 1rem;
                padding: 0.5rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
                background-color: #fff;
            }
            
            .chat-card-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.5rem 0;
                border-bottom: 1px solid rgba(0,0,0,.05);
            }
            
            .chat-card-row:last-of-type {
                border-bottom: none;
            }
            
            .chat-card-label {
                font-weight: 600;
                text-align: left;
                padding-right: 0.5rem;
                flex: 0 0 90px;
            }
            
            .chat-card-value {
                text-align: right;
                flex: 1;
            }
            
            .chat-card-actions {
                display: flex;
                justify-content: flex-end;
                padding-top: 0.5rem;
                border-top: 1px solid rgba(0,0,0,.05);
                margin-top: 0.5rem;
            }
            
            .chat-card-actions .btn {
                margin-left: 0.5rem;
            }
            
            /* Improve pagination on small screens */
            .d-flex.justify-content-between.align-items-center.mt-4 {
                flex-direction: column;
                align-items: flex-start !important;
            }
            
            .items-per-page {
                margin-bottom: 1rem;
                width: 100%;
            }
            
            nav[aria-label="Page navigation"] {
                width: 100%;
                display: flex;
                justify-content: center;
            }
        }
        
        /* Between small and medium screens */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .message-text {
                max-width: 100%;
                word-break: break-word;
            }
            
            .chat-message {
                width: 100%;
            }
        }
        
        /* Ensure chat message wrapping at all screen sizes */
        .message-text {
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 100%;
        }
        
        /* Edit message modal responsive */
        @media (max-width: 767.98px) {
            .modal-body textarea {
                min-height: 100px;
            }
        }
        
        /* Extra overrides for chat message text that's displaying vertically */
        .message-text {
            white-space: normal !important;
            display: block !important;
            width: 100% !important;
            word-break: break-word !important;
        }
        
        /* Message text styling */
        .message-text {
            background-color: #f8f9fa;
            padding: 0.5rem !important;
            border-radius: 0.25rem;
            margin-top: 0.25rem;
        }
        
        p.message-text {
            white-space: normal !important;
            word-break: normal !important;
            display: block !important;
            width: 100% !important;
            text-orientation: mixed !important;
            writing-mode: horizontal-tb !important;
            letter-spacing: normal !important;
        }
        
        /* Delete these unnecessary card styles */
        .chat-card-header,
        .chat-card-body,
        .chat-card-body strong,
        .chat-card-body .rounded,
        .chat-card-footer {
            display: none;
        }
        
        .btn-sm.mobile-edit-btn, .btn-sm.mobile-delete-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
        
        .mobile-edit-btn i, .mobile-delete-btn i {
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <?php include 'components/edit_product.php'; ?>
    <?php include 'components/delete_product.php'; ?>
    <?php include 'components/admin_header.php'; ?>
    
    <!-- Add notifications container -->
    <div id="notifications-container" class="mb-3"></div>
    
    <div class="d-flex admin-dashboard">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <?php include 'components/admin_sidebar.php'; ?>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-main">
            <div class="container-fluid px-4 py-4">
                <?php renderAdminHeader('CHAT RESPONSES', 'Search messages...'); ?>
                
                <!-- Include the fetch_chat_messages.php to get messages from DB -->
                <?php include 'components/fetch_chat_messages.php'; ?>
                
                <!-- Chat Responses Table -->
                <div class="admin-table-container">
                    <div class="table-responsive">
                        <!-- Simple card-based approach for chat messages on mobile -->
                        <div class="chat-messages-mobile d-md-none">
                            <?php
                            // Use $messages array from fetch_chat_messages.php
                            foreach ($messages as $message):
                            ?>
                            <div class="chat-card" data-id="<?php echo $message['chat_id']; ?>">
                                <div class="chat-card-row">
                                    <div class="chat-card-label">TIMESTAMP</div>
                                    <div class="chat-card-value"><?php echo $message['chat_time']; ?></div>
                                </div>
                                <div class="chat-card-row">
                                    <div class="chat-card-label">SENDER</div>
                                    <div class="chat-card-value"><?php echo $message['sender_name']; ?></div>
                                </div>
                                <div class="chat-card-row">
                                    <div class="chat-card-label">MESSAGE</div>
                                    <div class="chat-card-value">
                                        <div class="message-text p-2 bg-light rounded"><?php echo $message['message']; ?></div>
                                    </div>
                                </div>
                                <div class="chat-card-actions">
                                    <button class="btn btn-action edit-btn mobile-edit-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editMessageModal" 
                                            data-id="<?php echo $message['chat_id']; ?>"
                                            data-timestamp="<?php echo $message['chat_time']; ?>"
                                            data-sender="<?php echo $message['sender_name']; ?>"
                                            data-message="<?php echo htmlspecialchars($message['message']); ?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-action delete-btn mobile-delete-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#mobileDeleteMessageModal" 
                                            data-id="<?php echo $message['chat_id']; ?>"
                                            data-sender="<?php echo $message['sender_name']; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Regular table for larger screens -->
                        <table class="table admin-table chat-table d-none d-md-table">
                            <colgroup>
                                <col style="width: 15%;">
                                <col style="width: 70%;">
                                <col style="width: 15%;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>TIMESTAMP</th>
                                    <th>MESSAGE</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($messages as $message): ?>
                                <tr class="chat-row" data-id="<?php echo $message['chat_id']; ?>">
                                    <td data-label="TIMESTAMP"><?php echo $message['chat_time']; ?></td>
                                    <td data-label="MESSAGE">
                                        <div class="chat-message">
                                            <span class="message-sender"><?php echo $message['sender_name']; ?></span>
                                            <p class="message-text"><?php echo $message['message']; ?></p>
                                        </div>
                                    </td>
                                    <td class="action-buttons" data-label="ACTIONS">
                                        <button class="btn btn-action edit-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editMessageModal" 
                                                data-message-id="<?php echo $message['chat_id']; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-action delete-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteMessageModal" 
                                                data-message-id="<?php echo $message['chat_id']; ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="items-per-page">
                        <span>Items per page:</span>
                        <select class="form-select form-select-sm d-inline-block w-auto ms-2" id="itemsPerPageSelect">
                            <option value="10" <?php echo $itemsPerPage == 10 ? 'selected' : ''; ?>>10</option>
                            <option value="25" <?php echo $itemsPerPage == 25 ? 'selected' : ''; ?>>25</option>
                            <option value="50" <?php echo $itemsPerPage == 50 ? 'selected' : ''; ?>>50</option>
                            <option value="100" <?php echo $itemsPerPage == 100 ? 'selected' : ''; ?>>100</option>
                        </select>
                    </div>
                    
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $page-1; ?>&items_per_page=<?php echo $itemsPerPage; ?>" aria-label="Previous">
                                    Previous
                                </a>
                            </li>
                            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>&items_per_page=<?php echo $itemsPerPage; ?>"><?php echo $i; ?></a>
                            </li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $page+1; ?>&items_per_page=<?php echo $itemsPerPage; ?>" aria-label="Next">
                                    Next
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Admin JS -->
    <script src="js/admin.js"></script>
    
    <!-- Add direct delete modal for mobile view -->
    <div class="modal fade" id="mobileDeleteMessageModal" tabindex="-1" aria-labelledby="mobileDeleteMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="mobileDeleteMessageModalLabel">CONFIRM DELETION</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="delete-icon-container mb-4">
                        <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="delete-title mb-3">Are you sure?</h5>
                    <p class="delete-message mb-0">
                        You are about to delete a message from <span id="mobileSenderName" class="fw-bold"></span>. This action cannot be undone.
                    </p>
                    <input type="hidden" id="mobileMessageId">
                </div>
                <div class="modal-footer border-top-0 justify-content-center pt-0 pb-4">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-danger px-4" id="mobileConfirmDelete">
                        <i class="bi bi-trash me-2"></i>Delete Message
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Message Modal -->
    <div class="modal fade" id="editMessageModal" tabindex="-1" aria-labelledby="editMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMessageModalLabel">EDIT MESSAGE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editMessageForm">
                        <input type="hidden" id="editMessageId" name="messageId">
                        <div class="mb-4">
                            <label for="editTimestamp" class="form-label">TIMESTAMP</label>
                            <input type="text" class="form-control" id="editTimestamp" name="timestamp" readonly>
                        </div>
                        
                        <div class="mb-4">
                            <label for="editSender" class="form-label">SENDER</label>
                            <select class="form-select" id="editSender" name="sender" required>
                                <option value="Support Bot">Support Bot</option>
                                <option value="Customer">Customer</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="editMessageText" class="form-label">MESSAGE</label>
                            <textarea class="form-control" id="editMessageText" name="message" rows="5" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-save" id="saveMessageChanges">
                        <i class="bi bi-check-circle me-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Message Modal -->
    <div class="modal fade" id="deleteMessageModal" tabindex="-1" aria-labelledby="deleteMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="deleteMessageModalLabel">CONFIRM DELETION</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="delete-icon-container mb-4">
                        <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="delete-title mb-3">Are you sure?</h5>
                    <p class="delete-message mb-0">
                        You are about to delete a message from <span id="deleteMessageSender" class="fw-bold"></span>. This action cannot be undone.
                    </p>
                    <input type="hidden" id="deleteMessageId">
                </div>
                <div class="modal-footer border-top-0 justify-content-center pt-0 pb-4">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-danger px-4" id="confirmDeleteMessage">
                        <i class="bi bi-trash me-2"></i>Delete Message
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Custom script for chat buttons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile edit button click handler
            document.querySelectorAll('.mobile-edit-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    // Get data from data attributes
                    const id = this.getAttribute('data-id');
                    const timestamp = this.getAttribute('data-timestamp');
                    const sender = this.getAttribute('data-sender');
                    const message = this.getAttribute('data-message');
                    
                    // Populate the edit modal
                    document.getElementById('editMessageId').value = id;
                    document.getElementById('editTimestamp').value = timestamp;
                    
                    // Set sender dropdown
                    const senderSelect = document.getElementById('editSender');
                    for (let i = 0; i < senderSelect.options.length; i++) {
                        if (senderSelect.options[i].value === sender) {
                            senderSelect.selectedIndex = i;
                            break;
                        }
                    }
                    
                    document.getElementById('editMessageText').value = message;
                });
            });
            
            // Mobile delete button click handler
            document.querySelectorAll('.mobile-delete-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const sender = this.getAttribute('data-sender');
                    
                    // Set values in the mobile delete modal
                    document.getElementById('mobileMessageId').value = id;
                    document.getElementById('mobileSenderName').textContent = sender;
                });
            });
            
            // Mobile confirm delete button handler
            document.getElementById('mobileConfirmDelete').addEventListener('click', function() {
                const id = document.getElementById('mobileMessageId').value;
                
                // AJAX request to delete message
                deleteMessage(id, function(success) {
                    if (success) {
                        // Close the modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('mobileDeleteMessageModal'));
                        modal.hide();
                        
                        // Remove the message card from the DOM
                        const card = document.querySelector(`.chat-card[data-id="${id}"]`);
                        if (card) {
                            card.remove();
                        }
                        
                        // Show success notification
                        showNotification(`Success! Message has been deleted.`);
                    }
                });
            });
            
            // Desktop table edit button handler
            document.querySelectorAll('.edit-btn:not(.mobile-edit-btn)').forEach(function(button) {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const id = this.getAttribute('data-message-id') || row.dataset.id;
                    const timestamp = row.querySelector('td[data-label="TIMESTAMP"]').textContent.trim();
                    const sender = row.querySelector('.message-sender').textContent.trim();
                    const messageText = row.querySelector('.message-text').textContent.trim();
                    
                    // Populate the modal
                    document.getElementById('editMessageId').value = id;
                    document.getElementById('editTimestamp').value = timestamp;
                    
                    // Set the correct sender option
                    const senderSelect = document.getElementById('editSender');
                    for (let i = 0; i < senderSelect.options.length; i++) {
                        if (senderSelect.options[i].value === sender) {
                            senderSelect.selectedIndex = i;
                            break;
                        }
                    }
                    
                    document.getElementById('editMessageText').value = messageText;
                });
            });
            
            // Desktop table delete button handler
            document.querySelectorAll('.delete-btn:not(.mobile-delete-btn)').forEach(function(button) {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const id = this.getAttribute('data-message-id') || row.dataset.id;
                    const sender = row.querySelector('.message-sender').textContent.trim();
                    
                    // Set values in the delete modal
                    document.getElementById('deleteMessageId').value = id;
                    document.getElementById('deleteMessageSender').textContent = sender;
                });
            });
            
            // Desktop confirm delete button handler
            document.getElementById('confirmDeleteMessage').addEventListener('click', function() {
                const id = document.getElementById('deleteMessageId').value;
                
                // AJAX request to delete message
                deleteMessage(id, function(success) {
                    if (success) {
                        // Close the modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteMessageModal'));
                        modal.hide();
                        
                        // Remove the message row from the DOM
                        const row = document.querySelector(`tr[data-id="${id}"]`);
                        if (row) {
                            row.remove();
                        }
                        
                        // Show success notification
                        showNotification(`Success! Message has been deleted.`);
                    }
                });
            });
            
            // Save message changes button handler
            document.getElementById('saveMessageChanges').addEventListener('click', function() {
                const messageId = document.getElementById('editMessageId').value;
                const sender = document.getElementById('editSender').value;
                const messageText = document.getElementById('editMessageText').value;
                
                // Validate form
                if (!messageText) {
                    document.getElementById('editMessageText').classList.add('is-invalid');
                    showNotification('Message text is required.', 'danger');
                    return;
                }
                
                // Send AJAX request to update the message
                const formData = new FormData();
                formData.append('messageId', messageId);
                formData.append('sender', sender);
                formData.append('message', messageText);
                
                // Show loading state
                const saveButton = this;
                setButtonLoading(saveButton, true);
                
                fetch('components/edit_chat_message.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    if (result.trim() === 'success') {
                        // Update UI with new message
                        updateMessageInUI(messageId, sender, messageText);
                        
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editMessageModal'));
                        modal.hide();
                        
                        // Show success notification
                        showNotification('Message updated successfully.');
                    } else {
                        showNotification('Failed to update message.', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred while updating the message.', 'danger');
                })
                .finally(() => {
                    setButtonLoading(saveButton, false);
                });
            });
            
            // Items per page change handler
            document.getElementById('itemsPerPageSelect').addEventListener('change', function() {
                const newItemsPerPage = this.value;
                window.location.href = `?page=1&items_per_page=${newItemsPerPage}`;
            });
            
            // Function to update message in UI
            function updateMessageInUI(messageId, sender, messageText) {
                // Update in desktop view
                const row = document.querySelector(`tr[data-id="${messageId}"]`);
                if (row) {
                    const senderElement = row.querySelector('.message-sender');
                    const textElement = row.querySelector('.message-text');
                    if (senderElement) senderElement.textContent = sender;
                    if (textElement) textElement.textContent = messageText;
                }
                
                // Update in mobile view
                const card = document.querySelector(`.chat-card[data-id="${messageId}"]`);
                if (card) {
                    const senderElement = card.querySelector('.chat-card-row:nth-child(2) .chat-card-value');
                    const textElement = card.querySelector('.message-text');
                    if (senderElement) senderElement.textContent = sender;
                    if (textElement) textElement.textContent = messageText;
                    
                    // Update data attributes for future edits
                    const editBtn = card.querySelector('.mobile-edit-btn');
                    if (editBtn) {
                        editBtn.setAttribute('data-sender', sender);
                        editBtn.setAttribute('data-message', messageText);
                    }
                }
            }
            
            // Function to delete message via AJAX
            function deleteMessage(messageId, callback) {
                const formData = new FormData();
                formData.append('messageId', messageId);
                
                fetch('components/delete_chat_message.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    if (result.trim() === 'success') {
                        callback(true);
                    } else {
                        showNotification('Failed to delete message.', 'danger');
                        callback(false);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred while deleting the message.', 'danger');
                    callback(false);
                });
            }
            
            // Function to show notification
            function showNotification(message, type = 'success') {
                // Clear any existing notifications first
                const notificationContainer = document.getElementById('notifications-container');
                notificationContainer.innerHTML = '';
                
                // Create the new notification
                const notification = document.createElement('div');
                notification.className = `alert alert-${type} alert-dismissible fade show`;
                notification.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                notificationContainer.appendChild(notification);
                
                // Auto dismiss after 3 seconds
                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }
            
            // Function to set button loading state
            function setButtonLoading(button, loading) {
                if (loading) {
                    const originalContent = button.innerHTML;
                    button.setAttribute('data-original-content', originalContent);
                    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
                    button.disabled = true;
                } else {
                    const originalContent = button.getAttribute('data-original-content');
                    button.innerHTML = originalContent;
                    button.disabled = false;
                }
            }
        });
    </script>
</body>
</html>