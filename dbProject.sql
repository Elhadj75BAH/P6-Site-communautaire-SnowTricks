-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 13 déc. 2021 à 12:15
-- Version du serveur :  8.0.27-0ubuntu0.20.04.1
-- Version de PHP : 7.2.34-8+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_p6_SnowTriks`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int NOT NULL,
  `contenu` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_du_commentaire` datetime NOT NULL,
  `utilisateurs_id` int NOT NULL,
  `figure_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `contenu`, `date_du_commentaire`, `utilisateurs_id`, `figure_id`) VALUES
(40, 'oh good je veux aussi commencer le free-style ....', '2021-11-27 19:16:17', 43, 90),
(41, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ultricies mi eget mauris pharetra et ultrices neque ornare aenean. Phasellus faucibus scelerisque eleifend donec pretium. Etiam erat velit scelerisque in. Consectetur lorem donec massa sapien faucibus. Augue mauris augue neque gravida in. Nullam ac tortor vitae purus faucibus ornare suspendisse sed nisi. Faucibus vitae aliquet nec ullamcorper sit. Quis imperdiet massa tincidunt nunc pulvinar sapien et ligula ullamcorper. Sed vulputate odio ut enim blandit volutpat maecenas volutpat. Metus dictum at tempor commodo.', '2021-12-06 15:07:44', 43, 92),
(42, 'veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugi', '2021-12-08 13:14:58', 43, 113),
(43, 'veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugi jjdjdjdjjd', '2021-12-08 13:15:27', 43, 113),
(44, 'hdhhdhdhdhhdhdhd', '2021-12-08 13:15:42', 43, 113),
(45, 'hhdhhdhhdhdhdhdhd', '2021-12-08 13:16:07', 43, 113),
(46, 'au top', '2021-12-08 13:17:53', 43, 112);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `figure`
--

CREATE TABLE `figure` (
  `id` int NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `utilisateurs_id` int DEFAULT NULL,
  `groupe_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `figure`
--

INSERT INTO `figure` (`id`, `nom`, `slug`, `description`, `utilisateurs_id`, `groupe_id`) VALUES
(90, 'The Art Of Snowboarding', 'the-art-of-snowboarding', 'ok blabalbalbbblabl', 43, 8),
(91, 'Freestyle', 'freestyle', 'Best of Freestyle Snowboarding', 43, 5),
(92, 'engelhorn sports', 'engelhorn-sports', 'Burton Backcountry Snowboarding | engelhorn sports', 43, 5),
(93, 'Tricks', 'tricks', '5 Easy Snowboard Tricks to Impress Your Friends', 43, 5),
(109, 'tortor', 'tortor', 'Accumsan tortor posuere ac ut consequat semper. Accumsan lacus vel facilisis volutpat est. Gravida rutrum quisque non tellus orci ac auctor augue mauris. Sed felis eget velit aliquet. Massa massa ultricies mi quis hendrerit dolor magna eget. Volutpat sed cras ornare arcu dui. Interdum velit laoreet id donec ultrices tincidunt arcu non. Facilisis magna etiam tempor orci eu lobortis. Etiam tempor orci eu lobortis elementum. Proin sed libero enim sed faucibus turpis in eu. Elit ut aliquam purus sit amet luctus venenatis lectus. Eu feugiat pretium nibh ipsum consequat nisl vel. Nunc mi ipsum faucibus vitae aliquet nec. Arcu cursus euismod quis viverra. Ac feugiat sed lectus vestibulum mattis ullamcorper velit sed ullamcorper. Euismod nisi porta lorem mollis aliquam ut porttitor leo.', 43, 5),
(110, 'Blandit', 'blandit', 'Blandit massa enim nec dui nunc mattis enim ut. Tristique nulla aliquet enim tortor at auctor urna nunc. Pharetra vel turpis nunc eget lorem. Amet risus nullam eget felis eget. A condimentum vitae sapien pellentesque. Nisi vitae suscipit tellus mauris a diam. Magna etiam tempor orci eu lobortis elementum nibh. Posuere urna nec tincidunt praesent semper. Dignissim diam quis enim lobortis. Consequat interdum varius sit amet mattis. Rutrum tellus pellentesque eu tincidunt tortor aliquam.', 43, 5),
(111, 'Accumsan', 'accumsan', 'Accumsan tortor posuere ac ut consequat semper. Accumsan lacus vel facilisis volutpat est. Gravida rutrum quisque non tellus orci ac auctor augue mauris. Sed felis eget velit aliquet. Massa massa ultricies mi quis hendrerit dolor magna eget. Volutpat sed cras ornare arcu dui. Interdum velit laoreet id donec ultrices tincidunt arcu non. Facilisis magna etiam tempor orci eu lobortis. Etiam tempor orci eu lobortis elementum. Proin sed libero enim sed faucibus turpis in eu. Elit ut aliquam purus sit amet luctus venenatis lectus. Eu feugiat pretium nibh ipsum consequat nisl vel. Nunc mi ipsum faucibus vitae aliquet nec. Arcu cursus euismod quis viverra. Ac feugiat sed lectus vestibulum mattis ullamcorper velit sed ullamcorper. Euismod nisi porta lorem mollis aliquam ut porttitor leo.', 43, 5),
(112, 'Les flips', 'les-flips', 'Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière.\r\n\r\nIl est possible de faire plusieurs flips à la suite, et d\'ajouter un grab à la rotation.\r\n\r\nLes flips agrémentés d\'une vrille existent aussi (Mac Twist, Hakon Flip...), mais de manière beaucoup plus rare, et se confondent souvent avec certaines rotations horizontales désaxées.\r\nNéanmoins, en dépit de la difficulté technique relative d\'une telle figure, le danger de retomber sur la tête ou la nuque est réel et conduit certaines stations de ski à interdire de telles figures dans ses snowparks.\r\n[sources] wikipedia', 43, 5),
(113, 'sauts', 'sauts', 'Les tricks sont pour la plupart du temps, des rotations qui peuvent être de plusieurs types, combinées ou non avec un grab, et effectuées en position normal ou switch. La dénomination des figures ainsi créées répond à l\'usage suivant  :\r\n\r\nd\'abord le mot « switch » si la figure est effectuée du côté non naturel\r\nensuite le nom du type de désaxage de la rotation si la figure est une rotation désaxée\r\npuis le nom de la rotation elle-même, c’est-à-dire le nombre de degrés effectués\r\nsi la figure est grabée, le nom du grab\r\n[sources] wikipedia', 43, 7),
(120, 'Old school', 'old-school', 'Le terme old school désigne un style de freestyle caractérisée par en ensemble de figure et une manière de réaliser des figures passée de mode, qui fait penser au freestyle des années 1980 - début 1990 (par opposition à new school) :\r\n\r\nfigures désuètes : Japan air, rocket air, ...\r\nrotations effectuées avec le corps tendu\r\nfigures saccadées, par opposition au style new school qui privilégie l\'amplitude\r\nÀ noter que certains tricks old school restent indémodables :\r\n\r\nBackside Air\r\nMethod Air\r\n\r\n[sources] wikipedia', 43, 7),
(121, 'Barre de slide', 'barre-de-slide', 'Pour les barres de slide, la dénomination se fait de la manière suivante :\r\n\r\nd\'abord le nom de la figure d\'entrée si elle est autre qu\'un 90, suivi du mot anglais to\r\nle nom du slide (nose slide ou tail slide) ou le mot anglais rail si le slide est classique\r\nenfin le nom de la figure de sortie si elle est autre qu\'un 90, précédée du mot anglais to\r\nPar exemple, un switch 270 to rail signifie que le rideur part du côté non naturel, qu\'il effectue trois quarts de tour avant de slider normalement sur la barre, puis qu\'il sort avec un quart de tour.[...]', 43, 9);

-- --------------------------------------------------------

--
-- Structure de la table `groupe_figure`
--

CREATE TABLE `groupe_figure` (
  `id` int NOT NULL,
  `nom_groupe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `groupe_figure`
--

INSERT INTO `groupe_figure` (`id`, `nom_groupe`) VALUES
(5, 'Groupe 1'),
(6, 'Groupe 2'),
(7, 'Groupe 3'),
(8, 'Groupe 4'),
(9, 'groupe 5');

-- --------------------------------------------------------

--
-- Structure de la table `image_figure`
--

CREATE TABLE `image_figure` (
  `id` int NOT NULL,
  `figureimage_id` int NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `image_figure`
--

INSERT INTO `image_figure` (`id`, `figureimage_id`, `image`) VALUES
(129, 90, '0daec9ecc37f4441b547835aa023a6c5.png'),
(130, 90, '9ceafcada74e9e38790d5e1ccb560c0c.png'),
(131, 90, '55d9cf31d7e6cc77b4bc3996dd4423b5.png'),
(132, 90, '905972c802ee18db39277e116ea203f1.png'),
(133, 91, 'eccdab1e7eef0c72b10bdc578750e2e1.png'),
(134, 91, 'bff06080f663b570332dc13e3c13d65e.png'),
(135, 91, '8876859398da7b4f604389a6441e6df7.png'),
(136, 92, 'a9564adcd2c5f4ad8df64edd7c14a093.png'),
(137, 92, 'b5f64b90ef72896ad3fb76819463eea2.png'),
(138, 93, 'f68ef11ed3d243226cbfce250b8506d1.png'),
(142, 92, 'abf7855365ed1a20786794ecda7903e7.png'),
(143, 92, 'f5d4608da9703bfb1ba7222e0ecaa247.png'),
(144, 92, 'fa418912b12e660556171968e3e1c5f7.png'),
(152, 93, '67db5fd2606a0cf14afc923299953b07.png'),
(153, 93, 'b3d83039823476ed309998a7cee83823.png'),
(190, 109, '35472226ecddb31b79fff0fdf1733e96.png'),
(191, 109, '9da096e7431104b0a81f6e38681c9941.png'),
(192, 109, 'aedcb73ac3163007e307d178572b549a.png'),
(193, 110, 'd7b5dee31d44c8dee221a4a875b81275.png'),
(194, 110, '9fada49bec3cd4a29059eea52bcd0c91.png'),
(195, 110, '75f5c6e993b9fc91ea8bd01b4fad02fb.png'),
(196, 111, '76b8a734c7923b9d6028cef6c72f2614.png'),
(197, 111, 'b6dff49e26d33916413df620fdb20178.png'),
(198, 111, 'df488c3a7d43f57df1265de9237e9c6e.png'),
(199, 112, 'f9b13b0793c41dcf0e5bc2ca7c63fbde.png'),
(200, 112, '539158344dd84e2ae1d4f9023127df3c.png'),
(206, 113, '28677c0ae814a77470050e93acb970d9.png'),
(207, 113, 'd81bf5f29405a19de0ac5aa2568cc447.png'),
(209, 113, 'b048a29da8be2b018ff4571d2df4eebd.png'),
(219, 120, 'dafc89603c4332255e6987e80dc1bae8.png'),
(220, 120, '78b1cb6384ba43f9d1d893b875da73a9.png'),
(221, 120, 'b6d54a6762414166979d9b42edc17e83.png'),
(222, 121, 'fc6cca342c21cc77191f8a4e046e20cc.png'),
(223, 121, '738cceac08674fc64f0b3059f2d17bd4.png');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int NOT NULL,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token_pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `email`, `roles`, `password`, `nom`, `is_verified`, `picture`, `token`, `reset_token_pass`) VALUES
(43, 'bonjour@test.fr', '[]', '$2y$13$Z2dF.pDw7DOuaX6Y4ePWluEVsqkJPcAPTutvjxia/iAzjcHqpcM8y', 'Barry', 1, '4a99ddcf70f9bb627d7e4eaa3133f747.png', NULL, NULL),
(44, 'bonjour2@test.fr', '[]', '$2y$13$U2sZ8alrK5l5O30JjZ8J0eYxmlvYLpbtOeI/0MQ7qVTJCkSZGiST.', 'BAH', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `video_figure`
--

CREATE TABLE `video_figure` (
  `id` int NOT NULL,
  `figure_id` int DEFAULT NULL,
  `video` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `video_figure`
--

INSERT INTO `video_figure` (`id`, `figure_id`, `video`) VALUES
(66, 90, 'https://www.youtube.com/embed/0uGETVnkujA'),
(67, 90, 'https://www.youtube.com/embed/jq2AIcgs61U'),
(68, 90, 'https://www.youtube.com/embed/KoHzXi7Usl8'),
(69, 90, 'https://www.youtube.com/embed/RlIV7g1hmYU'),
(70, 91, 'https://www.youtube.com/embed/KoHzXi7Usl8'),
(71, 91, 'https://www.youtube.com/embed/jq2AIcgs61U'),
(72, 91, 'https://www.youtube.com/embed/RlIV7g1hmYU'),
(78, 93, 'https://www.youtube.com/embed/QMrelVooJR4'),
(79, 93, 'https://www.youtube.com/embed/Frln61fCrGk'),
(80, 93, 'https://www.youtube.com/embed/T1zEBh5HLH8'),
(81, 93, 'https://www.youtube.com/embed/RlIV7g1hmYU'),
(82, 92, 'https://www.youtube.com/embed/0uGETVnkujA'),
(83, 92, 'https://www.youtube.com/embed/jq2AIcgs61U'),
(84, 92, 'https://www.youtube.com/embed/KoHzXi7Usl8'),
(85, 92, 'https://www.youtube.com/embed/RlIV7g1hmYU'),
(125, 109, 'https://www.youtube.com/embed/QMrelVooJR4'),
(128, 110, 'https://www.youtube.com/embed/KoHzXi7Usl8'),
(140, 113, 'https://www.youtube.com/embed/jq2AIcgs61U'),
(141, 113, 'https://www.youtube.com/embed/T1zEBh5HLH8'),
(146, 109, 'https://www.youtube.com/embed/QMrelVooJR4'),
(147, 109, 'https://www.youtube.com/embed/T1zEBh5HLH8'),
(153, 120, 'https://www.youtube.com/embed/T1zEBh5HLH8'),
(154, 120, 'https://www.youtube.com/embed/Frln61fCrGk'),
(158, 121, 'https://www.youtube.com/embed/RlIV7g1hmYU'),
(159, 121, 'https://www.youtube.com/embed/jq2AIcgs61U'),
(161, 110, 'https://www.youtube.com/embed/hTkT9GjO8L4');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D9BEC0C41E969C5` (`utilisateurs_id`),
  ADD KEY `IDX_D9BEC0C45C011B5` (`figure_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `figure`
--
ALTER TABLE `figure`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2F57B37A6C6E55B5` (`nom`),
  ADD KEY `IDX_2F57B37A1E969C5` (`utilisateurs_id`),
  ADD KEY `IDX_2F57B37A7A45358C` (`groupe_id`);

--
-- Index pour la table `groupe_figure`
--
ALTER TABLE `groupe_figure`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `image_figure`
--
ALTER TABLE `image_figure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_804AEDB243B27D92` (`figureimage_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_497B315EE7927C74` (`email`);

--
-- Index pour la table `video_figure`
--
ALTER TABLE `video_figure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_170013B75C011B5` (`figure_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT pour la table `figure`
--
ALTER TABLE `figure`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT pour la table `groupe_figure`
--
ALTER TABLE `groupe_figure`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `image_figure`
--
ALTER TABLE `image_figure`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `video_figure`
--
ALTER TABLE `video_figure`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `FK_D9BEC0C41E969C5` FOREIGN KEY (`utilisateurs_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `FK_D9BEC0C45C011B5` FOREIGN KEY (`figure_id`) REFERENCES `figure` (`id`);

--
-- Contraintes pour la table `figure`
--
ALTER TABLE `figure`
  ADD CONSTRAINT `FK_2F57B37A1E969C5` FOREIGN KEY (`utilisateurs_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `FK_2F57B37A7A45358C` FOREIGN KEY (`groupe_id`) REFERENCES `groupe_figure` (`id`);

--
-- Contraintes pour la table `image_figure`
--
ALTER TABLE `image_figure`
  ADD CONSTRAINT `FK_804AEDB243B27D92` FOREIGN KEY (`figureimage_id`) REFERENCES `figure` (`id`);

--
-- Contraintes pour la table `video_figure`
--
ALTER TABLE `video_figure`
  ADD CONSTRAINT `FK_170013B75C011B5` FOREIGN KEY (`figure_id`) REFERENCES `figure` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
