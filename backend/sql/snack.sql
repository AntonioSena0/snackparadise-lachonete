-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/11/2025 às 22:04
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `snack`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `senha`, `profile_picture`, `created_at`) VALUES
(1, 'teste', 'teste@teste', '1234', NULL, '2025-10-22 13:16:06');

-- --------------------------------------------------------

--
-- Estrutura para tabela `duvidas`
--

CREATE TABLE `duvidas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `nome` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mensagem` text NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `resposta` text DEFAULT NULL,
  `respondida` tinyint(1) NOT NULL DEFAULT 0,
  `resposta_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `duvidas`
--

INSERT INTO `duvidas` (`id`, `usuario_id`, `nome`, `email`, `mensagem`, `criado_em`, `resposta`, `respondida`, `resposta_em`) VALUES
(1, NULL, 'Eduardo Cavalcante de Brito', 'edwinclarwis777@gmail.com', 'teste', '2025-11-06 20:03:30', 'teste', 1, '2025-11-06 17:40:43'),
(2, NULL, 'Eduardo Cavalcante de Brito', 'edwinclarwis777@gmail.com', 'lorem ipsum', '2025-11-06 20:43:02', 'lorem ipsum', 1, '2025-11-06 17:43:23');

-- --------------------------------------------------------

--
-- Estrutura para tabela `motoboys`
--

CREATE TABLE `motoboys` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `license_plate` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `motoboys`
--

INSERT INTO `motoboys` (`id`, `name`, `email`, `senha`, `profile_picture`, `vehicle_type`, `license_plate`, `created_at`) VALUES
(1, 'motoboy', 'motoboy@motoboy', '$2y$10$81HjF5QQJ/I0/BCaNcWkDuALdCwKtjvHGXPPwZuTcZYXPsUIWMWM.', NULL, 'moto', 'AAA1234', '2025-10-27 12:30:48');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `itens` text NOT NULL,
  `endereco` text NOT NULL,
  `pagamento` varchar(50) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `itens`, `endereco`, `pagamento`, `criado_em`, `status`) VALUES
(29, 2, '[{\"id\":1,\"nome\":\"Sunset Burguer\",\"quantidade\":2},{\"id\":7,\"nome\":\"Batata tam.P\",\"quantidade\":1},{\"id\":11,\"nome\":\"Pepsi\",\"quantidade\":2}]', 'Av. Exemplo, 123', 'cartao', '2025-10-27 15:21:12', 'pendente'),
(30, 3, '[{\"id\":1,\"nome\":\"Sunset Burguer\",\"quantidade\":2},{\"id\":7,\"nome\":\"Batata tam.P\",\"quantidade\":1},{\"id\":11,\"nome\":\"Pepsi\",\"quantidade\":2}]', 'Av. Exemplo, 123', 'cartao', '2025-10-27 15:21:12', 'pendente'),
(32, 3, '[{\"id\":1,\"nome\":\"Sunset Burguer\",\"quantidade\":2},{\"id\":7,\"nome\":\"Batata tam.P\",\"quantidade\":1},{\"id\":11,\"nome\":\"Pepsi\",\"quantidade\":2}]', 'Av. Exemplo, 123', 'cartao', '2025-10-27 15:21:12', 'pendente'),
(33, 3, '[{\"id\":1,\"nome\":\"Sunset Burguer\",\"quantidade\":2},{\"id\":7,\"nome\":\"Batata tam.P\",\"quantidade\":1},{\"id\":11,\"nome\":\"Pepsi\",\"quantidade\":2}]', 'Av. Exemplo, 123', 'cartao', '2025-10-27 15:21:12', 'pendente'),
(34, 2, '[{\"id\":1,\"nome\":\"Sunset Burguer\",\"quantidade\":2},{\"id\":7,\"nome\":\"Batata tam.P\",\"quantidade\":1},{\"id\":11,\"nome\":\"Pepsi\",\"quantidade\":2}]', 'Av. Exemplo, 123', 'cartao', '2025-10-27 15:21:19', 'pendente'),
(35, 3, '[{\"id\":1,\"nome\":\"Sunset Burguer\",\"quantidade\":2},{\"id\":7,\"nome\":\"Batata tam.P\",\"quantidade\":1},{\"id\":11,\"nome\":\"Pepsi\",\"quantidade\":2}]', 'Av. Exemplo, 123', 'cartao', '2025-10-27 15:21:19', 'pendente'),
(36, 2, '[{\"id\":1,\"nome\":\"Sunset Burguer\",\"quantidade\":2},{\"id\":7,\"nome\":\"Batata tam.P\",\"quantidade\":1},{\"id\":11,\"nome\":\"Pepsi\",\"quantidade\":2}]', 'Av. Exemplo, 123', 'cartao', '2025-10-27 15:21:19', 'pendente'),
(37, 3, '[{\"id\":1,\"nome\":\"Sunset Burguer\",\"quantidade\":2},{\"id\":7,\"nome\":\"Batata tam.P\",\"quantidade\":1},{\"id\":11,\"nome\":\"Pepsi\",\"quantidade\":2}]', 'Av. Exemplo, 123', 'cartao', '2025-10-27 15:21:19', 'pendente'),
(38, 3, '[{\"id\":1,\"nome\":\"Sunset Burguer\",\"quantidade\":2},{\"id\":7,\"nome\":\"Batata tam.P\",\"quantidade\":1},{\"id\":11,\"nome\":\"Pepsi\",\"quantidade\":2}]', 'Av. Exemplo, 123', 'cartao', '2025-10-27 15:21:19', 'preparando'),
(39, 2, '[{\"id\":1,\"nome\":\"Sunset Burguer\",\"quantidade\":2},{\"id\":7,\"nome\":\"Batata tam.P\",\"quantidade\":1},{\"id\":11,\"nome\":\"Pepsi\",\"quantidade\":2}]', 'Av. Exemplo, 123', 'cartao', '2025-10-27 15:21:23', 'entregue'),
(40, 3, '[{\"id\":1,\"nome\":\"Sunset Burguer\",\"quantidade\":2},{\"id\":7,\"nome\":\"Batata tam.P\",\"quantidade\":1},{\"id\":11,\"nome\":\"Pepsi\",\"quantidade\":2}]', 'Av. Exemplo, 123', 'cartao', '2025-10-27 15:21:23', 'pronto'),
(41, 2, '[{\"id\":1,\"nome\":\"Sunset Burguer\",\"quantidade\":2},{\"id\":7,\"nome\":\"Batata tam.P\",\"quantidade\":1},{\"id\":11,\"nome\":\"Pepsi\",\"quantidade\":2}]', 'Av. Exemplo, 123', 'cartao', '2025-10-27 15:21:23', 'em_entrega'),
(42, 3, '[{\"id\":1,\"nome\":\"Sunset Burguer\",\"quantidade\":2},{\"id\":7,\"nome\":\"Batata tam.P\",\"quantidade\":1},{\"id\":11,\"nome\":\"Pepsi\",\"quantidade\":2}]', 'Av. Exemplo, 123', 'cartao', '2025-10-27 15:21:23', 'pendente'),
(43, 3, '[{\"id\":1,\"nome\":\"Sunset Burguer\",\"quantidade\":2},{\"id\":7,\"nome\":\"Batata tam.P\",\"quantidade\":1},{\"id\":11,\"nome\":\"Pepsi\",\"quantidade\":2}]', 'Av. Exemplo, 123', 'cartao', '2025-10-27 15:21:23', 'pendente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT 0.00,
  `descricao` text DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `categoria`, `img`, `preco`, `descricao`, `criado_em`) VALUES
(1, 'Sunset Burguer', 'lanche', 'Assets/Encomendar e Retirar (Tradicional)/Hamburguer 2 1.png', 28.00, 'Bacon, cheddar, Hamburguer grelhado, Molho Barbecue, P?úo com gergelim', '2025-10-27 15:00:37'),
(2, 'Hamburguer Praiano', 'lanche', 'Assets/Encomendar e Retirar (Tradicional)/Hamburguer 1 1.png', 27.00, 'Alface, cebola, hamburguer grelhado, p?úo com gergelim, picles, tomate', '2025-10-27 15:00:37'),
(3, 'Snack Praia do Sol', 'lanche', 'Assets/Encomendar e Retirar (Tradicional)/Hamburguer 3 1.png', 26.00, 'Alface, bacon, cebola roxa, cheddar, hamburguer grelhado, p?úo com gergilim, tomate', '2025-10-27 15:00:37'),
(4, 'Palmeira Burguer', 'lanche', 'Assets/Encomendar e Retirar (Vegano)/Hamburguer 1 1.png', 28.00, 'Alface, cebola, coentro, molho bechamel vegano, p?úo com gergilim, seitan (hamburguer vegano), tomate', '2025-10-27 15:00:37'),
(5, 'Hamburguer Tropical', 'lanche', 'Assets/Encomendar e Retirar (Vegano)/Hamburguer 2 1.png', 26.00, 'Bacon, cheddar, Hamburguer grelhado, Molho Barbecue, P?úo com gergilim', '2025-10-27 15:00:37'),
(6, 'F?®rias Saudaveis', 'lanche', 'Assets/Encomendar e Retirar (Vegano)/Hamburguer3 1.png', 26.50, 'Alface, cebola, hamburguer grelhado, p?úo com gergilim, picles, tomate', '2025-10-27 15:00:37'),
(7, 'Batata tam.P', 'acompanhamento', 'Assets/Acompanhamentos/Batata P.jpeg', 7.75, NULL, '2025-10-27 15:00:37'),
(8, 'Batata tam.M', 'acompanhamento', 'Assets/Acompanhamentos/Batata M.jpeg', 8.25, NULL, '2025-10-27 15:00:37'),
(9, 'Batata tam.G', 'acompanhamento', 'Assets/Acompanhamentos/Batata G.jpeg', 8.99, NULL, '2025-10-27 15:00:37'),
(10, 'Coca-cola', 'bebida', 'Assets/Bebidas/file (12).png', 5.50, NULL, '2025-10-27 15:00:37'),
(11, 'Pepsi', 'bebida', 'Assets/Bebidas/file (11).png', 5.50, NULL, '2025-10-27 15:00:37'),
(12, 'Guarana', 'bebida', 'Assets/Bebidas/file (13).png', 4.50, NULL, '2025-10-27 15:00:37'),
(13, 'Fanta Laranja', 'bebida', 'Assets/Bebidas/file (14).png', 4.20, NULL, '2025-10-27 15:00:37'),
(14, 'Fanta Uva', 'bebida', 'Assets/Bebidas/file (15).png', 4.00, NULL, '2025-10-27 15:00:37');

-- --------------------------------------------------------

--
-- Estrutura para tabela `registro`
--

CREATE TABLE `registro` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `motoboy_id` int(11) DEFAULT NULL,
  `itens` text NOT NULL,
  `endereco` text NOT NULL,
  `pagamento` varchar(10) NOT NULL,
  `confirmar` tinyint(1) DEFAULT 0,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `motoboy_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `nota` int(11) NOT NULL CHECK (`nota` between 1 and 5),
  `comentario` text DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `rua` varchar(100) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `partner` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `senha`, `cep`, `cidade`, `bairro`, `rua`, `numero`, `profile_picture`, `partner`) VALUES
(2, 'root@localhost', 'root@local', '$2y$10$Rz01Oq.FjOpKzos7bj00PuEYIwlWg2WOSwfujGSe7E53CQzBRym6m', NULL, NULL, NULL, NULL, NULL, 'user_2_1761595064.jpg', 0),
(3, 'teste', 'teste@tetse', '$2y$10$off5KXVWAdHSJXMfD7SNTucO3bSXBwVZ/9aY.24P/S.Z2VirAZieK', NULL, NULL, NULL, NULL, NULL, NULL, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `duvidas`
--
ALTER TABLE `duvidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `motoboys`
--
ALTER TABLE `motoboys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `motoboy_id` (`motoboy_id`);

--
-- Índices de tabela `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `motoboy_id` (`motoboy_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `duvidas`
--
ALTER TABLE `duvidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `motoboys`
--
ALTER TABLE `motoboys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `registro`
--
ALTER TABLE `registro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `duvidas`
--
ALTER TABLE `duvidas`
  ADD CONSTRAINT `duvidas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `registro`
--
ALTER TABLE `registro`
  ADD CONSTRAINT `registro_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `registro_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `registro_ibfk_3` FOREIGN KEY (`motoboy_id`) REFERENCES `motoboys` (`id`);

--
-- Restrições para tabelas `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`motoboy_id`) REFERENCES `motoboys` (`id`),
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
