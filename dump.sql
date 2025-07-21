CREATE DATABASE  IF NOT EXISTS `blog-php` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `blog-php`;
-- MySQL dump 10.13  Distrib 8.0.31, for macos12 (x86_64)
--
-- Host: localhost    Database: blog-php
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (106,'Life Sciences','Focus: Living organisms and their processes.'),(107,'Physical Sciences','Physics, Chemistry, Astronomy, Geology'),(108,'Earth & Environmental','      Earth’s systems and human-environment interactions.    '),(109,'Medical & Health','      Medical & Health Sciences              '),(110,'Engineering & Technology','Applied science and innovation.'),(111,'Formal Sciences','Abstract systems and quantitative analysis.'),(112,'Social & Behavioral','      Human behavior and societal structures.    ');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories_has_posts`
--

DROP TABLE IF EXISTS `categories_has_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_has_posts` (
  `post_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`post_id`,`category_id`),
  KEY `fk_categories_has_posts_categories1_idx` (`category_id`),
  CONSTRAINT `fk_categories_has_posts_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_categories_has_posts_posts1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories_has_posts`
--

LOCK TABLES `categories_has_posts` WRITE;
/*!40000 ALTER TABLE `categories_has_posts` DISABLE KEYS */;
INSERT INTO `categories_has_posts` VALUES (101,106),(102,106),(106,106),(110,106),(101,107),(102,107),(109,107),(103,108),(104,109),(107,110),(108,110),(105,112);
/*!40000 ALTER TABLE `categories_has_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved') DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  PRIMARY KEY (`id`,`user_id`,`post_id`),
  KEY `fk_comments_users1_idx` (`user_id`),
  KEY `fk_comments_posts1_idx` (`post_id`),
  CONSTRAINT `fk_comments_posts1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_comments_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (101,'Game-changing AI! Early Alzheimer’s detection brings hope for millions. Brilliant work by MIT researchers! ','approved','2025-07-15 18:05:35','2025-07-15 18:05:35',107,104),(102,'Brilliant program! Teaching empathy reduces bullying and boosts learning. Finland leads again, this model should spread worldwide. Kids thrive when kindness is part of education! Great done!','approved','2025-07-15 18:07:33','2025-07-15 18:07:33',107,105),(103,'Science fiction becoming reality, amazing!      ','approved','2025-07-15 18:08:37','2025-07-15 18:08:37',107,106),(104,'Fascinating research! Gut health is key to immunity and wellness.','pending','2025-07-15 18:09:33','2025-07-15 19:08:24',107,101),(105,'Urgent action can restore soils sustainable farming is the future!','approved','2025-07-15 18:10:46','2025-07-15 18:10:46',107,103),(106,'Revolutionary leap for science!      ','approved','2025-07-15 18:11:43','2025-07-15 18:11:43',107,109),(107,'Incredible peek into Earth\'s secrets!','approved','2025-07-15 18:12:58','2025-07-15 18:12:58',107,110),(108,'Breakthrough tech saves futures, one prediction at a time!','approved','2025-07-15 18:23:39','2025-07-15 19:08:27',106,104),(109,'Compassion lessons transform schools, brilliant results!','approved','2025-07-15 18:26:10','2025-07-15 18:36:12',106,105),(110,'Aging reversal is near, science triumphs again!','approved','2025-07-15 18:26:48','2025-07-15 19:08:12',106,106),(111,'Healthy gut, stronger immunity amazing discovery!','approved','2025-07-15 18:27:16','2025-07-15 18:36:15',106,101),(112,'Brain’s resilience inspires hope, incredible healing!','pending','2025-07-15 18:27:37','2025-07-15 19:08:35',106,102),(113,'Save the soil, secure our future, act now!','approved','2025-07-15 18:28:26','2025-07-15 18:36:18',106,103),(114,'Innovation at its finest!','approved','2025-07-15 18:39:01','2025-07-15 18:39:01',105,104),(115,'Well said! Kindness in classrooms changes everything!','pending','2025-07-15 18:41:03','2025-07-15 19:08:18',105,105),(116,'Truly groundbreaking! Gut science is revolutionising healthcare!       ','approved','2025-07-15 18:42:13','2025-07-15 19:05:58',105,101),(121,'            \r\n      This is great news!','approved','2025-07-16 21:41:35','2025-07-16 21:41:35',104,106);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `featured_image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `content` longtext,
  `status` enum('draft','published') DEFAULT 'draft',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  `slug` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`,`user_id`),
  KEY `fk_posts_users_idx` (`user_id`),
  CONSTRAINT `fk_posts_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (101,'The Role of Gut Microbiota in Immune System Development','2748159668769088008242.78115817.jpg','Recent studies highlight the critical role of gut microbiota in shaping the human immune system. The gut hosts trillions of microorganisms, collectively known as the microbiome, which interact with immune cells to maintain homeostasis. Research shows that imbalances in gut bacteria (dysbiosis) are linked to autoimmune diseases, allergies, and even mental health disorders.\r\n\r\nExperiments on germ-free mice revealed that the absence of gut microbiota leads to underdeveloped immune systems. Conversely, probiotics and fecal transplants have shown promise in treating conditions like Crohn’s disease. Scientists are now exploring how specific bacterial strains, such as Bifidobacterium and Lactobacillus, can modulate immune responses.\r\n\r\nThis field, known as \"immuno-microbiology,\" could revolutionize personalized medicine. Future therapies may include microbiome-based interventions to prevent or cure immune-related disorders.','published','2025-07-15 17:31:51','2025-07-15 17:31:51',104,'the-role-of-gut-microbiota-in-immune-system-development'),(102,'Neuroplasticity: How the Brain Rewires Itself After Injury','1852482226687690fb228558.26219925.jpg','Neuroplasticity, the brain’s ability to reorganize itself, offers hope for stroke and trauma survivors. Studies show that damaged neural pathways can be rerouted through repetitive training and therapies like constraint-induced movement therapy (CIMT).\r\n\r\nAdvanced imaging techniques reveal that even adult brains generate new neurons (neurogenesis) in regions like the hippocampus. Researchers are exploring how drugs and non-invasive stimulation (e.g., transcranial magnetic stimulation) can enhance this process.\r\n\r\nUnderstanding neuroplasticity could lead to breakthroughs in treating Alzheimer’s, PTSD, and spinal cord injuries.','published','2025-07-15 17:33:46','2025-07-15 17:33:46',104,'neuroplasticity-how-the-brain-rewires-itself-after-injury'),(103,'Europe’s Silent Crisis: Soil Degradation Threatens 60% of Farmland','968618227687691b90f22d6.86174275.jpg','A recent report by the European Environment Agency (EEA) reveals that 60% of Europe’s soils are unhealthy, suffering from erosion, pollution, and loss of organic matter. Intensive agriculture, urban sprawl, and industrial activity are the primary culprits.\r\n\r\nIn countries like Italy and Spain, over 20% of arable land is now too degraded for sustainable farming. The EU’s Soil Health Law (2023) aims to restore soils by 2050, but progress is slow. Innovative solutions like biochar (carbon-rich charcoal) and cover cropping are being tested in Germany and France to rebuild soil fertility.\r\n\r\nScientists warn that without urgent action, Europe could face food security risks and biodiversity collapse.','published','2025-07-15 17:36:56','2025-07-15 17:36:56',104,'europe’s-silent-crisis-soil-degradation-threatens-60%-of-farmland'),(104,'AI Predicts Alzheimer’s 10 Years Early with 95% Accuracy','9383294016876923885ed93.91818170.jpg','        A team at MIT has developed an AI algorithm that analyzes speech patterns and MRI scans to predict Alzheimer’s disease a decade before symptoms appear—with 95% accuracy. Early intervention with new anti-amyloid drugs could now delay cognitive decline by up to 15 years.\r\n\r\nDr. Sarah Li, lead researcher, stated: This tool could make Alzheimer’s a manageable condition, not a life sentence. The AI will be tested in clinics across Europe in 2025.    ','published','2025-07-15 17:39:04','2025-07-15 17:39:13',104,'ai-predicts-alzheimer’s-10-years-early-with-95%-accuracy'),(105,'Empathy Training in Schools Reduces Bullying by 40%, Study Finds','1046633004687692f6c74b79.72076447.jpg','A 3-year program in Finnish schools teaching empathy and emotional intelligence has led to a 40% drop in bullying incidents. The \"Open Minds\" curriculum uses role-playing and group discussions to help students understand peers’ perspectives.\r\n\r\nResults show improved classroom climate and academic performance, with 75% of teachers reporting better student relationships. \"Kids now resolve conflicts themselves,\" said Helsinki educator Liisa Virtanen. The EU is considering adopting the model Union-wide by 2026.','published','2025-07-15 17:42:14','2025-07-15 17:42:14',104,'empathy-training-in-schools-reduces-bullying-by-40%,-study-finds'),(106,'Scientists Reverse Aging in Mice: Human Trials to Begin in 2026','184382561568769409093126.68975106.jpg','In a breakthrough study published in Cell, researchers at Harvard reversed key aging markers in mice using a cocktail of Yamanaka factors (proteins that reprogram cells). Treated mice showed younger organs, improved cognition, and 30% longer lifespans.\r\n\r\nThe team, led by Dr. David Sinclair, will start human trials next year. \"This isn’t just about longevity—it’s about extending healthy years,\" he said. Potential applications include treating Alzheimer’s and heart disease.\r\n\r\nCritics urge caution, but the study sparks hope for age-related disease reversal.','published','2025-07-15 17:46:48','2025-07-15 17:46:48',105,'scientists-reverse-aging-in-mice-human-trials-to-begin-in-2026'),(107,'World’s First Carbon-Neutral Cement Plant Opens in Sweden','19882108096876948a355b88.70707050.jpg','A revolutionary cement plant in Gothenburg now operates with zero CO₂ emissions, using carbon capture and hydrogen fuel instead of fossil fuels. The project, led by Heidelberg Materials, could cut global cement emissions by 8% if scaled.\r\n\r\n\"This proves heavy industry can decarbonize,\" says CEO Dominik von Achten. The EU plans 10 similar plants by 2030.','published','2025-07-15 17:48:57','2025-07-15 17:48:57',105,'world’s-first-carbon-neutral-cement-plant-opens-in-sweden'),(108,'SpaceX’s Starship Completes First Orbital Refueling Test for Moon Missions','1176441241687694d293e493.55595706.jpg','In a milestone for lunar exploration, SpaceX successfully transferred 10 tons of fuel between Starship tanks in orbit—a critical step for NASA’s Artemis program. The test brings crewed Mars missions closer to reality.\r\n\r\n\"This changes deep-space logistics,\" tweeted Elon Musk. Next goal: uncrewed Moon landing by 2026.','published','2025-07-15 17:50:10','2025-07-15 17:50:10',105,'spacex’s-starship-completes-first-orbital-refueling-test-for-moon-missions'),(109,'Room-Temperature Superconductor Breakthrough Verified After Peer Review','13472625568769643dec9f9.81134880.jpg','A team from Rochester University has confirmed the first ambient-pressure, room-temperature superconductor (15°C/59°F) with a modified hydrogen-lattice material. Published in Nature, the discovery could revolutionize energy grids, MRI machines, and quantum computing.\r\n\r\n\"Lossless power transmission is now plausible within a decade,\" said lead physicist Ranga Dias. Google and Siemens have already pledged funding for scalability tests.','published','2025-07-15 17:56:19','2025-07-15 17:56:19',107,'room-temperature-superconductor-breakthrough-verified-after-peer-review'),(110,'Neutrino Detector Reveals Hidden Structures Inside Earth’s Core','1708079069687696d54dfbd4.98892977.jpg','Using a 6-kiloton neutrino detector in Japan, scientists mapped Earth’s inner core with unprecedented detail, identifying a 400-km-wide dense structure near the mantle. The technique, called neutrino tomography, could replace seismic methods for planetary studies.\r\n\r\n\"It’s like X-raying the planet without radiation,\" said Dr. Sanne Cottaar. The find may rewrite models of plate tectonics.','published','2025-07-15 17:58:44','2025-07-15 17:58:44',107,'neutrino-detector-reveals-hidden-structures-inside-earth’s-core');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT '@user',
  `avatar` varchar(255) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `role` enum('admin','author','subscriber') DEFAULT 'subscriber',
  `token` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (104,'testUser','5000815376876a485d081f6.80610178.jpg','test@test.com','$2y$10$SlGpe.tPL8Pxq3GTBBF7D.sYyXPeQ3gxE.ZMHbZlc5X6Ebx61PYXq','admin','1','2025-07-15 16:20:34','2025-07-15 18:57:10'),(105,'Ralph','3505415706876a46f75e521.22646720.jpg','ralph@test.com','$2y$10$ODnOwFQcijEbAQru7BuF9OZDaTSH7JNDFfnzg6pI.pjEXP123IPty','author','1','2025-07-15 16:47:25','2025-07-15 18:56:48'),(106,'Sebastian','7604102516876a45d11f2f4.96909608.jpg','sebastian@test.com','$2y$10$YdN9Cn1OZ3LW9P1IsA/OPuFczraIGkB0UfrtAPvHRLdLX2xq5i7Ti','subscriber','1','2025-07-15 16:51:34','2025-07-15 18:56:30'),(107,'Rebecca','1117362976876a497be0897.43380897.jpg','rebecca@test.com','$2y$10$VuftUP4i0U1pLoKmT9vGruoXOUvEge6i3eyg7uwekZRoCD/0xQkBW','author','1','2025-07-15 16:52:22','2025-07-15 18:57:27');
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

-- Dump completed on 2025-07-21 18:04:20
