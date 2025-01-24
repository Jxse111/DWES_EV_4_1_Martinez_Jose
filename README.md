Sistema de Gestión de Espectáculos
Este proyecto es una aplicación web que gestiona espectáculos y permite a los usuarios con diferentes roles interactuar con ella según sus permisos. Está desarrollado en PHP y utiliza una base de datos MySQL para almacenar la información de usuarios, roles y espectáculos.

Descripción
El sistema cuenta con tres tipos de usuarios:

Administrador: Tiene permisos para dar de alta nuevos espectáculos.
Usuario: Puede reservar espectáculos disponibles.
Invitado: Solo puede ver los espectáculos disponibles.
Funcionalidades:
Autenticación: Los usuarios deben iniciar sesión para poder acceder a las páginas protegidas del sistema.
Roles y permisos: Después de iniciar sesión, se comprobarán los permisos del usuario y se le redirigirá a la página correspondiente según su rol:
Administrador: Redirigido a la página alta_espectaculo.php para dar de alta espectáculos.
Usuario: Redirigido a la página reservar_espectaculo.php para reservar un espectáculo.
Invitado: Redirigido a la página ver_espectaculos.php para visualizar los espectáculos disponibles.
Páginas protegidas: Las páginas sólo serán accesibles si el usuario ha iniciado sesión y tiene los permisos adecuados. Si no, será redirigido a login.php.
Cierre de sesión: En todas las páginas protegidas hay un enlace para cerrar sesión, lo que redirige a cerrar_sesion.php y luego a login.php.
Estructura de la Base de Datos
Tabla roles:
id_rol	tipo
1	administrador
2	usuario
3	invitado
Usuarios de ejemplo:
Se debe crear al menos un usuario para cada rol, por ejemplo:

dwes01 (Administrador)
dwes02 (Usuario)
dwes03 (Invitado)
Los permisos de los usuarios se asignan aleatoriamente a los usuarios ya creados en la base de datos.

Requisitos
PHP 7 o superior.
MySQL o MariaDB.
Servidor web compatible (por ejemplo, Apache).
Un navegador web para probar la aplicación.
Instalación
Clona este repositorio en tu máquina local:

bash
Copiar
git clone https://github.com/tu-usuario/proyecto-espectaculos.git
Configura tu servidor web local (XAMPP, WAMP, LAMP, etc.) y asegúrate de tener PHP y MySQL funcionando.

Crea una base de datos en MySQL y ejecuta el script de creación de tablas. Asegúrate de agregar los registros necesarios en la tabla roles y crear usuarios de prueba como dwes01, dwes02, etc.

Configura el archivo de conexión a la base de datos (conexion.php) con tus credenciales de MySQL.

Accede al proyecto desde tu navegador y ve a login.php para autenticarte.

Archivos principales
login.php: Página de inicio de sesión.
alta_espectaculo.php: Formulario para dar de alta un espectáculo (solo para administradores).
reservar_espectaculo.php: Página para reservar espectáculos (solo para usuarios).
ver_espectaculos.php: Página para visualizar espectáculos (para invitados).
cerrar_sesion.php: Cierra la sesión y redirige a login.php.
Funciones de autenticación y permisos
Los usuarios deben autenticarse para acceder a las páginas protegidas.
El sistema verifica el rol del usuario y lo redirige a la página correspondiente.
Si el usuario no tiene los permisos necesarios, será redirigido a login.php.
Comentarios sobre el manejo de sesiones
En el código se compara el uso de unset() y session_destroy() para finalizar la sesión de un usuario. La principal diferencia es:

unset(): Elimina variables específicas de la sesión. No destruye la sesión completamente.
session_destroy(): Destruye toda la sesión y elimina todos los datos asociados a ella.
Se recomienda usar session_destroy() para garantizar que la sesión se termine correctamente al cerrar sesión.

Contribuciones
Si deseas contribuir al proyecto, por favor crea un "fork" del repositorio y haz un "pull request" con tus cambios. Asegúrate de seguir las buenas prácticas de codificación y documentación.

Licencia
Este proyecto está bajo la licencia MIT. Para más detalles, consulta el archivo LICENSE.
