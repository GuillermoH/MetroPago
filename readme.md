

## Tesis Bernardo Bello y Guillermo Hellmund

Plataforma web para complementar la plataforma de pago desarrollada 
para la tesis de grado de la Universidad Metropolitana 
titulada **APLICACIÓN DE LA TECNOLOGÍA DE IDENTIFICACIÓN 
POR RADIOFRECUENCIA EN UN SISTEMA DE PAGO. CASO: UNIMET.**

##### Tutor: Christian Guillen 

## Correr proyecto
##### En un terminal 
1. `https://github.com/GuillermoH/MetroPago.git`
2. `composer install`
3. `npm install`
4. Crear una Base de Datos en MySQL
5. Configurar el ambiente en `MetroPago/.env`
   + Copiar `.env.example` a `.env`
   + Generar *key* `php artisan key:generate`
   + Completar configuracion de DB
6. `php artisan migrate`
7. Dependiendo del ambiente
   + Desarrollo: `npm run dev`
   + Producci&oacute;n: `npm run prod`
8. Para correr el proyecto `php artisan serve`
 

