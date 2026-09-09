-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: simc_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `consultas`
--

DROP TABLE IF EXISTS `consultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consultas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `mensaje` text NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultas`
--

LOCK TABLES `consultas` WRITE;
/*!40000 ALTER TABLE `consultas` DISABLE KEYS */;
INSERT INTO `consultas` VALUES (2,'Enzo Puntano','enzo.puntano.t1vl@gmail.com','muy caro xdd','181.104.119.237',1,'2026-08-26 21:13:22'),(3,'Ing. Carlos Méndez','carlos.mendez@ternium-logistica.com','Hola equipo SIMC, quisiéramos saber si el sistema soporta transmisión de 16 cámaras IP a 1080p simultáneas con el modelo YOLOv8 nano o si recomiendan distribuir el procesamiento en varios nodos locales.','190.220.14.82',1,'2026-09-01 13:24:15'),(4,'Mariana Rossi','mrossi@ingenieria-it.com.ar','Buenas tardes, me interesa solicitar presupuesto para implementar el módulo de detección de intrusión perimetral en un predio fabril de 4 hectáreas con alertas en tiempo real.','181.16.89.102',1,'2026-09-01 19:45:30'),(5,'Lic. Diego Fernández','dfernandez@seguridadprivada.net','¿El panel web de SIMC permite exportar reportes de incidentes en formato PDF y Excel automáticamente todos los fines de semana? Buscamos automatizar los reportes para nuestros clientes.','190.13.44.205',1,'2026-09-02 12:12:00'),(6,'Valeria Gómez','valeria.g@tech-innovations.io','Felicitaciones por la presentación en el evento de ciberseguridad. Quisiéramos agendar una demo técnica para evaluar la integración de su agente de visión con nuestro software central.','200.45.112.33',1,'2026-09-02 17:38:12'),(7,'Lucas Santillán','lsantillan@distribuidora-norte.com','Hola, ¿cuál es el requerimiento mínimo de hardware y GPU para correr el agente en un servidor on-premise conectado a 8 cámaras RTSP?','186.12.90.14',1,'2026-09-02 21:05:44'),(8,'Martín Palermo','mpalermo@bocajuniors-seguridad.com','Estimados, consulto por los tiempos de respuesta del bot de Telegram al detectar personas en sectores no autorizados durante horarios nocturnos.','181.117.165.69',1,'2026-09-03 14:20:10'),(9,'Dra. Florencia Paz','fpaz@hospital-central.org','¿Tienen alguna solución o módulo adaptado para control de acceso y detección de objetos olvidados/abandonados en salas de espera y guardias médicas?','190.2.140.78',1,'2026-09-03 18:40:22'),(10,'Gustavo Ibarra','gibarra@telecomunicaciones-ar.com','¿El servidor soporta WebSockets seguros (WSS) y túneles Cloudflare para monitoreo remoto sin necesidad de contar con una IP pública fija?','186.130.44.151',1,'2026-09-03 20:15:09'),(11,'Federico Romero','fromero.dev@gmail.com','Consulta técnica: ¿Se puede utilizar la API REST de SIMC para integrar los eventos de detección en un dashboard propio de Grafana?','181.104.119.237',1,'2026-09-04 00:05:50'),(12,'Patricia Bullrich','patricia.b@seguridad-moderna.gob.ar','Solicitud de informe técnico sobre la tasa de falsos positivos en condiciones climáticas adversas (lluvia, neblina e iluminación deficiente).','200.16.88.4',1,'2026-09-04 13:11:45'),(13,'Alejandro Domínguez','adominguez@conmebol-ops.com','Estamos evaluando tecnologías de visión artificial para control de flujo de personas en accesos y molinetes. Quisiéramos coordinar una videoconferencia.','190.190.51.195',1,'2026-09-04 17:50:30'),(14,'Marcos Juárez','mjuarez@agro-cerealera.com.ar','Hola, ¿el sistema puede configurarse para enviar alertas solo cuando detecta vehículos de carga pesada en la zona de balanza fuera de turno?','186.18.55.91',1,'2026-09-04 21:32:15'),(15,'Tomás Álvarez','talvarez@agroindustrias-pampeanas.com','Buenas tardes, necesitamos monitorear silos y perímetros rurales con enlaces 4G intermitentes. ¿El agente de SIMC almacena eventos localmente si se corta Internet?','190.224.71.18',1,'2026-09-05 12:30:00'),(16,'Camila Herrera','cherrera@aeropuerto-seguridad.com.ar','Quisiera solicitar información sobre la homologación de compatibilidad con cámaras térmicas FLIR y Axis para seguridad perimetral.','181.44.120.65',1,'2026-09-05 16:15:40'),(17,'Rodrigo Sosa','rsosa@puerto-rosario.com','Estimados, solicitamos cotización formal por 24 licencias de SIMC PRO con soporte anual preventivo y correctivo para terminal portuaria.','200.51.19.112',1,'2026-09-05 20:48:19'),(18,'Ignacio Funes','ifunes@ekoparty-attendee.org','¡Excelente presentación en la Ekoparty! Me sorprendió gratamente la baja latencia del pipeline YOLOv8 en vivo. ¿Tienen planeado publicar un paper técnico o demo comunitaria?','181.117.165.69',0,'2026-09-06 14:10:05'),(19,'Romina Blanco','rblanco@seguridad-corporativa.com','Buenos días, quisiéramos saber si el licenciamiento empresarial es por cámara conectada o por servidor de análisis de video.','190.190.51.195',0,'2026-09-06 18:22:40'),(20,'Gonzalo Pérez','gperez@transporte-logistica.com.ar','Hola, sufrimos intrusiones nocturnas en depósitos de zona norte. ¿El sistema se puede vincular a un relé IoT o MQTT para encender reflectores estroboscópicos de inmediato?','186.130.44.151',0,'2026-09-06 23:04:18'),(21,'Dr. Fernando Morales','fmorales@auditoria-forense.com','Estimados, ¿el software genera marcas de agua digitales o hash SHA-256 en cada captura de evento para validar la integridad de la prueba en procesos periciales?','190.2.98.44',0,'2026-09-07 12:15:30'),(22,'Laura Quintana','lquintana@minera-andina.cl','Hola equipo, precisamos implementar el agente en faena cordillerana sobre equipos NVIDIA Jetson Orin Nano. ¿Tienen el contenedor Docker optimizado para arquitectura ARM64?','181.104.119.237',0,'2026-09-07 15:44:50'),(23,'Matías Varela','mvarela@colegio-nacional.edu.ar','Buenos días, somos directivos de una escuela técnica y queremos coordinar una visita para que los alumnos de informática conozcan el proyecto SIMC y su aplicación en seguridad ciudadana.','186.130.44.151',0,'2026-09-07 19:10:22');
/*!40000 ALTER TABLE `consultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `licencias_membresia`
--

DROP TABLE IF EXISTS `licencias_membresia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `licencias_membresia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `token_licencia` varchar(40) NOT NULL,
  `plan` varchar(20) NOT NULL,
  `email_comprador` varchar(120) NOT NULL,
  `titular` varchar(100) NOT NULL,
  `monto_pagado` decimal(10,2) NOT NULL,
  `periodo` varchar(20) NOT NULL DEFAULT 'monthly',
  `limite_pcs` int(11) NOT NULL DEFAULT 20,
  `ultimos4` varchar(4) DEFAULT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'activa',
  `fecha_compra` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_expiracion` datetime NOT NULL,
  `canjeado_en` datetime DEFAULT NULL,
  `sala_token` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token_licencia` (`token_licencia`),
  KEY `idx_token` (`token_licencia`),
  KEY `idx_email` (`email_comprador`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `licencias_membresia`
--

LOCK TABLES `licencias_membresia` WRITE;
/*!40000 ALTER TABLE `licencias_membresia` DISABLE KEYS */;
INSERT INTO `licencias_membresia` VALUES (1,NULL,'SIMC-MED-AZVM-TWPA','MEDIUM','carlos@instituto.edu','Profesor Carlos Ramirez',25.00,'monthly',20,'2222','activa','2026-08-25 14:41:07','2026-09-24 19:41:07',NULL,NULL),(2,NULL,'SIMC-MED-FGPU-2HM2','MEDIUM','carlos@instituto.edu','Profesor Carlos Ramirez',25.00,'monthly',20,'2222','activa','2026-08-25 14:41:29','2026-09-24 19:41:29','2026-08-25 14:41:29',NULL),(3,2,'SIMC-BAS-6LG4-86C8','BASIC','m.m.jheysmar@gmail.com','Jheysmar Mendieta',15.00,'monthly',10,'6516','activa','2026-08-25 15:06:42','2026-09-24 20:06:42',NULL,NULL),(4,4,'SIMC-MED-SJTR-HEXV','MEDIUM','messi@gmail.com','Messi',25.00,'monthly',20,'6465','activa','2026-08-25 15:28:55','2026-09-24 20:28:55',NULL,NULL),(5,4,'SIMC-PRO-UCQ3-T4MV','ENTERPRISE','messi@gmail.com','sdadasd',60.00,'monthly',50,'6516','activa','2026-08-25 15:36:31','2026-09-24 20:36:31',NULL,NULL),(6,4,'SIMC-PRO-4CMH-L7V5','ENTERPRISE','messi@gmail.com','Messi',60.00,'monthly',50,'1414','activa','2026-08-25 15:39:21','2026-09-24 20:39:21',NULL,NULL),(7,2,'SIMC-MED-CFNE-XAGU','MEDIUM','m.m.jheysmar@gmail.com','Messi',240.00,'annual',20,'5065','activa','2026-08-25 15:58:50','2027-08-25 20:58:50',NULL,NULL),(8,2,'SIMC-PRO-FMTP-XUEX','ENTERPRISE','rete@gmail.com','rete',60.00,'monthly',50,'5132','activa','2026-08-25 17:42:35','2026-09-24 22:42:35',NULL,NULL),(9,4,'SIMC-PRO-P8QC-Q6DL','ENTERPRISE','messi@gmail.com','Jheysmar Mendieta',60.00,'monthly',50,'4832','activa','2026-09-02 20:31:29','2026-10-03 01:31:29',NULL,NULL);
/*!40000 ALTER TABLE `licencias_membresia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salas`
--

DROP TABLE IF EXISTS `salas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(32) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `plan` varchar(30) NOT NULL DEFAULT 'ENTERPRISE',
  `limite` int(11) NOT NULL DEFAULT 50,
  `docente_username` varchar(60) DEFAULT NULL,
  `tiempo` varchar(30) DEFAULT 'ilimitado',
  `mostrar_ip` tinyint(1) DEFAULT 1,
  `tipo_actividad` varchar(30) DEFAULT 'pestanas',
  `activa` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_token` (`token`),
  KEY `idx_activa` (`activa`,`creado_en`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salas`
--

LOCK TABLES `salas` WRITE;
/*!40000 ALTER TABLE `salas` DISABLE KEYS */;
INSERT INTO `salas` VALUES (1,'TEST999X','Laboratorio de Pruebas A','ENTERPRISE',50,'Jheysmar','ilimitado',1,'pestanas',0,'2026-09-07 21:23:28','2026-09-07 21:23:28'),(2,'AULA2026','Laboratorio Central','ENTERPRISE',50,'Jheysmar','ilimitado',1,'pestanas',0,'2026-09-07 21:25:08','2026-09-07 21:25:43');
/*!40000 ALTER TABLE `salas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sesiones_log`
--

DROP TABLE IF EXISTS `sesiones_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sesiones_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `accion` enum('login','logout','login_fallido') NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_ip_accion` (`ip`,`accion`,`creado_en`),
  KEY `fk_seslog_usuario` (`usuario_id`),
  CONSTRAINT `fk_seslog_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sesiones_log`
--

LOCK TABLES `sesiones_log` WRITE;
/*!40000 ALTER TABLE `sesiones_log` DISABLE KEYS */;
INSERT INTO `sesiones_log` VALUES (1,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','login','2026-06-16 21:45:38'),(2,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','logout','2026-06-16 21:51:51'),(3,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','login','2026-06-16 21:57:30'),(4,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','logout','2026-06-16 22:06:07'),(5,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','login','2026-06-16 22:06:21'),(6,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','logout','2026-06-16 22:06:41'),(7,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','login','2026-06-16 22:06:50'),(8,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','logout','2026-06-16 22:09:08'),(9,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','login','2026-06-16 22:09:20'),(10,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','logout','2026-06-16 22:10:55'),(11,3,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','login_fallido','2026-06-16 22:11:46'),(12,3,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','login','2026-06-16 22:11:56'),(13,3,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','logout','2026-06-16 22:12:39'),(14,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','login_fallido','2026-06-16 22:12:54'),(15,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','login','2026-06-16 22:13:02'),(16,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','login_fallido','2026-08-25 03:58:56'),(17,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','login_fallido','2026-08-25 03:58:58'),(18,2,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','login','2026-08-25 03:59:06'),(19,2,'181.117.165.69','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36','login_fallido','2026-08-25 05:52:22'),(20,2,'181.117.165.69','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36','login','2026-08-25 05:52:28'),(21,2,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','login','2026-08-25 05:52:52'),(22,2,'181.117.165.69','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36','login','2026-08-25 06:20:03'),(23,2,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 OPR/134.0.0.0 (Edition ms_store_gx)','login','2026-08-25 14:18:20'),(24,2,'181.117.165.69','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36','login','2026-08-25 16:47:17'),(25,2,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 OPR/134.0.0.0 (Edition ms_store_gx)','logout','2026-08-25 18:27:30'),(26,4,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 OPR/134.0.0.0 (Edition ms_store_gx)','login','2026-08-25 18:28:20'),(27,4,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','login','2026-08-25 18:36:05'),(28,4,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 OPR/134.0.0.0 (Edition ms_store_gx)','logout','2026-08-25 18:46:01'),(29,2,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 OPR/134.0.0.0 (Edition ms_store_gx)','login','2026-08-25 18:46:10'),(30,2,'181.104.119.237','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','login','2026-08-25 20:41:29'),(31,4,'181.104.119.237','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','login','2026-08-25 20:51:32'),(32,2,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 OPR/134.0.0.0 (Edition ms_store_gx)','login','2026-08-26 15:09:51'),(33,2,'190.190.51.195','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36','login','2026-08-26 20:12:38'),(34,2,'181.104.119.237','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','login','2026-08-26 21:13:31'),(35,5,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 OPR/134.0.0.0 (Edition ms_store_gx)','login','2026-09-03 05:09:44'),(36,2,'186.130.44.151','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','login_fallido','2026-09-07 20:28:12'),(37,2,'186.130.44.151','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','login','2026-09-07 20:28:23'),(38,6,'186.130.44.151','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','login','2026-09-07 18:42:10'),(39,7,'190.190.51.195','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/130.0.0.0','login','2026-09-07 17:18:33'),(40,7,'190.190.51.195','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/130.0.0.0','logout','2026-09-07 18:10:02'),(41,8,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:129.0) Gecko/20100101 Firefox/129.0','login_fallido','2026-09-07 14:02:14'),(42,8,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:129.0) Gecko/20100101 Firefox/129.0','login','2026-09-07 14:03:00'),(43,8,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:129.0) Gecko/20100101 Firefox/129.0','logout','2026-09-07 15:30:15'),(44,3,'190.2.98.44','Mozilla/5.0 (Linux; Android 14; Pixel 8) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36','login','2026-09-07 12:45:00'),(45,3,'190.2.98.44','Mozilla/5.0 (Linux; Android 14; Pixel 8) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36','logout','2026-09-07 13:15:30'),(46,9,'181.104.119.237','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','login','2026-09-06 23:15:00'),(47,9,'181.104.119.237','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','logout','2026-09-07 01:45:10'),(48,4,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','login','2026-09-06 17:10:20'),(49,5,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','login_fallido','2026-09-06 19:30:00'),(50,5,'181.117.165.69','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','login','2026-09-06 19:30:45'),(51,2,'186.130.44.151','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','login','2026-09-06 12:12:00'),(52,6,'186.130.44.151','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','login','2026-09-05 19:00:20'),(53,7,'190.190.51.195','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/130.0.0.0','login','2026-09-06 01:00:00');
/*!40000 ALTER TABLE `sesiones_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','operador') NOT NULL DEFAULT 'operador',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `ip_registro` varchar(45) DEFAULT NULL,
  `ultimo_login` datetime DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_username` (`username`),
  UNIQUE KEY `uq_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (2,'Jheysmar','m.m.jheysmar@gmail.com','$2y$12$yHM0/kK/1CkvoBVg1aCwk.gjD2SBGxuJ5FhxMhzdjXotjmD1fvRqG','admin',1,'::1','2026-09-07 18:14:37','2026-06-16 21:17:46'),(3,'Gadiel','gadiel@gmail.com','$2y$12$oCK/1di9qnPPYW0mBfOAlebYIMzFh.3jKpQCuBzBDdw7iXrnSHFFm','operador',1,'::1','2026-06-16 19:11:56','2026-06-16 22:11:25'),(4,'Messi','messi@gmail.com','$2y$12$uXdnteuhjgXD2c1GNeL6Mu0zJswRSJp/b0DURqXrbo3rzoLRcNDLC','operador',1,'181.117.165.69','2026-09-04 16:10:11','2026-08-25 18:28:07'),(5,'Bruno','bruno@gmail.com','$2y$12$0kjeY9h5IaqvT8N7voouyuG70IFhg9nswG5Mmg0F148JGGlLz6Ym2','operador',1,'181.117.165.69','2026-09-03 02:09:44','2026-09-03 05:09:28'),(6,'lucia_tech','lucia@simc-security.com','$2y$10$48w9RkoOZ/ZzF9GlW83Db.MYvR9dTdaZO0VLABQ3mGgG5OvydY0eK','admin',1,'186.130.44.151','2026-09-07 15:42:10','2026-08-20 13:15:00'),(7,'marcos_ops','marcos.ops@logisticasur.com.ar','$2y$10$48w9RkoOZ/ZzF9GlW83Db.MYvR9dTdaZO0VLABQ3mGgG5OvydY0eK','operador',1,'190.190.51.195','2026-09-07 14:18:33','2026-08-22 17:30:00'),(8,'carolina_auditor','cduarte@seguridad-industrial.com','$2y$10$48w9RkoOZ/ZzF9GlW83Db.MYvR9dTdaZO0VLABQ3mGgG5OvydY0eK','operador',1,'181.117.165.69','2026-09-06 18:22:45','2026-08-28 12:00:00'),(9,'esteban_infra','esteban.m@datacenter-ar.com','$2y$10$48w9RkoOZ/ZzF9GlW83Db.MYvR9dTdaZO0VLABQ3mGgG5OvydY0eK','operador',1,'181.104.119.237','2026-09-05 11:05:12','2026-08-29 19:40:00'),(10,'sofia_guard','sofia.guardia@simc-monitoreo.com','$2y$10$48w9RkoOZ/ZzF9GlW83Db.MYvR9dTdaZO0VLABQ3mGgG5OvydY0eK','operador',0,'190.2.98.44','2026-09-01 08:30:19','2026-08-30 14:20:00');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-07 18:25:50
