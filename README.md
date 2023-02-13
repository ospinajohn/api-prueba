# API PRUEBA EN LARAVEL

## Instalación

1. Clonar el repositorio
2. Ejecutar `composer install` para instalar las dependencias de Laravel
3. Ejecutar `php artisan migrate` para crear las tablas en la base de datos, aqui preguntara preguntara si se quiere crear la base de dato si no se ha creado previamente y si se quiere crear las tablas, se debe responder `yes` a ambas preguntas.
4. Ejecutar `php artisan db:seed` para poblar la base de datos con datos de prueba
5. Ejecutar `php artisan serve` para levantar el servidor de desarrollo

### Tener en cuenta

1. Se debe tener instalado composer y php en el equipo con xampp o wampp para poder ejecutar el proyecto.
2. Se debe tener instalado postman u otro cliente para hacer peticiones a la API.


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
Aqui se encuentra la documentación de las rutas de la API en postman donde se muestra la peticion y su respuesta, de igual manera se puede importar el archivo `API.postman_collection.json` para poder probar las rutas. [Documentacion API](https://documenter.getpostman.com/view/16562195/2s935uH1oC)


## Notas

1. Para poder crear un usuario se debe estar logueado como administrador y tener el token de autorización en el header de la petición, pero igualmanera se creo la ruta /register para crear un usuario sin necesidad de estar logueado, pero esta ruta no esta protegida por el middleware de autenticación.

2. Para poder listar los usuarios se debe estar logueado como administrador y tener el token de autorización en el header de la petición.


## Modelo de base de dato

![c0da6dc7-36ea-4539-97c2-8d2fea0400fd](https://user-images.githubusercontent.com/93017179/218377486-d96f9dd7-b682-4d8f-b6a0-9616874be8b5.jpg)




## Autor

- John James Ospina



