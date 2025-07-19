-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS cadastro_usuarios CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Permissões para o usuário (substitua com suas credenciais)
GRANT ALL PRIVILEGES ON cadastro_usuarios.* TO 'app_user' @'localhost' IDENTIFIED BY 'senha_segura';

FLUSH PRIVILEGES;