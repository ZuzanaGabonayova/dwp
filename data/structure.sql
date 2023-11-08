/* DROP TABLE IF EXISTS products; */

CREATE TABLE ProductCategory (
    CategoryID INT AUTO_INCREMENT PRIMARY KEY,
    CategoryName VARCHAR(255) NOT NULL
)ENGINE=InnoDB;

CREATE TABLE ProductBrand (
    BrandID INT AUTO_INCREMENT PRIMARY KEY,
    BrandName VARCHAR(255) NOT NULL
)ENGINE=InnoDB;

CREATE TABLE Admin
(
    AdminID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    FirstName VARCHAR(200) NOT NULL,
    LastName VARCHAR(200) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    UpdatedAt DateTime NOT NULL
) ENGINE=InnoDB;

CREATE TABLE Product (
    ProductID INT AUTO_INCREMENT PRIMARY KEY,
    ProductNumber VARCHAR(255) NOT NULL UNIQUE,
    Model VARCHAR(255) NOT NULL,
    Color VARCHAR(50),
    Size INT,
    Description TEXT,
    Price DECIMAL(10, 2) NOT NULL,
    StockQuantity INT DEFAULT 0,
    ProductMainImage VARCHAR(255),
    CategoryID INT,
    BrandID INT,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    EditedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Author INT,
    FOREIGN KEY (CategoryID) REFERENCES ProductCategory(CategoryID),
    FOREIGN KEY (BrandID) REFERENCES ProductBrand(BrandID),
    FOREIGN KEY (Author) REFERENCES Admin (AdminID)
)ENGINE=InnoDB;

CREATE TABLE DailySpecialOffer
(
    DailySpecialOfferID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    ProductID INT NOT NULL,
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
) ENGINE=InnoDB;

CREATE TABLE ProductGallery
(
    ProductGalleryID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    ProductID INT NOT NULL,
    ProductImage VARCHAR(500) NOT NULL,
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
) ENGINE=InnoDB;

CREATE TABLE PostalCode
(
    PostalCodeID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    PostalCode VARCHAR(70) NOT NULL,
    City VARCHAR(500) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE Address
(
    AddressID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Street VARCHAR(255) NOT NULL,
    HouseNumber VARCHAR(50) NOT NULL,
    PostalCodeID INT NOT NULL,
    FOREIGN KEY (PostalCodeID) REFERENCES PostalCode(PostalCodeID)
) ENGINE=InnoDB;

CREATE TABLE Customer
(
    CustomerID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    FirstName VARCHAR(200) NOT NULL,
    LastName VARCHAR(200) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Phone VARCHAR(100) NOT NULL,
    AddressID INT NOT NULL,
    FOREIGN KEY (AddressID) REFERENCES Address(AddressID)
) ENGINE=InnoDB;

CREATE TABLE BillingAddress
(
    BillingAddressID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Street VARCHAR(255) NOT NULL,
    HouseNumber VARCHAR(50) NOT NULL,
    PostalCodeID INT NOT NULL,
    FOREIGN KEY (PostalCodeID) REFERENCES PostalCode(PostalCodeID)
) ENGINE=InnoDB;

CREATE TABLE OrderP
(
    OrderID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    OrderDate DateTime NOT NULL,
    OrderStatus Boolean NOT NULL
) ENGINE=InnoDB;

CREATE TABLE OrderDetails
(
    OrderDetailsID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    Quantity INT NOT NULL,
    Price DECIMAL(8,2) NOT NULL,
    OrderID INT NOT NULL,
    ProductID INT NOT NULL,
    CustomerID INT NOT NULL,
    BillingAddressID INT NOT NULL,
    FOREIGN KEY (OrderID) REFERENCES OrderP(OrderID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID),
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID),
    FOREIGN KEY (BillingAddressID) REFERENCES BillingAddress(BillingAddressID)
) ENGINE=InnoDB;

/* CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255)
); */

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

CREATE TABLE PresentationOfCompany
(
    DescriptionOfCompany VARCHAR(2000) NOT NULL,
    OpeningHours VARCHAR(500) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Phone VARCHAR(100) NOT NULL,
    Street VARCHAR(255) NOT NULL,
    HouseNumber VARCHAR(50) NOT NULL,
    PostalCodeID INT NOT NULL,
    FOREIGN KEY (PostalCodeID) REFERENCES PostalCode(PostalCodeID)
) ENGINE=InnoDB;

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