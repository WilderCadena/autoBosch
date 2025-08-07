# AutoBosch – Sistema de Cotización Digital

**AutoBosch** es un sistema web desarrollado como parte del proyecto productivo del SENA. Permite a los clientes de un taller automotriz enviar solicitudes de cotización de forma digital, sin necesidad de desplazarse, mejorando la eficiencia del proceso y la atención al cliente.

## Objetivo
Digitalizar y optimizar el proceso de solicitud de cotizaciones en un taller automotriz convencional, brindando a los usuarios una experiencia ágil, accesible y organizada.

## Tecnologías utilizadas
- **Lenguaje servidor:** PHP
- **Base de datos:** MySQL
- **Frontend:** HTML5, CSS3
- **Librerías:** PHPMailer (para envío de correos)
- **Servidor local recomendado:** XAMPP

## Estructura del proyecto
```
AutoBosch/
├── Controlador/
│   ├── cotizacion.php
│   ├── login.php
│   ├── logout.php
│   ├── registro.php
│   └── verificar.login.php
├── Modelo/
│   ├── db.php
│   └── enviar_correo.php
├── Vista/
│   ├── inicio.html
│   ├── estilos.css
│   └── Imagenes/
├── Libs/
│   └── PHPMailer/ (biblioteca para envío de correos)
└── index.html
```

## Cómo ejecutar el proyecto localmente

1. Instala **XAMPP** u otro servidor local.
2. Clona o descarga este proyecto en la carpeta `htdocs`.
3. Importa el archivo `.sql` con la base de datos `autoserviciobosch` en **phpMyAdmin**.
4. Asegúrate de que el archivo `Modelo/db.php` tenga esta configuración:
```php
$host = 'localhost';
$db = 'autoserviciobosch';
$user = 'root';
$pass = '';
```
5. Abre tu navegador y accede a:  
   `http://localhost/AutoBosch/`

## Funcionalidades
- Registro e inicio de sesión de usuarios.
- Envío de solicitudes de cotización con opción de subir imágenes.
- Notificación por correo al cliente y al administrador.
- Diseño responsivo y navegación clara.

## Protección de datos
Este sistema incluye un aviso de protección de datos personales que informa al usuario sobre el uso y tratamiento de la información enviada.

## Video demostrativo
(Adjuntar enlace aquí o mencionar que se incluye en la entrega)

## Autor
**Wilder J. Cadena**  
Técnico en Programación de Software – SENA  
2025
