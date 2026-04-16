# Emisora App (DDD + Hexagonal Architecture)

Plataforma de gestión de emisoras implementando un CRUDL en PHP 8.2 utilizando Diseño Guiado por el Dominio (DDD) y Arquitectura Hexagonal.

## Requisitos

- PHP 8.2+
- MySQL 8.0+
- (Recomendado) Docker y Docker Compose
- Laragon, XAMPP o servidor web de tu preferencia si no usas Docker.

## Configuración y Ejecución

### Opción A: XAMPP / Laragon (Servidor Local)
1. Mover la carpeta del proyecto a `htdocs` (XAMPP) o `www` (Laragon).
2. Iniciar **Apache** y **MySQL** desde el panel de control.
3. Crear una base de datos llamada `emisora_app` e importar el archivo `database/schema.sql`.
4. Acceder vía navegador: `http://localhost/nombre_directorio/public/index.php`
   - *Nota: El sistema detectará automáticamente el subdirectorio y ajustará el ruteo.*

### Opción B: Docker
1. Clonar el repositorio.
2. Levantar los contenedores: `docker-compose up -d`.
3. Acceder en [http://localhost:8080](http://localhost:8080).

## Funcionalidades Incluidas

- **Director Público:** Vista tipo Dark Mode con estética Glassmorphism para que cualquier usuario vea las emisoras.
- **Sistema de Registro/Login:** Los radiodifusores pueden crear su propia cuenta.
- **Panel Administrativo:** CRUD completo para gestionar las emisoras propias.
- **Recuperación de Contraseña:** Flujo simulado (Mock) que registra la petición en logs.

### Credenciales de Prueba
- **Email:** `admin@emisora.com`
- **Password:** `admin123`

## Arquitectura (Hexagonal)
- `src/Domain`: Entidad `Emisora`, Value Objects (`EmisoraId`, `BandaFm`, `BandaAm`) y excepciones.
- `src/Application`: Casos de uso (Create, Read, Update, Delete, List, Login, Register).
- `src/Infrastructure`: Repositorios PDO, Controladores HTTP y Router personalizado.
- `views`: Plantillas de UI divididas en `auth`, `emisora` y `public`.
