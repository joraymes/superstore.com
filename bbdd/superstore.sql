-- DDL Base de datos SUPERSTORE.COM --
-- Crear Base de datos --
create DATABASE IF NOT EXISTS superstore 
CHARACTER SET utf8 COLLATE utf8_general_ci;
-- Crear Usuario de BD --
CREATE USER IF NOT EXISTS 'u_superstore'@'%' IDENTIFIED BY '12345';
-- Asignaciónd de permisos --
GRANT ALL ON superstore.* TO u_superstore;

-- Seleccionar BD activa --
USE superstore ;
-- tbl_countries -- 
CREATE TABLE IF NOT EXISTS  `superstore`.`tbl_countries` (
	`id` INT(11) NOT NULL AUTO_INCREMENT, 
	`country` VARCHAR(50) ,
	PRIMARY KEY(`id`)
);
-- tbl_states -- 
CREATE TABLE IF NOT EXISTS `superstore`.`tbl_states` (
	`id` INT(11) NOT NULL AUTO_INCREMENT, 
	`state` VARCHAR(50) ,
	`id_countries` INT(11) NOT NULL ,
	PRIMARY KEY(`id`)
);

ALTER TABLE `tbl_states` ADD CONSTRAINT Fk_states_countries 
FOREIGN KEY (`id_countries`) 
REFERENCES tbl_countries(`id`) ON DELETE CASCADE ON UPDATE CASCADE ;

-- tbl_regions -- 
CREATE TABLE IF NOT EXISTS  `superstore`.`tbl_regions` (
	`id` INT(11) NOT NULL AUTO_INCREMENT, 
	`region` VARCHAR(50) ,
	PRIMARY KEY(`id`)
);

-- tbl_cities --
CREATE TABLE IF NOT EXISTS `superstore`.`tbl_cities` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`city` VARCHAR(45) NULL,
	`postalCode` VARCHAR(45) NULL,
	`id_states` INT(11) NULL,
	`id_regions` INT(11) NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `tbl_cities` ADD CONSTRAINT Fk_cities_states 
FOREIGN KEY (`id_states`) 
REFERENCES tbl_states(`id`) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE `tbl_cities` ADD CONSTRAINT Fk_cities_regions 
FOREIGN KEY (`id_regions`) 
REFERENCES tbl_regions(`id`) ON DELETE CASCADE ON UPDATE CASCADE ;

-- tbl_customers --
CREATE TABLE IF NOT EXISTS `superstore`.`tbl_customers` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`code` VARCHAR(55) NULL,
	`name` VARCHAR(255) NULL,
	`segment` ENUM('Corporate', 'Home Office', 'Consumer') NULL,
	`id_cities` INT(11) NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_tbl_customers_tbl_cities1_idx` (`id_cities` ASC),
	CONSTRAINT `fk_tbl_customers_tbl_cities1` FOREIGN KEY (`id_cities`)
	REFERENCES `superstore`.`tbl_cities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
-- tbl_ordres --
CREATE TABLE IF NOT EXISTS `superstore`.`tbl_orders` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`code` VARCHAR(45) NULL,
	`orderDate` DATE NULL,
	`shipDate` DATE NULL,
	`shipMode` ENUM('First Class', 'Second Class', 'Standard Class') NULL,
	`id_customers` INT(11) NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_tbl_orders_tbl_customers1_idx` (`id_customers` ASC),
	CONSTRAINT `fk_tbl_orders_tbl_customers1` FOREIGN KEY (`id_customers`)
	REFERENCES `superstore`.`tbl_customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
-- tbl_categories --
CREATE TABLE IF NOT EXISTS `superstore`.`tbl_categories` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`category` VARCHAR(255) NULL,
	`id_categories` INT(11) NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_tbl_categories_tbl_categories1_idx` (`id_categories` ASC),
	CONSTRAINT `fk_tbl_categories_tbl_categories1` FOREIGN KEY (`id_categories`)
	REFERENCES `superstore`.`tbl_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
-- tbl_products --
CREATE TABLE IF NOT EXISTS `superstore`.`tbl_products` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`code` VARCHAR(55) NULL,
	`name` VARCHAR(255) NULL,
	`id_categories` INT(11) NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_tbl_products_tbl_categories1_idx` (`id_categories` ASC),
	CONSTRAINT `fk_tbl_products_tbl_categories1` FOREIGN KEY (`id_categories`)
	REFERENCES `superstore`.`tbl_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- tbl_orders_products --
CREATE TABLE IF NOT EXISTS `superstore`.`tbl_orders_products` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`id_orders` INT(11) NULL,
	`id_products` INT(11) NULL,
	`sales` DECIMAL(10,2) NULL,
	`quantity` INT NULL,
	`discount` DECIMAL(10,2) NULL,
	`profit` DECIMAL(10,4) NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_tbl_orders_products_tbl_orders1_idx` (`id_orders` ASC),
	INDEX `fk_tbl_orders_products_tbl_products1_idx` (`id_products` ASC),
	CONSTRAINT `fk_tbl_orders_products_tbl_orders1` FOREIGN KEY (`id_orders`)
	REFERENCES `superstore`.`tbl_orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT `fk_tbl_orders_products_tbl_products1` FOREIGN KEY (`id_products`)
	REFERENCES `superstore`.`tbl_products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

