<p align="center"><img src="https://media.licdn.com/dms/image/C4E0BAQFLHdgQYtz5Sw/company-logo_200_200/0/1559930921499?e=1706745600&v=beta&t=lqMt40cOzqkT2a-Aly9mlCM1mP1QzRLZ5Mu-Jj7ZIpc" width="150" alt="WIID Logo"></p>
<h1 align="center"><a href="https://github.com/Work-In-Ideas-WiiD/teste-backend-pleno">Teste Prático Back-end Pleno WiiD</a></h1>
<hr>

## Sumário

Este repositório foi criado em resposta ao teste prático back-end para empresa WIID por Caio
Albuquerque, <a href="https://github.com/mex3890">Github</a>. As introduções e justificativas da aplicação estão
deisponíveis no repositório do <a href="https://github.com/Work-In-Ideas-WiiD/teste-backend-pleno">teste</a>.

- [Tecnologias](#tecnologias).
- [Migrations](#migrations).
- [Factories & Seeders](#factories--seeders).
- [Autenticação](#autenticação).
- [Rotas](#rotas).

<hr>

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

