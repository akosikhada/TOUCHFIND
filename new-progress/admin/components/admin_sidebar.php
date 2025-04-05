<!-- Admin Sidebar -->
<div class="admin-brand mb-4">
    <h5 class="text-white mb-0">ADMIN</h5>
</div>

<nav class="admin-nav">
    <a href="product_list.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'product_list.php') ? 'active' : ''; ?>">
        <i class="bi bi-cart nav-icon"></i>
        PRODUCT
    </a>
    
    <a href="add_product.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'add_product.php') ? 'active' : ''; ?>">
        <i class="bi bi-plus-circle nav-icon"></i>
        ADD PRODUCT
    </a>
    
    <a href="chatbot.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'chatbot.php') ? 'active' : ''; ?>">
        <i class="bi bi-chat-dots nav-icon"></i>
        CHAT
    </a>
</nav>

<div class="admin-logout">
    <a href="login.php" class="logout-link">
        <i class="bi bi-box-arrow-right nav-icon"></i>
        LOGOUT
    </a>
</div>