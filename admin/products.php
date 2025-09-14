<?php
// Admin product management page
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

include '../includes/header.php';
include '../includes/config.php';
include '../includes/functions.php';

// Handle product deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $product_id = (int)$_GET['delete'];
    if (deleteProduct($product_id)) {
        $success_message = "Product deleted successfully!";
    } else {
        $error_message = "Error deleting product.";
    }
}

// Get all products for admin view
$products = searchProducts('', [], 'created_at', 'DESC', 1, 100); // Get more products for admin
$categories = getAllCategories();
?>

<div class="container">
    <!-- Admin Navigation -->
    <nav class="admin-nav">
        <div class="container">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="products.php" class="active">Products</a></li>
                <li><a href="add_product.php">Add Product</a></li>
            </ul>
        </div>
    </nav>

    <div class="admin-header">
        <h1>Product Management</h1>
        <a href="add_product.php" class="button">Add New Product</a>
    </div>

    <?php if (isset($success_message)): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <!-- Products Table -->
    <table class="admin-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Rating</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="9" style="text-align: center; padding: 40px;">
                        <p>No products found. <a href="add_product.php">Add your first product</a></p>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <?php if ($product['image_url']): ?>
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            <?php else: ?>
                                <div style="width: 50px; height: 50px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 4px; font-size: 10px;">No Image</div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                            <br><small><?php echo htmlspecialchars($product['sku']); ?></small>
                        </td>
                        <td><?php echo htmlspecialchars($product['category_name'] ?? 'Uncategorized'); ?></td>
                        <td><?php echo htmlspecialchars($product['brand'] ?? '-'); ?></td>
                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                        <td>
                            <?php if ($product['stock_quantity'] > 0): ?>
                                <span class="in-stock"><?php echo $product['stock_quantity']; ?></span>
                            <?php else: ?>
                                <span class="out-of-stock">Out of Stock</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="status-<?php echo $product['status']; ?>">
                                <?php echo ucfirst(str_replace('_', ' ', $product['status'])); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($product['rating'] > 0): ?>
                                <?php echo number_format($product['rating'], 1); ?> ★ (<?php echo $product['review_count']; ?>)
                            <?php else: ?>
                                No ratings
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="admin-actions">
                                <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="edit">Edit</a>
                                <a href="?delete=<?php echo $product['id']; ?>" 
                                   class="delete" 
                                   onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Quick Stats -->
    <div class="admin-stats">
        <div class="stat-card">
            <h3>Total Products</h3>
            <p><?php echo count($products); ?></p>
        </div>
        <div class="stat-card">
            <h3>Categories</h3>
            <p><?php echo count($categories); ?></p>
        </div>
        <div class="stat-card">
            <h3>Out of Stock</h3>
            <p><?php echo count(array_filter($products, function($p) { return $p['stock_quantity'] == 0; })); ?></p>
        </div>
    </div>
</div>

<style>
.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.success-message {
    background: #d4edda;
    color: #155724;
    padding: 12px 15px;
    border: 1px solid #c3e6cb;
    border-radius: 4px;
    margin-bottom: 20px;
}

.error-message {
    background: #f8d7da;
    color: #721c24;
    padding: 12px 15px;
    border: 1px solid #f5c6cb;
    border-radius: 4px;
    margin-bottom: 20px;
}

.status-active {
    color: #28a745;
    font-weight: 500;
}

.status-inactive {
    color: #6c757d;
    font-weight: 500;
}

.status-out_of_stock {
    color: #dc3545;
    font-weight: 500;
}

.admin-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    text-align: center;
}

.stat-card h3 {
    margin: 0 0 10px 0;
    color: #666;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-card p {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #333;
}
</style>

</body>
</html>
