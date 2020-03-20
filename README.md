# Metric Starter Theme

Es una base desde la que poder construir un theme basado en Timber y el motor de plantilla Twig. El objetivo principal de este tema es proporcionar una estructura de archivos y clases así como ejemplos para trabajar con timber.

## Instalación del Theme
Descargar el tema y poner en la carpeta wp-content/themes
1. Descargar el zip de theme (o clonarlo) y moverlo a la carpeta `wp-content/themes` de la instalación de wordpress
2. Renombrar la carpeta del theme y cambiar el nombre en el archivo `styles.css` del directorio raíz 
3. Instalar dependencias PHP ejecutar ```composer install```
4. Instalar dependencias GULP (si se quiere utilizar sass, concatenación de archivos y uglify)
5. Activar theme en Apariencia > Themes.

## Características

1. Uso de composer para la instalación de paquetes de terceros y autocarca de clases psr-4
2. Utilidades para el volcado de variables y ficheros log
3. Carga sencilla de archivos css y js
4. Gestión de llamadas Ajax
5. Clase controlador para definir codigo PHP
6. Estructura de carpetas
7. Carga y salvado de campos (Advanced Custom Fields) en archivos JSON
8. Ejemplo de uso

## Estructura de carpetas
`acf-json` archivos json con la definición de los advanced custom fields pluging.
`src` código php.
`static` archivos css, js, sass,imágenes, iconosm svg's.
- `static/assets` imágenes, iconosm svg's.
- `static/build` archivos de salida GULP.
- `static/css` archivos css.
- `static/css/admin` archivos css para el panel de administración (si son necesarios).
- `static/fonts` fuentes letra.
- `static/js` archivos js.
- `static/js/admin` archivos js para el panel de administración (si son necesarios).
- `static/sass` archivos sass.
- `static/vendor` paquetes node.
`templates` archivos twig.

## Other Resources








