# 🔑 Cuentas de Prueba - Voces de Gracia

Este archivo contiene el listado de las cuentas creadas por el sembrador de base de datos (`seeder`) para probar las diferentes funcionalidades y roles en el entorno de desarrollo local.

## 👤 Credenciales de Acceso

| Nombre | Correo Electrónico | Contraseña | Rol | Descripción / Permisos |
| :--- | :--- | :--- | :--- | :--- |
| **Pastor Alexander** | `admin@vocesdegracia.com` | `password` | `admin` | **Administrador**: Acceso total al panel, gestión de artículos, aprobación de testimonios y lectura de oraciones privadas. |
| **Escritor Juan** | `writer@vocesdegracia.com` | `password` | `writer` | **Redactor**: Puede escribir, editar y eliminar sus propios artículos. |
| **Diácono Carlos Mendoza** | `carlos@vocesdegracia.com` | `password` | `writer` | **Redactor**: Cuenta secundaria para pruebas de multi-autoría. |
| **Hermana Diana Cardona** | `diana@vocesdegracia.com` | `password` | `writer` | **Redactora**: Cuenta secundaria para pruebas de multi-autoría. |
| **Pastora Martha Ortiz** | `martha@vocesdegracia.com` | `password` | `writer` | **Redactora**: Cuenta secundaria para pruebas de multi-autoría. |

---

## 🚀 Cómo restablecer o volver a sembrar los datos
Si realizas cambios en los datos de la base de datos y deseas restablecerlos a este estado inicial, ejecuta en tu terminal:

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```
