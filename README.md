# 📚 Proyecto Integrador - Quinto Semestre
Proyecto Integrador de **5to semestre** de la carrera de Ingeniería de Software, grupo **1**. Proyecto para una tienda de ropa. 

## Rutas de usuarios

#### /admin
#### /account-dashboard

## Comandos

#### php artisan serve
#### npm run dev 

## Materias involucradas

- Aplicaciones distribuidas
- Construcción de software

## Tecnologías utilizadas

Laravel, PHP, HTML, CSS, JavaScript, XAMPP, bootstrap


## INSTALACIÓN
## 📦 Requisitos Técnicos
- PHP 8.0 o superior
- Composer 2.x
- Node.js 16.x o superior
- MySQL 5.7+ o MariaDB 10.3+
- Servidor web (Apache/Nginx) o PHP built-in server

### 1. Clonar repositorio
```bash
git clone https://github.com/sayuricerna/ProyectoIntegradorS5.git
cd ProyectoIntegradorS5-main
composer install
npm install
copy .env.example .env
php artisan key:generate

Editar el archivo .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=swinroom_db
DB_USERNAME=root
DB_PASSWORD=pw
php artisan migrate
php artisan storage:link
npm run dev
php artisan serve

```

## DEPENDECIAS

Laravel 10	Framework backend
Bootstrap 5	Framework CSS
jQuery	Manipulación DOM
Laravel UI	Autenticación
Intervention Image	Procesamiento de imágenes
Fancybox	Galería de productos

### Limpiar caché
php artisan optimize:clear

### Ver rutas disponibles
php artisan route:list

### Crear enlace de storage
php artisan storage:link

### Monitorizar cambios en Vite
npm run watch

Descarga del .zip o Git clone
cd projectpath
composer install
npm install
copy .env.example .env
php artisan key:generate
.env> 
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nombreDeBaseDeDatos
DB_USERNAME=root
DB_PASSWORD=
php artisan migrate
<!-- php artisan db:seed -->
php artisan storage:link
npm run dev
php artisan serve



<!-- Modelo: -->
<!-- 
app
    Http
        Controllers
            Auth
                ConfirmPasswordController.php
                ForgorPasswordController.php
                LoginController.php
                RegisterController.php
                ResetPasswordController.php
                VerificationController.php
            AdminController.php
            Controller.php
            HomeController.php
            UserController.php
        Middleware
            AuthAdmin.php
    Models
        Brand.php
        Category.php
        User.php
    Providers
        AppServiceProvider.php
bootstrap
    cache
        .gitignore
        packages.php
        services.php
    app.php
    providers.php
config
    app.php
    auth.php
    cache.php
    database.php
    filesystems.php
    logging.php
    mail.php
    queue.php
    services.php
    session.php
database
    factories
        UserFactory.php
    migrations
        users_table.php
        cache_table.php
        jobs_cache.php
        brands_table.php
        categories_table.php
    seeders
        DatabaseSeeder.php
    .gitignore
    database.sqlite
node_modules
public
    assets
        css
            plugins
                swiper.min.css
            custom.css
            style.css
        fonts
            SofiaProBold.woff
        images
            about
                about-1.jpg
            home
                ...
            products
                ...
            shop
                ...
        js
    build
    css
    font
    icon
    images
    js
    uploads
        categories
        uploads
    hot
    index.php
resources
    css
    js
    sass
    views
        admin
            brand-add.blade.php
            brand-edit.blade.php
            brands.blade.php
            categories.blade.php
            category-add.blade.php
            category-edit.blade.php
            index.blade.php
        auth
            passwords
            login.blade.php
            register.blade.php
            verify.blade.php
        layouts
            admin.blade.php
            app.blade.php
        user
            account-nav.blade.php
            index.blade.php
        contact.blade.php
        home.blade.php
        index.blade.php
routes
    console.php
    web.php
storage
tests
vender
.editorconfig
.emv
.env.example
.gitattributes
.gitignore
artisan
composer.json
composer.lock
package-lock.json
package.json
 -->
