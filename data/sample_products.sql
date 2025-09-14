-- Sample data for ecommerce product search functionality

-- Insert sample categories
INSERT INTO categories (name, description) VALUES
('Electronics', 'Electronic devices and gadgets'),
('Clothing', 'Apparel and fashion items'),
('Books', 'Books and educational materials'),
('Home & Garden', 'Home improvement and garden supplies'),
('Sports & Outdoors', 'Sports equipment and outdoor gear'),
('Health & Beauty', 'Health and beauty products'),
('Toys & Games', 'Toys and gaming products'),
('Automotive', 'Car parts and automotive accessories');

-- Insert sample products
INSERT INTO products (name, description, price, category_id, brand, stock_quantity, image_url, sku, rating, review_count) VALUES
-- Electronics
('iPhone 15 Pro', 'Latest Apple smartphone with advanced camera system and A17 Pro chip', 999.99, 1, 'Apple', 25, 'https://via.placeholder.com/300x300/007bff/ffffff?text=iPhone+15', 'IPHONE15PRO', 4.8, 1250),
('Samsung Galaxy S24', 'Premium Android smartphone with AI features and excellent display', 899.99, 1, 'Samsung', 30, 'https://via.placeholder.com/300x300/28a745/ffffff?text=Galaxy+S24', 'GALAXYS24', 4.6, 890),
('MacBook Air M3', 'Ultra-thin laptop with M3 chip and all-day battery life', 1299.99, 1, 'Apple', 15, 'https://via.placeholder.com/300x300/6c757d/ffffff?text=MacBook+Air', 'MACBOOKAIRM3', 4.9, 567),
('Dell XPS 13', 'Premium ultrabook with InfinityEdge display', 1099.99, 1, 'Dell', 20, 'https://via.placeholder.com/300x300/dc3545/ffffff?text=Dell+XPS', 'DELLXPS13', 4.5, 423),
('Sony WH-1000XM5', 'Industry-leading noise canceling wireless headphones', 399.99, 1, 'Sony', 45, 'https://via.placeholder.com/300x300/ffc107/000000?text=Sony+Headphones', 'SONYWH1000XM5', 4.7, 2100),
('iPad Pro 12.9"', 'Professional tablet with M2 chip and Liquid Retina display', 1099.99, 1, 'Apple', 18, 'https://via.placeholder.com/300x300/17a2b8/ffffff?text=iPad+Pro', 'IPADPRO129', 4.8, 756),

-- Clothing
('Levi\'s 501 Original Jeans', 'Classic straight-leg jeans in authentic indigo denim', 89.99, 2, 'Levi\'s', 100, 'https://via.placeholder.com/300x300/343a40/ffffff?text=Levis+Jeans', 'LEVIS501ORIG', 4.4, 1890),
('Nike Air Max 270', 'Comfortable running shoes with Max Air cushioning', 149.99, 2, 'Nike', 75, 'https://via.placeholder.com/300x300/007bff/ffffff?text=Nike+Air+Max', 'NIKEAIRMAX270', 4.3, 1456),
('Patagonia Down Jacket', 'Lightweight down jacket perfect for outdoor adventures', 249.99, 2, 'Patagonia', 35, 'https://via.placeholder.com/300x300/28a745/ffffff?text=Patagonia+Jacket', 'PATAGDOWNJKT', 4.6, 678),
('Adidas Ultraboost 22', 'Premium running shoes with responsive Boost midsole', 189.99, 2, 'Adidas', 60, 'https://via.placeholder.com/300x300/6f42c1/ffffff?text=Adidas+Ultraboost', 'ADIDASUB22', 4.5, 1234),

-- Books
('The Psychology of Money', 'Timeless lessons on wealth, greed, and happiness', 16.99, 3, 'Harriman House', 200, 'https://via.placeholder.com/300x300/fd7e14/ffffff?text=Psychology+Money', 'PSYCHMONEY', 4.7, 3456),
('Atomic Habits', 'An easy and proven way to build good habits and break bad ones', 18.99, 3, 'Avery', 150, 'https://via.placeholder.com/300x300/e83e8c/ffffff?text=Atomic+Habits', 'ATOMICHABITS', 4.8, 5678),
('Clean Code', 'A handbook of agile software craftsmanship', 42.99, 3, 'Prentice Hall', 80, 'https://via.placeholder.com/300x300/20c997/ffffff?text=Clean+Code', 'CLEANCODE', 4.6, 2345),
('The Lean Startup', 'How today\'s entrepreneurs use continuous innovation', 24.99, 3, 'Crown Business', 120, 'https://via.placeholder.com/300x300/6610f2/ffffff?text=Lean+Startup', 'LEANSTARTUP', 4.4, 1789),

-- Home & Garden
('Dyson V15 Detect', 'Cordless vacuum with laser dust detection', 749.99, 4, 'Dyson', 25, 'https://via.placeholder.com/300x300/fd7e14/ffffff?text=Dyson+V15', 'DYSONV15', 4.5, 890),
('KitchenAid Stand Mixer', 'Professional 5-quart stand mixer for baking', 379.99, 4, 'KitchenAid', 40, 'https://via.placeholder.com/300x300/dc3545/ffffff?text=KitchenAid', 'KITCHENAIDMIXER', 4.8, 1567),
('Weber Genesis II Grill', 'Premium gas grill with GS4 grilling system', 899.99, 4, 'Weber', 15, 'https://via.placeholder.com/300x300/198754/ffffff?text=Weber+Grill', 'WEBERGENESIS2', 4.6, 456),

-- Sports & Outdoors
('Yeti Rambler Tumbler', 'Insulated stainless steel tumbler', 39.99, 5, 'Yeti', 200, 'https://via.placeholder.com/300x300/0dcaf0/000000?text=Yeti+Tumbler', 'YETIRAMBLER', 4.7, 2890),
('REI Co-op Tent', '2-person backpacking tent with excellent weather protection', 299.99, 5, 'REI Co-op', 30, 'https://via.placeholder.com/300x300/198754/ffffff?text=REI+Tent', 'REITENT2P', 4.5, 567),
('Hydro Flask Water Bottle', '32oz insulated water bottle', 44.99, 5, 'Hydro Flask', 150, 'https://via.placeholder.com/300x300/6f42c1/ffffff?text=Hydro+Flask', 'HYDROFLASK32', 4.6, 1890),

-- Health & Beauty
('Olaplex Hair Treatment', 'Professional hair treatment for damaged hair', 28.99, 6, 'Olaplex', 100, 'https://via.placeholder.com/300x300/e83e8c/ffffff?text=Olaplex', 'OLAPLEXTREAT', 4.4, 1234),
('The Ordinary Serum Set', 'Complete skincare serum collection', 89.99, 6, 'The Ordinary', 75, 'https://via.placeholder.com/300x300/fd7e14/ffffff?text=Ordinary+Serum', 'ORDINARYSERUM', 4.3, 890),
('Fitbit Charge 5', 'Advanced fitness tracker with built-in GPS', 199.99, 6, 'Fitbit', 50, 'https://via.placeholder.com/300x300/0d6efd/ffffff?text=Fitbit+Charge', 'FITBITCHARGE5', 4.2, 1567),

-- Toys & Games
('LEGO Creator Expert Set', 'Advanced building set for adult collectors', 179.99, 7, 'LEGO', 40, 'https://via.placeholder.com/300x300/dc3545/ffffff?text=LEGO+Expert', 'LEGOCREATOR', 4.8, 678),
('Nintendo Switch OLED', 'Gaming console with vibrant OLED screen', 349.99, 7, 'Nintendo', 25, 'https://via.placeholder.com/300x300/e83e8c/ffffff?text=Switch+OLED', 'SWITCHOLED', 4.7, 2345),
('PlayStation 5', 'Next-generation gaming console', 499.99, 7, 'Sony', 10, 'https://via.placeholder.com/300x300/0d6efd/ffffff?text=PlayStation+5', 'PS5CONSOLE', 4.9, 3456),

-- Automotive
('Michelin Pilot Sport Tires', 'High-performance summer tires', 299.99, 8, 'Michelin', 60, 'https://via.placeholder.com/300x300/343a40/ffffff?text=Michelin+Tires', 'MICHELINPS', 4.5, 567),
('Garmin DashCam', 'HD dashboard camera with GPS', 199.99, 8, 'Garmin', 35, 'https://via.placeholder.com/300x300/20c997/ffffff?text=Garmin+Dash', 'GARMINDASH', 4.3, 890),
('Chemical Guys Car Care Kit', 'Complete car detailing and care kit', 79.99, 8, 'Chemical Guys', 80, 'https://via.placeholder.com/300x300/fd7e14/ffffff?text=Car+Care+Kit', 'CHEMGUYSKIT', 4.4, 1234);

-- Add some out of stock items for testing
UPDATE products SET stock_quantity = 0, status = 'out_of_stock' WHERE id IN (3, 8, 12);
