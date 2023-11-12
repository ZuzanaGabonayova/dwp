-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: zuzanagabonayova.eu.mysql.service.one.com:3306
-- Generation Time: Nov 12, 2023 at 03:28 PM
-- Server version: 10.6.15-MariaDB-1:10.6.15+maria~ubu2204
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zuzanagabonayova_euwebshopdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `Address`
--

CREATE TABLE `Address` (
  `AddressID` int(11) NOT NULL,
  `Street` varchar(255) NOT NULL,
  `HouseNumber` varchar(50) NOT NULL,
  `PostalCodeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Address`
--

INSERT INTO `Address` (`AddressID`, `Street`, `HouseNumber`, `PostalCodeID`) VALUES
(1, 'Helena', '5049', 3),
(2, 'Dovetail', '9', 14),
(3, 'Independence', '75489', 5),
(4, 'Schlimgen', '04892', 1),
(5, 'Forster', '1813', 6),
(6, 'Dexter', '8', 7),
(7, 'Eagle Crest', '34951', 2),
(8, 'Michigan', '792', 5),
(9, 'Packers', '6', 15),
(10, 'Rockefeller', '57', 10),
(11, 'Prairie Rose', '768', 7),
(12, 'Lerdahl', '2', 9),
(13, 'Sheridan', '5672', 9),
(14, 'Dayton', '3', 1),
(15, 'Oak Valley', '8', 6),
(16, 'Longview', '5026', 9),
(17, 'Rusk', '36', 10),
(18, 'Raven', '32', 4),
(19, 'Morning', '64756', 5),
(20, 'Forest Dale', '8', 15),
(21, 'Portage', '072', 7),
(22, 'Burrows', '4', 10),
(23, 'Bonner', '1839', 7),
(24, 'John Wall', '53', 11),
(25, 'Dottie', '66650', 12);

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `AdminID` int(11) NOT NULL,
  `FirstName` varchar(200) NOT NULL,
  `LastName` varchar(200) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `UpdatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`AdminID`, `FirstName`, `LastName`, `Email`, `UpdatedAt`) VALUES
(1, 'Laszlo', 'Vitkai', 'lasz0167@easv365.dk', '2023-11-08 12:18:10'),
(2, 'Zuzana', 'Gabonayova', 'zuza0466@easv365.dk', '2023-11-08 12:19:13');

-- --------------------------------------------------------

--
-- Table structure for table `BillingAddress`
--

CREATE TABLE `BillingAddress` (
  `BillingAddressID` int(11) NOT NULL,
  `Street` varchar(255) NOT NULL,
  `HouseNumber` varchar(50) NOT NULL,
  `PostalCodeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `BillingAddress`
--

INSERT INTO `BillingAddress` (`BillingAddressID`, `Street`, `HouseNumber`, `PostalCodeID`) VALUES
(1, 'Shelley', '1', 12),
(2, 'Judy', '79773', 5),
(3, 'Thackeray', '4', 9),
(4, 'Bartelt', '509', 12),
(5, 'Warbler', '41', 8),
(6, 'Laurel', '51407', 7),
(7, 'Hazelcrest', '9', 9),
(8, 'Stoughton', '2404', 10),
(9, '1st', '3160', 1),
(10, 'Springview', '12348', 10),
(11, 'Hollow Ridge', '057', 14),
(12, 'Nancy', '036', 10),
(13, 'Bartelt', '19636', 4),
(14, 'Parkside', '4', 10),
(15, 'Sachs', '8886', 10),
(16, 'West', '394', 3),
(17, 'Vera', '34237', 15),
(18, 'Park Meadow', '440', 9),
(19, 'Weeping Birch', '33', 3),
(20, 'Harbort', '33', 6),
(21, '2nd', '2589', 1),
(22, 'Welch', '8051', 11),
(23, 'Old Shore', '777', 7),
(24, 'Arrowood', '511', 7),
(25, 'Delladonna', '59', 7);

-- --------------------------------------------------------

--
-- Table structure for table `Color`
--

CREATE TABLE `Color` (
  `ColorID` int(11) NOT NULL,
  `ColorName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Color`
--

INSERT INTO `Color` (`ColorID`, `ColorName`) VALUES
(4, 'black'),
(5, 'blue'),
(21, 'blue violet'),
(11, 'brown'),
(13, 'gold'),
(12, 'gray'),
(6, 'green'),
(17, 'indigo'),
(20, 'khaki'),
(16, 'lime green'),
(18, 'magenta'),
(14, 'navy blue'),
(22, 'olive'),
(10, 'orange'),
(9, 'pink'),
(8, 'purple'),
(1, 'red'),
(15, 'sky blue'),
(19, 'violet'),
(3, 'white'),
(7, 'yellow');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(1, 'name', 'lasz0167@easv365.dk', 'message', '2023-11-07 10:19:28'),
(2, 'name', 'lasz0167@easv365.dk', 'hello', '2023-11-07 10:21:09'),
(3, 'Lasz0167', 'lasz0167@easv365.dk', 'hello', '2023-11-07 10:28:22'),
(4, 'Zuzana', 'lasz0167@easv365.dk', 'New message', '2023-11-07 10:32:32'),
(5, 'laszlo', 'lasz0167@easv365.dk', 'new', '2023-11-07 10:45:31'),
(6, 'John', 'laszlo.vitkai@gmail.com', 'Hello', '2023-11-07 10:53:39'),
(7, 'john', 'lasz0167@easv365.dk', 'Lorem ipsum dolor sit', '2023-11-07 10:56:18'),
(8, 'laszlo', 'lasz0167@easv365.dk', 'hello', '2023-11-07 12:31:25'),
(9, 'Zuzana Gabonayova', 'gabonayova.zuzka@gmail.com', 'test', '2023-11-07 23:17:05'),
(10, 'Laszlo', 'lasz0167@easv365.dk', 'Does it still work?', '2023-11-08 06:48:07'),
(11, 'Zuzana Gabonayova', 'gabonayova.zuzka@gmail.com', 'test', '2023-11-08 07:36:08'),
(12, 'Zuzana Gabonayova', 'gabonayova.zuzka@gmail.com', 'testtt', '2023-11-08 07:40:36'),
(13, 'Zuzana', 'gabonayova.zuzka@gmail.com', 'tst', '2023-11-08 07:43:25'),
(14, 'Zuzana Gabonayova', 'gabonayova.zuzka@gmail.com', 'testing', '2023-11-08 07:49:23'),
(15, 'z', 'zuza0466@easv365.dk', 'tet', '2023-11-08 07:52:49'),
(16, 'Zuzana Gabonayova', 'gabonayova.zuzka@gmail.com', 'testing', '2023-11-08 09:29:35'),
(17, 'Zuzana Gabonayova', 'gabonayova.zuzka@gmail.com', 'dascd', '2023-11-08 09:42:49'),
(18, 'hello', 'lasz0167@easv365.dk', 'je', '2023-11-08 13:50:41');

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `CustomerID` int(11) NOT NULL,
  `FirstName` varchar(200) NOT NULL,
  `LastName` varchar(200) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(100) NOT NULL,
  `AddressID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`CustomerID`, `FirstName`, `LastName`, `Email`, `Phone`, `AddressID`) VALUES
(1, 'Ardys', 'Machon', 'amachon0@joomla.org', '+86 308 537 3366', 1),
(2, 'Robinia', 'Izachik', 'rizachik1@goo.ne.jp', '+54 889 836 5560', 2),
(3, 'Ambrosio', 'Bugg', 'abugg2@stanford.edu', '+57 967 624 6629', 3),
(4, 'Kathryn', 'Colam', 'kcolam3@wikimedia.org', '+63 241 371 3707', 4),
(5, 'Maxy', 'Paskerful', 'mpaskerful4@alexa.com', '+967 488 968 3915', 5),
(6, 'Thaxter', 'Auger', 'tauger5@rediff.com', '+51 422 768 4204', 6),
(7, 'Gipsy', 'Cleveland', 'gcleveland6@irs.gov', '+234 698 801 8426', 7),
(8, 'Brook', 'Ratcliffe', 'bratcliffe7@usda.gov', '+62 139 259 0956', 8),
(9, 'Ave', 'Jenkison', 'ajenkison8@smh.com.au', '+216 383 637 7941', 9),
(10, 'Georgena', 'Stammler', 'gstammler9@msn.com', '+967 498 973 9559', 10),
(11, 'Jolie', 'Biasini', 'jbiasinia@va.gov', '+56 899 597 6072', 11),
(12, 'Benita', 'Farrance', 'bfarranceb@sciencedirect.com', '+232 536 838 6037', 12),
(13, 'Aubry', 'Borthe', 'aborthec@trellian.com', '+33 609 828 6120', 13),
(14, 'Hadlee', 'Mc Meekan', 'hmcmeekand@harvard.edu', '+86 750 541 5576', 14),
(15, 'Alfred', 'Manford', 'amanforde@netlog.com', '+62 238 278 7845', 15),
(16, 'Agata', 'Chicken', 'achickenf@cam.ac.uk', '+351 630 995 6664', 16),
(17, 'Tripp', 'Scales', 'tscalesg@w3.org', '+55 571 744 4455', 17),
(18, 'Maynard', 'Dowrey', 'mdowreyh@oaic.gov.au', '+86 429 840 3888', 18),
(19, 'Egon', 'Yankov', 'eyankovi@imageshack.us', '+7 278 399 4963', 19),
(20, 'Melitta', 'Bedboro', 'mbedboroj@fc2.com', '+63 880 187 5934', 20),
(21, 'Marilee', 'Wikey', 'mwikeyk@globo.com', '+7 833 135 4183', 21),
(22, 'Josefina', 'Pierson', 'jpiersonl@psu.edu', '+218 607 738 2787', 22),
(23, 'Faun', 'Beaushaw', 'fbeaushawm@t.co', '+55 234 493 6898', 23),
(24, 'Stevena', 'Brakespear', 'sbrakespearn@techcrunch.com', '+420 658 614 5035', 24),
(25, 'Tonia', 'McCarlich', 'tmccarlicho@joomla.org', '+7 796 747 7951', 25);

-- --------------------------------------------------------

--
-- Table structure for table `DailySpecialOffer`
--

CREATE TABLE `DailySpecialOffer` (
  `DailySpecialOfferID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_posts`
--

CREATE TABLE `news_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news_posts`
--

INSERT INTO `news_posts` (`id`, `title`, `short_description`, `content`, `image`, `image_alt`, `created_at`, `updated_at`) VALUES
(2, 'Global Economic Update', 'Latest update on the global economic shifts.', 'Nulla facilisi. Curabitur at lacus ac velit ornare lobortis. Curabitur a felis in nunc fringilla tristique. Morbi mattis ullamcorper velit. Phasellus gravida semper nisi...', 'assets/images/prod_6550ea64b84e6.jpg', 'Graph showing global economic trends', '2023-11-06 12:49:18', '2023-11-12 15:08:20'),
(3, 'Healthcare and You', 'How recent changes in healthcare may affect you.', 'Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Nullam sagittis. Suspendisse pulvinar, augue ac venenatis condimentum, sem libero volutpat nibh, nec pellentesque velit pede quis nunc...', 'assets/images/prod_6550ea4104926.png', 'Healthcare professionals in discussion', '2023-11-06 12:49:18', '2023-11-12 15:07:45'),
(4, 'Fresh Kicks Alert! Explore New Arrivals at Sneakers Today!', 'The hottest sneakers of the season!', 'Excitement is in the air as Sneakers drops the hottest sneakers of the season! Dive into a collection of exclusive releases and trendsetting styles that promise to elevate your sneaker game. Limited quantities, maximum style snag your pair now and step into a world of unmatched footwear fashion. Don t miss out, visit Sneakers online or in-store today! #SneakerStyle #FreshKicks #NewArrivals', 'assets/images/prod_6550ed991aae3.jpg', 'news1', '2023-11-12 11:28:48', '2023-11-12 15:22:01');

-- --------------------------------------------------------

--
-- Table structure for table `OrderDetails`
--

CREATE TABLE `OrderDetails` (
  `OrderDetailsID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(8,2) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `BillingAddressID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `OrderP`
--

CREATE TABLE `OrderP` (
  `OrderID` int(11) NOT NULL,
  `OrderDate` datetime NOT NULL,
  `OrderStatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PostalCode`
--

CREATE TABLE `PostalCode` (
  `PostalCodeID` int(11) NOT NULL,
  `PostalCode` varchar(70) NOT NULL,
  `City` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `PostalCode`
--

INSERT INTO `PostalCode` (`PostalCodeID`, `PostalCode`, `City`) VALUES
(1, '592 13', 'Bohdalov'),
(2, '458 10', 'Yanglang'),
(3, '56030', 'San Juan'),
(4, '453150', 'Karmaskaly'),
(5, '30404 CEDEX', 'Villeneuve-lès-Avignon'),
(6, '12345', 'Banjarwaru'),
(7, '458 107', 'Yangying Chengguanzhen'),
(8, '41231', 'Uurainen'),
(9, '83514 CEDEX', 'La Seyne-sur-Mer'),
(10, 'H9J', 'Stonewall'),
(11, '34629', 'Clearwater'),
(12, '1248', 'Sumusţā as Sulţānī'),
(13, '31110', 'Nang Rong'),
(14, '67975 CEDEX 9', 'Strasbourg'),
(15, '1024', 'Monjarás');

-- --------------------------------------------------------

--
-- Table structure for table `PresentationOfCompany`
--

CREATE TABLE `PresentationOfCompany` (
  `DescriptionOfCompany` varchar(2000) NOT NULL,
  `OpeningHours` varchar(500) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(100) NOT NULL,
  `Street` varchar(255) NOT NULL,
  `HouseNumber` varchar(50) NOT NULL,
  `PostalCodeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE `Product` (
  `ProductID` int(11) NOT NULL,
  `ProductNumber` varchar(255) NOT NULL,
  `Model` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `ProductMainImage` varchar(255) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `BrandID` int(11) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `EditedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `AdminID` int(11) DEFAULT NULL,
  `StockQuantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Product`
--

INSERT INTO `Product` (`ProductID`, `ProductNumber`, `Model`, `Description`, `Price`, `ProductMainImage`, `CategoryID`, `BrandID`, `CreatedAt`, `EditedAt`, `AdminID`, `StockQuantity`) VALUES
(8, 'P000003', 'Nike Dunk Low big', 'Lorem', 345.00, 'assets/images/prod_654ce5b4411a1.webp', 1, 1, '2023-11-08 13:46:10', '2023-11-09 13:59:16', 1, 3),
(9, 'P000001', 'Nike Dunk Low', 'Created for the hardwood but taken to the streets, the icon returns to let you do good by looking good. Now made from at least 20% recycled materials by weight, we refreshed a classic that keeps the original integrity with a minimised impact. Crafted from synthetic leather, the Dunk Low channels vintage baller style and simple living onto the streets.', 980.00, 'assets/images/prod_654b9f038f7c0.webp', 2, 1, '2023-11-08 14:33:03', '2023-11-09 10:30:44', 2, 0),
(10, 'P000002', 'Nike Dunk Low kids', 'Recognising the Dunk roots as the top-ranking university-team sneaker, the Be True To Your School Pack looks to the original ad campaign for inspiration. Colours represent top-flight universities, while crisp leather has the perfect amount of sheen to make em a hands-down win. So lace up and show off that varsity spirit. Are you game?', 980.00, 'assets/images/prod_654ba39d47c47.webp', 1, 1, '2023-11-08 14:46:23', '2023-11-09 13:24:21', 2, 0),
(13, 'jdk2321', 'Nike Jordan', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enimin eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enimin eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim\r\nin eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor\r\n', 299.00, 'assets/images/prod_654d3faf38217.jpeg', 1, 1, '2023-11-09 20:23:11', '2023-11-10 16:11:54', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ProductBrand`
--

CREATE TABLE `ProductBrand` (
  `BrandID` int(11) NOT NULL,
  `BrandName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ProductBrand`
--

INSERT INTO `ProductBrand` (`BrandID`, `BrandName`) VALUES
(1, 'Nike'),
(2, 'Adidas'),
(3, 'Puma'),
(4, 'Reebok'),
(5, 'New Balance'),
(6, 'Vans'),
(7, 'Converse'),
(8, 'Under Armour'),
(9, 'Tommy Hilfiger'),
(10, 'Jordan');

-- --------------------------------------------------------

--
-- Table structure for table `ProductCategory`
--

CREATE TABLE `ProductCategory` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ProductCategory`
--

INSERT INTO `ProductCategory` (`CategoryID`, `CategoryName`) VALUES
(1, 'men'),
(2, 'women'),
(3, 'kids');

-- --------------------------------------------------------

--
-- Table structure for table `ProductColor`
--

CREATE TABLE `ProductColor` (
  `ProductID` int(11) NOT NULL,
  `ColorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ProductColor`
--

INSERT INTO `ProductColor` (`ProductID`, `ColorID`) VALUES
(8, 4),
(8, 14),
(9, 3),
(9, 4),
(10, 7),
(10, 9),
(13, 8);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`) VALUES
(3, 'Product 3', 'This is the description for product 3', 39.99, 'product3.jpg'),
(4, 'Product 4', 'This is the description for product 4', 49.99, 'product4.jpg'),
(5, 'Product 5', 'This is the description for product 5', 59.99, 'product5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ProductSize`
--

CREATE TABLE `ProductSize` (
  `ProductID` int(11) NOT NULL,
  `SizeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ProductSize`
--

INSERT INTO `ProductSize` (`ProductID`, `SizeID`) VALUES
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(8, 5),
(8, 11),
(8, 17),
(9, 5),
(9, 7),
(9, 9),
(10, 11),
(10, 13),
(10, 15),
(13, 22);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `alt_text`, `created_at`) VALUES
(1, 4, 'https://source.unsplash.com/random/640x480?sig=1', 'Product Image 1', '2023-11-07 12:06:53'),
(2, 4, 'https://source.unsplash.com/random/640x480?sig=2', 'Product Image 2', '2023-11-07 12:06:53'),
(3, 4, 'https://source.unsplash.com/random/640x480?sig=3', 'Product Image 3', '2023-11-07 12:06:53'),
(4, 4, 'https://source.unsplash.com/random/640x480?sig=4', 'Product Image 4', '2023-11-07 12:06:53');

-- --------------------------------------------------------

--
-- Table structure for table `Size`
--

CREATE TABLE `Size` (
  `SizeID` int(11) NOT NULL,
  `Size` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Size`
--

INSERT INTO `Size` (`SizeID`, `Size`) VALUES
(1, 35),
(2, 36),
(3, 37),
(4, 37.5),
(5, 38),
(6, 38.5),
(7, 39),
(8, 39.5),
(9, 40),
(10, 40.5),
(11, 41),
(12, 41.5),
(13, 42),
(14, 42.5),
(15, 43),
(16, 43.5),
(17, 44),
(18, 44.5),
(19, 45),
(20, 45.5),
(21, 46),
(22, 46.5),
(23, 47);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Address`
--
ALTER TABLE `Address`
  ADD PRIMARY KEY (`AddressID`),
  ADD KEY `PostalCodeID` (`PostalCodeID`);

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `BillingAddress`
--
ALTER TABLE `BillingAddress`
  ADD PRIMARY KEY (`BillingAddressID`),
  ADD KEY `PostalCodeID` (`PostalCodeID`);

--
-- Indexes for table `Color`
--
ALTER TABLE `Color`
  ADD PRIMARY KEY (`ColorID`),
  ADD UNIQUE KEY `ColorName` (`ColorName`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`CustomerID`),
  ADD KEY `AddressID` (`AddressID`);

--
-- Indexes for table `DailySpecialOffer`
--
ALTER TABLE `DailySpecialOffer`
  ADD PRIMARY KEY (`DailySpecialOfferID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `news_posts`
--
ALTER TABLE `news_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `OrderDetails`
--
ALTER TABLE `OrderDetails`
  ADD PRIMARY KEY (`OrderDetailsID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `BillingAddressID` (`BillingAddressID`);

--
-- Indexes for table `OrderP`
--
ALTER TABLE `OrderP`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `PostalCode`
--
ALTER TABLE `PostalCode`
  ADD PRIMARY KEY (`PostalCodeID`);

--
-- Indexes for table `PresentationOfCompany`
--
ALTER TABLE `PresentationOfCompany`
  ADD KEY `PostalCodeID` (`PostalCodeID`);

--
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`ProductID`),
  ADD UNIQUE KEY `ProductNumber` (`ProductNumber`),
  ADD KEY `CategoryID` (`CategoryID`),
  ADD KEY `BrandID` (`BrandID`),
  ADD KEY `Author` (`AdminID`);

--
-- Indexes for table `ProductBrand`
--
ALTER TABLE `ProductBrand`
  ADD PRIMARY KEY (`BrandID`);

--
-- Indexes for table `ProductCategory`
--
ALTER TABLE `ProductCategory`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `ProductColor`
--
ALTER TABLE `ProductColor`
  ADD PRIMARY KEY (`ProductID`,`ColorID`),
  ADD KEY `ColorID` (`ColorID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ProductSize`
--
ALTER TABLE `ProductSize`
  ADD PRIMARY KEY (`ProductID`,`SizeID`),
  ADD KEY `SizeID` (`SizeID`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `Size`
--
ALTER TABLE `Size`
  ADD PRIMARY KEY (`SizeID`),
  ADD UNIQUE KEY `Size` (`Size`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Address`
--
ALTER TABLE `Address`
  MODIFY `AddressID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `BillingAddress`
--
ALTER TABLE `BillingAddress`
  MODIFY `BillingAddressID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `Color`
--
ALTER TABLE `Color`
  MODIFY `ColorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `DailySpecialOffer`
--
ALTER TABLE `DailySpecialOffer`
  MODIFY `DailySpecialOfferID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news_posts`
--
ALTER TABLE `news_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `OrderDetails`
--
ALTER TABLE `OrderDetails`
  MODIFY `OrderDetailsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `OrderP`
--
ALTER TABLE `OrderP`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `PostalCode`
--
ALTER TABLE `PostalCode`
  MODIFY `PostalCodeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Product`
--
ALTER TABLE `Product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ProductBrand`
--
ALTER TABLE `ProductBrand`
  MODIFY `BrandID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ProductCategory`
--
ALTER TABLE `ProductCategory`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Size`
--
ALTER TABLE `Size`
  MODIFY `SizeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Address`
--
ALTER TABLE `Address`
  ADD CONSTRAINT `Address_ibfk_1` FOREIGN KEY (`PostalCodeID`) REFERENCES `PostalCode` (`PostalCodeID`);

--
-- Constraints for table `BillingAddress`
--
ALTER TABLE `BillingAddress`
  ADD CONSTRAINT `BillingAddress_ibfk_1` FOREIGN KEY (`PostalCodeID`) REFERENCES `PostalCode` (`PostalCodeID`);

--
-- Constraints for table `Customer`
--
ALTER TABLE `Customer`
  ADD CONSTRAINT `Customer_ibfk_1` FOREIGN KEY (`AddressID`) REFERENCES `Address` (`AddressID`);

--
-- Constraints for table `DailySpecialOffer`
--
ALTER TABLE `DailySpecialOffer`
  ADD CONSTRAINT `DailySpecialOffer_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `Product` (`ProductID`);

--
-- Constraints for table `OrderDetails`
--
ALTER TABLE `OrderDetails`
  ADD CONSTRAINT `OrderDetails_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `OrderP` (`OrderID`),
  ADD CONSTRAINT `OrderDetails_ibfk_3` FOREIGN KEY (`CustomerID`) REFERENCES `Customer` (`CustomerID`),
  ADD CONSTRAINT `OrderDetails_ibfk_4` FOREIGN KEY (`BillingAddressID`) REFERENCES `BillingAddress` (`BillingAddressID`);

--
-- Constraints for table `PresentationOfCompany`
--
ALTER TABLE `PresentationOfCompany`
  ADD CONSTRAINT `PresentationOfCompany_ibfk_1` FOREIGN KEY (`PostalCodeID`) REFERENCES `PostalCode` (`PostalCodeID`);

--
-- Constraints for table `Product`
--
ALTER TABLE `Product`
  ADD CONSTRAINT `Product_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `ProductCategory` (`CategoryID`),
  ADD CONSTRAINT `Product_ibfk_2` FOREIGN KEY (`BrandID`) REFERENCES `ProductBrand` (`BrandID`),
  ADD CONSTRAINT `Product_ibfk_3` FOREIGN KEY (`AdminID`) REFERENCES `Admin` (`AdminID`);

--
-- Constraints for table `ProductColor`
--
ALTER TABLE `ProductColor`
  ADD CONSTRAINT `ProductColor_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `Product` (`ProductID`),
  ADD CONSTRAINT `ProductColor_ibfk_2` FOREIGN KEY (`ColorID`) REFERENCES `Color` (`ColorID`);

--
-- Constraints for table `ProductSize`
--
ALTER TABLE `ProductSize`
  ADD CONSTRAINT `ProductSize_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `Product` (`ProductID`),
  ADD CONSTRAINT `ProductSize_ibfk_2` FOREIGN KEY (`SizeID`) REFERENCES `Size` (`SizeID`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
