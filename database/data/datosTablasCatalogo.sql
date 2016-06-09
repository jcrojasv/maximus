-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 19, 2016 at 11:39 AM
-- Server version: 5.6.26-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `entrep_maximus`
--

--
-- Dumping data for table `alimento`
--

INSERT INTO `alimentos` (`id`, `nombre`) VALUES
(1, 'Proplan'),
(2, 'Dog Show'),
(3, 'Max'),
(4, 'Equilibrio'),
(5, 'Nutra Nuggets'),
(6, 'Taste on the wild'),
(7, 'Hills'),
(8, 'Chunky'),
(9, 'Pedigree'),
(10, 'Diamond Naturals'),
(11, 'Dog Gourmet'),
(12, 'Nutre Can'),
(13, 'Animal Planet'),
(14, 'Ringo'),
(15, 'Nutrion');

--
-- Dumping data for table `arreglo`
--

INSERT INTO `arreglos` (`id`, `descripcion`, `padre`, `tipo`) VALUES
(1, 'Baño Comercial', 0, 'ESP'),
(2, 'Baño Especializado', 0, 'ESP'),
(3, 'Limado de uñas', 0, 'GEN'),
(4, 'Limpieza de oídos', 0, 'GEN'),
(5, 'Pluking', 0, 'GEN'),
(6, 'Limpieza de oídos tratamiento', 0, 'GEN'),
(7, 'Limpieza de dientes', 0, 'GEN'),
(8, 'Uso de cuchilla', 0, 'GEN'),
(9, 'Uso de tijera', 0, 'GEN'),
(10, 'Texturizado', 0, 'GEN'),
(11, 'Corte', 0, 'GEN'),
(12, 'Realzado de color', 2, 'ESP'),
(13, 'Olores fuertes', 2, 'ESP'),
(14, 'Insecticida', 2, 'ESP'),
(15, 'Dermatológico', 2, 'ESP'),
(16, 'Hand Stripping', 2, 'ESP');

--
-- Dumping data for table `color`
--

INSERT INTO `colores` (`id`, `color`) VALUES
(1, 'Blanco'),
(2, 'Negro'),
(3, 'Marron'),
(4, 'Gris');

--
-- Dumping data for table `especie`
--

INSERT INTO `especies` (`id`, `descripcion`) VALUES
(1, 'Canino'),
(2, 'Felino');

--
-- Dumping data for table `raza`
--

INSERT INTO `razas` (`id`, `descripcion`, `especie_id`, `correlativo`) VALUES
(1001, 'Shih Tzu', 1, 1),
(1002, 'Shnauzer', 1, 2),
(1003, 'Cocker Spaniel', 1, 3),
(1004, 'Yorkshire Terrier', 1, 4),
(1005, 'Criollo', 1, 5),
(1006, 'Poodle', 1, 6);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
