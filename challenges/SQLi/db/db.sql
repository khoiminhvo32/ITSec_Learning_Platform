create database IF NOT EXISTS myDB;

use myDB;

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(50),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);

INSERT INTO `users` (`id`, `username`, `password`) VALUES (1, 'conmeo', '0f91cd8b141e007a8912b8e849700633a34a68c6');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (2, 'trudie92', 'a2ef8b5adc71e0cdbba60b2fb199510dd0e38fdb');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (3, 'deckow.vernie', 'aac408a9ea1774e50a14c71c4a526ec1ca310b5c');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (4, 'alta35', '66ee95fa66e2eabd0906c2c6b4df79aebf92d569');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (5, 'nikki13', 'bb091d6dc315e3337933e00b89d499604879b347');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (6, 'ritchie.benton', '59be46482be0ac00aafd6efd8a7b6c54a41055f4');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (7, 'kzboncak', '31b00b953872e07ba4ac13a44a4da65840f69d89');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (8, 'ulueilwitz', '0e678bb0b9831f2471a7b47d0356c2ac4cef7141');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (9, 'maegan.roob', '7eb0602ba70b52b3fc18ec986b7e965dda4f6bf8');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (10, 'nicholaus.ledner', '916ffdeb0fd43b42aa47f10a63153f62a769a972');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (11, 'admin', '6f43d14e2f1138475380733f6ea1f8f0720ec567');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (12, 'maria.gulgowski', '341881d8b5ce1e993888997a7742476af1432821');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (13, 'delphia69', '3d68771639a9ac510bf50770e5fc60259e88dbeb');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (14, 'ondricka.judd', '1191d5b94fde5efed7a1235e66ccdfc9ab823942');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (15, 'eleanora36', 'caa77964ee7f3dd542a0c80d399fcf77f4df8b60');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (16, 'qkling', '1aa00ccb23868461f2cfa9885e2b441447b84ad0');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (17, 'pconsidine', '3a599af4d98cdd339eafe15703cd80a6ff86f02b');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (18, 'vcruickshank', '00c3e55155be91e566fe43be8162cf4ac8cbed64');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (19, 'mozelle31', '77fcaac32573b45afe72f4322110087e88f51788');
INSERT INTO `users` (`id`, `username`, `password`) VALUES (20, 'orunte', '9d8f7cbcff04586d3fa22591ea7be77f63dea352');
INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES (21, 'CBJS_FLAG', 'CBJS{SeConD_oRdEr_SqL_InjecTioN}', 'cbjs@cyberjutsu.io');

DROP TABLE IF EXISTS `test`;

CREATE TABLE `test` (
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL
);

INSERT INTO `test` VALUES ('aan', 'haha'), ('bo8', 'mothaiba');

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `posts` (`id`, `content`) VALUES (1, 'https://blog.cyberjutsu.io/2021/08/09/hoc-an-toan-thong-tin/');
INSERT INTO `posts` (`id`, `content`) VALUES (2, 'https://blog.cyberjutsu.io/2021/06/02/IDOL-streamer-vs-XSS/');
INSERT INTO `posts` (`id`, `content`) VALUES (3, 'https://blog.cyberjutsu.io/2021/05/13/HTML-sanitizer-vs-XSS/');

DROP TABLE IF EXISTS `secret6`;

CREATE TABLE `secret6` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `secret6` (`id`, `content`) VALUES (1, 'CBJS{eb627f3d394a64184da1a16d6bb8100d}');