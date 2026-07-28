<?php
// Main page entry point
include 'includes/header.php';
include 'includes/config.php';
include 'includes/functions.php';

// Get featured products (latest 6 products)
$featured_products = searchProducts('', [], 'created_at', 'DESC', 1, 6);
$categories = getAllCategories();
?>

<div class="container">
    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Welcome to Ecommerce Dashboard</h1>
        <p>Discover amazing products with our advanced search and filtering system</p>
        
        <!-- Quick Search -->
        <form method="GET" action="products.php" class="hero-search">
            <div class="search-input-group">
                <input type="text" name="search" placeholder="Search for products..." class="search-input">
                <button type="submit" class="search-button">🔍 Search Products</button>
            </div>
        </form>
    </div>

    <!-- Categories Section -->
    <?php if (!empty($categories)): ?>
        <section class="categories-section">
            <h2>Shop by Category</h2>
            <div class="categories-grid">
                <?php foreach ($categories as $category): ?>
                    <a href="products.php?category=<?php echo $category['id']; ?>" class="category-card">
                        <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                        <p><?php echo htmlspecialchars($category['description']); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Featured Products Section -->
    <?php if (!empty($featured_products)): ?>
        <section class="featured-section">
            <h2>Featured Products</h2>
            <div class="products-grid">
                <?php foreach ($featured_products as $product): ?>
                    <div class="product-card">
                        <?php if ($product['image_url']): ?>
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="product-image">
                        <?php else: ?>
                            <div class="product-image-placeholder">No Image</div>
                        <?php endif; ?>
                        
                        <div class="product-info">
                            <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                            
                            <?php if ($product['brand']): ?>
                                <p class="product-brand"><?php echo htmlspecialchars($product['brand']); ?></p>
                            <?php endif; ?>
                            
                            <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
                            
                            <?php if ($product['rating'] > 0): ?>
                                <div class="product-rating">
                                    <span class="stars"><?php echo str_repeat('★', floor($product['rating'])); ?><?php echo str_repeat('☆', 5 - floor($product['rating'])); ?></span>
                                    <span class="rating-text"><?php echo number_format($product['rating'], 1); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="view-all-section">
                <a href="products.php" class="button">View All Products</a>
            </div>
        </section>
    <?php endif; ?>

    <!-- Features Section -->
    <section class="features-section">
        <h2>Why Choose Our Platform?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🔍</div>
                <h3>Advanced Search</h3>
                <p>Find exactly what you're looking for with our powerful search and filtering system</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Mobile Responsive</h3>
                <p>Shop seamlessly on any device with our fully responsive design</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Fast Performance</h3>
                <p>Lightning-fast search results and smooth browsing experience</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3>Secure Platform</h3>
                <p>Your data is protected with industry-standard security measures</p>
            </div>
        </div>
    </section>
</div>

</body>
</html>
