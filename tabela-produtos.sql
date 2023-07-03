CREATE TABLE Product(
ID int(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ProductCode char(10) NOT NULL,
ProductName varchar(255) NOT NULL,
Price float NOT NULL,
PricePromotion float NOT NULL,
Tax float NOT NULL,
Promotion bool NOT NULL,
IsActive bool NOT NULL,
CreatedAt date NOT NULL,
UpdatedAt date);
