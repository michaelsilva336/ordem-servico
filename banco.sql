

---------------------------------------------------------------------------------------



create database if not exists sistemos

use sistemos;

ALTER DATABASE `sistemos` CHARSET = UTF8 COLLATE = utf8_general_ci;


CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `user` varchar(20) NOT NULL,
  `password` varchar(150) NOT NULL,
  `token` varchar(150) NOT NULL,
  `priority` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci


CREATE TABLE `clients` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cpf` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cell` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `rua` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `number` int(10) NOT NULL,
  `district` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `city` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `state` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cep` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `entry_date` timestamp NULL DEFAULT current_timestamp(),
  `users_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci




CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `brand` varchar(30) NOT NULL,
  `unity` varchar(5) NOT NULL,
  `value_buy` float DEFAULT NULL,
  `value_sale` float NOT NULL,
  `amount` int(11) NOT NULL,
  `inventory` int(10) NOT NULL,
  `barcode` int(50) DEFAULT NULL,
  `entry_date` timestamp NULL DEFAULT current_timestamp(),
  `users_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci



CREATE TABLE `services` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `value` float NOT NULL,
  `description` varchar(200) NOT NULL,
  `entry_date` timestamp NULL DEFAULT current_timestamp(),
  `users_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `services_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci



CREATE TABLE `services_orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `responsible` varchar(20) DEFAULT NULL,
  `warranty` varchar(45) DEFAULT NULL,
  `product_description` varchar(150) DEFAULT NULL,
  `defect` varchar(150) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `observation` varchar(150) DEFAULT NULL,
  `technical_report` varchar(150) DEFAULT NULL,
  `value_total` varchar(15) DEFAULT NULL,
  `billed` varchar(10) NOT NULL,
  `clients_id` int(11) unsigned NOT NULL,
  `users_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `clients_id` (`clients_id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `services_orders_ibfk_1` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `services_orders_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci



CREATE TABLE `products_os` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL,
  `sub_total` float DEFAULT NULL,
  `porcent` float NOT NULL,
  `porcent_price_sum` float NOT NULL,
  `porcent_value_total` float NOT NULL,
  `services_orders_id` int(11) unsigned NOT NULL,
  `products_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `products_os_ibfk_1` (`services_orders_id`),
  KEY `products_os_ibfk_2` (`products_id`),
  CONSTRAINT `products_os_ibfk_1` FOREIGN KEY (`services_orders_id`) REFERENCES `services_orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_os_ibfk_2` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci





CREATE TABLE `services_os` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sub_total` float DEFAULT NULL,
  `services_orders_id` int(11) unsigned NOT NULL,
  `services_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `services_os_ibfk_1` (`services_orders_id`),
  KEY `services_os_ibfk_2` (`services_id`),
  CONSTRAINT `services_os_ibfk_1` FOREIGN KEY (`services_orders_id`) REFERENCES `services_orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `services_os_ibfk_2` FOREIGN KEY (`services_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci





CREATE TABLE `vehicles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `brand` varchar(20) NOT NULL,
  `model` varchar(20) NOT NULL,
  `year` varchar(30) NOT NULL,
  `choose` varchar(20) NOT NULL,
  `date_entry` timestamp NOT NULL DEFAULT current_timestamp(),
  `clients_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `clients` (`clients_id`),
  CONSTRAINT `clients` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci


CREATE TABLE `porcent` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `price_product` float NOT NULL,
  `price_sum` float NOT NULL,
  `mount` int(10) NOT NULL,
  `porcent_value` float NOT NULL,
  `porcent_value_total` float NOT NULL,
  `os_id_porcent` int(11) unsigned NOT NULL,
  `product_id_porcent` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `porcent_ibfk_1` (`os_id_porcent`),
  KEY `porcent_ibfk_2` (`product_id_porcent`),
  CONSTRAINT `porcent_ibfk_1` FOREIGN KEY (`os_id_porcent`) REFERENCES `services_orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `porcent_ibfk_2` FOREIGN KEY (`product_id_porcent`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci




ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci





