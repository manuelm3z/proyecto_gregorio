CREATE DATABASE  IF NOT EXISTS `amparo` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `amparo`;
-- MySQL dump 10.13  Distrib 5.5.28, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: amparo
-- ------------------------------------------------------
-- Server version	5.5.28-0ubuntu0.12.10.1

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
-- Table structure for table `representante`
--

DROP TABLE IF EXISTS `representante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `representante` (
  `idRepresentante` varchar(10) NOT NULL,
  `nombresRepresentante` varchar(60) NOT NULL,
  `apellidosRepresentante` varchar(60) NOT NULL,
  `cedulaRepresentante` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `oficio` varchar(60) NOT NULL,
  `fechaNacimientoR` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`idRepresentante`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `representante`
--

LOCK TABLES `representante` WRITE;
/*!40000 ALTER TABLE `representante` DISABLE KEYS */;
INSERT INTO `representante` VALUES ('JP15468951','Jose','Perez','15468951','02443957035','Obrero','1986-09-15',0),('MM12345678','Martin','Maza','12345678','04124683023','Vendedor','1985-08-21',1),('MZ17247580','Manuel Martin','Zambrano Maza','17247580','04261408684','Analista','1986-09-21',1);
/*!40000 ALTER TABLE `representante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumno`
--

DROP TABLE IF EXISTS `alumno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumno` (
  `idAlumno` varchar(10) NOT NULL,
  `nombresAlumno` varchar(60) NOT NULL,
  `apellidosAlumno` varchar(60) NOT NULL,
  `cedulaAlumno` varchar(20) DEFAULT NULL,
  `fechaNacimientoA` date NOT NULL,
  `lugarNacimiento` varchar(60) NOT NULL,
  `estatura` int(4) NOT NULL,
  `peso` int(4) NOT NULL,
  `tCamisa` varchar(4) NOT NULL,
  `tPantalon` varchar(4) NOT NULL,
  `tZapatos` int(4) NOT NULL,
  `observacion` text,
  `idRepresentante` varchar(10) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `fechaRegistro` date NOT NULL,
  PRIMARY KEY (`idAlumno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumno`
--

LOCK TABLES `alumno` WRITE;
/*!40000 ALTER TABLE `alumno` DISABLE KEYS */;
INSERT INTO `alumno` VALUES ('AZ62486','Arturo','Zambrano','25874963','2001-12-15','Maracay',69,56,'M','30',35,'','MZ17247580',0,'2012-11-30'),('MZ42158','Martina','Zambrano','','2002-06-12','Maracay',50,45,'s','25',32,'','MZ17247580',1,'2012-11-30'),('MZ69021','Manuel','Zambrano','','2000-01-14','Maracay',56,45,'m','27',35,'','MZ17247580',0,'2012-11-29');
/*!40000 ALTER TABLE `alumno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `idUsuario` int(4) NOT NULL AUTO_INCREMENT,
  `login` varchar(60) NOT NULL,
  `clave` varchar(60) NOT NULL,
  `fechaRegistro` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'admin','admin','2012-11-25',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-12-01  1:11:28
