CREATE DATABASE  IF NOT EXISTS `farmington` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `farmington`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: ec2-54-68-234-52.us-west-2.compute.amazonaws.com    Database: farmington
-- ------------------------------------------------------
-- Server version	5.5.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(250) NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `color` char(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (52,'Religion',0,NULL,'2014-12-13 23:51:17',NULL),(53,'Slavery',1,NULL,NULL,NULL),(54,'Government',2,NULL,NULL,NULL),(55,'Economy',3,NULL,NULL,NULL),(56,'Natural Features',4,NULL,NULL,NULL),(57,'Education',5,NULL,NULL,NULL),(58,'Population',6,NULL,NULL,NULL),(59,'Land Transactions',7,NULL,NULL,NULL);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `era`
--

DROP TABLE IF EXISTS `era`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `era` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(250) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `era`
--

LOCK TABLES `era` WRITE;
/*!40000 ALTER TABLE `era` DISABLE KEYS */;
INSERT INTO `era` VALUES (80,'1680',NULL,NULL),(81,'1720',NULL,NULL),(82,'1760',NULL,NULL),(83,'1800',NULL,NULL),(84,'1840',NULL,NULL),(85,'1880',NULL,NULL),(86,'1920',NULL,NULL),(87,'1960',NULL,NULL),(88,'2000',NULL,NULL),(89,'2040',NULL,NULL),(90,'1610',NULL,NULL),(91,'1640',NULL,NULL);
/*!40000 ALTER TABLE `era` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo`
--

DROP TABLE IF EXISTS `photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(500) NOT NULL,
  `point_of_interest_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `point_of_interest_id` (`point_of_interest_id`),
  CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`point_of_interest_id`) REFERENCES `point_of_interest` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo`
--

LOCK TABLES `photo` WRITE;
/*!40000 ALTER TABLE `photo` DISABLE KEYS */;
INSERT INTO `photo` VALUES (20,'stanley_whitman_house.jpg',54,NULL,NULL);
/*!40000 ALTER TABLE `photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `point_of_interest`
--

DROP TABLE IF EXISTS `point_of_interest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `point_of_interest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `name` varchar(500) NOT NULL,
  `description` varchar(20000) DEFAULT NULL,
  `display` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `point_of_interest`
--

LOCK TABLES `point_of_interest` WRITE;
/*!40000 ALTER TABLE `point_of_interest` DISABLE KEYS */;
INSERT INTO `point_of_interest` VALUES (51,41.72129900,-72.83000600,'First Church of Christ Congregational','75 Main Street, Farmington.  National Historic Landmark.  The Congregational Church in Farmington has a long history, beginning in 1652 when seven \"pillars\" established the church. The present meetinghouse, built by Judah Woodruff in 1774, is the third meetinghouse on the site. Roger Newton, the first pastor, was the son-in-law of Hartford founder Thomas Hooker, and was succeeded by Hooker\'s son, Samuel. Among First Church\'s pastors was Noah Porter, who began America\'s first foreign missionary society and supported the abolition of slavery. He was also the father of Sarah Porter, founder of Miss Porter\'s School, and Noah Porter, Jr., president of Yale University. In its  350- year history, First Church has had 18 Senior Ministers.',1,NULL,NULL),(52,41.73690050,-72.85156690,'Farmington River','The 81-mile long Farmington River has been a critical source of water for farming, living and transportation since man\'s earliest occupation of the area. In 1994, a 14-mile segment of the Farmington River received Federal Wild and Scenic designation, the first r iver so named in Connecticut and one of only six in New England.',1,NULL,NULL),(53,41.71997000,-72.82817100,'The Farmington Academy','13 Church Street, Farmington.  Built in 1816 as a school for boys taught by Deacon Stephen Hart, in which English grammar, geography, Greek and Latin were taught. The school operated until 1850 and was then used as a town hall for a brief period of time. The building was the site of numerous abolitionist and anti-abolitionist meetings.  It was moved to its present location in 1917 and is now a private residence.',1,NULL,NULL),(54,41.72139280,-72.82595160,'Stanley-Whitman House','37 High Street, Farmington. National Historic Landmark.  Built by Deacon John Stanley sometime between 1709-1719, the building is one of the best existing examples of New England overframe architecture. The house was used as a home untill 1928, when D. Newton Barney purchased it, had it restored, and opened it as the \"Farmingotn Museum\" in 1935. It continues to function as a museum of Early American history, open to the public. Owned by The Farmingotn Village Green and Library Association.',1,NULL,NULL),(55,41.72282200,-72.83283900,'The Hart Grist Mill','2 Mill Lane, Farmington.  The Grist Mill was constructed in 1650 by Deacon Stephen Hart, using the power of the Farmington River to grind flour.  Owners have included Roger Hooker (1757), Thomas Hart Hooker (1770), Samuel Deming (1770), Winchell Smith (1917) and Helen Winter (1970). Until 1963, local people could still buy flour at the self-service window and leave money in the box. Owned by Miss Porter\'s School, it is now private.',1,NULL,NULL),(56,41.71762400,-72.83434000,'Austin Williams Home and Carriage  House.','127 Main Street, Farmington.  National Historic Landmark. Austin Williams was one of those responsible for bringing the Mendi Africans to Farmington. Williams gave a pportion of his land on which townspeople built a dormitory for the men and boys. The building still retains interior dormitory features. Sengbe Pieh\'s private room and back-to-back privies.  A rear a ddition served teh Underground Railroad, with a trapdoor to a windowless basemen where fugitives hid. ',1,NULL,NULL),(57,41.75851500,-72.88715200,'Tunxis Hose Company No. 1','42 Lovely Street, Unionville.  National Register of Historic Places. Unionville Historic District.  After a disastrous fire in one of the paper mills, Unionville citizens petitioned the General Assembly to form a fire district for the village. With financial help from the mills, a Queen Anne-style firehouse was constructed in 1893. The building features a 3-story drying tower for the canvas  hoses. It is now owned by the Town of Farmington.',1,NULL,NULL),(58,41.76260000,-72.89273300,'Griswold-Mulrooney House','206 Main Street, Unionville. Edwin Griswold built this house around 1870, selling it to Mrs. Ann Mulrooney in 1875. The Mulrooney family worked in the Platner and Porter paper mills (later the American Writing Company) and were active in St. Mary\'s Star of the Sea Catholic Church. The building is significiant for its association with the Mulrooney fa mily, one of the area\'s earliest and most prominent Irish immigrant families.',1,NULL,NULL),(59,41.75963900,-72.88954100,'Dr. William Sage House','20 Elm Street, Unionville. Unionville Historic District.  The house was built in 1852 in a Vernacular style with Greek Revival influences. Dr. William Sage (1825-1909) came to Unionville as a young physician in 1850, and became the village\'s leading physician. A Yale graduate, he practice homeopahty, which led to his his ouster from the Connecticut Medical Society.',1,NULL,NULL),(60,41.74605800,-72.78136100,'Round Hill','Farmington Avenue, Farmington.  A geographic reference point for Native Americans and the early English settlers, this slight rise was used in delineating boundaries in the original land agreement between the Tunxis and the English. It is now the site of the town\'s water treatment plant.',1,NULL,NULL),(61,41.74524013,-72.96295166,'test1','hhhhhhhhhh',0,'2014-12-09 21:10:33','2014-12-09 21:16:33'),(62,41.70219127,-72.88742065,'Test2','e',0,'2014-12-09 21:12:14','2014-12-09 21:16:17'),(63,41.72083224,-72.95899201,'NameTest','a brief description.....<br>',1,'2014-12-13 23:37:08','2014-12-13 23:37:08');
/*!40000 ALTER TABLE `point_of_interest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `point_of_interest_category`
--

DROP TABLE IF EXISTS `point_of_interest_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `point_of_interest_category` (
  `point_of_interest_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`point_of_interest_id`,`category_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `point_of_interest_category_ibfk_1` FOREIGN KEY (`point_of_interest_id`) REFERENCES `point_of_interest` (`id`),
  CONSTRAINT `point_of_interest_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `point_of_interest_category`
--

LOCK TABLES `point_of_interest_category` WRITE;
/*!40000 ALTER TABLE `point_of_interest_category` DISABLE KEYS */;
INSERT INTO `point_of_interest_category` VALUES (51,52),(61,52),(62,52),(63,52),(51,53),(56,53),(63,53),(51,54),(57,54),(52,55),(55,55),(58,55),(52,56),(55,56),(60,56),(53,57),(54,58),(58,58),(60,59);
/*!40000 ALTER TABLE `point_of_interest_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `point_of_interest_era`
--

DROP TABLE IF EXISTS `point_of_interest_era`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `point_of_interest_era` (
  `point_of_interest_id` int(11) NOT NULL DEFAULT '0',
  `era_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`point_of_interest_id`,`era_id`),
  KEY `era_id` (`era_id`),
  CONSTRAINT `point_of_interest_era_ibfk_1` FOREIGN KEY (`point_of_interest_id`) REFERENCES `point_of_interest` (`id`),
  CONSTRAINT `point_of_interest_era_ibfk_2` FOREIGN KEY (`era_id`) REFERENCES `era` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `point_of_interest_era`
--

LOCK TABLES `point_of_interest_era` WRITE;
/*!40000 ALTER TABLE `point_of_interest_era` DISABLE KEYS */;
INSERT INTO `point_of_interest_era` VALUES (51,80),(52,80),(55,80),(60,80),(51,81),(52,81),(54,81),(55,81),(60,81),(51,82),(52,82),(54,82),(55,82),(60,82),(51,83),(52,83),(54,83),(55,83),(60,83),(51,84),(52,84),(53,84),(54,84),(55,84),(56,84),(60,84),(51,85),(52,85),(53,85),(54,85),(55,85),(56,85),(58,85),(59,85),(60,85),(51,86),(52,86),(53,86),(54,86),(55,86),(56,86),(57,86),(58,86),(59,86),(60,86),(51,87),(52,87),(53,87),(54,87),(55,87),(56,87),(57,87),(58,87),(59,87),(60,87),(51,88),(52,88),(53,88),(54,88),(55,88),(56,88),(57,88),(58,88),(59,88),(60,88),(51,89),(52,89),(53,89),(54,89),(55,89),(56,89),(57,89),(58,89),(59,89),(60,89),(61,89),(62,89),(52,90),(60,90),(63,90),(52,91),(60,91),(63,91);
/*!40000 ALTER TABLE `point_of_interest_era` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(64) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin','admin@stanleywhitman.org','$2y$10$xuvwSkIRz7Ru8w3ZnAUrgu8aFCfyr9Mtr0/tmJnVKyc5.t3BCvwZK',NULL,'2014-12-15 03:26:33','2014-12-15 03:26:33');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-15  9:30:00
