#CRUD Generator

[![Support via Gittip](https://rawgithub.com/twolfson/gittip-badge/0.2.0/dist/gittip.png)](https://www.gittip.com/jerson/)


Genera CRUD's simples en base a plantillas que tu mismo puedes crear, los CRUD's se generan usando la información de las tablas: nombres, tipos de dato,
referencias e indices.

> Actualmente solo existe una plantilla que genera un proyecto "**JSP Simple**"
> que genera paquetes Model, DAO's, Servelts y Formularios para todas las tablas

![consola](https://github.com/jerson/crud-generator/raw/master/doc/images/console.gif "Generando el CRUD")

El archivo de configuración que necesitas para generar el crud es **config.yml**

```YAML
database:
    driver: mysql
    host: 127.0.0.1
    port: 3306
    name: base_de_datos
    user: usuario
    password: clave

project:
    name: 'Titulo del Proyecto'

output:
    dir: 'directorio/salida

```

Despúes de generar el proyecto puedes usar algún IDE como netbeans para que veas tu proyecto.

> Debes agregar las librerías necesarias, por ejemplo "**JSP Simple**" necesita JSTL y MySQL Driver

![consola](https://github.com/jerson/crud-generator/raw/master/doc/images/netbeans.gif "Abriendo el Proyecto")

##Campos Especiales

Los campos especiales permiten aumentar las opciones al generar el código, los campos especiales que existen son:

- **EMAIL**: *Disponile en:* JSPSimple
- **PASSWORD**:: *Disponile en:* JSPSimple
- **CELLPHONE**
- **PHONE**: *Disponile en:* JSPSimple
- **WEEK**: *Disponile en:* JSPSimple
- **URL**: *Disponile en:* JSPSimple
- **MONTH**: *Disponile en:* JSPSimple
- **RANGE**
- **HTML**
- **MARKDOWN**
- **OPTIONS**: *Disponile en:* JSPSimple
- **FILE**
- **IMAGE**

Para agregar campos especiales debes definirlo en un comentario de la columna donde desees

![special-types](https://github.com/jerson/crud-generator/raw/master/doc/images/special-types.gif "Special Types")

> Las posibilidades de los campos especiales son muchas, como por ejemplo validar que una columna sea un email, un texto HTML, MARKDOWN o incluso agregar un subidor de imagenes.

##Limitaciones

- Para que funcione correctamente las tablas deben tener una clave primaria, no necesariamente auto-incrementable pero es recomendable para mas facilidad.


##Visión

Mi Meta es que se creen muchas plantillas "**Bundles**" para distintos lenguajes de programación, actualmente las plantillas disponibles son:

- JSPSimple

Los Gestores de Bases de Datos soportados son:

- MariaDB
- MySQL

Y puedes ejecutar la aplicación con:

- PHP 5.4 o Superior
- HHVM


> Sí, a las plantillas les llamo **Bundles**

##Creditos

Gerson Alexander Pardo Gamez, Estudiante de Ingeniería de Software.
