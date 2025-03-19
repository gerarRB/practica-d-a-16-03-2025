# LARAVEL API TEMPLATE

## Guía de instalación
Como primer paso se debe realizar la copia del archivo **".env.example"** a **".env"** y configurar las variables de entorno que se van a ocupar, como por ejemplo la conexion a la base de datos, la copia del archivo se puede realizar ejecutando el siguiente comando:
````
cp .env.example .env;
````
Ademas se ha establecido un comando para el inicio del proyecto, teniendo en cuenta que se haya realizado el paso anterior, éste permite generar las claves de la aplicación, generar las migraciones, seeders y jwt key.

Este comando solo se debe ejecutar la primera vez que se instale la aplicación.
````
composer init-project;
````
## Convenciones de la plantilla
1. Las tablas de base de datos usan **snake_case** para sus nombres y deben ser creadas basadas en un módulo, es decir [Nombre modulo]_[Nombre de la tabla], *por ejemplo "proyecto_configuraciones", "proyecto_participantes"*.
   
2. Los modelos se construyen a partir del nombre de la tabla usando **CamelCase**.
   
3. Para nombre de controladores se debe establecer en CamelCase y debe tener como subfijo la palabra **"Controller"**.
   
4. Las rutas para la API existen en dos formatos: públicas y protegidas. Las rutas públicas se colocan en **public.php** y las protegidas en **api.php**.
   
5. Las rutas usan el formato **kebab-case**, solo si es necesario, de otro modo, se debe mantener lo más posible la convención de uso REST, es decir, las rutas en lo posible no deben contener verbos y las acciones deben ser bien establecidas dados los métodos REST (POST, GET, PUT, DELETE).
   
6. Los recursos a usar de manera estática (como imágenes) se deben agregar a la carpeta **public/** y según el tipo en **/documents** o **/images**

## Comandos útiles

````
# Generar un nuevo modelo
php artisan make:model User

# Generar un nuevo controlador
php artisan make:controller UserController

# Ver toda la información de un modelo
php artisan model:show User
````

## Documentación con Swagger
El uso de Swagger para documentar los endpoints es de suma importancia, no solo mejora la comprensión y accesibilidad de una API, sino que también simplifica el proceso de desarrollo y colaboración entre equipos.
Para poder documentar los endpoints se seguirá el siguiente estandar: 
1. La documentación será agrupada por controlador, es decir todos los endpoints de un controlador deben ser documentados en el mismo archivo.
2. El archivo a crear debe estar ubicado dentro de la carpeta app/Swagger.
3. El nombre de los archivos será el mismo nombre del controlador con el único cambio de que se reemplazará la palabra 'Controller' por la palabra 'Doc'.
Por ejemplo, si el controllador tiene el nombre de 'PermisoController.php' su archivo de swagger deberá ser llamado: 'PermisoDoc.php'.

El comando para generar la documentación es el siguiente:  php artisan l5-swagger:generate
Para ver la documentación debes dirigirte a la siguiente ruta: http://${tu-dominio}/api/documentation
# plantilla-uls
