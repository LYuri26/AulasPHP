-- Dados iniciais para teste
USE cadastro_usuarios;

INSERT INTO
    usuarios (nome, email, telefone)
VALUES
    (
        'João Silva',
        'joao@example.com',
        '(11) 9999-8888'
    ),
    (
        'Maria Santos',
        'maria@example.com',
        '(21) 9876-5432'
    ),
    (
        'Carlos Oliveira',
        'carlos@example.com',
        '(31) 9123-4567'
    );

-- Consulta para verificar os dados
SELECT
    *
FROM
    usuarios;