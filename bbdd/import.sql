-- Data import --
LOAD DATA INFILE "C:/IFCD0210/Projectes/superstore.com/bbdd/tbl_countries.csv"
INTO TABLE `superstore`.`tbl_countries`
CHARACTER SET utf8
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
-- Data import --
LOAD DATA INFILE "C:/IFCD0210/Projectes/superstore.com/bbdd/tbl_states.csv"
INTO TABLE `superstore`.`tbl_states`
CHARACTER SET utf8
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
-- Data import --
LOAD DATA INFILE "C:/IFCD0210/Projectes/superstore.com/bbdd/tbl_regions.csv"
INTO TABLE `superstore`.`tbl_regions`
CHARACTER SET utf8
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
-- Data import --
LOAD DATA INFILE "C:/IFCD0210/Projectes/superstore.com/bbdd/tbl_cities.csv"
INTO TABLE `superstore`.`tbl_cities`
CHARACTER SET utf8
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;

-- Data import --
LOAD DATA INFILE "C:/IFCD0210/Projectes/superstore.com/bbdd/tbl_customers.csv"
INTO TABLE `superstore`.`tbl_customers`
CHARACTER SET utf8
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
-- Data import --
LOAD DATA INFILE "C:/IFCD0210/Projectes/superstore.com/bbdd/tbl_categories.csv"
INTO TABLE `superstore`.`tbl_categories`
CHARACTER SET utf8
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
-- Data import --
LOAD DATA INFILE "C:/IFCD0210/Projectes/superstore.com/bbdd/tbl_products.csv"
INTO TABLE `superstore`.`tbl_products`
CHARACTER SET utf8
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
-- Data import --
LOAD DATA INFILE "C:/IFCD0210/Projectes/superstore.com/bbdd/tbl_orders.csv"
INTO TABLE `superstore`.`tbl_orders`
CHARACTER SET utf8
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(id, code, @var1,@var2,shipMode,id_customers)
SET orderDate = str_to_date(@var1,'%d/%m/%Y') ,
shipDate = str_to_date(@var2,'%d/%m/%Y') ;
-- Data import --
LOAD DATA INFILE " C:/IFCD0210/Projectes/superstore.com/bbdd/tbl_orders_products.csv"
INTO TABLE `superstore`.`tbl_orders_products`
CHARACTER SET utf8
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(id, id_orders, id_products ,@var1, quantity,@var2,@var3)
SET sales = REPLACE(@var1, ',', '.'), discount = REPLACE(@var2, ',', '.'), profit=REPLACE(@var3, ',', '.');
