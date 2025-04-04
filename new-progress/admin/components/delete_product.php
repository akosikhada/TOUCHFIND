<?php
/**
 * Renders the delete confirmation modal HTML for various item types
 * 
 * @param string $type The type of item being deleted (product, delivery, message)
 * @return string HTML for the delete modal
 */
function renderDeleteModal($type) {
    // Set modal-specific attributes based on type
    $modalConfig = [
        'product' => [
            'id' => 'deleteProductModal',
            'label' => 'deleteProductModalLabel',
            'title' => 'CONFIRM DELETION',
            'heading' => 'Are you sure?',
            'message' => 'You are about to delete "<span id="deleteProductName" class="fw-bold"></span>". This action cannot be undone.',
            'hidden_id' => 'deleteProductId',
            'confirm_id' => 'confirmDeleteProduct',
            'button_text' => 'Delete Product'
        ],
        'delivery' => [
            'id' => 'deleteDeliveryModal',
            'label' => 'deleteDeliveryModalLabel',
            'title' => 'CONFIRM DELETION',
            'heading' => 'Are you sure?',
            'message' => 'You are about to delete delivery <span id="deleteDeliveryOrder" class="fw-bold"></span> for <span id="deleteDeliveryCustomer" class="fw-bold"></span>. This action cannot be undone.',
            'hidden_id' => 'deleteDeliveryId',
            'confirm_id' => 'confirmDeleteDelivery',
            'button_text' => 'Delete Delivery'
        ],
        'message' => [
            'id' => 'deleteMessageModal',
            'label' => 'deleteMessageModalLabel',
            'title' => 'CONFIRM DELETION',
            'heading' => 'Are you sure?',
            'message' => 'You are about to delete a message from <span id="deleteMessageSender" class="fw-bold"></span>. This action cannot be undone.',
            'hidden_id' => 'deleteMessageId',
            'confirm_id' => 'confirmDeleteMessage',
            'button_text' => 'Delete Message'
        ]
    ];
    
    // Check if the type exists in our configuration
    if (!array_key_exists($type, $modalConfig)) {
        return "<!-- Error: Invalid type '{$type}' provided to renderDeleteModal -->";
    }
    
    $config = $modalConfig[$type];
    
    // Build the modal HTML
    return <<<HTML
<!-- Delete {$type} Modal -->
<div class="modal fade" id="{$config['id']}" tabindex="-1" aria-labelledby="{$config['label']}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="{$config['label']}">{$config['title']}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="delete-icon-container mb-4">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h5 class="delete-title mb-3">{$config['heading']}</h5>
                <p class="delete-message mb-0">
                    {$config['message']}
                </p>
                <input type="hidden" id="{$config['hidden_id']}">
            </div>
            <div class="modal-footer border-top-0 justify-content-center pt-0 pb-4">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-danger px-4" id="{$config['confirm_id']}">
                    <i class="bi bi-trash me-2"></i>{$config['button_text']}
                </button>
            </div>
        </div>
    </div>
</div>
HTML;
}
?>
