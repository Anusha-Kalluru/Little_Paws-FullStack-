-- Create database
CREATE DATABASE IF NOT EXISTS pet_grocery_db;
USE pet_grocery_db;

-- Users table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL,
    description TEXT,
    image_url VARCHAR(1000)
);

-- Products table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    product_name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image_url VARCHAR(1000),
    stock_quantity INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

-- Cart table
CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Orders table
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10,2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Order items table
CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Insert sample categories with images
INSERT INTO categories (category_name, description, image_url) VALUES
('DOGS', 'Essentials for Dogs', 'https://imgs.search.brave.com/CtQgmcFNViqJQzoCI2XoPXDeDBkl02w04FmvCDxZkHI/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5nZXR0eWltYWdl/cy5jb20vaWQvMTMw/Nzc1MDU5OS9waG90/by9wdXBweS5qcGc_/cz02MTJ4NjEyJnc9/MCZrPTIwJmM9TUR6/TlBIaUlHTV9JM0M3/VHdnV0tuclowVGpN/X3o5dVBUcFZmdWpq/eDdmbz0'),
('CATS', 'Essentials for Cats', 'https://imgs.search.brave.com/xRzvZPCGvqWHY_6Pnm_C1u2QqAEFlPJKC9TAoGsGXT0/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5nZXR0eWltYWdl/cy5jb20vaWQvMTg1/MzA0Mjc0L3Bob3Rv/L2tpdHRlbi5qcGc_/cz02MTJ4NjEyJnc9/MCZrPTIwJmM9WFpZ/NVVsUEdrTEhCSGst/cFlUMGQzNm81NGdO/VW0tWW5RcWYtLTNi/MkU5QT0'),
('BIRDS', 'Essentials for Birds', 'https://imgs.search.brave.com/3Wu_V58XYtlf4mVQ00EOv3bFF1p1P2wwykJ42Sn4gFQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvNTc3/MzM0MTI0L3Bob3Rv/L3BhcmFrZWV0LWlu/LWNhZ2UuanBnP3M9/NjEyeDYxMiZ3PTAm/az0yMCZjPWRNdTI3/c2NIZ2FvREZ3WXJY/VWtQQVdfVkwxaEd6/anlmVGF5UUVsc0J1/T009'),
('RABBITS', 'Essentials for Rabbits', 'https://imgs.search.brave.com/xMwxl3SB4oilXgap4drV9mvdP3mE09Bb_1nDKo2r9aU/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzAxLzM1LzA0LzI0/LzM2MF9GXzEzNTA0/MjQ2MF9ZN01Ealh4/VTRaNDY1anVvWnVo/MWJ1eXdEWkVlelU5/Ti5qcGc');

-- Insert sample products with images
INSERT INTO products (category_id, product_name, price, description, image_url, stock_quantity) VALUES
(1, 'Pedigree', 100.00, 'Pedigree Chicken & Vegetables Adult Dry Dog Food', 'https://headsupfortails.com/cdn/shop/files/8906002482832.jpg?v=1744608850', 100),
(1, 'Heads Up For Tails', 99.99, 'HUFT Chewbarks Grilled Duck Soft Chew Strips Treat For Dogs', 'https://headsupfortails.com/cdn/shop/files/DSC_4803.jpg?v=1739043449', 100),
(1, 'Dash Dog', 1499.00, 'Dash Dog Radiant Blaze Easy Walk Harness For Dog - Orange', 'https://headsupfortails.com/cdn/shop/files/DSC_0637_af1c539e-aeec-4e2c-b8f2-e2dbfed1b664.jpg?v=1741088528', 100),
(1, 'Moe', 321.00, 'Moe Puppy Tick Free Spray', 'https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcRgow03VAipep8GvxKoZQnAUkR75mRHVj6-bb3LURae5WcT5bRgOdNdK3JK74ZU1_BJD1iw7_ado-p69XU6NUd23_nPdDdxSTraO8R4gGk', 100),
(1, 'Heads Up For Tailsd', 2999.00, 'HUFT Walnut Weave Lounger Bed For Dog - Brown', 'https://headsupfortails.com/cdn/shop/files/DSC_1856_f1d2387a-9751-4c60-a553-d2d9417e674f.jpg?v=1743679952', 100),
(1, 'Dash Dog', 899.00, 'Dash Dog Eclipse Bowl For Dogs', 'https://headsupfortails.com/cdn/shop/products/DSC_2788_974224b3-6edb-4e89-a4f7-245c2cb97f4d.jpg?v=1681364074', 100),
(2, 'Heads Up For Tails', 199.00, 'HUFT Cat Mahi Mahi Fish Crunchies - 35 g', 'https://headsupfortails.com/cdn/shop/products/cattreatMahiMahi.jpg?v=1739045638', 50),
(2, 'Trixie', 2095.00, 'Trixie Vico Cat Litter Tray with Hood - Grey/White - 23 x 16 x 16 inch', 'https://headsupfortails.com/cdn/shop/products/TrixieVicoCatLitterTraywithHood-BlackWhite-23x16x16inch.jpg?v=1638783407', 30),
(2, 'Heads Up For Tails', 4499.00, 'HUFT Feline Cane Bed With Cushion For Cat - Beige', 'https://headsupfortails.com/cdn/shop/files/DSC_7883_b4f67820-e527-4603-972e-ef557f9d0712.jpg?v=1739041345', 30),
(2, 'Trixie', 8500.00, 'Trixie William Backpack Dog & Cat Carrier - Hold Upto 30 kg - (33 x 43 X 23) cm', 'https://headsupfortails.com/cdn/shop/files/4057589289452_1.jpg?v=1685625587', 30),
(2, 'Tail Lovers Company', 300.00, 'TLC Mouse Mischief Plush Toy For Cat - Brown', 'https://headsupfortails.com/cdn/shop/files/612spltG_pL._SL1500__1.jpg?v=1734351988', 30),
(2, 'Tail Lovers Company', 299.99, 'TLC Steel Wand Toy For Cats With Pom Pom - Yellow', 'https://headsupfortails.com/cdn/shop/files/DSC_7627.jpg?v=1734353138', 30),
(3, 'Birdie', 229.99, 'Colored Wooden & Chewing Toy for Big Birds', 'https://parrotdipankarstores.com/wp-content/uploads/2021/12/CT-03-01-scaled.jpg', 40),
(3, 'Birdie', 210.00, 'Colored Playing & Chewing Toy for All Types Birds ( 3 Piece )', 'https://parrotdipankarstores.com/wp-content/uploads/2021/12/CT-03-01-scaled.jpg', 25),
(3, 'Macaw', 699.00, 'BLUE AND GOLD MACAW SWING', 'https://parrotdipankarstores.com/wp-content/uploads/2021/12/GOLD-AND-BLUE-01-scaled.jpg', 25),
(3, 'Prestige', 1932.00, 'Versele Laga Prestige Food For Parrots', 'https://cdn.shopify.com/s/files/1/0565/8021/0861/products/Frame1-2021-10-28T151854.443_1_1.png?v=1696632364&width=300&height=300&crop=center&fit=crop', 25),
(3, 'Pet Life', 293.00, 'Pet Life Birds Aloe Dry Bath /Waterless/Spray Shampoo For Poultry Birds/Parrots/Pigeon 200 Ml Pet Coat Cleanser', 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcTB50FAVBeKoBR9V3p_NkYLssK8Rw02deBrnl4XBQPbRnToNw-auZXicQANywnr8XJBTSUUndUiuiS-Ufd6GcEcQ76p0EPAe-hbXseTuSPlkpPtWCSfzXNd', 25),
(4, 'Floof You', 1039.00, 'Forage Mix Pure Veg Natural Healthy Enrichment Treat for Rabbits', 'https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcRhjZzvT3K3W6m7UcpIvuAk1GjWJ3Y3Emyj-LeCYVGd92ekAWcp9hmpEplpE5X7OEt7ilcwmOApasEH2DdFyD5dB16TsKNNcvLWW-ZEH-DlCSuc-5l_gd8ABQ', 60),
(4, 'Niteangel', 1411.00, 'Niteangel Adjustable Soft Harness with Elastic Leash for Rabbits', 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcTOzTxP4VkW7aR_OGEOTLZolT6TY1JkiEeq0LG99Va7UwVoS7mbXiBaDjuBwmkES8m1TTOekwnmUoa05Y9XuJ57kz2XnDplycp-f9dnzJr7MlB7Ua-zkhS7', 60),
(4, 'Trixie', 6945.00, 'Rosewood Boredom Breaker Bunny Fun Tree', 'https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcQTPHLw8DkrAZpPon0vUsXUr0b_3AfBUNg739NmpyvfCtgBUwlaNkRos9eZdCTIpRxd333MLwJ-pRcBt4crJL-pwiFvCYwDTlhaVUOmXyZXiEct8mg0SWDHwg', 60),
(4, 'Sage Square', 299.00, 'Sage Square Wood Shaving - Premium Natural Soft Bedding for Birds', 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcSl1Z-TnocVgXoDeCnqlpHAvls7XIL6q4heoiAvPEzikzGE-NlyeOWYjXcjJ08fD36-T6UWH3gloOoUBgSYzU2N99Fj25n7c3LUm50GW2U', 60),
(4, 'Pet Mom',268.00, 'The Pet Mom 2 In 1 Smooth & Shine Serum', 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcQ9DFB9dCWii0M7j8nlXVcayofVuyxTdXJ2chQGCh98SPCoUK25KVGLu5qtM2-yBrkVmFJtAeR6pOjuc4Jyx20jhd_xJ5_rAj82kh5emWs', 60),
(4, 'CJ ', 170.00, 'Rabbit Automatic Water Bowl', 'https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcQLv-jt5nBfmPh1M0WYwg3-Lq18OT2989LLRrVxPzJSdec9wtxJp8A0voYdgGiCLUEcDx6lFD0af_PtYrDnHIBjg7krfBX3KBqpCK1Fexd7rCN-VLIrDoE2', 45);

-- Create trigger for updating stock after order
DELIMITER //
CREATE TRIGGER update_stock_after_order
AFTER INSERT ON order_items
FOR EACH ROW
BEGIN
    UPDATE products 
    SET stock_quantity = stock_quantity - NEW.quantity
    WHERE product_id = NEW.product_id;
END //
DELIMITER ;

-- Create view for product categories
CREATE VIEW product_categories AS
SELECT p.product_id, p.product_name, p.price, p.image_url, c.category_name
FROM products p
JOIN categories c ON p.category_id = c.category_id;

-- Create view for user cart
CREATE VIEW user_cart_view AS
SELECT c.cart_id, u.username, p.product_name, p.image_url, c.quantity, p.price
FROM cart c
JOIN users u ON c.user_id = u.user_id
JOIN products p ON c.product_id = p.product_id; 