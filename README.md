# 📚 Proyecto Integrador - Quinto Semestre
Proyecto Integrador de **5to semestre** de la carrera de Ingeniería de Software, grupo **1**. Proyecto para una tienda de ropa. 

## Integrantes
WILTHON BAQUE
MICHAEL CASTRO
SAYURI CERNA

## Rutas de usuarios
- /admin
- /account-dashboard

## Materias involucradas
- Aplicaciones distribuidas
- Construcción de software

## Tecnologías utilizadas
Laravel, PHP, HTML, CSS, JavaScript, XAMPP, bootstrap

### 📦 Requisitos Técnicos
- PHP 8.0 o superior
- Composer 2.x
- Node.js 16.x o superior
- MySQL 5.7+ o MariaDB 10.3+
- Servidor web (Apache/Nginx) o PHP built-in server

## PASOS DE INSTALACIÓN
### 1. Base de datos
- Crear base de datos ecommercepi en PhpMyAdmin
- importar el archivo ecommercepi.sql
#### **Usuarios**
- admin@admin.com:ADMINISTRADOR
- user@user.com:usuario1

### 2. Instalación
```bash
git clone https://github.com/sayuricerna/ProyectoIntegradorS5.git 
```
``` bash
cd ProyectoIntegradorS5-main
``` 
``` bash
composer install
``` 
``` bash
npm install
``` 
``` bash
copy .env.example .env
``` 
``` bash
php artisan key:generate
``` 
### 3. Editar archivo **.env**
``` bash
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=ecommercepi
DB_USERNAME=root
DB_PASSWORD=
``` 
``` bash
php artisan migrate
```
``` bash
php artisan storage:link

```
``` bash
npm run dev
```
``` bash
php artisan serve
```


## DEPENDENCIAS
Laravel v12.0	Framework backend,
jQuery	Manipulación DOM,
shoppingcart 2.0,
Laravel UI	Autenticación v4.6,
Intervention Image	Procesamiento de imágenes v1.2,
Fancybox	Galería de productos,
Stripe 17.4,
dompdf v3.1

### Limpiar caché
php artisan optimize:clear

### Ver rutas disponibles
php artisan route:list

### Crear enlace de storage
php artisan storage:link

### Monitorizar cambios en Vite
npm run watch
