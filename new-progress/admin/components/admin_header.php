<?php
/**
 * Admin Header Component
 * Displays the page title, and optionally search bar and filter button
 * 
 * @param string $pageTitle The title of the admin page
 * @param string $searchPlaceholder The placeholder text for the search box
 * @param bool $showSearch Whether to show the search box and filter button
 */
function renderAdminHeader($pageTitle, $searchPlaceholder = 'Search...', $showSearch = true) {
    // Clean up page title for use in IDs and data attributes
    $pageName = strtolower(str_replace([' ', '/'], ['-', '-'], $pageTitle));
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="admin-page-title"><?php echo $pageTitle; ?></h1>
    
    <?php if ($showSearch): ?>
    <div class="d-flex align-items-center">
        <div class="search-box">
            <input type="text" class="form-control" placeholder="<?php echo $searchPlaceholder; ?>" id="search-<?php echo $pageName; ?>" data-search-target="<?php echo $pageName; ?>">
            <i class="bi bi-search search-icon"></i>
        </div>
        
        <button class="btn btn-filter" id="filter-<?php echo $pageName; ?>" data-filter-target="<?php echo $pageName; ?>">
            <i class="bi bi-funnel-fill"></i>
            Filter
        </button>
    </div>
    <?php endif; ?>
</div>

<!-- Notifications Container -->
<div id="notifications-container" class="mb-3"></div>
<?php
}
?>
