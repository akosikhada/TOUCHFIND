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
        /* Chat interface modern styling */
        .chat-container {
            background-color: #f9f9f9;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .chat-header {
            background-color: #c32424;
            color: white;
            padding: 16px 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .chat-header .bi-chat-dots {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .chat-filters {
            background-color: #f8f9fa;
            padding: 16px 20px;
            border-bottom: 1px solid #e8e8e8;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .filter-header {
            margin-bottom: 12px;
        }
        
        .filter-header h6 {
            color: #333;
            font-weight: 600;
            margin: 0;
            font-size: 0.95rem;
        }
        
        .filter-body {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .filter-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }
        
        .filter-label {
            font-weight: 500;
            font-size: 0.8rem;
            color: #555;
            text-transform: uppercase;
        }
        
        .filter-select {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px 12px;
            font-size: 0.9rem;
            width: 100%;
            color: #333;
            height: 42px;
        }
        
        .btn-apply-filters {
            background-color: #c32424;
            color: white;
            border: none;
            padding: 12px 16px;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-left: auto;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-width: 120px;
        }
        
        .btn-apply-filters i {
            font-size: 1rem;
        }
        
        .btn-apply-filters:hover {
            background-color: #a71f1f;
            color: white;
        }
        
        /* Message styling */
        .message-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
            margin-bottom: 12px;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        
        .message-card:hover {
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
        
        .message-card.bot-message {
            border-left-color: #2e86de;
        }
        
        .message-card.customer-message {
            border-left-color: #20bf6b;
        }
        
        .message-header {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .message-sender {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .message-sender i {
            font-size: 1rem;
        }
        
        .message-timestamp {
            font-size: 0.8rem;
            color: #777;
        }
        
        .message-content {
            padding: 12px 16px;
            color: #444;
            line-height: 1.5;
        }
        
        .message-actions {
            padding: 8px 16px;
            background-color: #f9f9f9;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }
        
        .btn-message-action {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 4px 10px;
            font-size: 0.85rem;
            color: #555;
            transition: all 0.2s ease;
        }
        
        .btn-message-action:hover {
            background-color: #f5f5f5;
            color: #333;
        }
        
        .btn-message-action.edit {
            color: #2e86de;
        }
        
        .btn-message-action.delete {
            color: #e74c3c;
        }
        
        .btn-message-action.edit:hover {
            background-color: #2e86de;
            color: white;
            border-color: #2e86de;
        }
        
        .btn-message-action.delete:hover {
            background-color: #e74c3c;
            color: white;
            border-color: #e74c3c;
        }
        
        /* Enhanced pagination */
        .pagination-container {
            background-color: white;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }
        
        .pagination {
            margin-bottom: 0;
        }
        
        .page-link {
            border: none;
            margin: 0 3px;
            border-radius: 4px;
            color: #555;
            font-weight: 500;
        }
        
        .page-item.active .page-link {
            background-color: #c32424;
            color: white;
        }
        
        .items-per-page {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .items-per-page span {
            color: #555;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        /* Enhanced notification */
        #notifications-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            width: 300px;
        }
        
        .alert {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            animation: slideIn 0.3s ease forwards;
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        /* Enhanced modal styles */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eaeaea;
            border-radius: 12px 12px 0 0;
        }
        
        .modal-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #eaeaea;
            border-radius: 0 0 12px 12px;
        }
        
        #editMessageText {
            resize: none;
            min-height: 120px;
        }
        
        /* Enhanced search box styling */
        .search-box {
            position: relative;
            width: 100%;
        }
        
        .search-box input {
            padding-right: 40px;
            height: 42px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            background-color: white;
            transition: all 0.3s ease;
        }
        
        .search-box input:focus {
            border-color: #c32424;
            box-shadow: 0 0 0 0.2rem rgba(195, 36, 36, 0.15);
        }
        
        .search-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            font-size: 16px;
            pointer-events: none;
        }
        
        /* Responsive improvements */
        @media (max-width: 991.98px) {
            .admin-main {
                padding-left: 0;
            }
        }
        
        /* Laptop specific styles to fix Apply Filters button alignment */
        @media (min-width: 992px) {
            .filter-sort-container {
                padding: 15px 20px;
            }
            
            .filter-sort-container .row {
                display: flex;
                flex-wrap: nowrap;
                align-items: flex-start;
                margin: 0 -8px;
            }
            
            .filter-sort-container .col-lg-3,
            .filter-sort-container .col-lg-4, 
            .filter-sort-container .col-lg-2 {
                padding: 0 8px;
                margin-bottom: 0;
            }
            
            .filter-item {
                margin-bottom: 0;
            }
            
            .filter-sort-container .filter-label {
                margin-bottom: 8px;
                font-size: 0.8rem;
                font-weight: 500;
            }
            
            .filter-sort-container .col-lg-3 {
                flex: 0 0 20%;
                max-width: 20%;
            }
            
            .filter-sort-container .col-lg-4 {
                flex: 0 0 40%;
                max-width: 40%;
            }
            
            .filter-sort-container .col-lg-2 {
                flex: 0 0 20%;
                max-width: 20%;
            }
            
            .filter-sort-container .form-select,
            .filter-sort-container .form-control,
            .filter-sort-container .btn-apply-filters {
                height: 38px;
            }
            
            .filter-sort-container .btn-apply-filters {
                padding: 6px 15px;
                width: 100%;
                font-size: 0.9rem;
                white-space: nowrap;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #c32424;
                color: white;
                border: none;
                border-radius: 4px;
                margin-top: 28px; /* Match the height of label + margin */
            }
            
            .filter-sort-container .btn-apply-filters i {
                margin-right: 6px;
                font-size: 0.85rem;
            }
        }
        
        @media (max-width: 767.98px) {
            .message-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            
            .message-timestamp {
                font-size: 0.75rem;
            }
            
            .chat-header {
                padding: 12px 16px;
            }
            
            .pagination-container {
                padding: 12px;
            }
            
            .items-per-page {
                margin-bottom: 1rem;
            }
            
            .search-box {
                width: 100%;
                margin-bottom: 10px;
            }
            
            .filter-sort-container {
                padding: 15px;
            }
            
            .filter-sort-container .col-lg-4 {
                margin-bottom: 10px;
            }
            
            .filter-sort-container .btn-apply-filters {
                margin-top: 5px;
            }
            
            .d-flex.justify-content-between.align-items-center.mb-4 {
                flex-direction: column;
                align-items: flex-start !important;
            }
            
            .d-flex.align-items-center {
                width: 100%;
                flex-direction: column;
                align-items: flex-start !important;
            }
            
            .admin-page-title {
                margin-bottom: 15px;
                font-size: 1.5rem;
            }
            
            .filter-body {
                flex-direction: column;
                gap: 12px;
            }
            
            .filter-item {
                width: 100%;
                min-width: unset;
            }
            
            .btn-apply-filters {
                width: 100%;
                justify-content: center;
                margin-top: 8px;
            }
            
            .chat-filters {
                padding: 12px 16px;
            }
        }
        
        /* Inline filter & sort styling */
        .filter-sort-container {
            background-color: #f9f9f9;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 20px;
        }
        
        .filter-sort-heading {
            color: #333;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }
        
        .filter-label {
            font-weight: 500;
            font-size: 0.85rem;
            color: #555;
        }
        
        .btn-apply-filters {
            background-color: #c32424;
            color: white;
            border: none;
            height: 40px;
            padding: 0 15px;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-apply-filters:hover {
            background-color: #a71f1f;
            color: white;
        }
        
        /* Tablet layout (768px to 991px) */
        @media (min-width: 768px) and (max-width: 991px) {
            .filter-sort-container {
                padding: 16px;
            }
            
            .filter-row {
                display: flex;
                flex-wrap: wrap;
                margin: 0 -8px;
            }
            
            /* Force 2x2 grid on tablets */
            .sender-col {
                width: 50%;
                padding-right: 8px;
                margin-bottom: 16px;
                order: 1;
            }
            
            .sort-col {
                width: 50%;
                padding-left: 8px;
                margin-bottom: 16px;
                order: 2;
            }
            
            .search-col {
                width: 50%;
                padding-right: 8px;
                order: 3;
            }
            
            .button-col {
                width: 50%;
                padding-left: 8px;
                order: 4;
                display: flex;
                align-items: flex-end;
            }
            
            /* Align elements perfectly */
            .filter-button-wrapper {
                width: 100%;
                margin-top: 0;
            }
            
            /* Vertical spacing between rows */
            .search-col .filter-item, 
            .button-col .filter-item {
                margin-top: 0;
            }
            
            /* Remove extra bottom margin */
            .filter-col {
                margin-bottom: 0;
            }
            
            /* Align button with search field */
            .button-col .filter-item {
                margin-top: 24px; /* Match label height */
            }
            
            /* Ensure consistent form control heights */
            .filter-sort-container .form-select,
            .filter-sort-container .form-control,
            .filter-sort-container .btn-apply-filters {
                height: 38px;
            }
            
            /* Fix specifically for tablet view */
            .button-col {
                padding-top: 0;
                padding-bottom: 0;
            }
            
            /* Make button same height as search field */
            .filter-button-wrapper {
                margin-top: 24px; /* Match label height exactly */
            }
            
            /* Remove any unnecessary spacing */
            .filter-col {
                margin-bottom: 0;
            }
        }
        
        /* Filter row custom layout */
        .filter-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -8px;
        }
        
        .filter-col {
            padding: 0 8px;
            margin-bottom: 15px;
        }
        
        .filter-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 0;
        }
        
        .filter-label {
            font-weight: 500;
            font-size: 0.85rem;
            color: #555;
            margin-bottom: 8px;
        }
        
        .sender-col, .sort-col {
            width: 50%;
        }
        
        .search-col {
            width: 100%;
        }
        
        .button-col {
            width: 100%;
        }
        
        .btn-apply-filters {
            height: 38px;
            padding: 6px 15px;
            font-size: 0.9rem;
            background-color: #c32424;
            color: white;
            border: none;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-apply-filters i {
            margin-right: 6px;
            font-size: 0.85rem;
        }
        
        /* Desktop layout (992px and up) */
        @media (min-width: 992px) {
            .filter-row {
                flex-wrap: nowrap;
                align-items: flex-end;
            }
            
            .filter-col {
                margin-bottom: 0;
            }
            
            .sender-col, .sort-col {
                width: 20%;
            }
            
            .search-col {
                width: 40%;
            }
            
            .button-col {
                width: 20%;
            }
            
            .button-col .filter-item {
                margin-top: 24px;
            }
            
            /* Fix for button alignment */
            .filter-button-wrapper {
                margin-top: 0;
            }
        }
        
        /* Filter button wrapper */
        .filter-button-wrapper {
            height: 100%;
            display: flex;
            align-items: flex-end;
        }
        
        .filter-button-wrapper .btn-apply-filters {
            width: 100%;
        }
    </style>
</head>
<body>
    <?php include 'components/edit_product.php'; ?>
    <?php include 'components/delete_product.php'; ?>
    <?php include 'components/admin_header.php'; ?>
    
    <!-- Add notifications container -->
    <div id="notifications-container"></div>
    
    <div class="d-flex admin-dashboard">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <?php include 'components/admin_sidebar.php'; ?>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-main">
            <div class="container-fluid px-4 py-4">
                <!-- Custom responsive header for mobile view -->
                <div class="d-flex flex-column mb-4">
                    <h1 class="admin-page-title">CHAT RESPONSES</h1>
                </div>
                
                <!-- Include the fetch_chat_messages.php to get messages from DB -->
                <?php include 'components/fetch_chat_messages.php'; ?>
                
                <!-- Simple inline filter area that matches the screenshot -->
                <div class="filter-sort-container mb-4">
                    <h6 class="filter-sort-heading mb-3">FILTER & SORT</h6>
                    <div class="filter-row">
                        <div class="filter-col sender-col">
                            <div class="filter-item">
                                <label for="inlineSenderFilter" class="filter-label">SENDER:</label>
                                <select class="form-select" id="inlineSenderFilter">
                                    <option value="">All Senders</option>
                                    <option value="Support Bot">Support Bot</option>
                                    <option value="Customer">Customer</option>
                                </select>
                            </div>
                        </div>
                        <div class="filter-col sort-col">
                            <div class="filter-item">
                                <label for="inlineSortOrder" class="filter-label">SORT BY:</label>
                                <select class="form-select" id="inlineSortOrder">
                                    <option value="newest">Newest First</option>
                                    <option value="oldest">Oldest First</option>
                                </select>
                            </div>
                        </div>
                        <div class="filter-col search-col">
                            <div class="filter-item">
                                <label for="search-chat-responses" class="filter-label">SEARCH:</label>
                                <div class="search-box">
                                    <input type="text" class="form-control" id="search-chat-responses" placeholder="Search messages..." data-search-target="chat-responses">
                                    <i class="bi bi-search search-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="filter-col button-col">
                            <div class="filter-button-wrapper">
                                <button class="btn btn-apply-filters" id="applyInlineFilters">
                                    <i class="bi bi-check2"></i>Apply Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Chat Container -->
                <div class="chat-container">
                    <div class="chat-header">
                        <div>
                            <i class="bi bi-chat-dots"></i>
                            <span>CONVERSATION HISTORY</span>
                        </div>
                        <span class="badge bg-light text-dark"><?php echo $totalMessages; ?> Messages</span>
                    </div>
                    
                    <!-- Message list -->
                    <div class="p-3" id="message-list">
                        <?php foreach ($messages as $message): ?>
                        <div class="message-card <?php echo strtolower(str_replace(' ', '-', $message['sender_name'])); ?>-message" 
                             data-id="<?php echo $message['chat_id']; ?>"
                             data-sender="<?php echo $message['sender_name']; ?>">
                            <div class="message-header">
                                <div class="message-sender">
                                    <i class="bi <?php echo ($message['sender_name'] == 'Support Bot' || $message['sender_name'] == 'Bot') ? 'bi-robot' : 'bi-person-circle'; ?>"></i>
                                    <span><?php echo $message['sender_name']; ?></span>
                                </div>
                                <div class="message-timestamp">
                                    <i class="bi bi-clock"></i>
                                    <?php echo $message['chat_time']; ?>
                                </div>
                            </div>
                            <div class="message-content">
                                <?php echo $message['message']; ?>
                            </div>
                            <div class="message-actions">
                                <button class="btn-message-action edit" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editMessageModal" 
                                        data-id="<?php echo $message['chat_id']; ?>"
                                        data-timestamp="<?php echo $message['chat_time']; ?>"
                                        data-sender="<?php echo $message['sender_name']; ?>"
                                        data-message="<?php echo htmlspecialchars($message['message']); ?>">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <button class="btn-message-action delete" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteMessageModal" 
                                        data-id="<?php echo $message['chat_id']; ?>"
                                        data-sender="<?php echo $message['sender_name']; ?>">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <div class="items-per-page mb-3 mb-md-0">
                            <span>Items per page:</span>
                            <select class="form-select form-select-sm d-inline-block w-auto" id="itemsPerPageSelect">
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
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                                <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>&items_per_page=<?php echo $itemsPerPage; ?>"><?php echo $i; ?></a>
                                </li>
                                <?php endfor; ?>
                                <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $page+1; ?>&items_per_page=<?php echo $itemsPerPage; ?>" aria-label="Next">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Admin JS -->
    <script src="js/admin.js"></script>
    
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
                                <option value="Bot">Bot</option>
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
                    <button type="button" class="btn btn-primary" id="saveMessageChanges">
                        <i class="bi bi-check-circle me-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Custom script for chat functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Edit message handlers
            document.querySelectorAll('.btn-message-action.edit').forEach(function(button) {
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
            
            // Handle inline filter application
            document.getElementById('applyInlineFilters').addEventListener('click', function() {
                const sender = document.getElementById('inlineSenderFilter').value;
                const sortOrder = document.getElementById('inlineSortOrder').value;
                const searchTerm = document.getElementById('search-chat-responses').value.toLowerCase().trim();
                
                applyFiltersAndSearch(sender, sortOrder, searchTerm);
                
                // Show notification
                showNotification('Filters applied successfully.');
            });
            
            // Function to apply filters and search
            function applyFiltersAndSearch(sender, sortOrder, searchTerm) {
                // Filter by sender and search term
                const messageCards = document.querySelectorAll('.message-card');
                
                messageCards.forEach(card => {
                    const cardSender = card.getAttribute('data-sender');
                    const messageContent = card.querySelector('.message-content').textContent.toLowerCase();
                    
                    // Check if card matches both sender filter and search term
                    const matchesSender = !sender || cardSender === sender;
                    const matchesSearch = !searchTerm || 
                                         messageContent.includes(searchTerm) || 
                                         cardSender.toLowerCase().includes(searchTerm);
                    
                    // Show only if both conditions are met
                    if (matchesSender && matchesSearch) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // Sort messages
                const messageList = document.getElementById('message-list');
                const visibleCards = Array.from(document.querySelectorAll('.message-card')).filter(
                    card => card.style.display !== 'none'
                );
                
                visibleCards.sort((a, b) => {
                    const aTime = a.querySelector('.message-timestamp').textContent.trim();
                    const bTime = b.querySelector('.message-timestamp').textContent.trim();
                    
                    if (sortOrder === 'oldest') {
                        return aTime.localeCompare(bTime);
                    } else {
                        return bTime.localeCompare(aTime);
                    }
                });
                
                messageList.innerHTML = '';
                visibleCards.forEach(card => messageList.appendChild(card));
            }
            
            // Delete message handlers
            document.querySelectorAll('.btn-message-action.delete').forEach(function(button) {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const sender = this.getAttribute('data-sender');
                    
                    // Set values in the delete modal
                    document.getElementById('deleteMessageId').value = id;
                    document.getElementById('deleteMessageSender').textContent = sender;
                });
            });
            
            // Confirm delete button handler
            document.getElementById('confirmDeleteMessage').addEventListener('click', function() {
                const id = document.getElementById('deleteMessageId').value;
                
                // AJAX request to delete message
                deleteMessage(id, function(success) {
                    if (success) {
                        // Close the modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteMessageModal'));
                        modal.hide();
                        
                        // Remove the message card from the DOM
                        const card = document.querySelector(`.message-card[data-id="${id}"]`);
                        if (card) {
                            card.remove();
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
                const card = document.querySelector(`.message-card[data-id="${messageId}"]`);
                if (card) {
                    // Update sender class if needed
                    if (card.getAttribute('data-sender') !== sender) {
                        card.classList.remove('support-bot-message', 'customer-message', 'bot-message');
                        card.classList.add(sender.toLowerCase().replace(' ', '-') + '-message');
                        card.setAttribute('data-sender', sender);
                        
                        // Update sender icon and text
                        const senderElement = card.querySelector('.message-sender');
                        const iconElement = senderElement.querySelector('i');
                        
                        iconElement.className = `bi ${(sender === 'Support Bot' || sender === 'Bot') ? 'bi-robot' : 'bi-person-circle'}`;
                        senderElement.querySelector('span').textContent = sender;
                    }
                    
                    // Update message content
                    card.querySelector('.message-content').textContent = messageText;
                    
                    // Update data attributes for future edits
                    const editBtn = card.querySelector('.btn-message-action.edit');
                    if (editBtn) {
                        editBtn.setAttribute('data-sender', sender);
                        editBtn.setAttribute('data-message', messageText);
                    }
                    
                    // Update delete button if needed
                    const deleteBtn = card.querySelector('.btn-message-action.delete');
                    if (deleteBtn) {
                        deleteBtn.setAttribute('data-sender', sender);
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