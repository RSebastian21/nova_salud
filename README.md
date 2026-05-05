# Nova Salud - Sistema de Gestión Farmacéutica

[![PHP](https://img.shields.io/badge/PHP-8.0+-blue.svg)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange.svg)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.0+-purple.svg)](https://getbootstrap.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

**Nova Salud** es una solución integral de software para la gestión operativa de farmacias, desarrollada bajo arquitectura MVC con tecnologías modernas. Ofrece un control completo del inventario, procesamiento de ventas punto de venta (POS), alertas inteligentes de stock y análisis de métricas comerciales en tiempo real.

## 📋 Tabla de Contenidos

- [Características Principales](#-características-principales)
- [Arquitectura Técnica](#-arquitectura-técnica)
- [Requisitos del Sistema](#-requisitos-del-sistema)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Uso del Sistema](#-uso-del-sistema)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [API y Endpoints](#-api-y-endpoints)
- [Contribución](#-contribución)
- [Licencia](#-licencia)

## ✨ Características Principales

### 🏥 Gestión de Inventario
- **CRUD completo** de productos con validaciones avanzadas
- **Control de categorías** jerárquico y organizado
- **Alertas automáticas** para productos con stock crítico (< 10 unidades)
- **Reabastecimiento** en tiempo real con confirmaciones visuales

### 💰 Sistema POS Avanzado
- **Ventas múltiples** con cálculo automático de subtotales
- **Validación de stock** en tiempo real durante la venta
- **Actualización automática** del inventario post-venta
- **Historial completo** de transacciones con detalles

### 📊 Dashboard Ejecutivo
- **Métricas clave**: productos totales, ventas, ingresos acumulados
- **Resumen comercial** con indicadores de rendimiento
- **Alertas de stock** centralizadas para toma de decisiones
- **Interfaz intuitiva** con diseño moderno y responsivo

### 🔐 Seguridad y Autenticación
- **Sistema de login** seguro con hash de contraseñas
- **Sesiones protegidas** con validación automática
- **Visualización segura** de contraseñas en formulario
- **Validaciones** de entrada y sanitización de datos

### 🎨 Experiencia de Usuario
- **Interfaz moderna** con Bootstrap 5 y animaciones suaves
- **Operaciones AJAX** sin recarga de página
- **Notificaciones inteligentes** con SweetAlert2
- **Diseño responsivo** optimizado para dispositivos móviles

## 🏗️ Arquitectura Técnica

### Tecnologías Core
- **Backend**: PHP 8.0+ con arquitectura MVC pura
- **Base de Datos**: MySQL 5.7+ con PDO para conexiones seguras
- **Frontend**: Bootstrap 5, JavaScript ES6+, AJAX con Fetch API
- **UI/UX**: Bootstrap Icons, SweetAlert2 para notificaciones

### Patrón de Diseño
- **MVC (Model-View-Controller)**: separación clara de responsabilidades
- **ORM Ligero**: consultas SQL optimizadas con prepared statements
- **Routing**: sistema de rutas limpio y escalable
- **Middleware**: autenticación y validación centralizada

### Seguridad Implementada
- **Password Hashing**: bcrypt para almacenamiento seguro
- **SQL Injection Prevention**: prepared statements PDO
- **XSS Protection**: sanitización de datos de entrada
- **CSRF Protection**: tokens de sesión únicos

## 💻 Requisitos del Sistema

### Servidor
- **PHP**: 8.0 o superior
- **MySQL**: 5.7 o superior
- **Apache/Nginx**: con mod_rewrite habilitado
- **Composer**: para gestión de dependencias (opcional)

### Navegador Web
- **Chrome**: 90+
- **Firefox**: 88+
- **Brave**: 1.20+
- **Edge**: 90+

### Hardware Mínimo
- **RAM**: 2GB
- **Almacenamiento**: 500MB disponible
- **Procesador**: 1.5 GHz dual-core

## 🚀 Instalación

### 1. Preparación del Entorno
Ubicar el proyecto dentro de la carpeta de XAMPP:
```bash
cd C:\xampp\htdocs\
```

### 2. Configuración de XAMPP
```bash
# Iniciar servicios
Start Apache
Start MySQL
```

### 3. Base de Datos
```sql
# Acceder a phpMyAdmin
http://localhost/phpmyadmin

# Crear base de datos
CREATE DATABASE nova_salud CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Importar esquema
Source: database.sql
```

### 4. Configuración del Sistema
```php
# Verificar configuración en config/database.php
host: localhost
database: nova_salud
user: root
password: ""  # vacío por defecto
```

### 5. Acceso al Sistema
```
URL: http://localhost/nova-salud/public/
Usuario: admin@novasalud.com
Contraseña: admin123
```

## ⚙️ Configuración

### Variables de Entorno
```php
# config/config.php
define('BASE_URL', 'http://localhost/nova-salud/public/');
define('APP_NAME', 'Nova Salud');
define('APP_VERSION', '1.0.0');
```

### Base de Datos
```php
# config/database.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'nova_salud');
define('DB_USER', 'root');
define('DB_PASS', '');
```

## 📖 Uso del Sistema

### Flujo de Trabajo Básico

1. **Inicio de Sesión**
   - Acceder con credenciales administrativas
   - Sistema valida sesión automáticamente

2. **Configuración Inicial**
   - Crear categorías de productos
   - Registrar productos con stock inicial

3. **Operaciones Diarias**
   - Gestionar inventario según necesidades
   - Procesar ventas en el módulo POS
   - Monitorear alertas de stock

4. **Análisis y Reportes**
   - Revisar métricas en el dashboard
   - Identificar productos para reabastecer

### Gestión de Productos
```php
// Crear producto
POST /products/create
{
  "name": "Paracetamol 500mg",
  "price": 2.50,
  "stock": 100,
  "category_id": 1
}
```

### Procesamiento de Ventas
```php
// Registrar venta
POST /sales/create
{
  "items": [
    {"product_id": 1, "quantity": 2},
    {"product_id": 3, "quantity": 1}
  ]
}
```

## 📁 Estructura del Proyecto

```
nova_salud/
├── 📁 config/           # Configuraciones del sistema
│   ├── config.php       # Constantes globales
│   └── database.php     # Conexión PDO
├── 📁 controllers/      # Lógica de negocio
│   ├── AuthController.php
│   ├── DashboardController.php
│   ├── ProductController.php
│   ├── CategoryController.php
│   └── SaleController.php
├── 📁 core/            # Núcleo del framework
│   ├── Auth.php        # Sistema de autenticación
│   ├── Controller.php  # Clase base controlador
│   ├── Model.php       # Clase base modelo
│   └── helpers.php     # Funciones utilitarias
├── 📁 models/          # Modelos de datos
│   ├── User.php
│   ├── Product.php
│   ├── Category.php
│   └── Sale.php
├── 📁 public/          # Assets públicos
│   ├── css/style.css
│   ├── js/app.js
│   ├── index.php       # Punto de entrada
│   └── .htaccess       # Reglas de reescritura
├── 📁 views/           # Plantillas de vista
│   ├── auth/login.php
│   ├── dashboard/index.php
│   ├── products/
│   ├── categories/
│   └── layouts/
└── 📄 database.sql     # Esquema de BD
```

## 🔗 API y Endpoints

### Autenticación
- `GET /login` - Formulario de login
- `POST /authenticate` - Procesar login
- `GET /logout` - Cerrar sesión

### Productos
- `GET /products` - Listar productos
- `POST /products/create` - Crear producto
- `POST /products/update` - Actualizar producto
- `POST /products/delete` - Eliminar producto
- `POST /products/restock` - Reabastecer stock

### Categorías
- `GET /categories` - Listar categorías
- `POST /categories/create` - Crear categoría
- `POST /categories/update` - Actualizar categoría
- `POST /categories/delete` - Eliminar categoría

### Ventas
- `GET /sales` - Historial de ventas
- `GET /sales/create` - Formulario POS
- `POST /sales/create` - Procesar venta

### Dashboard
- `GET /dashboard` - Panel principal con métricas

## 🤝 Contribución

1. Fork el proyecto
2. Crear rama de feature (`git checkout -b feature/AmazingFeature`)
3. Commit cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir Pull Request

### Estándares de Código
- PSR-12 para PHP
- ESLint para JavaScript
- Documentación en inglés
- Commits descriptivos

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.

## 👨‍💻 Autor

**Ronald Sebastian Chevez Trujillo**
- Proyecto: Sistema de Farmacia Nova Salud
- Tecnologías: PHP MVC + MySQL + Bootstrap 5
- Contacto: [ronald@example.com]

---

⭐ **Si este proyecto te resulta útil, considera darle una estrella en GitHub**

📧 **Soporte**: Para consultas técnicas, crear un issue en el repositorio