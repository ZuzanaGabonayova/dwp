-- This trigger will update the UpdatedAt field in the Admin table with the current timestamp before each update on the Admin table
DELIMITER //
CREATE TRIGGER BeforeUpdateOnAdmin BEFORE UPDATE ON Admin
FOR EACH ROW BEGIN
    SET new.UpdatedAt = NOW();
END //
DELIMITER ;



-- This trigger will be activated after an insert into the OrderDetails table, and it will update the StockQuantity of the corresponding product by subtracting the quantity ordered.
DELIMITER //
CREATE TRIGGER AfterInsertOnOrderDetails AFTER INSERT ON OrderDetails
FOR EACH ROW BEGIN
    -- Decrease the stock quantity of the ordered product
    UPDATE Product
    SET StockQuantity = StockQuantity - NEW.Quantity
    WHERE ProductID = NEW.ProductID;
END //
DELIMITER ;


-- Automatically Set Billing Address for New Customers:
DELIMITER //
CREATE TRIGGER AfterInsertOnCustomer AFTER INSERT ON Customer
FOR EACH ROW BEGIN
    INSERT INTO BillingAddress (Street, HouseNumber, PostalCodeID)
    VALUES (NEW.Street, NEW.HouseNumber, NEW.PostalCodeID);
END //
DELIMITER ;
