-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: mysql.php4devs
-- Generation Time: 21-Mar-2016 às 11:36
-- Versão do servidor: 5.7.11
-- PHP Version: 5.6.19

SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET
  time_zone = "+00:00";



/*!40101 SET
  @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;

/*!40101 SET
  @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;

/*!40101 SET
  @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;

/*!40101 SET NAMES
  utf8mb4 */;


--
-- Database: `estoque`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoques`
--

CREATE TABLE `estoques`(
  `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `usuario_id` INT(11) NOT NULL,
  `produto_id` INT(11) NOT NULL,
  `quantidade` INT(11) NOT NULL DEFAULT '0',
  `criado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos`(
  `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `quantidade` INT(11) NOT NULL DEFAULT '0'
) ENGINE = InnoDB DEFAULT CHARSET = utf8;



-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios`(
  `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `senha` VARCHAR(255) DEFAULT NULL,
  `perfil` VARCHAR(10) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `estoques`
--
ALTER TABLE
  `estoques` 
  ADD KEY `usuario_id`(`usuario_id`),
  ADD KEY `produto_id`(`produto_id`);


--
-- Indexes for table `produtos`
--
ALTER TABLE
  `produtos` 
  ADD KEY `nome`(`nome`);


--
-- Indexes for table `usuarios`
--
ALTER TABLE
  `usuarios` 
  ADD UNIQUE KEY `email`(`email`);


--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `estoques`
--
ALTER TABLE
  `estoques` ADD CONSTRAINT `estoques_produto_id_foreign` FOREIGN KEY(`produto_id`) REFERENCES `produtos`(`id`),
  ADD CONSTRAINT `estoques_usuario_id_foreign` FOREIGN KEY(`usuario_id`) REFERENCES `usuarios`(`id`);


/*!40101 SET
  CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET
  CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET
  COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;