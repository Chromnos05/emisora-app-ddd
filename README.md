# Emisora App (DDD + Hexagonal Architecture)

Plataforma de gestión de emisoras implementando un CRUDL en PHP 8.2 utilizando Diseño Guiado por el Dominio (DDD) y Arquitectura Hexagonal.

## Requisitos

- PHP 8.2+
- MySQL 8.0+
- (Recomendado) Docker y Docker Compose
- Laragon, XAMPP o servidor web de tu preferencia si no usas Docker.

## Configuración con Docker

1. Clona el repositorio.
2. Levanta los contenedores en la terminal:
```bash
docker-compose up -d
```
3. Accede a la aplicación en [http://localhost:8080](http://localhost:8080).
4. El esquema de base de datos se crea e inicializa automáticamente con un administrador:
- **Email:** admin@emisora.com
- **Password:** admin123

## Módulos y Capas (Guía de Aprendizaje)

1. **Domain:** Entidad `Emisora`, Excepciones de negocio y Value Objects.
2. **Application:** Casos de uso (Create, Read, Update, Delete, List) y mock de Forgot Password.
3. **Infrastructure:** Repositorios PDO y Controladores.
4. **Web/UI:** Enrutador y vistas base (HTML/PHP).
