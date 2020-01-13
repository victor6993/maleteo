# Esqueleto entorno Webserver, PHP y MySql

Este proyecto sirve de base para disponer de un entorno 
completamente funcional de PHP con el framework Symfony versión 5
y una BBDD MySql.

## Instrucciones 

Teniendo docker y docker-compose instalado en el equipo, una vez clonado 
el repositorio habrá que ejecutar lo siguiente:

```shell script
docker-compose up -d
```

Una vez levantados los 3 contenedores, lanzamos un terminal contra 
el contenedor de PHP:

```shell script
docker-compose exec php bash
```

E instalamos las dependencias del proyecto:

```shell script
composer install
```

Una vez hecho esto, en la URL http://localhost:8000 tendremos nuestra aplicación Symfony
recién instalada.
