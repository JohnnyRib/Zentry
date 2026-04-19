# Zentry

## 1. Nombre del proyecto
Zentry

## 2. Descripción general
Zentry es una aplicación web académica para la gestión de acceso a una plataforma de eventos. Combina interfaces HTML/CSS con un backend PHP/MySQL y ofrece un flujo básico de registro y autenticación.

## 3. Objetivo de la aplicación
El objetivo es permitir que usuarios y promotores accedan a una plataforma de eventos con roles diferenciados, facilitando el manejo de cuentas y la navegación entre páginas de eventos.

## 4. Funcionalidades principales
- Registro de usuarios y promotores.
- Inicio de sesión mediante correo electrónico y contraseña.
- Redirección según rol: Cliente o Promotor.
- Navegación de eventos: búsqueda, listado y detalle.
- Páginas de perfil para cada tipo de usuario.
- Estructura de páginas accesibles con navegación clara.

## 5. Tecnologías utilizadas
- HTML
- CSS
- PHP
- MySQL
- XAMPP (Servidor Apache y base de datos)

## 6. Estructura del proyecto
- `Controler/controler.php` — lógica de registro, login y logout.
- `Model/Zentry.sql` — esquema de base de datos.
- `View/` — frontend de la aplicación:
  - `index.html`
  - `login.html`
  - `registro-usuario.html`
  - `registro-promotor.html`
  - `Index_Cliente.html`
  - `Index_Promotor.html`
  - `buscar-evento.html`
  - `listado-evento.html`
  - `detalle-evento.html`
  - `detalle-evento-tech.html`
  - `perfil-usuario.html`
  - `styles.css`

## 7. Cómo ejecutar el proyecto en XAMPP
1. Copie la carpeta del proyecto dentro de `xampp/htdocs`.
2. Inicie Apache y MySQL desde el panel de XAMPP.
3. En phpMyAdmin, importe el archivo `Model/Zentry.sql` para crear la base de datos y las tablas.
4. Verifique las credenciales de conexión en `Controler/controler.php`.
5. Abra en el navegador la ruta al archivo `View/index.html`.

> Ejemplo: `http://localhost/mywebs/Proyecto%20transversal/Accessible/View/index.html`

## 8. Cómo usar la aplicación
1. Abra `login.html` para iniciar sesión.
2. Si no tiene cuenta, use `registro-usuario.html` o `registro-promotor.html`.
3. Complete los formularios y envíelos al backend.
4. Tras la autenticación, la aplicación redirige según el rol seleccionado.
5. Navegue por las páginas de eventos y perfil desde el menú.

## 9. Casos de uso principales: registro, login y acceso según rol
- Registro: `registro-usuario.html` y `registro-promotor.html` envían los datos a `Controler/controler.php`.
- Login: `login.html` valida el correo, la contraseña y el rol contra la base de datos.
- Acceso según rol: si el rol es `Cliente`, el usuario va a `Index_Cliente.html`; si es `Promotor`, accede a `Index_Promotor.html`.

## 10. Repositorio de GitHub
Repositorio: [URL del repositorio]

## 11. Autores
Autores: [Nombre(s) del autor o del equipo]
