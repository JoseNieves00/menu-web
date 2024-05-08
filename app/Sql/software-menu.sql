/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 5.7.28 : Database - software-menu
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `category-product` */

DROP TABLE IF EXISTS `category-product`;

CREATE TABLE `category-product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `state` int(11) NOT NULL DEFAULT '1',
  `is_principal` int(11) NOT NULL DEFAULT '0' COMMENT '1=si\r\n0=no',
  `has_size` int(11) NOT NULL DEFAULT '1' COMMENT '1=si 0=no',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `category-product` */

insert  into `category-product`(`id`,`name`,`description`,`state`,`is_principal`,`has_size`,`created_at`,`updated_at`) values 
(1,'pizzas sencillas','pizzas sencillas',1,1,1,'2024-04-30 09:47:17','2024-04-30 09:47:17'),
(2,'pizzas combinadas','pizzas combinadas',1,1,1,'2024-04-30 10:39:47','2024-04-30 10:39:47'),
(3,'Pizzas Especiales','Pizzas Especiales',1,1,1,'2024-04-30 10:40:01','2024-04-30 10:40:01'),
(4,'Adiciones','Adiciones',1,1,1,'2024-04-30 10:41:09','2024-04-30 10:41:09'),
(5,'Bordes','Bordes',1,0,1,'2024-04-30 10:41:28','2024-04-30 10:41:28'),
(6,'Calzones','Calzones',1,1,0,'2024-04-30 10:41:56','2024-04-30 10:41:56'),
(7,'Lasagnas','Lasagnas',1,1,0,'2024-04-30 10:42:13','2024-04-30 10:42:13'),
(8,'Pastas','Pastas',1,1,0,'2024-04-30 10:42:28','2024-04-30 10:42:28'),
(9,'Bebidas','Bebidas',1,1,0,'2024-04-30 10:42:40','2024-04-30 10:42:40');

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double DEFAULT NULL,
  `price_xs` int(11) DEFAULT NULL COMMENT '1 porcion',
  `price_s` int(11) DEFAULT NULL COMMENT '6 porciones',
  `price_m` int(11) DEFAULT NULL COMMENT '10 porciones',
  `price_l` int(11) DEFAULT NULL COMMENT '12 porciones',
  `price_xl` int(11) DEFAULT NULL COMMENT '12 porciones (mas grande)',
  `id_product_category` int(11) NOT NULL COMMENT '1= Pizza',
  `description` text COLLATE utf8mb4_unicode_ci,
  `url_image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `product` */

insert  into `product`(`id`,`name`,`price`,`price_xs`,`price_s`,`price_m`,`price_l`,`price_xl`,`id_product_category`,`description`,`url_image`,`state`,`created_at`,`updated_at`) values 
(1,'pizza 1',NULL,10000,20000,30000,40000,55000,1,'pizza 1','1.png',1,'2024-04-30 09:47:34','2024-04-30 09:47:34'),
(2,'pizza 2',NULL,20000,30000,40000,50000,70000,1,'pizza 2','2.png',1,'2024-04-30 09:47:52','2024-04-30 09:47:52'),
(3,'pizza 3',NULL,30000,40000,50000,60000,70000,1,'pizza 3','3.png',1,'2024-04-30 11:33:37','2024-05-03 17:55:16'),
(4,'Coca Cola 1.5L',10000,NULL,NULL,NULL,NULL,NULL,9,'Coca Cola Litro','cocaCola.webp',1,'2024-05-01 12:25:32','2024-05-01 12:25:32'),
(5,'Carnes Tradicionales',NULL,NULL,4900,6900,8900,10900,4,'Carnes Tradicionales','',1,'2024-05-02 10:57:39','2024-05-02 10:57:39');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`first_name`,`last_name`,`username`,`password`,`state`,`created_at`,`updated_at`) values 
(2,'soporte','soporte','soporte','827ccb0eea8a706c4c34a16891f84e7b',1,'2024-05-01 15:29:31','2024-05-01 15:29:31');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
