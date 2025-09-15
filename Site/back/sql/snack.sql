CREATE DATABASE IF NOT EXISTS snack;
USE snack;

-- Usuários
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL,
    partner BOOLEAN DEFAULT FALSE
);

-- Motoboys
CREATE TABLE motoboys (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL,
    vehicle_type VARCHAR(50) NOT NULL,
    license_plate VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Administradores
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Pedidos
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    itens TEXT NOT NULL,
    endereco TEXT NOT NULL,
    pagamento VARCHAR(50) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES users(id)
);

-- Registro de entregas
CREATE TABLE registro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    cliente_id INT NOT NULL,
    motoboy_id INT,
    itens TEXT NOT NULL,
    endereco TEXT NOT NULL,
    pagamento VARCHAR(50) NOT NULL,
    confirmar BOOLEAN DEFAULT FALSE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (cliente_id) REFERENCES users(id),
    FOREIGN KEY (motoboy_id) REFERENCES motoboys(id)
);

-- Avaliações
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT,
    motoboy_id INT,
    usuario_id INT NOT NULL,
    nota INT NOT NULL CHECK (nota BETWEEN 1 AND 5),
    comentario TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (motoboy_id) REFERENCES motoboys(id),
    FOREIGN KEY (usuario_id) REFERENCES users(id)
);