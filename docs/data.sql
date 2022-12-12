CREATE TABLE `productions` (
`id` int(11) NOT NULL,
`intitule` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
`compositeur` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `productions` (`id`, `intitule`, `compositeur`) VALUES
(1, 'Tosca', 'Giuseppe Verdi'),
(3, 'Casse Noisette', 'I. Tchaikovski'),
(4, 'Don Giovanni', 'W.A. Mozart'),
(5, 'Il Barbiere di Siviglia', 'Rossini');
CREATE TABLE `distribution` (
`id` int(11) NOT NULL,
`idProduction` int(11) NOT NULL,
`role` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
`artiste` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `distribution` (`id`, `idProduction`, `role`, `artiste`) VALUES
(1, 1, 'Tosca', 'Marie Lemieux'),
(2, 1, 'Mario Cavaradossi', 'Anja Harteros'),
(3, 1, 'Scarpia', 'Marcelo Spuente'),
(4, 1, 'Cesare Angelotti', 'Luca Salsi'),
(5, 2, 'Clara', 'Mélanie Hurel'),
(6, 2, 'Le Prince', 'Josua Hoffalt'),
(7, 2, 'Luisa', 'Caroline Bance'),
(8, 2, 'Fritz', 'Axel Ibot');
CREATE TABLE `productions_dates` (
`id` int(11) NOT NULL,
`idProduction` int(11) NOT NULL,
`dateHeure` datetime NOT NULL,
`commentaire` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `productions_dates` (`id`, `idProduction`, `dateHeure`, `commentaire`) VALUES
(1, 1, '2022-01-11 19:30:00', 'Première'),
(2, 2, '2022-03-01 19:30:00', 'Première'),
(3, 1, '2022-01-20 19:30:00', ''),
(4, 1, '2022-01-21 19:30:00', ''),
(5, 2, '2022-03-03 11:30:00', 'Matinée'),
(6, 1, '2022-01-15 19:30:00', ''),
(7, 2, '2022-03-06 19:30:00', ''),
(8, 2, '2022-03-08 19:30:00', ''),
(9, 1, '2022-01-13 19:30:00', '');