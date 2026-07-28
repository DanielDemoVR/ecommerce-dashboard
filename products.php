<?php
// Product search and listing page
include 'includes/header.php';
include 'includes/config.php';
include 'includes/functions.php';

// Get search parameters
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : '';
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : '';
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : '';
$brand = isset($_GET['brand']) ? trim($_GET['brand']) : '';
$min_rating = isset($_GET['min_rating']) ? (float)$_GET['min_rating'] : '';
$in_stock = isset($_GET['in_stock']) ? true : false;
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'name';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$per_page = 12;

// Build filters array
$filters = [];
if ($category_id) $filters['category_id'] = $category_id;
if ($min_price) $filters['min_price'] = $min_price;
if ($max_price) $filters['max_price'] = $max_price;
if ($brand) $filters['brand'] = $brand;
if ($min_rating) $filters['min_rating'] = $min_rating;
if ($in_stock) $filters['in_stock'] = true;

// Get search results
$products = searchProducts($search_term, $filters, $sort_by, $sort_order, $page, $per_page);
$total_results = getSearchResultsCount($search_term, $filters);
$total_pages = ceil($total_results / $per_page);

// Get filter options
$categories = getAllCategories();
$brands = getAllBrands();
$price_range = getPriceRange();
?>

<div class="container">
    <div class="search-header">
        <h1>Product Search</h1>
        
        <!-- Main Search Bar -->
        <form method="GET" class="search-form">
            <div class="search-input-group">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search_term); ?>" 
                       placeholder="Search products..." class="search-input">
                <button type="submit" class="search-button">🔍 Search</button>
            </div>
            
            <!-- Preserve other filters -->
            <?php if ($category_id): ?>
                <input type="hidden" name="category" value="<?php echo $category_id; ?>">
            <?php endif; ?>
            <?php if ($min_price): ?>
                <input type="hidden" name="min_price" value="<?php echo $min_price; ?>">
            <?php endif; ?>
            <?php if ($max_price): ?>
                <input type="hidden" name="max_price" value="<?php echo $max_price; ?>">
            <?php endif; ?>
            <?php if ($brand): ?>
                <input type="hidden" name="brand" value="<?php echo htmlspecialchars($brand); ?>">
            <?php endif; ?>
            <?php if ($min_rating): ?>
                <input type="hidden" name="min_rating" value="<?php echo $min_rating; ?>">
            <?php endif; ?>
            <?php if ($in_stock): ?>
                <input type="hidden" name="in_stock" value="1">
            <?php endif; ?>
        </form>
    </div>

    <div class="search-layout">
        <!-- Filters Sidebar -->
        <div class="filters-sidebar">
            <h3>Filters</h3>
            
            <form method="GET" class="filters-form">
                <!-- Preserve search term -->
                <?php if ($search_term): ?>
                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($search_term); ?>">
                <?php endif; ?>
                
                <!-- Category Filter -->
                <div class="filter-group">
                    <label for="category">Category:</label>
                    <select name="category" id="category">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" 
                                    <?php echo $category_id == $cat['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Price Range Filter -->
                <div class="filter-group">
                    <label>Price Range:</label>
                    <div class="price-inputs">
                        <input type="number" name="min_price" placeholder="Min" 
                               value="<?php echo $min_price; ?>" step="0.01" min="0">
                        <span>to</span>
                        <input type="number" name="max_price" placeholder="Max" 
                               value="<?php echo $max_price; ?>" step="0.01" min="0">
                    </div>
                    <?php if ($price_range): ?>
                        <small>Range: $<?php echo number_format($price_range['min_price'], 2); ?> - 
                               $<?php echo number_format($price_range['max_price'], 2); ?></small>
                    <?php endif; ?>
                </div>

                <!-- Brand Filter -->
                <div class="filter-group">
                    <label for="brand">Brand:</label>
                    <select name="brand" id="brand">
                        <option value="">All Brands</option>
                        <?php foreach ($brands as $b): ?>
                            <option value="<?php echo htmlspecialchars($b); ?>" 
                                    <?php echo $brand == $b ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($b); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Rating Filter -->
                <div class="filter-group">
                    <label for="min_rating">Minimum Rating:</label>
                    <select name="min_rating" id="min_rating">
                        <option value="">Any Rating</option>
                        <option value="4" <?php echo $min_rating == 4 ? 'selected' : ''; ?>>4+ Stars</option>
                        <option value="3" <?php echo $min_rating == 3 ? 'selected' : ''; ?>>3+ Stars</option>
                        <option value="2" <?php echo $min_rating == 2 ? 'selected' : ''; ?>>2+ Stars</option>
                        <option value="1" <?php echo $min_rating == 1 ? 'selected' : ''; ?>>1+ Stars</option>
                    </select>
                </div>

                <!-- In Stock Filter -->
                <div class="filter-group">
                    <label>
                        <input type="checkbox" name="in_stock" value="1" <?php echo $in_stock ? 'checked' : ''; ?>>
                        In Stock Only
                    </label>
                </div>

                <button type="submit" class="button filter-button">Apply Filters</button>
                <a href="products.php" class="clear-filters">Clear All Filters</a>
            </form>
        </div>

        <!-- Results Area -->
        <div class="results-area">
            <!-- Results Header -->
            <div class="results-header">
                <div class="results-info">
                    <span><?php echo number_format($total_results); ?> products found</span>
                    <?php if ($search_term): ?>
                        <span>for "<?php echo htmlspecialchars($search_term); ?>"</span>
                    <?php endif; ?>
                </div>
                
                <!-- Sort Options -->
                <div class="sort-options">
                    <label for="sort">Sort by:</label>
                    <select name="sort" id="sort" onchange="updateSort()">
                        <option value="name" <?php echo $sort_by == 'name' ? 'selected' : ''; ?>>Name</option>
                        <option value="price" <?php echo $sort_by == 'price' ? 'selected' : ''; ?>>Price</option>
                        <option value="rating" <?php echo $sort_by == 'rating' ? 'selected' : ''; ?>>Rating</option>
                        <option value="created_at" <?php echo $sort_by == 'created_at' ? 'selected' : ''; ?>>Newest</option>
                    </select>
                    <select name="order" id="order" onchange="updateSort()">
                        <option value="ASC" <?php echo $sort_order == 'ASC' ? 'selected' : ''; ?>>Ascending</option>
                        <option value="DESC" <?php echo $sort_order == 'DESC' ? 'selected' : ''; ?>>Descending</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid">
                <?php if (empty($products)): ?>
                    <div class="no-results">
                        <h3>No products found</h3>
                        <p>Try adjusting your search criteria or filters.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
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
                                
                                <?php if ($product['category_name']): ?>
                                    <p class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></p>
                                <?php endif; ?>
                                
                                <?php if ($product['brand']): ?>
                                    <p class="product-brand"><?php echo htmlspecialchars($product['brand']); ?></p>
                                <?php endif; ?>
                                
                                <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
                                
                                <?php if ($product['rating'] > 0): ?>
                                    <div class="product-rating">
                                        <span class="stars"><?php echo str_repeat('★', floor($product['rating'])); ?><?php echo str_repeat('☆', 5 - floor($product['rating'])); ?></span>
                                        <span class="rating-text"><?php echo number_format($product['rating'], 1); ?> (<?php echo $product['review_count']; ?>)</span>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="product-stock">
                                    <?php if ($product['stock_quantity'] > 0): ?>
                                        <span class="in-stock">✓ In Stock (<?php echo $product['stock_quantity']; ?>)</span>
                                    <?php else: ?>
                                        <span class="out-of-stock">✗ Out of Stock</span>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ($product['description']): ?>
                                    <p class="product-description"><?php echo htmlspecialchars(substr($product['description'], 0, 100)); ?>...</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>" 
                           class="pagination-link">« Previous</a>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                        <?php if ($i == $page): ?>
                            <span class="pagination-current"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>" 
                               class="pagination-link"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>" 
                           class="pagination-link">Next »</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function updateSort() {
    const sort = document.getElementById('sort').value;
    const order = document.getElementById('order').value;
    const url = new URL(window.location);
    url.searchParams.set('sort', sort);
    url.searchParams.set('order', order);
    url.searchParams.set('page', '1'); // Reset to first page
    window.location.href = url.toString();
}
</script>

</body>
</html>
