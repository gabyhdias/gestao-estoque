# Gestão de Estoque — Mercado

## Objetivo
Este é um projeto simples de CRUD (Create, Read, Update, Delete) desenvolvido em PHP para gerenciar o estoque de produtos de um mercado. O sistema foi projetado para rodar em um ambiente local (localhost) utilizando o XAMPP.

## Tecnologias e Pré-requisitos

* **Servidor e Banco de Dados:** Apache e MySQL (via XAMPP).
* **Back-end:** PHP para lógica de negócio e conexão com o banco de dados.
* **Front-end:** HTML e CSS para a estrutura e estilização da interface.

## Funcionalidades (CRUD)

O sistema implementa as quatro operações básicas de gerenciamento de dados:

* **Create (Cadastrar):** Formulário na página principal (`index.php`) que envia dados via POST para o arquivo `cadastro.php`, inserindo um novo produto no banco.
* **Read (Listar):** A página principal realiza uma consulta SQL (JOIN entre produtos e categorias) e exibe os resultados em uma tabela interativa.
* **Update (Editar):** Acessível pelo link "Editar" na tabela. Redireciona para `editar.php`, que carrega os dados do produto em um formulário. 
* **Delete (Excluir):** Acessível pelo link "Excluir" na tabela. Envia o ID do produto via GET para `deletar.php`, que executa o comando DELETE e remove o registro.