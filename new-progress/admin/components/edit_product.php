<?php
/**
 * Reusable edit button component for admin pages
 * 
 * @param string $type Type of item being edited (product, delivery, message)
 * @param string $id The ID of the item to edit
 * @param string $extraClasses Additional CSS classes
 * @return string HTML for the edit button
 */
function renderEditButton($type, $id, $extraClasses = '') {
    $buttonClass = "{$type}-edit-btn";
    $dataAttr = "data-{$type}-id";
    
    return <<<HTML
    <button class="btn btn-edit {$buttonClass} {$extraClasses}" {$dataAttr}="{$id}">
        <i class="bi bi-pencil"></i>
    </button>
HTML;
}

/**
 * Reusable delete button component for admin pages
 * 
 * @param string $type Type of item being deleted (product, delivery, message)
 * @param string $id The ID of the item to delete
 * @param string $extraClasses Additional CSS classes
 * @return string HTML for the delete button
 */
function renderDeleteButton($type, $id, $extraClasses = '') {
    $buttonClass = "{$type}-delete-btn";
    $dataAttr = "data-{$type}-id";
    
    return <<<HTML
    <button class="btn btn-delete {$buttonClass} {$extraClasses}" {$dataAttr}="{$id}">
        <i class="bi bi-trash"></i>
    </button>
HTML;
}

/**
 * Renders edit and delete buttons for admin tables
 * 
 * @param string $type The type of item ('product', 'delivery', or 'message')
 * @param string $id The ID of the item
 * @return string HTML for the action buttons
 */
function renderActionButtons($type, $id) {
    // Simplify button attributes to ensure consistency
    return <<<HTML
    <div class="d-inline-flex gap-2 justify-content-center">
        <button class="btn btn-action edit-btn" 
                data-bs-toggle="modal" 
                data-bs-target="#edit{$type}Modal" 
                data-{$type}-id="{$id}">
            <i class="bi bi-pencil-square"></i>
        </button>
        <button class="btn btn-action delete-btn" 
                data-bs-toggle="modal" 
                data-bs-target="#delete{$type}Modal" 
                data-{$type}-id="{$id}">
            <i class="bi bi-trash"></i>
        </button>
    </div>
HTML;
}   
?>
