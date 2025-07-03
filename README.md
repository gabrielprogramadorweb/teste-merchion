## FlowTask
### Laravel 12 • Vue.js 3.5 • Bootstrap 5.3
FlowTask é uma plataforma para gerenciamento de tarefas com comentários, controle de status e um chat com agente de IA integrado para tirar dúvidas sobre a própria aplicação.

✅ Funcionalidades principais
✅ Criação de tarefas com:

Título

Descrição

Status: Pendente, Em progresso, Completa

💬 Possibilidade de comentar tarefas (ex: feedback, instruções, histórico)

🤖 Chat com agente de IA no canto inferior direito, treinado para responder perguntas sobre a plataforma FlowTask

### Instalação do projeto

#### . Clone projeto  
```
git clone git@github.com:gabrielprogramadorweb/teste-merchion.git
```

#### . Navegar pasta sistema  
```
cd teste-merchion/sistema

```

#### . Criar .env
```
cp .env.example .env
```  

#### . Subir container
```
docker-compose up -d --build
```

#### . Composer

```
docker compose exec php bash
```
###
```
composer install
```

#### . Gerar key da aplicação
```
php artisan key:generate
```

#### . No diretório sistema, instale o npm, indicado usar o terminal do phpstorm ou vscode
```
npm install
```
##
#### ⚙️ Scripts Úteis (Executar via npm run)
Estes scripts foram definidos no package.json para facilitar a execução de comandos frequentes no ambiente Docker + Laravel:

✅ 1. Resetar o banco e rodar seeders
```
npm run fresh-seed
```
Executa php artisan migrate:fresh --seed, ou seja:

Apaga todas as tabelas,

Recria as migrations,

Popula o banco com os seeders.

Atenção: Esse comando apaga todos os dados da base!

✅ 2. Reiniciar containers do Docker

```
npm run dc
```
Para quando quiser derrubar e subir todos os containers do Docker novamente (por exemplo, após mudar algo no docker-compose.yml ou .env).

✅ 3. Acessar o container PHP
```
npm run php
```
Abre um terminal dentro do container php, onde você pode executar comandos Artisan, Composer, etc.

##
#### . Instalar npm no frontend Vue.js no diretório /sistema/frontend
```
cd frontend
npm install
```

#### . Versão Node.js v18
```
nvm use 18
nvm alias default 18
```
#### . Node -version
```
node -v
```
#### . Subir frontend Vue.js no diretório /sistema/frontend
```
npm run dev
```

Após isso, acesse a rota [http://localhost:5173/](http://localhost:5173/)
##
#### . Para acessar o container do MySQL com phpMyAdmin
[http://localhost:8888/](http://localhost:8888/)
#### Credencias
```
Usuário: user
Senha: password
```
ou
```
Usuário: root
Senha: password
```
Base do projeto: FlowTask
###
#### . 🧩 Uso de .vue e .ts na mesma pasta
Cada view (ex: LoginView.vue) possui um arquivo .ts correspondente (useLogin.ts) na mesma pasta. Essa abordagem:

Organiza a lógica e visual por funcionalidade (feature-based);

Separa a lógica (use*.ts) do template, facilitando leitura e manutenção;

Permite reutilizar código e testar com mais facilidade;

Escala bem para projetos maiores, mantendo o código modular.

Exemplo: pages/Auth/LoginView.vue usa pages/Auth/useLogin.ts para lidar com o formulário e requisição.
##
#### . Caso deseje testar as rotas da API, acesse o diretório collection e importe o arquivo teste-merchion.json no Postman ou Insomnia.

Autenticação e Testes de Rotas Protegidas
As rotas da API que manipulam tarefas, comentários e perfil de usuário estão protegidas pelo middleware auth:sanctum. Isso significa que o usuário precisa estar autenticado para acessá-las.

Como testar rotas protegidas:
Faça login via rota:
```
POST /api/register
```
O corpo da requisição deve conter o email e password.

Você receberá um token no formato JWT. Exemplo:

```json
{
  "token": "25|GGULwOJMrYQw9Fqoegd3pkSRkF7twxrsm5tsFHHPd17cafb9",
  "user": {
    "name": "Teste",
    "email": "teste@flowtask.com",
    "updated_at": "2025-06-30T05:41:38.000000Z",
    "created_at": "2025-06-30T05:41:38.000000Z",
    "id": 4
  }
}
```

Nas requisições subsequentes às rotas protegidas, adicione o token no cabeçalho de autenticação:

Authorization: Bearer SEU_TOKEN
Agora você pode acessar rotas como:

#### Tarefas
```
GET    /api/tasks
POST   /api/tasks
PUT    /api/tasks/{id}
DELETE /api/tasks/{id}
GET    /api/comentarios/task/{id}
```
#### Comentários
```
GET  /api/comentarios
POST /api/comentarios
```
#### Perfil
```
GET    /api/user
POST   /api/perfil/editar
DELETE /api/perfil/deletar
```



