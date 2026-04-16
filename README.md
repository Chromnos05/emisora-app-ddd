# 📻 RadioStream: Gestión de Emisoras (DDD + Hexagonal)

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![Architecture](https://img.shields.io/badge/Architecture-Hexagonal-orange.svg)](https://en.wikipedia.org/wiki/Hexagonal_architecture_(software))
[![Design](https://img.shields.io/badge/Design-DDD-green.svg)](https://en.wikipedia.org/wiki/Domain-driven_design)

**RadioStream** es una plataforma premium de gestión de emisoras radiofónicas diseñada con principios de **Arquitectura Hexagonal** y **Diseño Guiado por el Dominio (DDD)**. Ofrece una experiencia inmersiva tanto para usuarios finales como para administradores.

---

## ✨ Características Principales

### 🌐 Interfaz Pública (Oyentes)
- **Diseño Ultra-Moderno:** Estética *Glassmorphism* sobre un modo oscuro profundo, utilizando tipografía `Outfit` para una sensación premium.
- **Catálogo Dinámico:** Exploración de emisoras disponibles con detalles técnicos (frecuencias FM/AM, géneros, locutores).
- **Agnóstica a la Ubicación:** El sistema detecta automáticamente su ruta de instalación, garantizando que todos los enlaces funcionen perfectamente en cualquier servidor.

### 🔐 Zona de Radiodifusores (Admin)
- **Sistema de Autenticación:** Registro seguro de nuevos administradores y login protegido.
- **CRUDL Educativo:** Gestión completa de emisoras con validaciones estrictas de dominio.
- **Seguridad en Rutas:** Protección mediante middleware para evitar accesos no autorizados al panel.

---

## 🏗️ Arquitectura del Sistema

El proyecto sigue una separación de responsabilidades estricta para garantizar un código mantenible y testeable:

```plaintext
src/
├── Domain/         # Lógica pura de negocio (Entidades, Value Objects, Excepciones)
├── Application/    # Casos de uso (Orquestación de las acciones del sistema)
├── Infrastructure/ # Implementaciones técnicas (Adaptadores, PDO, Controllers, Router)
views/              # Capa de presentación (HTML Semántico + Tailwind CSS)
public/             # Único punto de entrada (index.php, .htaccess)
```

---

## 🚀 Instalación y Configuración

### 🛠️ Requisitos
- **PHP 8.2 o superior** (extensión PDO habilitada).
- **MySQL 8.0+**.
- Servidor local como **XAMPP**, **Laragon** o **Docker**.

### 💻 Paso a Paso (Servidor Local)
1. **Clonar e Importar:**
   - Clona este repositorio en tu carpeta de servidor local (`htdocs` o `www`).
   - Crea una base de datos llamada `emisora_app`.
   - Importa el archivo `database/schema.sql`.

2. **Acceso:**
   - Abre tu navegador en: `http://localhost/nombre_del_proyecto/public/`
   - El sistema configurará automáticamente las rutas relativas.

---

## 🔑 Credenciales de Prueba (Demo)

Para explorar el panel de administración de inmediato, puedes usar:

- **Usuario:** `admin@emisora.com`
- **Contraseña:** `admin123`

---

## 🛠️ Tecnologías Utilizadas
- **Lenguaje:** PHP 8.2 (Tipado fuerte y características modernas).
- **Estilos:** Tailwind CSS (UI Premium y responsiva).
- **Persistencia:** MariaDB/MySQL a través de PDO.
- **Ruteo:** Enrutador personalizado nativo con soporte para subdirectorios.

---

## 📂 Próximos Pasos (Hoja de Ruta)
- [ ] Implementación de un Contenedor de Inyección de Dependencias.
- [ ] Integración de servicio real de envío de correos (PHPMailer/Mailtrap).
- [ ] Implementación de pruebas unitarias para el Dominio.
- [ ] Perfiles de usuario personalizados para oyentes favoritos.

---
*Desarrollado como proyecto de estructura de software con enfoque en alta calidad de código y diseño moderno.*
