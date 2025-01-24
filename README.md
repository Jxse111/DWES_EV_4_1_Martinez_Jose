# Sistema de Gestión de Espectáculos

Este proyecto es una aplicación web que gestiona espectáculos y permite a los usuarios con diferentes roles interactuar con ella según sus permisos. Está desarrollado en PHP y utiliza una base de datos MySQL para almacenar la información de usuarios, roles y espectáculos.

## Descripción

El sistema cuenta con tres tipos de usuarios:

- **Administrador**: Tiene permisos para dar de alta nuevos espectáculos.
- **Usuario**: Puede reservar espectáculos disponibles.
- **Invitado**: Solo puede ver los espectáculos disponibles.

### Funcionalidades

- **Autenticación**: Los usuarios deben iniciar sesión para acceder a las páginas protegidas del sistema.
- **Roles y permisos**: Según el rol del usuario, se redirige a la página correspondiente.
- **Páginas protegidas**: Las páginas solo son accesibles si el usuario ha iniciado sesión y tiene los permisos adecuados.
- **Cierre de sesión**: En todas las páginas protegidas hay un enlace para cerrar sesión.

## Instalación

1. Clona este repositorio en tu máquina local:

   ```bash
   git clone https://github.com/tu-usuario/proyecto-espectaculos.git

Si deseas contribuir al proyecto, por favor crea un "fork" del repositorio y haz un "pull request" con tus cambios. Asegúrate de seguir las buenas prácticas de codificación y documentación.
