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
</head>
<body>
    <?php include 'components/edit_product.php'; ?>
    <?php include 'components/delete_product.php'; ?>
    <?php include 'components/admin_header.php'; ?>
    
    <div class="d-flex admin-dashboard">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <?php include 'components/admin_sidebar.php'; ?>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-main">
            <div class="container-fluid px-4 py-4">
                <?php renderAdminHeader('CHAT RESPONSES', 'Search messages...'); ?>
                
                <!-- Chat Responses Table -->
                <div class="admin-table-container">
                    <div class="table-responsive">
                        <table class="table admin-table chat-table">
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
                                <tr>
                                    <td>2024-01-20 09:15</td>
                                    <td>
                                        <div class="chat-message">
                                            <div class="message-sender">Support Bot</div>
                                            <div class="message-text">Hello! How can I assist you today?</div>
                                        </div>
                                    </td>
                                    <td class="action-buttons">
                                        <?php echo renderActionButtons('message', '1'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2024-01-20 09:16</td>
                                    <td>
                                        <div class="chat-message">
                                            <div class="message-sender">Customer</div>
                                            <div class="message-text">I need help with my order #TL-1001</div>
                                        </div>
                                    </td>
                                    <td class="action-buttons">
                                        <?php echo renderActionButtons('message', '2'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2024-01-20 09:16</td>
                                    <td>
                                        <div class="chat-message">
                                            <div class="message-sender">Support Bot</div>
                                            <div class="message-text">I'll help you track your order. Let me check the status.</div>
                                        </div>
                                    </td>
                                    <td class="action-buttons">
                                        <?php echo renderActionButtons('message', '3'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2024-01-20 09:17</td>
                                    <td>
                                        <div class="chat-message">
                                            <div class="message-sender">Support Bot</div>
                                            <div class="message-text">Your order is currently in transit and will be delivered today.</div>
                                        </div>
                                    </td>
                                    <td class="action-buttons">
                                        <?php echo renderActionButtons('message', '4'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2024-01-20 09:18</td>
                                    <td>
                                        <div class="chat-message">
                                            <div class="message-sender">Customer</div>
                                            <div class="message-text">Thank you for the information!</div>
                                        </div>
                                    </td>
                                    <td class="action-buttons">
                                        <?php echo renderActionButtons('message', '5'); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="items-per-page">
                        <span>Items per page:</span>
                        <select class="form-select form-select-sm d-inline-block w-auto ms-2">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    Previous
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
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
    <?php echo renderDeleteModal('message'); ?>
</body>
</html>