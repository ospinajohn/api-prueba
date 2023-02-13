# API PRUEBA EN LARAVEL

## Instalación

1. Clonar el repositorio
2. Ejecutar `composer install`
3. crear una base de datos en mysql preferiblmente en xaamp por facilidad con nombre `api-prueba`
4. Ejecutar `php artisan migrate` para crear las tablas en la base de datos
5. Ejecutar `php artisan db:seed` para poblar la base de datos con datos de prueba
6. Ejecutar `php artisan serve` para levantar el servidor de desarrollo


## Configuración

1. Crear archivo `.env` a partir del `.env.example`

## Datos de prueba

1. Usuario administrador
    - email: `admin@gmail.com`
    - contraseña: `123456`

2. Usuario cliente
    - email: `prueba@gmail.com`
    - constraseña `123456`

## Endpoints

1. Login
    - POST `/api/login`
    - Body
        - correo
        - password
    - Response
        - token
        - user

2. Logout
    - POST `/api/logout`
    - Headers
        - Authorization: Bearer {token}
    - Response
        - message

3. Listar usuarios
    - GET `/api/users`
    - Headers
        - Authorization: Bearer {token}
    - Response
        - users

4. Crear usuario
    - POST `/api/user/new`
    - Headers
        - Authorization: Bearer {token}
    - Body
        - nombre
        - correo
        - password
        - telefono
    - Response
        - user

## Documentacion de rutas



## Notas

1. Para poder crear un usuario se debe estar logueado como administrador y tener el token de autorización en el header de la petición, pero igualmanera se creo la ruta /register para crear un usuario sin necesidad de estar logueado, pero esta ruta no esta protegida por el middleware de autenticación.

2. Para poder listar los usuarios se debe estar logueado como administrador y tener el token de autorización en el header de la petición.




## Autor

- John James Ospina



