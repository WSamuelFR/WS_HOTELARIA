CREATE DATABASE hotel;

USE hotel;

CREATE TABLE hospedes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    rg VARCHAR(20) NOT NULL UNIQUE,
    birth_date DATE NOT NULL,
    gender ENUM('masculino', 'feminino', 'outro') NOT NULL,
    ethnicity ENUM('branco', 'negro', 'pardo', 'indigena') NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    birth_country VARCHAR(50) NOT NULL,
    current_country VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    city VARCHAR(50) NOT NULL,
    neighborhood VARCHAR(50) NOT NULL,
    street VARCHAR(50) NOT NULL,
    address VARCHAR(50) NOT NULL,
    cep VARCHAR(14),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE empresa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(100) NOT NULL,
    cnpj VARCHAR(14) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    founding_date DATE NOT NULL,
    sector VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE quarto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    number_room INT NOT NULL UNIQUE,
    room_type ENUM('ar-condicionado', 'ventilador'),
    room_status ENUM('livre', 'ocupado') DEFAULT 'livre',
    clean_status ENUM('limpo', 'sujo') DEFAULT 'limpo',
    bed_quantity ENUM('single', 'duplo', 'triplo', 'quaduplo'),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE hospede_reserva (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hospede VARCHAR(200) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    cnpj VARCHAR(14) NOT NULL,
    quarto_number INT,
    data_checkin DATE NOT NULL,
    data_checkout DATE NOT NULL
);

CREATE TABLE reserva_quarto (
    reserva_id INT AUTO_INCREMENT PRIMARY KEY,
    hospede_titular_cpf VARCHAR(14),
    empresa_titular_cnpj VARCHAR(14),
    hospede_one VARCHAR(14),
    hospede_two VARCHAR(14),
    hospede_three VARCHAR(14),
    hospede_four VARCHAR(14),
    quarto_number INT,
    data_checkin DATE NOT NULL,
    data_checkout DATE NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    observacoes LONGTEXT,
    situacao ENUM('ativa', 'encerrada'),
    usuario_responsavel VARCHAR(100) NOT NULL,
    FOREIGN KEY (hospede_titular_cpf) REFERENCES hospedes(cpf),
	 FOREIGN KEY (empresa_titular_cnpj) REFERENCES empresa(cnpj), 
    FOREIGN KEY (quarto_number) REFERENCES quarto(number_room)
);