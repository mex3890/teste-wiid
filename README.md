<p align="center"><img src="https://media.licdn.com/dms/image/C4E0BAQFLHdgQYtz5Sw/company-logo_200_200/0/1559930921499?e=1706745600&v=beta&t=lqMt40cOzqkT2a-Aly9mlCM1mP1QzRLZ5Mu-Jj7ZIpc" width="150" alt="WIID Logo"></p>
<h1 align="center"><a href="https://github.com/Work-In-Ideas-WiiD/teste-backend-pleno">Teste Prático Back-end Pleno WiiD</a></h1>
<hr>

## Sumário

Este repositório foi criado em resposta ao teste prático back-end para empresa WIID por Caio
Albuquerque, <a href="https://github.com/mex3890">Github</a>. As introduções e justificativas da aplicação estão
deisponíveis no repositório do <a href="https://github.com/Work-In-Ideas-WiiD/teste-backend-pleno">teste</a>.

- [Postman](#Postman)
- [Tecnologias](#tecnologias).
- [Migrations](#migrations).
- [Factories & Seeders](#factories--seeders).
- [Rotas](#rotas).

<hr>

## Postman

Para realizar testes basta importar a pasta gerada pelo Postman que estão na raiz do projeto, as instruções de
utilização da API estão descritas na própria collection do Postman. Para utilizar corretamente basta carregar o environment
do Postman e seguir as instruções descritas na collection.

## Tecnologias

Para realização do teste foram utilizadas as seguintes tecnologias:

- Como linguagem back-end: `PHP`,
- Como framework: `Laravel`,
- Como sistema gerenciador de banco de dados: `MySQL`,
- Para versionamento da aplicação: `Git`, `Github` e `Gitflow`,
- Para edição da aplicação: `PhpStorm`,
- Para criar um ambiente local: `Laragon`,
- Para testes e consultas na API: `Postman`

## Migrations

Migrações para criação das tabelas de:

- Usuários (2014_10_12_000000_create_users_table.php)
- Tokens de reset de senha - (2014_10_12_100000_create_password_reset_tokens_table.php)
- Tokens pessoais de acesso - (2019_12_14_000001_create_personal_access_tokens_table.php)
- Pagadores (2023_10_30_222119_create_payers_table.php)
- Boletos (2023_10_30_222132_create_barcodes_table.php)

## Factories & Seeders

Para alterar os valores referentes aos dados do primeiro Usuário que será criado e o número de Usuários, Pagadores e
Boletos que serão gerados pelo Seeder, altere as chaves `admin` e `seeder` na config `database`

Factories:

- Usuários - UserFactory.php
- Pagadores - PayerFactory.php
- Boletos - BarcodeFactory.php

## Rotas

- Autenticação e dados pessoais

| Método | Rota          | Precisa de Autenticação | Parâmetros URI |
|--------|---------------|-------------------------|----------------|
| POST   | /api/login    | false                   | null           |
| POST   | /api/register | false                   | null           |
| GET    | /api/logout   | true                    | null           |
| GET    | /api/me       | true                    | null           |

- Boletos

| Método | Rota                              | Precisa de Autenticação | Parâmetros URI |
|--------|-----------------------------------|-------------------------|----------------|
| POST   | `/api/boleto/create`              | true                    | null           |
| PUT    | `/api/boleto/update/$boleto_id`   | true                    | null           |
| DEL    | `/api/boleto/delete/$boleto_id`   | true                    | null           |
| GET    | `/api/boleto/me`                  | true                    | order_by       |
| GET    | `/api/boleto/pagador/$pagador_id` | true                    | order_by       |

- Pagadores

| Método | Rota                              | Precisa de Autenticação | Parâmetros URI |
|--------|-----------------------------------|-------------------------|----------------|
| POST   | `/api/pagador/create`             | true                    | null           |
| PUT    | `/api/pagador/update/$pagador_id` | true                    | null           |
| DEL    | `/api/pagador/delete/$pagador_id` | true                    | null           |
| GET    | `/api/pagador/me`                 | true                    | order_by       |
