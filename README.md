# Tião Carreiro e Pardinho - Top Músicas

Este é um projeto web que exibe uma lista de músicas da dupla Tião Carreiro e Pardinho, permitindo que usuários sugiram novas músicas através de links do YouTube. O projeto conta com uma área administrativa para aprovação e gerenciamento das sugestões.

A aplicação foi desenvolvida com **Laravel 11** no backend e **React** no frontend, utilizando **Inertia.js** para a integração.

## Funcionalidades

- **Página Principal:** Exibe o Top 5 de músicas mais populares e uma lista secundária paginada com as demais.
- **Sugestão de Músicas:** Formulário para qualquer usuário enviar um link de um vídeo do YouTube como sugestão.
- **Autenticação:** Sistema de login e registro de usuários com Laravel Breeze.
- **Painel Administrativo:** Área restrita para usuários autenticados onde é possível visualizar, aprovar ou remover as sugestões de músicas.

## Tecnologias Utilizadas

- **Backend:** PHP 8.2+, Laravel 11
- **Frontend:** React, Tailwind CSS
- **Banco de Dados:** MySQL (ou outro de sua preferência compatível com Laravel)
- **Ferramentas:** Composer, Node.js, npm

## Como Executar o Projeto Localmente

Siga os passos abaixo para configurar e executar a aplicação em seu ambiente de desenvolvimento.

### Pré-requisitos

- PHP >= 8.2
- Composer
- Node.js e npm
- Um servidor de banco de dados (ex: MySQL, MariaDB)

### 1. Clonar o Repositório

```bash
git clone https://github.com/seu-usuario/tiao-videos.git
cd tiao-videos
```

### 2. Instalar Dependências

Instale as dependências do PHP com o Composer e do JavaScript com o npm.

```bash
composer install
npm install
```

### 3. Configurar o Ambiente

Copie o arquivo de exemplo `.env.example` para `.env`.

```bash
cp .env.example .env
```

Abra o arquivo `.env` e configure as variáveis do banco de dados (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, etc.).

### 4. Gerar a Chave da Aplicação

```bash
php artisan key:generate
```

### 5. Executar as Migrations

Crie as tabelas no banco de dados executando as migrations do Laravel.

```bash
php artisan migrate
```

### 6. Popular o Banco de Dados (Opcional)

Para ter alguns dados iniciais, você pode criar um *Seeder* para popular a tabela de músicas.

```bash
# Crie o Seeder
php artisan make:seeder MusicaSeeder

# Execute o Seeder (após adicionar a lógica a ele)
php artisan db:seed --class=MusicaSeeder
```

### 7. Iniciar os Servidores

Você precisa iniciar o servidor de desenvolvimento do Laravel e o compilador de assets do Vite (para o React).

**Terminal 1: Servidor PHP**
```bash
php artisan serve
```

**Terminal 2: Compilador Vite**
```bash
npm run dev
```

Agora, a aplicação estará acessível em `http://127.0.0.1:8000`. Você pode se registrar como um novo usuário para acessar o dashboard e gerenciar as sugestões.
