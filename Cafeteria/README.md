# Code Brew Café - Sistema de Pedidos

## Instalação

1. Clone este repositório
2. Importe o banco de dados executando o script `db/Script.sql`
3. Configure as credenciais do banco em `db/Conexao.php`
4. Coloque as imagens das bebidas na pasta `static/img/` com os nomes correspondentes

## Estrutura de Arquivos

- `index.html` - Página principal com cardápio
- `RegistrarPedido.php` - Processa os pedidos
- `VisualizarPedidos.php` - Mostra todos os pedidos
- `static/` - Contém CSS, JS e imagens
- `db/` - Arquivos de configuração do banco de dados

## Como Usar

1. Acesse `index.html` para ver o cardápio
2. Selecione os itens e informe seu nome
3. Clique em "Enviar Pedido"
4. Veja os pedidos em `VisualizarPedidos.php`