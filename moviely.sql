-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2023 a las 21:23:11
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `moviely`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actor`
--

CREATE TABLE `actor` (
  `id_actor` int(8) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actor`
--

INSERT INTO `actor` (`id_actor`, `nombre`, `apellido`) VALUES
(4, 'Hitoshi', 'Takagi'),
(6, 'Noriko', 'Hidaka'),
(7, 'Sumi', 'Shimamoto'),
(8, 'Naoki', 'Tatsuta'),
(9, 'Jamie', 'Foxx'),
(10, 'Chirstoph', 'Waltz'),
(11, 'Leonardo', 'DiCaprio'),
(12, 'Margot', 'Robbie'),
(13, 'Ryan', 'Gosling'),
(14, 'America', 'Ferrera'),
(15, 'Will', 'Ferrell'),
(16, 'Kate', 'McKinnon'),
(19, 'Uma', 'Thurman'),
(20, 'Lucy', 'Liu'),
(21, 'Michael', 'Bowel'),
(22, 'Youji', 'Matsuda'),
(23, 'Yuriko', 'Ishida'),
(24, 'Yuko', 'Tanaka'),
(25, 'Carey', 'Mulligan'),
(26, 'Bryan', 'Cranston'),
(27, 'Oscar', 'Isaac'),
(28, 'Edward', 'Norton'),
(29, 'Helena', 'Bonham Carter'),
(30, 'Brad', 'Pitt'),
(31, 'Johnny', 'Depp'),
(32, 'Alan', 'Rickman'),
(33, 'Robin', 'Williams'),
(34, 'Ethan', 'Hawke'),
(35, 'Gale', 'Hansen'),
(36, 'Joaquin', 'Phoenix'),
(37, 'Robert', 'De Niro'),
(38, 'Zazie', 'Beetz'),
(39, 'Rami', 'Malek'),
(40, 'Gwilym', 'Lee'),
(41, 'Ben', 'Hardy'),
(42, 'Joseph', 'Mazzello');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `director`
--

CREATE TABLE `director` (
  `id_director` int(8) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `director`
--

INSERT INTO `director` (`id_director`, `nombre`, `apellido`) VALUES
(17, 'Hayao', 'Miyazaki'),
(18, 'Quentin', 'Tarantino'),
(22, 'Greta', 'Gerwig'),
(26, 'Nicolas', 'Winding Refn'),
(27, 'David', 'Fincher'),
(28, 'Tim', 'Burton'),
(29, 'Peter', 'Weir'),
(30, 'Todd', 'Phillips'),
(31, 'Anthony', 'McCarten');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `id_genero` int(8) NOT NULL,
  `nombre_genero` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id_genero`, `nombre_genero`) VALUES
(2, 'Kids'),
(3, 'Infantil'),
(4, 'Fantasía'),
(5, 'Dramático'),
(6, 'Wéstern'),
(7, 'Familiar'),
(8, 'Comedia'),
(9, 'Sátira'),
(11, 'Acción'),
(12, 'Thriller'),
(13, 'Aventura'),
(14, 'Suspenso'),
(15, 'Crimen'),
(16, 'Terror'),
(17, 'Misterio'),
(18, 'Historia Real'),
(19, 'Música');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mi_lista`
--

CREATE TABLE `mi_lista` (
  `id_usuario` int(8) NOT NULL,
  `id_peli` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peli`
--

CREATE TABLE `peli` (
  `id_peli` int(8) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `path_poster` varchar(255) NOT NULL,
  `estreno` date NOT NULL,
  `descripcion` text NOT NULL,
  `temporada` int(4) DEFAULT NULL,
  `duracion` int(4) DEFAULT NULL,
  `calificacion` float NOT NULL,
  `cant_review` int(10) NOT NULL,
  `cant_estrellas` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peli`
--

INSERT INTO `peli` (`id_peli`, `titulo`, `path_poster`, `estreno`, `descripcion`, `temporada`, `duracion`, `calificacion`, `cant_review`, `cant_estrellas`) VALUES
(48, 'Mi Vecino Totoro', 'posters/20230928200113to.jpg', '1988-04-16', 'Una familia japonesa se traslada al campo. Las dos hijas se encuentran con un espíritu llamado Totoro, que habita en el bosque. Junto a él, comparten mágicas aventuras.', 0, 86, 4.3, 0, 0),
(49, 'Django Desencadenado', 'posters/20230928200128dj.jpg', '2013-01-31', 'Acompañado por un cazarrecompensas alemán, un esclavo liberado, Django viaja a través de Estados Unidos para liberar a su esposa del sádico propietario de una plantación.', 0, 165, 0, 0, 0),
(52, 'Barbie', 'posters/20230930155146barbi.jpg', '2023-07-20', 'Barbie lleva una vida ideal en Barbieland, allí todo es perfecto, con fiestas llenas de música y color, todos los días son el mejor día. Claro que Barbie se hace algunas preguntas, cuestiones bastante incómodas que no encajan con el mundo idílico en el que ella y las demás Barbies viven. Cuando Barbie se dé cuenta de que es capaz de apoyar los talones en el suelo, y tener los pies planos, decidirá calzarse unos zapatos sin tacones y viajar hasta el mundo real.', NULL, 114, 0, 0, 0),
(73, 'Kill Bill', 'posters/20231003224718kb.jpg', '2003-11-27', 'El día de su boda, una asesina profesional sufre el ataque de algunos miembros de su propia banda, que obedecen las órdenes de Bill, el jefe de la organización criminal. Logra sobrevivir al ataque, aunque queda en coma. Cuatro años después despierta dominada por un gran deseo de venganza. ', 0, 110, 0, 0, 0),
(74, 'La Princesa Mononoke', 'posters/20231003232650mo.jpg', '1997-07-12', 'Tras sufrir el ataque de un monstruoso jabalí maldito, el joven Ashitaka emprende el camino en busca de la cura que detenga la infección. Mientras, los humanos están acabando con los bosques y los dioses convertidos en temibles bestias hacen todo lo posible por protegerlo encabezados por Mononoke, una princesa guerrera. Ashikata deberá escoger bando y decidir si ayudar a los hombres o las deidades intentando detener su maldición.', 0, 134, 0, 0, 0),
(75, 'Drive', 'posters/20231004005342dri.jpg', '2012-03-01', 'Durante el día, Driver trabaja en un taller y es conductor especialista de cine, pero, algunas noches de forma esporádica, trabaja como chófer para delincuentes. Shannon, su mentor y jefe, que conoce bien su talento al volante, le busca directores de cine y televisión o criminales que necesiten al mejor conductor para sus fugas, llevándose la correspondiente comisión. Pero el mundo de Driver cambia el día en que conoce a Irene, una guapa vecina que tiene un hijo pequeño y a su marido en la cárcel.', 0, 100, 0, 0, 0),
(76, 'El Club de la Pelea', 'posters/20231003235405ec.jpg', '1999-11-04', 'Un joven sin ilusiones lucha contra su insomnio, consecuencia quizás de su hastío por su gris y rutinaria vida. En un viaje en avión conoce a Tyler Durden, un carismático vendedor de jabón que sostiene una filosofía muy particular: el perfeccionismo es cosa de gentes débiles; en cambio, la autodestrucción es lo único que hace que realmente la vida merezca la pena. Ambos deciden entonces formar un club secreto de lucha donde descargar sus frustaciones y su ira que tendrá un éxito arrollador.', 0, 139, 0, 0, 0),
(77, 'Sweeney Todd: El barbero diabólico de la calle Fleet', 'posters/20231004005437sw.jpg', '2008-01-25', 'Benjamin Barker, un hombre encarcelado 15 años injustamente en el otro lado del mundo, que escapa y vuelve a Londres con la promesa de vengarse, junto a su obsesiva y devota cómplice, la Sra. Nellie Lovett. Adoptando el disfraz de Sweeney Todd, Barker regresa a su antigua barbería encima del local de empanadas de carne de la Sra. Lovett, y fija su mira en el juez Turpin que, con la ayuda de su vil secuaz Beadle Bamford, lo encarcelaron con una acusación falsa y así poder robarle a su esposa, Lucy, y a su hija bebé.', 0, 117, 0, 0, 0),
(78, 'El Club de los Poetas Muetos', 'posters/20231004002321ecp.jpg', '1990-02-15', 'En un elitista y estricto colegio privado de Nueva Inglaterra, un grupo de alumnos descubrirá la poesía, el significado de \"Carpe Diem\" -aprovechar el momento- y la importancia de perseguir los sueños, gracias a un excéntrico profesor que despierta sus mentes por medio de métodos poco convencionales.', 0, 128, 0, 0, 0),
(79, 'Joker', 'posters/20231004005315ej.jpg', '2019-10-03', 'Arthur Fleck es un hombre ignorado por la sociedad, cuya motivación en la vida es hacer reír. Pero una serie de trágicos acontecimientos le llevarán a ver el mundo de otra forma. Película basada en Joker, el popular personaje de DC Comics y archivillano de Batman, pero que en este film toma un cariz más realista y oscuro.', 0, 122, 0, 0, 0),
(80, 'Bohemian Rhapsody', 'posters/20231004004942dh.jpg', '2018-11-01', 'Bohemian Rhapsody es una rotunda y sonora celebración de Queen, de su música y de su extraordinario cantante Freddie Mercury, que desafió estereotipos e hizo añicos tradiciones para convertirse en uno de los showmans más queridos del mundo. ', NULL, 134, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peli_actor`
--

CREATE TABLE `peli_actor` (
  `id_peli` int(8) NOT NULL,
  `id_actor` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peli_actor`
--

INSERT INTO `peli_actor` (`id_peli`, `id_actor`) VALUES
(48, 4),
(48, 6),
(48, 7),
(48, 8),
(49, 9),
(49, 10),
(49, 11),
(52, 12),
(52, 13),
(52, 14),
(52, 15),
(52, 16),
(73, 19),
(73, 20),
(73, 21),
(74, 22),
(74, 23),
(74, 24),
(75, 13),
(75, 25),
(75, 26),
(75, 27),
(76, 28),
(76, 29),
(76, 30),
(77, 29),
(77, 31),
(77, 32),
(78, 33),
(78, 34),
(78, 35),
(79, 36),
(79, 37),
(79, 38),
(80, 39),
(80, 40),
(80, 41),
(80, 42);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peli_director`
--

CREATE TABLE `peli_director` (
  `id_peli` int(8) NOT NULL,
  `id_director` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peli_director`
--

INSERT INTO `peli_director` (`id_peli`, `id_director`) VALUES
(49, 18),
(48, 17),
(52, 22),
(73, 18),
(74, 17),
(75, 26),
(76, 27),
(77, 28),
(78, 29),
(79, 30),
(80, 31);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peli_genero`
--

CREATE TABLE `peli_genero` (
  `id_peli` int(8) NOT NULL,
  `id_genero` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peli_genero`
--

INSERT INTO `peli_genero` (`id_peli`, `id_genero`) VALUES
(48, 2),
(48, 3),
(48, 4),
(49, 5),
(49, 6),
(48, 7),
(52, 8),
(52, 4),
(52, 9),
(73, 11),
(73, 12),
(74, 13),
(75, 5),
(75, 14),
(75, 15),
(76, 5),
(77, 5),
(77, 16),
(78, 5),
(79, 15),
(79, 5),
(79, 14),
(80, 5),
(80, 18),
(80, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `review`
--

CREATE TABLE `review` (
  `id_review` int(8) NOT NULL,
  `id_usuario` int(8) NOT NULL,
  `id_peli` int(8) NOT NULL,
  `comentario` text DEFAULT NULL,
  `calificacion` int(1) NOT NULL,
  `estado_review` tinyint(1) DEFAULT NULL,
  `estado_usuario` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(8) NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `administrador` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `mail`, `contraseña`, `estado`, `administrador`) VALUES
(7, 'kensho', 'kensho@mail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actor`
--
ALTER TABLE `actor`
  ADD PRIMARY KEY (`id_actor`);

--
-- Indices de la tabla `director`
--
ALTER TABLE `director`
  ADD PRIMARY KEY (`id_director`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id_genero`);

--
-- Indices de la tabla `mi_lista`
--
ALTER TABLE `mi_lista`
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_peli` (`id_peli`);

--
-- Indices de la tabla `peli`
--
ALTER TABLE `peli`
  ADD PRIMARY KEY (`id_peli`),
  ADD UNIQUE KEY `path_poster` (`path_poster`);

--
-- Indices de la tabla `peli_actor`
--
ALTER TABLE `peli_actor`
  ADD KEY `id_peli` (`id_peli`),
  ADD KEY `id_actor` (`id_actor`);

--
-- Indices de la tabla `peli_director`
--
ALTER TABLE `peli_director`
  ADD KEY `id_peli` (`id_peli`),
  ADD KEY `id_director` (`id_director`);

--
-- Indices de la tabla `peli_genero`
--
ALTER TABLE `peli_genero`
  ADD KEY `id_peli` (`id_peli`),
  ADD KEY `id_genero` (`id_genero`);

--
-- Indices de la tabla `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_peli` (`id_peli`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actor`
--
ALTER TABLE `actor`
  MODIFY `id_actor` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `director`
--
ALTER TABLE `director`
  MODIFY `id_director` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `id_genero` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `peli`
--
ALTER TABLE `peli`
  MODIFY `id_peli` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `review`
--
ALTER TABLE `review`
  MODIFY `id_review` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mi_lista`
--
ALTER TABLE `mi_lista`
  ADD CONSTRAINT `mi_lista_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `mi_lista_ibfk_2` FOREIGN KEY (`id_peli`) REFERENCES `peli` (`id_peli`);

--
-- Filtros para la tabla `peli_actor`
--
ALTER TABLE `peli_actor`
  ADD CONSTRAINT `peli_actor_ibfk_1` FOREIGN KEY (`id_peli`) REFERENCES `peli` (`id_peli`),
  ADD CONSTRAINT `peli_actor_ibfk_2` FOREIGN KEY (`id_actor`) REFERENCES `actor` (`id_actor`);

--
-- Filtros para la tabla `peli_director`
--
ALTER TABLE `peli_director`
  ADD CONSTRAINT `peli_director_ibfk_1` FOREIGN KEY (`id_peli`) REFERENCES `peli` (`id_peli`),
  ADD CONSTRAINT `peli_director_ibfk_2` FOREIGN KEY (`id_director`) REFERENCES `director` (`id_director`);

--
-- Filtros para la tabla `peli_genero`
--
ALTER TABLE `peli_genero`
  ADD CONSTRAINT `peli_genero_ibfk_1` FOREIGN KEY (`id_peli`) REFERENCES `peli` (`id_peli`),
  ADD CONSTRAINT `peli_genero_ibfk_2` FOREIGN KEY (`id_genero`) REFERENCES `genero` (`id_genero`);

--
-- Filtros para la tabla `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`id_peli`) REFERENCES `peli` (`id_peli`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
