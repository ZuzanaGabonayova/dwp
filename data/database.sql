/*                                                              *
*   This sql script creates shoes_webshop database.             *
*   It also creates all tables needed for snickers webshop.     *
*                                                               *
*   Project:                                                    *
*   - DWP (Web programming - Backend, Databases)                *
*   Authors:                                                    *   
*   -   Zuzana Gabonayova                                       *
*   -   Laszlo Vitkai                                           * 
*   Time Period:                                                *
*   - October-December 2023                                     *
*                                                               */

DROP DATABASE IF EXISTS `shoes_webshop`;
CREATE DATABASE `shoes_webshop`;
USE `shoes_webshop`;


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
    PRIMARY KEY (DailySpecialOfferID),
    KEY ProductID (ProductID),
    CONSTRAINT DailySpecialOffer_ibfk_1 FOREIGN KEY (ProductID) REFERENCES Product (ProductID)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS Address;
CREATE TABLE Address (
    AddressID int(11) NOT NULL AUTO_INCREMENT,
    Street varchar(255) NOT NULL,
    HouseNumber varchar(50) NOT NULL,
    PostalCodeID int(11) NOT NULL,
    PRIMARY KEY (AddressID),
    KEY PostalCodeID (PostalCodeID),
    CONSTRAINT Address_ibfk_1 FOREIGN KEY (PostalCodeID) REFERENCES PostalCode (PostalCodeID)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS Customer;
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
) ENGINE=InnoDB;


CREATE TABLE Orders (
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
) ENGINE=InnoDB;


DROP TABLE IF EXISTS OrderProduct;
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
) ENGINE=InnoDB;