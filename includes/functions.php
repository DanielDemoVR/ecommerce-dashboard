<?php
// Dangerous code for demo: SQL injection vulnerability
function getUserPosts($userId) {
    global $connection;
    $query = "SELECT * FROM posts WHERE user_id = " . $userId;
    return mysqli_query($connection, $query);
}

// Sanitize user input for safe output
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Get all users from the database
function getAllUsers() {
    global $connection;
    $query = "SELECT * FROM users";
    $result = mysqli_query($connection, $query);
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    return $users;
}

function checkDatabase($username, $password) {
    $csvFile = __DIR__ . '/../data/users.csv';
    
    if (!file_exists($csvFile)) {
        return false;
    }
    
    $handle = fopen($csvFile, 'r');
    
    while (($line = fgetcsv($handle)) !== false) {
        if (!empty($line[0]) && $line[0][0] !== '#') {
            break;
        }
    }
    
    while (($row = fgetcsv($handle)) !== false) {
        if (count($row) >= 4) {
            $csvUsername = trim($row[1]);
            $csvPassword = trim($row[3]);
            if ($csvUsername === $username && $csvPassword === $password) {
                fclose($handle);
                return true;
            }
        }
    }
    
    fclose($handle);
    return false;
}

// ============ PRODUCT MANAGEMENT FUNCTIONS ============

// Get all categories
function getAllCategories() {
    global $connection;
    $query = "SELECT * FROM categories ORDER BY name ASC";
    $result = mysqli_query($connection, $query);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    return $categories;
}

// Get category by ID
function getCategoryById($id) {
    global $connection;
    $id = (int)$id;
    $query = "SELECT * FROM categories WHERE id = $id";
    $result = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($result);
}

// Add new product
function addProduct($name, $description, $price, $category_id, $brand, $stock_quantity, $image_url, $sku) {
    global $connection;
    $name = mysqli_real_escape_string($connection, $name);
    $description = mysqli_real_escape_string($connection, $description);
    $price = (float)$price;
    $category_id = $category_id ? (int)$category_id : null;
    $brand = mysqli_real_escape_string($connection, $brand);
    $stock_quantity = (int)$stock_quantity;
    $image_url = mysqli_real_escape_string($connection, $image_url);
    $sku = mysqli_real_escape_string($connection, $sku);
    
    $query = "INSERT INTO products (name, description, price, category_id, brand, stock_quantity, image_url, sku) 
              VALUES ('$name', '$description', $price, " . ($category_id ? $category_id : 'NULL') . ", '$brand', $stock_quantity, '$image_url', '$sku')";
    
    return mysqli_query($connection, $query);
}

// Get product by ID
function getProductById($id) {
    global $connection;
    $id = (int)$id;
    $query = "SELECT p.*, c.name as category_name 
              FROM products p 
              LEFT JOIN categories c ON p.category_id = c.id 
              WHERE p.id = $id";
    $result = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($result);
}

// Update product
function updateProduct($id, $name, $description, $price, $category_id, $brand, $stock_quantity, $image_url, $sku) {
    global $connection;
    $id = (int)$id;
    $name = mysqli_real_escape_string($connection, $name);
    $description = mysqli_real_escape_string($connection, $description);
    $price = (float)$price;
    $category_id = $category_id ? (int)$category_id : null;
    $brand = mysqli_real_escape_string($connection, $brand);
    $stock_quantity = (int)$stock_quantity;
    $image_url = mysqli_real_escape_string($connection, $image_url);
    $sku = mysqli_real_escape_string($connection, $sku);
    
    $query = "UPDATE products SET 
              name = '$name', 
              description = '$description', 
              price = $price, 
              category_id = " . ($category_id ? $category_id : 'NULL') . ", 
              brand = '$brand', 
              stock_quantity = $stock_quantity, 
              image_url = '$image_url', 
              sku = '$sku',
              updated_at = CURRENT_TIMESTAMP
              WHERE id = $id";
    
    return mysqli_query($connection, $query);
}

// Delete product
function deleteProduct($id) {
    global $connection;
    $id = (int)$id;
    $query = "DELETE FROM products WHERE id = $id";
    return mysqli_query($connection, $query);
}

// ============ PRODUCT SEARCH FUNCTIONS ============

// Search products with filters
function searchProducts($search_term = '', $filters = [], $sort_by = 'name', $sort_order = 'ASC', $page = 1, $per_page = 12) {
    global $connection;
    
    $offset = ($page - 1) * $per_page;
    $where_conditions = [];
    $where_conditions[] = "p.status = 'active'";
    
    // Search term
    if (!empty($search_term)) {
        $search_term = mysqli_real_escape_string($connection, $search_term);
        $where_conditions[] = "(MATCH(p.name, p.description, p.brand) AGAINST('$search_term' IN NATURAL LANGUAGE MODE) 
                              OR p.name LIKE '%$search_term%' 
                              OR p.description LIKE '%$search_term%' 
                              OR p.brand LIKE '%$search_term%')";
    }
    
    // Category filter
    if (!empty($filters['category_id'])) {
        $category_id = (int)$filters['category_id'];
        $where_conditions[] = "p.category_id = $category_id";
    }
    
    // Price range filter
    if (!empty($filters['min_price'])) {
        $min_price = (float)$filters['min_price'];
        $where_conditions[] = "p.price >= $min_price";
    }
    if (!empty($filters['max_price'])) {
        $max_price = (float)$filters['max_price'];
        $where_conditions[] = "p.price <= $max_price";
    }
    
    // Brand filter
    if (!empty($filters['brand'])) {
        $brand = mysqli_real_escape_string($connection, $filters['brand']);
        $where_conditions[] = "p.brand = '$brand'";
    }
    
    // Rating filter
    if (!empty($filters['min_rating'])) {
        $min_rating = (float)$filters['min_rating'];
        $where_conditions[] = "p.rating >= $min_rating";
    }
    
    // In stock filter
    if (!empty($filters['in_stock'])) {
        $where_conditions[] = "p.stock_quantity > 0";
    }
    
    $where_clause = implode(' AND ', $where_conditions);
    
    // Validate sort parameters
    $allowed_sort_fields = ['name', 'price', 'rating', 'created_at'];
    $sort_by = in_array($sort_by, $allowed_sort_fields) ? $sort_by : 'name';
    $sort_order = strtoupper($sort_order) === 'DESC' ? 'DESC' : 'ASC';
    
    $query = "SELECT p.*, c.name as category_name 
              FROM products p 
              LEFT JOIN categories c ON p.category_id = c.id 
              WHERE $where_clause 
              ORDER BY p.$sort_by $sort_order 
              LIMIT $per_page OFFSET $offset";
    
    $result = mysqli_query($connection, $query);
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    
    return $products;
}

// Get total count of search results
function getSearchResultsCount($search_term = '', $filters = []) {
    global $connection;
    
    $where_conditions = [];
    $where_conditions[] = "p.status = 'active'";
    
    // Search term
    if (!empty($search_term)) {
        $search_term = mysqli_real_escape_string($connection, $search_term);
        $where_conditions[] = "(MATCH(p.name, p.description, p.brand) AGAINST('$search_term' IN NATURAL LANGUAGE MODE) 
                              OR p.name LIKE '%$search_term%' 
                              OR p.description LIKE '%$search_term%' 
                              OR p.brand LIKE '%$search_term%')";
    }
    
    // Apply same filters as search function
    if (!empty($filters['category_id'])) {
        $category_id = (int)$filters['category_id'];
        $where_conditions[] = "p.category_id = $category_id";
    }
    
    if (!empty($filters['min_price'])) {
        $min_price = (float)$filters['min_price'];
        $where_conditions[] = "p.price >= $min_price";
    }
    if (!empty($filters['max_price'])) {
        $max_price = (float)$filters['max_price'];
        $where_conditions[] = "p.price <= $max_price";
    }
    
    if (!empty($filters['brand'])) {
        $brand = mysqli_real_escape_string($connection, $filters['brand']);
        $where_conditions[] = "p.brand = '$brand'";
    }
    
    if (!empty($filters['min_rating'])) {
        $min_rating = (float)$filters['min_rating'];
        $where_conditions[] = "p.rating >= $min_rating";
    }
    
    if (!empty($filters['in_stock'])) {
        $where_conditions[] = "p.stock_quantity > 0";
    }
    
    $where_clause = implode(' AND ', $where_conditions);
    
    $query = "SELECT COUNT(*) as total FROM products p WHERE $where_clause";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    
    return (int)$row['total'];
}

// Get all unique brands
function getAllBrands() {
    global $connection;
    $query = "SELECT DISTINCT brand FROM products WHERE brand IS NOT NULL AND brand != '' ORDER BY brand ASC";
    $result = mysqli_query($connection, $query);
    $brands = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $brands[] = $row['brand'];
    }
    return $brands;
}

// Get price range
function getPriceRange() {
    global $connection;
    $query = "SELECT MIN(price) as min_price, MAX(price) as max_price FROM products WHERE status = 'active'";
    $result = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($result);
}

// Add category
function addCategory($name, $description = '', $parent_id = null) {
    global $connection;
    $name = mysqli_real_escape_string($connection, $name);
    $description = mysqli_real_escape_string($connection, $description);
    $parent_id = $parent_id ? (int)$parent_id : null;
    
    $query = "INSERT INTO categories (name, description, parent_id) 
              VALUES ('$name', '$description', " . ($parent_id ? $parent_id : 'NULL') . ")";
    
    return mysqli_query($connection, $query);
}
