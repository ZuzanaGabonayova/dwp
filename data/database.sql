/*                                                              *
*   This sql script creates shoes_webshop database.             *
*   It also creates all tables needed for snickers webshop.     *
*                                                               *
*   Data for tables are stored in another file named 'data.sql' *
*   which is located in the same folder as this file.           *
*                                                               *
*   Database views and triggers are included in this file.      *
*                                                               *
*   Project:                                                    *
*   - DWP (Web programming - Backend, Databases)                *
*   Authors:                                                    *   
*   -   Zuzana Gabonayova                                       *
*   -   Laszlo Vitkai                                           * 
*   Time Period:                                                *
*   -   October-December 2023                                   *
*                                                               */

DROP DATABASE IF EXISTS squkanhyqf;
CREATE DATABASE squkanhyqf;
USE squkanhyqf;


DROP TABLE IF EXISTS contacts;
CREATE TABLE contacts (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    message text NOT NULL,
    submitted_at timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (id)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS news_posts;
CREATE TABLE news_posts (
    id int(11) NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    short_description varchar(255) DEFAULT NULL,
    content text NOT NULL,
    image varchar(255) DEFAULT NULL,
    image_alt varchar(255) DEFAULT NULL,
    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS PostalCode;
CREATE TABLE PostalCode (
    PostalCodeID int(11) NOT NULL AUTO_INCREMENT,
    PostalCode varchar(70) NOT NULL,
    City varchar(500) NOT NULL,
    PRIMARY KEY (PostalCodeID)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS PresentationOfCompany;
CREATE TABLE PresentationOfCompany (
    DescriptionOfCompany varchar(2000) NOT NULL,
    OpeningHours varchar(500) NOT NULL,
    Email varchar(100) NOT NULL,
    Phone varchar(100) NOT NULL,
    Street varchar(255) NOT NULL,
    HouseNumber varchar(50) NOT NULL,
    PostalCodeID int(11) NOT NULL,
    KEY PostalCodeID (PostalCodeID),
    CONSTRAINT PresentationOfCompany_ibfk_1 FOREIGN KEY (PostalCodeID) REFERENCES PostalCode (PostalCodeID)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS Size;
CREATE TABLE Size (
    SizeID int(11) NOT NULL AUTO_INCREMENT,
    Size float NOT NULL,
    PRIMARY KEY (SizeID),
    UNIQUE KEY Size (Size)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS ProductCategory;
CREATE TABLE ProductCategory (
    CategoryID int(11) NOT NULL AUTO_INCREMENT,
    CategoryName varchar(255) NOT NULL,
    PRIMARY KEY (CategoryID)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS ProductBrand;
CREATE TABLE ProductBrand (
    BrandID int(11) NOT NULL AUTO_INCREMENT,
    BrandName varchar(255) NOT NULL,
    PRIMARY KEY (BrandID)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS Color;
CREATE TABLE Color (
  ColorID int(11) NOT NULL AUTO_INCREMENT,
  ColorName varchar(50) NOT NULL,
  PRIMARY KEY (ColorID),
  UNIQUE KEY ColorName (ColorName)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS Admin;
CREATE TABLE Admin (
    AdminID int NOT NULL AUTO_INCREMENT,
    FirstName varchar(100) NOT NULL,
    LastName varchar(100) NOT NULL,
    Email varchar(100) NOT NULL,
    Username varchar(50) NOT NULL,
    Password VARCHAR(255) NOT NULL, 
    UpdatedAt datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (AdminID),
    UNIQUE KEY unique_username (Username)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS Product;
CREATE TABLE Product (
    ProductID int(11) NOT NULL AUTO_INCREMENT,
    ProductNumber varchar(255) NOT NULL,
    Model varchar(255) NOT NULL,
    Description text DEFAULT NULL,
    Price decimal(6,2) NOT NULL,
    ProductMainImage varchar(255) DEFAULT NULL,
    CategoryID int(11) DEFAULT NULL,
    BrandID int(11) DEFAULT NULL,
    CreatedAt datetime DEFAULT current_timestamp(),
    EditedAt datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    AdminID int(11) DEFAULT NULL,
    StockQuantity int(11) DEFAULT 0,
    StripePriceID varchar(255) DEFAULT NULL,
    PRIMARY KEY (ProductID),
    UNIQUE KEY ProductNumber (ProductNumber),
    KEY CategoryID (CategoryID),
    KEY BrandID (BrandID),
    KEY Author (AdminID),
    CONSTRAINT Product_ibfk_1 FOREIGN KEY (CategoryID) REFERENCES ProductCategory (CategoryID),
    CONSTRAINT Product_ibfk_2 FOREIGN KEY (BrandID) REFERENCES ProductBrand (BrandID),
    CONSTRAINT Product_ibfk_3 FOREIGN KEY (AdminID) REFERENCES Admin (AdminID)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS ProductSize;
CREATE TABLE ProductSize (
    ProductID int(11) NOT NULL,
    SizeID int(11) NOT NULL,
    PRIMARY KEY (ProductID, SizeID),
    KEY SizeID (SizeID),
    CONSTRAINT ProductSize_ibfk_1 FOREIGN KEY (ProductID) REFERENCES Product (ProductID),
    CONSTRAINT ProductSize_ibfk_2 FOREIGN KEY (SizeID) REFERENCES Size (SizeID)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS DailySpecialOffer;
CREATE TABLE DailySpecialOffer (
    DailySpecialOfferID int(11) NOT NULL AUTO_INCREMENT,
    ProductID int(11) NOT NULL,
    updated_at DATETIME DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (DailySpecialOfferID),
    KEY ProductID (ProductID),
    CONSTRAINT DailySpecialOffer_ibfk_1 FOREIGN KEY (ProductID) REFERENCES Product (ProductID)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS DailySpecialOfferLog;
CREATE TABLE DailySpecialOfferLog (
  LogID int(11) NOT NULL AUTO_INCREMENT,
  DailySpecialOfferID int(11) NOT NULL,
  ProductID int(11) NOT NULL,
  UpdatedAt datetime NOT NULL,
  PRIMARY KEY (LogID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS ProductColor;
CREATE TABLE ProductColor (
  ProductID int(11) NOT NULL,
  ColorID int(11) NOT NULL,
  PRIMARY KEY (ProductID,ColorID),
  KEY ColorID (ColorID),
  CONSTRAINT ProductColor_ibfk_1 FOREIGN KEY (ProductID) REFERENCES Product (ProductID),
  CONSTRAINT ProductColor_ibfk_2 FOREIGN KEY (ColorID) REFERENCES Color (ColorID)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
  id int(11) NOT NULL AUTO_INCREMENT,
  session_id varchar(255) NOT NULL,
  payment_intent_id varchar(255) NOT NULL,
  amount_total int(11) NOT NULL,
  currency varchar(3) NOT NULL,
  customer_id varchar(255) DEFAULT NULL,
  customer_email varchar(255) DEFAULT NULL,
  payment_status varchar(50) DEFAULT NULL,
  payment_method_types text DEFAULT NULL,
  shipping_address text DEFAULT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  customer_name varchar(255) DEFAULT NULL,
  customer_phone varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS order_line_items;
CREATE TABLE order_line_items (
  id int(11) NOT NULL AUTO_INCREMENT,
  order_id int(11) NOT NULL,
  product_name varchar(255) NOT NULL,
  quantity int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY order_id (order_id),
  CONSTRAINT order_line_items_ibfk_1 FOREIGN KEY (order_id) REFERENCES orders (id)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS OrderProduct;
CREATE TABLE OrderProduct (
  ProductID int(11) NOT NULL,
  OrderID int(11) NOT NULL,
  PRIMARY KEY (ProductID,OrderID),
  KEY ProductID (ProductID),
  CONSTRAINT OrderProduct_ibfk_1 FOREIGN KEY (ProductID) REFERENCES Product (ProductID),
  CONSTRAINT OrderProduct_ibfk_2 FOREIGN KEY (OrderID) REFERENCES order_line_items (id)
) ENGINE=InnoDB;



/* TRIGGERS */
-- The trigger ensures when a new order data are added to order_line_items table, 
-- the StockQuantity of the corresponding product in the Product table is updated by counting down the quantity ordered.
DELIMITER //

CREATE TRIGGER after_orderline_insert
AFTER INSERT ON order_line_items
FOR EACH ROW
BEGIN
    DECLARE prodID INT;

    -- Find the ProductID based on the product_name (Model)
    SELECT ProductID INTO prodID 
    FROM Product 
    WHERE Model = NEW.product_name
    LIMIT 1;

    -- Update the stock quantity
    UPDATE Product
    SET StockQuantity = StockQuantity - NEW.quantity
    WHERE ProductID = prodID;
END //

DELIMITER ;


-- The trigger creates a log in the DailySpecialOfferLog table, capturing the changes made to the DailySpecialOffer 
-- table by recording the DailySpecialOfferID, ProductID, and UpdatedAt timestamp of the updated row.
DELIMITER //

CREATE TRIGGER after_daily_special_offer_update
AFTER UPDATE ON DailySpecialOffer
FOR EACH ROW
BEGIN
    INSERT INTO DailySpecialOfferLog (DailySpecialOfferID, ProductID, UpdatedAt)
    VALUES (NEW.DailySpecialOfferID, NEW.ProductID, NEW.updated_at);
END //

DELIMITER ;


/* VIEWS */
-- The ProductInformation view is used to display the product information that are stored in multiple tables.
CREATE VIEW ProductInformation AS
SELECT 
    P.ProductID,
    P.ProductNumber,
    P.Model,
    P.Description,
    P.Price,
    PC.CategoryName,
    PB.BrandName,
    S.Size,
    C.ColorName
FROM 
    Product P
LEFT JOIN 
    ProductCategory PC ON P.CategoryID = PC.CategoryID
LEFT JOIN 
    ProductBrand PB ON P.BrandID = PB.BrandID
LEFT JOIN 
    ProductSize PSizes ON P.ProductID = PSizes.ProductID
LEFT JOIN 
    Size S ON PSizes.SizeID = S.SizeID
LEFT JOIN 
    ProductColor PCo ON P.ProductID = PCo.ProductID
LEFT JOIN 
    Color C ON PCo.ColorID = C.ColorID;


-- This view connects the Product table with ProductBrand to display products alongside their associated brands in alphabetical order.
CREATE VIEW ProductBrandInformation AS
SELECT 
    P.ProductID,
    P.ProductNumber,
    P.Model,
    P.Description,
    P.Price,
    PB.BrandName
FROM 
    Product P
INNER JOIN 
    ProductBrand PB ON P.BrandID = PB.BrandID
ORDER BY 
    PB.BrandName;


/*

    Following tables are not used in this project, but in the future we might need them and implement them.
    The structure of these tables was our initial idea, but while implementing stripe payments functionality
    we used simpler version of storing order data in orders table and order_line_items table.

*/

/* DROP TABLE IF EXISTS Address;
CREATE TABLE Address (
    AddressID int(11) NOT NULL AUTO_INCREMENT,
    Street varchar(255) NOT NULL,
    HouseNumber varchar(50) NOT NULL,
    PostalCodeID int(11) NOT NULL,
    PRIMARY KEY (AddressID),
    KEY PostalCodeID (PostalCodeID),
    CONSTRAINT Address_ibfk_1 FOREIGN KEY (PostalCodeID) REFERENCES PostalCode (PostalCodeID)
) ENGINE=InnoDB; */


/* DROP TABLE IF EXISTS Customer;
CREATE TABLE Customer (
    CustomerID varchar(255) NOT NULL,
    FirstName varchar(200) NOT NULL,
    LastName varchar(200) NOT NULL,
    Email varchar(100) NOT NULL,
    Phone varchar(50) NOT NULL,
    CreatedAt datetime NOT NULL DEFAULT current_timestamp(),
    AddressID int(11) NOT NULL,
    PRIMARY KEY (CustomerID),
    KEY AddressID (AddressID),
    CONSTRAINT Customer_ibfk_1 FOREIGN KEY (AddressID) REFERENCES Address (AddressID)
) ENGINE=InnoDB; */


/* CREATE TABLE Orders (
    OrderNumber int(11) NOT NULL AUTO_INCREMENT,
    OrderID varchar(255) NOT NULL,
    OrderDate datetime NOT NULL DEFAULT current_timestamp(),
    Status varchar(255) NOT NULL,
    TotalPrice decimal(8,2) NOT NULL,
    CustomerID varchar(255) NOT NULL,
    PRIMARY KEY (OrderNumber),
    UNIQUE KEY (OrderID),
    KEY CustomerID (CustomerID),
    CONSTRAINT Orders_ibfk_1 FOREIGN KEY (CustomerID) REFERENCES Customer (CustomerID)
) ENGINE=InnoDB; */


/* DROP TABLE IF EXISTS OrderProduct;
CREATE TABLE OrderProduct (
    OrderProductID int(11) NOT NULL AUTO_INCREMENT,
    Quantity int(11) NOT NULL,
    ProductID int(11) NOT NULL,
    OrderID varchar(255) NOT NULL,
    PRIMARY KEY (OrderProductID),
    KEY ProductID (ProductID),
    KEY OrderID (OrderID),
    CONSTRAINT OrderProduct_ibfk_1 FOREIGN KEY (ProductID) REFERENCES Product (ProductID),
    CONSTRAINT OrderProduct_ibfk_2 FOREIGN KEY (OrderID) REFERENCES Orders (OrderID)
) ENGINE=InnoDB; */