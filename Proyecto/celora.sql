-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-11-2024 a las 03:33:34
-- Versión del servidor: 8.0.40-0ubuntu0.24.04.1
-- Versión de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `celora`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `department`
--

CREATE TABLE `department` (
  `code` varchar(5) NOT NULL,
  `name` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `department`
--

INSERT INTO `department` (`code`, `name`) VALUES
('ADMIN', 'Administration'),
('ALMAA', 'Warehouse'),
('CALDD', 'Quality'),
('COMPR', 'Purchasing'),
('DSPRO', 'Product Development'),
('FINSZ', 'Finance'),
('IITTT', 'IT'),
('INDSS', 'Research & Development'),
('INNVN', 'Innovation'),
('LGALL', 'Legal'),
('LOGSS', 'Logistics'),
('MANTT', 'Maintenance'),
('MARKE', 'Marketing'),
('PLESS', 'Strategic Planning'),
('PRODD', 'Production'),
('REHUM', 'Human Resources'),
('RLPBP', 'Public Relations'),
('SGRDD', 'Security'),
('SRCLI', 'Customer Service'),
('VENTS', 'Sales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employee`
--

CREATE TABLE `employee` (
  `employeeNumber` int NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `secondLastName` varchar(100) DEFAULT NULL,
  `departmentCode` varchar(5) DEFAULT NULL,
  `password` varchar(8) NOT NULL,
  `userType` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `employee`
--

INSERT INTO `employee` (`employeeNumber`, `firstName`, `lastName`, `secondLastName`, `departmentCode`, `password`, `userType`) VALUES
(1, 'Luis', 'García', 'Pérez', 'REHUM', '3h5K1rT2', 'u1'),
(2, 'Ana', 'Martínez', 'Hernández', 'FINSZ', 'Y9b2M4xP', 'u1'),
(3, 'Jorge', 'Ramírez', 'Díaz', 'COMPR', 'Q1r8L2jF', 'u2'),
(4, 'Sofía', 'Torres', 'López', 'IITTT', 'D7f3P6nV', 'u1'),
(5, 'Mario', 'Gutiérrez', 'Ortiz', 'MARKE', 'E9y4W3lQ', 'u1'),
(6, 'Isabel', 'Castillo', 'Soto', 'VENTS', 'L2n5K8dR', 'u1'),
(7, 'Andrés', 'Vargas', 'Morales', 'LOGSS', 'F1j7R5xT', 'u1'),
(8, 'Laura', 'Jiménez', 'Rosales', 'PRODD', 'P3m9Y2wQ', 'u1'),
(9, 'Pablo', 'Gómez', 'Hernández', 'MANTT', 'G7b2X4kM', 'u1'),
(10, 'Daniela', 'Pérez', 'Solís', 'CALDD', 'H6l1J9mY', 'u1'),
(11, 'Diego', 'Sánchez', 'N/A', 'DSPRO', 'K2x8L3vP', 'u1'),
(12, 'Mariana', 'Luna', 'Fernández', 'SRCLI', 'R5m3Q8yF', 'u1'),
(13, 'Sergio', 'Ortiz', 'Mena', 'LGALL', 'J1p9T4wK', 'u1'),
(14, 'Carmen', 'Rodríguez', 'Núñez', 'ADMIN', 'Y8k6M1lH', 'u1'),
(15, 'Rafael', 'Navarro', 'Campos', 'INNVN', 'W3b4L7yN', 'u1'),
(16, 'Valeria', 'Paredes', 'Flores', 'PLESS', 'Q9t5F2nZ', 'u1'),
(17, 'Eduardo', 'Medina', 'Romero', 'INDSS', 'X2r7J1yP', 'u1'),
(18, 'Patricia', 'Silva', 'Ruiz', 'ALMAA', 'M5y4K3vH', 'u1'),
(19, 'Roberto', 'Moreno', 'Lara', 'SGRDD', 'L1k9R8tY', 'u1'),
(20, 'Elena', 'Castro', 'Peña', 'RLPBP', 'N8w3F6rT', 'u1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment`
--

CREATE TABLE `payment` (
  `id` int NOT NULL,
  `reference` varchar(30) NOT NULL,
  `concept` varchar(50) NOT NULL,
  `paymentTypeCode` varchar(4) DEFAULT NULL,
  `purchaseOrderId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `payment`
--

INSERT INTO `payment` (`id`, `reference`, `concept`, `paymentTypeCode`, `purchaseOrderId`) VALUES
(1, 'REF001', '1', 'TRCD', 1),
(2, 'REF002', '2', 'TRBC', 2),
(3, 'REF003', '1', 'EFCT', 3),
(4, 'REF004', '3', 'PGON', 4),
(5, 'REF005', '2', 'PGCT', 5),
(6, 'REF006', '1', 'ORDP', 6),
(7, 'REF007', '3', 'PGPM', 7),
(8, 'REF008', '1', 'TRCD', 8),
(9, 'REF009', '2', 'TRBC', 9),
(10, 'REF010', '3', 'EFCT', 10),
(11, 'REF011', '1', 'PGON', 11),
(12, 'REF012', '2', 'PGCT', 12),
(13, 'REF013', '3', 'ORDP', 13),
(14, 'REF014', '1', 'PGPM', 14),
(15, 'REF015', '2', 'TRCD', 15),
(16, 'REF016', '3', 'TRBC', 16),
(17, 'REF017', '1', 'EFCT', 17),
(18, 'REF018', '2', 'PGON', 18),
(19, 'REF019', '1', 'PGCT', 19),
(20, 'REF020', '3', 'ORDP', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paymentType`
--

CREATE TABLE `paymentType` (
  `code` varchar(4) NOT NULL,
  `type` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `paymentType`
--

INSERT INTO `paymentType` (`code`, `type`) VALUES
('EFCT', 'Cash'),
('ORDP', 'Payment Order'),
('PGCT', 'Cash on Delivery'),
('PGON', 'Online Payment'),
('PGPM', 'Mobile Payment'),
('TRBC', 'Bank Transfer'),
('TRCD', 'Credit Card');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `code` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` float(10,2) NOT NULL,
  `description` varchar(150) NOT NULL,
  `stockCode` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`code`, `name`, `price`, `description`, `stockCode`) VALUES
(1, 'Laptop', 800.50, 'Laptop with 16 GB RAM and 512 GB SSD.', 1),
(2, 'Laser Printer', 120.99, 'High-speed multifunction printer.', 2),
(3, 'Office Desk', 200.00, 'Ergonomic adjustable office desk.', 3),
(4, 'Ergonomic Chair', 150.75, 'Office chair with adjustable lumbar support.', 4),
(5, '27\" Monitor', 300.99, 'Monitor with 4K resolution and anti-glare technology.', 5),
(6, 'Mechanical Keyboard', 45.99, 'Keyboard with backlighting and blue switches.', 6),
(7, 'Optical Mouse', 20.50, 'Ergonomic mouse with adjustable sensitivity.', 7),
(8, 'LED Projector', 600.00, 'Portable projector with Full HD resolution.', 8),
(9, '1TB External HDD', 80.00, 'External hard drive with USB 3.0 connection and high speed.', 9),
(10, 'IP Phone', 50.00, 'Conference phone with advanced features.', 10),
(11, 'Wireless Router', 70.50, 'Router with dual band and wide coverage.', 11),
(12, 'Security Camera', 120.00, 'Camera with night vision and Wi-Fi connection.', 12),
(13, 'Floor Fan', 30.00, 'Fan with three speeds and oscillation.', 13),
(14, '2-meter HDMI Cable', 10.00, 'Cable with gold-plated connectors for better signal.', 14),
(15, 'USB-C Adapter', 25.00, 'Adapter with multiple ports to connect devices.', 15),
(16, 'Charging Station', 40.00, 'Wireless charging base for mobile devices.', 16),
(17, 'USB Microphone', 35.00, 'Microphone for high-quality recording.', 17),
(18, 'Monitor Stand', 45.00, 'Adjustable stand to improve ergonomics.', 18),
(19, 'USB 3.0 Hub', 15.00, 'Hub with multiple USB ports for expansion.', 19),
(20, 'Software License', 100.00, 'Annual license for productivity software.', 20),
(21, 'asdasd', 50.00, 'aasdasda', 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_requisition`
--

CREATE TABLE `product_requisition` (
  `productCode` int NOT NULL,
  `requisitionId` int NOT NULL,
  `quantity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `product_requisition`
--

INSERT INTO `product_requisition` (`productCode`, `requisitionId`, `quantity`) VALUES
(1, 1, 10),
(2, 2, 5),
(3, 3, 15),
(4, 4, 20),
(5, 5, 30),
(6, 6, 50),
(7, 7, 8),
(8, 8, 2),
(9, 9, 25),
(10, 10, 18),
(11, 11, 12),
(12, 12, 9),
(13, 13, 14),
(14, 14, 6),
(15, 15, 10),
(16, 16, 5),
(17, 17, 3),
(18, 18, 40),
(19, 19, 22),
(20, 20, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchaseOrder`
--

CREATE TABLE `purchaseOrder` (
  `id` int NOT NULL,
  `requiredQuantity` int NOT NULL,
  `requiredDate` date NOT NULL,
  `total` float(10,2) DEFAULT NULL,
  `subtotal` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `purchaseOrder`
--

INSERT INTO `purchaseOrder` (`id`, `requiredQuantity`, `requiredDate`, `total`, `subtotal`) VALUES
(1, 10, '2024-10-05', 8000.00, 7000.00),
(2, 5, '2024-10-06', 600.00, 500.00),
(3, 15, '2024-10-07', 4500.00, 4000.00),
(4, 20, '2024-10-08', 3000.00, 2500.00),
(5, 30, '2024-10-09', 1800.00, 1500.00),
(6, 8, '2024-10-10', 1200.00, 1000.00),
(7, 2, '2024-10-11', 700.00, 600.00),
(8, 25, '2024-10-12', 5000.00, 4000.00),
(9, 18, '2024-10-13', 3500.00, 3000.00),
(10, 12, '2024-10-14', 2400.00, 2000.00),
(11, 9, '2024-10-15', 700.00, 600.00),
(12, 14, '2024-10-16', 4200.00, 3500.00),
(13, 6, '2024-10-17', 1800.00, 1500.00),
(14, 5, '2024-10-18', 1500.00, 1200.00),
(15, 10, '2024-10-19', 1000.00, 800.00),
(16, 3, '2024-10-20', 900.00, 800.00),
(17, 4, '2024-10-21', 350.00, 300.00),
(18, 7, '2024-10-22', 1100.00, 1000.00),
(19, 11, '2024-10-23', 1300.00, 1100.00),
(20, 20, '2024-10-24', 4000.00, 3500.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quotation`
--

CREATE TABLE `quotation` (
  `id` varchar(8) NOT NULL,
  `issueDate` date DEFAULT NULL,
  `total` float(10,2) DEFAULT NULL,
  `subtotal` float(10,2) DEFAULT NULL,
  `supplierId` int DEFAULT NULL,
  `file` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `quotation`
--

INSERT INTO `quotation` (`id`, `issueDate`, `total`, `subtotal`, `supplierId`, `file`) VALUES
('1', '2024-10-01', 12000.00, 10000.00, 1, NULL),
('10', '2024-10-10', 20000.00, 18000.00, 10, NULL),
('11', '2024-10-11', 25000.00, 22000.00, 11, NULL),
('12', '2024-10-12', 3000.00, 2500.00, 12, NULL),
('13', '2024-10-13', 500.00, 400.00, 13, NULL),
('14', '2024-10-14', 1200.00, 1000.00, 14, NULL),
('15', '2024-10-15', 7000.00, 6000.00, 15, NULL),
('16', '2024-10-16', 1500.00, 1200.00, 16, NULL),
('17', '2024-10-17', 8000.00, 7500.00, 17, NULL),
('18', '2024-10-18', 900.00, 800.00, 18, NULL),
('19', '2024-10-19', 650.00, 500.00, 19, NULL),
('2', '2024-10-02', 5000.00, 4500.00, 2, NULL),
('20', '2024-10-20', 1800.00, 1500.00, 20, NULL),
('3', '2024-10-03', 15000.00, 13000.00, 3, NULL),
('4', '2024-10-04', 18000.00, 16000.00, 4, NULL),
('5', '2024-10-05', 7500.00, 7000.00, 5, NULL),
('6', '2024-10-06', 9000.00, 8500.00, 6, NULL),
('7', '2024-10-07', 11000.00, 10000.00, 7, NULL),
('8', '2024-10-08', 6000.00, 5500.00, 8, NULL),
('9', '2024-10-09', 14000.00, 12000.00, 9, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `report`
--

CREATE TABLE `report` (
  `id` int NOT NULL,
  `requisitionId` int DEFAULT NULL,
  `purchaseOrderId` int DEFAULT NULL,
  `quotationId` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `report`
--

INSERT INTO `report` (`id`, `requisitionId`, `purchaseOrderId`, `quotationId`) VALUES
(1, 1, 1, '1'),
(2, 2, 2, '2'),
(3, 3, 3, '3'),
(4, 4, 4, '4'),
(5, 5, 5, '5'),
(6, 6, 6, '6'),
(7, 7, 7, '7'),
(8, 8, 8, '8'),
(9, 9, 9, '9'),
(10, 10, 10, '10'),
(11, 11, 11, '11'),
(12, 12, 12, '12'),
(13, 13, 13, '13'),
(14, 14, 14, '14'),
(15, 15, 15, '15'),
(16, 16, 16, '16'),
(17, 17, 17, '17'),
(18, 18, 18, '18'),
(19, 19, 19, '19'),
(20, 20, 20, '20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requisition`
--

CREATE TABLE `requisition` (
  `id` int NOT NULL,
  `requiredQuantity` int NOT NULL,
  `date` date NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `requester` int DEFAULT NULL,
  `authorizer` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `requisition`
--

INSERT INTO `requisition` (`id`, `requiredQuantity`, `date`, `description`, `requester`, `authorizer`) VALUES
(1, 10, '2024-10-01', 'Computers for new staff.', 1, 3),
(2, 5, '2024-10-02', 'Printers for office.', 2, 3),
(3, 15, '2024-10-03', 'Monitors for work teams.', 4, 3),
(4, 20, '2024-10-04', 'Ergonomic chairs for employees.', 5, 3),
(5, 30, '2024-10-05', 'Keyboards and mice.', 6, 3),
(6, 50, '2024-10-06', 'Office documents.', 7, 3),
(7, 8, '2024-10-07', 'Charging stations.', 8, 3),
(8, 2, '2024-10-08', 'Projectors for presentations.', 9, 3),
(9, 25, '2024-10-09', 'HDMI cables.', 10, 3),
(10, 18, '2024-10-10', 'Monitor stands.', 11, 3),
(11, 12, '2024-10-11', 'Software licenses.', 12, 3),
(12, 9, '2024-10-12', 'Security cameras.', 13, 3),
(13, 14, '2024-10-13', 'Fans for the office.', 14, 3),
(14, 6, '2024-10-14', 'USB microphones.', 15, 3),
(15, 10, '2024-10-15', 'Cleaning products.', 16, 3),
(16, 5, '2024-10-16', 'Desktop computers.', 17, 3),
(17, 3, '2024-10-17', 'Portable projector.', 18, 3),
(18, 40, '2024-10-18', 'Visitor chairs.', 19, 3),
(19, 22, '2024-10-19', 'External hard drive.', 20, 3),
(20, 17, '2024-10-20', 'USB-C adapters.', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `code` int NOT NULL,
  `quantity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`code`, `quantity`) VALUES
(1, 100),
(2, 50),
(3, 70),
(4, 30),
(5, 60),
(6, 20),
(7, 80),
(8, 40),
(9, 15),
(10, 90),
(11, 25),
(12, 35),
(13, 45),
(14, 55),
(15, 65),
(16, 75),
(17, 85),
(18, 95),
(19, 5),
(20, 10),
(21, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `supplier`
--

CREATE TABLE `supplier` (
  `id` int NOT NULL,
  `firstName` varchar(35) NOT NULL,
  `lastName` varchar(35) NOT NULL,
  `secondLastName` varchar(35) DEFAULT NULL,
  `legalName` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `supplier`
--

INSERT INTO `supplier` (`id`, `firstName`, `lastName`, `secondLastName`, `legalName`) VALUES
(1, 'Juan', 'Pérez', 'Rodríguez', 'Proveedor Comercial SA'),
(2, 'Ana', 'López', 'González', 'Logística Integral SL'),
(3, 'Carlos', 'Fernández', 'Jiménez', 'Tecnología y Servicios SA'),
(4, 'María', 'Martínez', 'Díaz', 'Maquinarias Industriales SAC'),
(5, 'José', 'García', 'Romero', 'Alimentos Frescos SL'),
(6, 'Laura', 'Sánchez', 'Torres', 'Importaciones del Norte SA'),
(7, 'Pedro', 'Castillo', 'Ruiz', 'Servicios Eléctricos SA'),
(8, 'Marta', 'Delgado', 'Herrera', 'Suministros Empresariales SL'),
(9, 'Jorge', 'Mendoza', 'Ortiz', 'Distribuciones Centrales SA'),
(10, 'Silvia', 'Moreno', 'Morales', 'Transporte Especializado SL'),
(11, 'Luis', 'Gutiérrez', 'Rivas', 'Fabricación Metálica SAC'),
(12, 'Elena', 'Paredes', 'Santos', 'Comercializadora del Sur SL'),
(13, 'Manuel', 'Ramírez', 'Aguirre', 'Ingeniería de Precisión SA'),
(14, 'Patricia', 'Barrios', 'Cano', 'Agroindustria y Servicios SL'),
(15, 'Alberto', 'Núñez', 'Escobar', 'Tecnología Avanzada SA'),
(16, 'Gabriela', 'Rojas', 'Lozano', 'Consultores Técnicos SL'),
(17, 'Raúl', 'Villarreal', 'Molina', 'Energía Renovable SA'),
(18, 'Daniela', 'Vélez', 'Cardona', 'Productos Químicos SA'),
(19, 'Julio', 'Peña', 'Ayala', 'Alquiler de Maquinaria SL'),
(20, 'Lorena', 'Salazar', 'Villegas', 'Servicios Integrados SL');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employeeNumber`),
  ADD KEY `departmentCode` (`departmentCode`);

--
-- Indices de la tabla `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paymentTypeCode` (`paymentTypeCode`),
  ADD KEY `purchaseOrderId` (`purchaseOrderId`);

--
-- Indices de la tabla `paymentType`
--
ALTER TABLE `paymentType`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`code`),
  ADD KEY `stockCode` (`stockCode`);

--
-- Indices de la tabla `product_requisition`
--
ALTER TABLE `product_requisition`
  ADD PRIMARY KEY (`productCode`,`requisitionId`),
  ADD KEY `requisitionId` (`requisitionId`);

--
-- Indices de la tabla `purchaseOrder`
--
ALTER TABLE `purchaseOrder`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplierId` (`supplierId`);

--
-- Indices de la tabla `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requisitionId` (`requisitionId`),
  ADD KEY `purchaseOrderId` (`purchaseOrderId`),
  ADD KEY `quotationId` (`quotationId`);

--
-- Indices de la tabla `requisition`
--
ALTER TABLE `requisition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requester` (`requester`),
  ADD KEY `authorizer` (`authorizer`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `code` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `purchaseOrder`
--
ALTER TABLE `purchaseOrder`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `report`
--
ALTER TABLE `report`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `requisition`
--
ALTER TABLE `requisition`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `code` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`departmentCode`) REFERENCES `department` (`code`);

--
-- Filtros para la tabla `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`paymentTypeCode`) REFERENCES `paymentType` (`code`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`purchaseOrderId`) REFERENCES `purchaseOrder` (`id`);

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`stockCode`) REFERENCES `stock` (`code`);

--
-- Filtros para la tabla `product_requisition`
--
ALTER TABLE `product_requisition`
  ADD CONSTRAINT `product_requisition_ibfk_1` FOREIGN KEY (`productCode`) REFERENCES `product` (`code`),
  ADD CONSTRAINT `product_requisition_ibfk_2` FOREIGN KEY (`requisitionId`) REFERENCES `requisition` (`id`);

--
-- Filtros para la tabla `quotation`
--
ALTER TABLE `quotation`
  ADD CONSTRAINT `quotation_ibfk_1` FOREIGN KEY (`supplierId`) REFERENCES `supplier` (`id`);

--
-- Filtros para la tabla `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`requisitionId`) REFERENCES `requisition` (`id`),
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`purchaseOrderId`) REFERENCES `purchaseOrder` (`id`),
  ADD CONSTRAINT `report_ibfk_3` FOREIGN KEY (`quotationId`) REFERENCES `quotation` (`id`);

--
-- Filtros para la tabla `requisition`
--
ALTER TABLE `requisition`
  ADD CONSTRAINT `requisition_ibfk_1` FOREIGN KEY (`requester`) REFERENCES `employee` (`employeeNumber`),
  ADD CONSTRAINT `requisition_ibfk_2` FOREIGN KEY (`authorizer`) REFERENCES `employee` (`employeeNumber`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
