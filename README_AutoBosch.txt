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
- **Validaciones:** JS y PHP para inputs (correo, teléfono, nombre/apellido)

## Estructura del proyecto
\`\`\`
AutoBosch/
├── Controlador/
│   ├── cotizacion.php          # Formulario y envío de cotización
│   ├── login.php               # Inicio de sesión
│   ├── logout.php              # Cierre de sesión
│   ├── registro.php            # Registro de usuarios
│   ├── verificar.login.php     # Validación de login
│   ├── recuperar.php           # Formulario de recuperación de contraseña
│   └── enviar_recuperar.php    # Envío de correo de recuperación
├── Modelo/
│   ├── db.php                  # Conexión a la base de datos
│   └── enviar_correo.php       # Funciones para envío de correo
├── Vista/
│   ├── inicio.html             # Página principal
│   ├── estilos.css             # Estilos globales
│   └── Imagenes/               # Carpeta de imágenes
├── Libs/
│   └── PHPMailer/              # Biblioteca PHPMailer
└── index.html                  # Redirección a inicio.html
\`\`\`

## Cómo ejecutar el proyecto localmente

1. Instala **XAMPP** u otro servidor local.
2. Clona o descarga este proyecto en la carpeta `htdocs`.
3. Importa el archivo `.sql` con la base de datos `autoserviciobosch` en **phpMyAdmin**.
4. Asegúrate de que el archivo `Modelo/db.php` tenga esta configuración:
\`\`\`php
$host = 'localhost';
$db = 'autoserviciobosch';
$user = 'root';
$pass = '';
\`\`\`
5. Abre tu navegador y accede a:  
   `http://localhost/AutoBosch/`

## Funcionalidades implementadas
- Registro e inicio de sesión de usuarios.
- Validación de formularios:  
  - Nombres y apellidos solo permiten letras.  
  - Correo debe ser válido y contener "@".  
  - Teléfono solo permite números positivos.
- Envío de solicitudes de cotización con opción de subir imágenes.
- Envío automático de correo al cliente y al administrador cuando se realiza una cotización.
- Recuperación de contraseña vía correo con token seguro.
- Redirección a página de inicio tras enviar cotización.
- Botón “Inicio” disponible tras enviar la cotización para regresar a la página principal.
- Diseño responsivo y navegación clara.
- Protección de datos personales y aviso de privacidad.

## Uso recomendado
1. Registrar usuario desde la página de registro.
2. Iniciar sesión con usuario registrado.
3. Enviar cotización desde la página correspondiente.
4. Si olvida la contraseña, usar la opción de recuperación para recibir un enlace en el correo.
5. Después de enviar la cotización, usar el botón “Inicio” para volver a la página principal.

## Protección de datos
Este sistema incluye un aviso de protección de datos personales que informa al usuario sobre el uso y tratamiento de la información enviada.

## Video demostrativo
(Adjuntar enlace aquí o mencionar que se incluye en la entrega)

## Autor
**Wilder J. Cadena**  
Técnico en Programación de Software – SENA  
2025
EOF

git add README.md
git commit -m "Actualizar README con funcionalidades implementadas"
git push origin main
