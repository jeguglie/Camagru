-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  ven. 11 oct. 2019 à 01:55
-- Version du serveur :  10.1.41-MariaDB-0+deb9u1
-- Version de PHP :  7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `jeguglie_camagru`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `img_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`img_id`, `comment`, `username`, `date`) VALUES
(56, 'Hey!', 'jeguglie', '2019-10-02'),
(60, '1', 'jeguglie', '2019-10-02'),
(59, '2', 'jeguglie', '2019-10-02'),
(58, '3', 'jeguglie', '2019-10-02'),
(57, '4', 'jeguglie', '2019-10-02'),
(60, 'Heyy', 'jeguglie', '2019-10-02'),
(62, 'd', 'jeguglie', '2019-10-02'),
(58, 'salut', 'jeguglie', '2019-10-08'),
(58, 'salut', 'jeguglie', '2019-10-08'),
(64, 'Hh', 'jeguglie', '2019-10-09'),
(65, 'oklm', 'jeguglie', '2019-10-09'),
(66, 'le s', 'jeguglie', '2019-10-09'),
(60, 'Jj', 'jeguglie', '2019-10-09'),
(67, 'salut', 'jeguglie', '2019-10-10'),
(67, 'heyyyy', 'jeguglie', '2019-10-10'),
(67, 'dfsfsd', 'jeguglie', '2019-10-10'),
(67, 'sfsf', 'jeguglie', '2019-10-10'),
(67, 'ff', 'jeguglie', '2019-10-10'),
(67, 'f', 'jeguglie', '2019-10-10'),
(66, 'fff', 'jeguglie0606', '2019-10-10'),
(67, 'f', 'jeguglie', '2019-10-10'),
(121, 'g', 'jeguglie', '2019-10-10'),
(121, 'd', 'jeguglie', '2019-10-10'),
(121, 'd', 'jeguglie', '2019-10-10'),
(123, 'rr', 'jeguglie', '2019-10-10'),
(121, 'rr', 'jeguglie', '2019-10-10'),
(123, 'rr', 'jeguglie', '2019-10-10'),
(123, 'r', 'jeguglie', '2019-10-10'),
(123, 'r', 'jeguglie', '2019-10-10'),
(123, 'rwewer', 'jeguglie', '2019-10-10'),
(123, 'rrwrwrewfewgwegwrbrwwrthrwthtwrh', 'jeguglie', '2019-10-10'),
(123, 'rhtrehreherthvwrgrhtrentenetne', 'jeguglie', '2019-10-10'),
(64, 'dd', 'jeguglie', '2019-10-10'),
(65, 'af', 'jeguglie', '2019-10-10'),
(66, 'af', 'jeguglie', '2019-10-10'),
(66, 'f', 'jeguglie', '2019-10-10'),
(66, 'f', 'jeguglie', '2019-10-10'),
(66, 'f', 'jeguglie', '2019-10-10'),
(67, 'dasasf', 'jeguglie', '2019-10-10'),
(67, '&lt;html&gt;salut&lt;html&gt;', 'jeguglie', '2019-10-10'),
(67, '&lt;h1&gt;salut&lt;h1&gt;', 'jeguglie', '2019-10-10'),
(67, '&lt;br&gt;lol&lt;br&gt;', 'jeguglie', '2019-10-10'),
(67, '&lt;div class=&quot;media&quot;&gt;pl&lt;div&gt;', 'jeguglie', '2019-10-10'),
(67, '&lt;h3&gt;test&lt;h3&gt;', 'jeguglie', '2019-10-10'),
(67, 'okkk', 'jeguglie', '2019-10-10'),
(67, 'test', 'jeguglie', '2019-10-10'),
(63, 'okkk', 'jeguglie', '2019-10-10'),
(121, 'fsfd', 'jeguglie', '2019-10-10'),
(121, 'sfsdfsdfsdfs', 'jeguglie', '2019-10-10'),
(67, 'Dkek', 'jeguglie', '2019-10-10');

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `username` varchar(255) NOT NULL,
  `img_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`username`, `img_id`) VALUES
('jeguglie', 56),
('jeguglie', 59),
('jeguglie', 58),
('jeguglie', 57),
('jeguglie', 60),
('jeguglie', 63),
('jeguglie', 67),
('jeguglie', 121),
('jeguglie', 65),
('jeguglie', 64),
('jeguglie', 128);

-- --------------------------------------------------------

--
-- Structure de la table `pictures`
--

CREATE TABLE `pictures` (
  `username` varchar(255) NOT NULL,
  `img_link` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL,
  `comments` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `img_filter` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pictures`
--

INSERT INTO `pictures` (`username`, `img_link`, `likes`, `comments`, `id`, `date`, `img_filter`) VALUES
('jeguglie', '/app/public/images/wall/2019-10-02-10-25.png', 1, 0, 57, '2019-10-02', 'sepia(100%)'),
('jeguglie', '/app/public/images/wall/2019-10-08-10-21.png', 1, 0, 63, '2019-10-08', 'hue-rotate(90deg)'),
('jeguglie', '/app/public/images/wall/2019-10-09-10-13.png', 1, 0, 64, '2019-10-09', 'none'),
('jeguglie', '/app/public/images/wall/2019-10-09-10-20.png', 1, 0, 65, '2019-10-09', 'sepia(100%)'),
('jeguglie', '/app/public/images/wall/2019-10-09-10-12.png', 0, 0, 66, '2019-10-09', 'sepia(100%)'),
('jeguglie', '/app/public/images/wall/2019-10-09-10-07.png', 1, 0, 67, '2019-10-09', 'sepia(100%)'),
('jeguglie0606', '/app/public/images/wall/2019-10-10-10-58.png', 1, 0, 121, '2019-10-10', 'none');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `valid_key` varchar(32) NOT NULL DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '0',
  `password_key` varchar(32) NOT NULL,
  `send_link` int(1) NOT NULL DEFAULT '0',
  `new_comment` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`username`, `password`, `mail`, `valid_key`, `active`, `password_key`, `send_link`, `new_comment`) VALUES
('jeguglie', 'd21e53ad860bbbc070163a43e5ef30b60d4fd6497f0c58d2c280d5f8e8c3f72fa436b6d777a2627df57eb8a00b9c05ea8c520bd4d2d169466a4a95fd34283de8', 'guglielmettijv@gmail.com', '2d98bfda3adf1758d2d8f6cb0ecb240d', 1, '0358de85444070592b3a0b472e5aeaea', 0, 1),
('jeguglie0606', '8b6722e45c807d511b06a87dcc37bdb542461e826d8d56b7ef05e185c23e82ba4e099e757dcc332894561e0dbcf0a5aec9e69fa09524c2fbdfca7909eabd0b1a', 'guglielmettijv@gmail.com', '573a49be5ec6f04ebbd114f5390caad0', 1, '0358de85444070592b3a0b472e5aeaea', 0, 1),
('test2', '0cd155703076e44851e120dd8d45dab839248191fb9bc6c5fe028ceddcd19381e7c15fb7eb585172c3be948d25fb1ea4b82a9a9218cec1271a770c5ee38cc868', 'guglielmettijv@gmail.com', 'ed2db227066941aab6138c72b9cb34ac', 0, '0358de85444070592b3a0b472e5aeaea', 0, 1),
('heyyyyy', '8b6722e45c807d511b06a87dcc37bdb542461e826d8d56b7ef05e185c23e82ba4e099e757dcc332894561e0dbcf0a5aec9e69fa09524c2fbdfca7909eabd0b1a', 'guglielmettijv@gmail.com', '6a324e8b9337130c3bfb110f84654ece', 1, '', 1, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
