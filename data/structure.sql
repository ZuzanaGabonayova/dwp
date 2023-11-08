DROP TABLE IF EXISTS products;

CREATE TABLE ProductCategory (
    CategoryID INT AUTO_INCREMENT PRIMARY KEY,
    CategoryName VARCHAR(255) NOT NULL
);

CREATE TABLE ProductBrand (
    BrandID INT AUTO_INCREMENT PRIMARY KEY,
    BrandName VARCHAR(255) NOT NULL
);

CREATE TABLE product (
    ProductID INT AUTO_INCREMENT PRIMARY KEY,
    ProductNumber VARCHAR(255) NOT NULL UNIQUE,
    Model VARCHAR(255) NOT NULL,
    Color VARCHAR(50),
    Size VARCHAR(50),
    Description TEXT,
    Price DECIMAL(10, 2) NOT NULL,
    StockQuantity INT DEFAULT 0,
    ProductMainImage VARCHAR(255),
    CategoryID INT,
    BrandID INT,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    EditedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Author VARCHAR(255),
    FOREIGN KEY (CategoryID) REFERENCES ProductCategory(CategoryID),
    FOREIGN KEY (BrandID) REFERENCES ProductBrand(BrandID)
);


CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255)
);

DROP TABLE IF EXISTS news_posts;

CREATE TABLE news_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    short_description VARCHAR(255),
    content TEXT NOT NULL,
    image VARCHAR(255),
    image_alt VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- -- Create a table for the product images
-- CREATE TABLE product_images (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     product_id INT NOT NULL,
--     image_path VARCHAR(255) NOT NULL,
--     alt_text VARCHAR(255),
--     -- You can include additional fields for image like title, sort order, etc.
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
--     -- This ensures that each image is linked to a product
--     -- The ON DELETE CASCADE option means that when a product is deleted, its images are too
-- );

-- -- Add an index on the product_id column of the product_images table for faster lookups
-- CREATE INDEX idx_product_id ON product_images(product_id);