# FlowTask
### Laravel 12, Vue.js 3.5, Bootstrap 5.3

#### . Clone projeto  
```
git clone git@github.com:gabrielprogramadorweb/teste-merchion.git
```

#### . Navegar pasta sistema  
```
cd sistema
```

#### . Criar .env
```
cp .env.example .env
```  

#### . Subir container
```
docker-compose up -d --build
```

#### Composer

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

#### . Subir frontend Vue.js no diretório /sistema/frontend
```
npm install
npm run dev
```


#### . Versão Node.js v18
```
nvm use 18
nvm alias default 18
```
#### Node -version
```
node -v
```

#### .env:
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:HKKDGYubRU2L61oVLJUdoHOBI80nSFgOHtHMsQAKWes=
APP_DEBUG=true
APP_URL=http://localhost:8080

GROQ_API_KEY=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

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=setup-mysql
DB_PORT=3306
DB_DATABASE=flowtask
DB_USERNAME=root
DB_PASSWORD=password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=setup-redis
REDIS_PASSWORD=null
REDIS_PORT=6379

SESSION_DOMAIN=localhost
SANCTUM_STATEFUL_DOMAINS=localhost:5173

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

```

#### . 🧩 Uso de .vue e .ts na mesma pasta
Cada view (ex: LoginView.vue) possui um arquivo .ts correspondente (useLogin.ts) na mesma pasta. Essa abordagem:

Organiza a lógica e visual por funcionalidade (feature-based);

Separa a lógica (use*.ts) do template, facilitando leitura e manutenção;

Permite reutilizar código e testar com mais facilidade;

Escala bem para projetos maiores, mantendo o código modular.

Exemplo: pages/Auth/LoginView.vue usa pages/Auth/useLogin.ts para lidar com o formulário e requisição.


