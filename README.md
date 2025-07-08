# 📚 Proyecto Integrador - Quinto Semestre
Proyecto Integrador de **5to semestre** de la carrera de Ingeniería de Software, grupo **1**. Proyecto para una tienda de ropa. 

## Rutas de usuarios

#### /admin
#### /account-dashboard

## Comandos

#### php artisan serve
#### npm run dev 
#### php artisan migrate:refresh    **actualizar cambios en DB**
#### php artisan make:model Brand -m


## Materias involucradas

- Aplicaciones distribuidas
- Construcción de software

## Tecnologías utilizadas

Laravel, PHP, HTML, CSS, JavaScript, XAMPP, bootstrap


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
