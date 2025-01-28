-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 28-01-2025 a las 21:47:06
-- Versión del servidor: 8.0.40
-- Versión de PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `medical_appointments`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medical_appointments`
--

CREATE TABLE `medical_appointments` (
  `appointment_id` int NOT NULL,
  `appointment_date` datetime NOT NULL,
  `appointment_reason` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `appointment_diagnostic` text COLLATE utf8mb3_spanish_ci,
  `patient_id` int DEFAULT NULL,
  `doctor_name` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `medical_appointments`
--

INSERT INTO `medical_appointments` (`appointment_id`, `appointment_date`, `appointment_reason`, `appointment_diagnostic`, `patient_id`, `doctor_name`) VALUES
(17, '2025-12-12 13:00:00', 'Dolor en el pecho.', '', 17, 'Dr. Juan Pérez'),
(19, '2025-09-09 17:30:00', 'Dolencias en la cadera al andar.', '', 18, 'Dra. María López'),
(20, '2025-08-08 12:20:00', 'Subidas espontáneas de tensión.', '', 10, 'Dra. María López'),
(21, '2025-06-06 15:00:00', 'Adicción al serranito.', '', 20, 'Dr. Carlos García'),
(22, '2025-07-07 08:00:00', 'Alta fiebre.', '', 9, 'Dra. Ana Torres'),
(23, '2025-04-04 16:00:00', 'Rehabilitación del tobillo derecho.', '', 5, 'Dra. Ana Torres'),
(24, '2025-05-05 19:20:00', 'Ansiedad.', '', 17, 'Dr. Juan Pérez'),
(25, '2025-05-22 13:35:00', 'Migraña.', '', 4, 'Dr. Carlos García'),
(26, '2025-05-06 12:30:00', 'Diarrea.', '', 9, 'Dr. Juan Pérez'),
(27, '2025-02-28 18:50:00', 'Oye menos por un oído que por otro.', '', 10, 'Dra. Ana Torres');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patients`
--

CREATE TABLE `patients` (
  `patient_id` int NOT NULL,
  `patient_name` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `patient_birthdate` date NOT NULL,
  `patient_history` text COLLATE utf8mb3_spanish_ci,
  `patient_phone` varchar(15) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `patient_email` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `patients`
--

INSERT INTO `patients` (`patient_id`, `patient_name`, `patient_birthdate`, `patient_history`, `patient_phone`, `patient_email`) VALUES
(4, 'Ana López', '1978-07-19', 'Historial: diabetes tipo 2.', '680234567', 'ana.lopez@gmail.com'),
(5, 'Luis Martínez', '2000-02-28', NULL, '610345678', 'luis.martinez@outlook.com'),
(6, 'Laura Sánchez', '1995-06-08', 'Historial: asma.', '690987123', 'laura.sanchez@gmail.com'),
(7, 'Pedro Torres', '1970-12-01', 'Historial: colesterol alto.', '600567890', 'pedro.torres@yahoo.com'),
(8, 'Isabel Romero', '1988-04-14', NULL, '620234890', 'isabel.romero@hotmail.com'),
(9, 'Sofía Hernández', '1999-09-09', 'Historial: migrañas crónicas.', '670890123', 'sofia.hernandez@gmail.com'),
(10, 'Miguel Fernández', '1965-01-23', NULL, '610890456', 'miguel.fernandez@outlook.com'),
(17, 'Roberto', '1432-02-12', 'rewrwe', '321654987', 'robertooo@gmail.com'),
(18, 'Adrián Serrano', '2005-12-29', 'Ningún antecedente.', '689879456', 'adriantecn789@gmail.com'),
(20, 'Carlos Alberto Rodriguez', '2000-12-15', 'Adicto al serranito.', '666888999', 'carlos@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `medical_appointments`
--
ALTER TABLE `medical_appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD UNIQUE KEY `appointment_date` (`appointment_date`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indices de la tabla `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `patient_phone` (`patient_phone`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `medical_appointments`
--
ALTER TABLE `medical_appointments`
  MODIFY `appointment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `medical_appointments`
--
ALTER TABLE `medical_appointments`
  ADD CONSTRAINT `medical_appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
