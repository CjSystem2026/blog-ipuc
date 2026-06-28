# 🚀 Guía de Despliegue en Railway - Voces de Gracia (IPUC)

Subir un proyecto de Laravel 11/13 con React (Inertia.js) a Railway es directo y robusto gracias a **Nixpacks** (el constructor automático de Railway). Sigue estos pasos y recomendaciones para configurar un entorno de producción seguro y estable.

---

## 1. 🗄️ Configuración de la Base de Datos (MySQL)

En producción necesitas un servidor de base de datos dedicado. En Railway puedes crear uno en 2 clics:

1. En tu dashboard de Railway, haz clic en **New** -> **Database** -> **Add MySQL**.
2. Railway creará un servicio MySQL y generará variables automáticas (`MYSQLHOST`, `MYSQLPORT`, `MYSQLUSER`, etc.).
3. En la configuración del servicio de tu aplicación Laravel, añade las siguientes variables apuntando dinámicamente al servicio MySQL para que se conecten de forma interna:

| Variable Laravel | Valor en Railway (Referencia dinámica) |
| :--- | :--- |
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` | `${{MySQL.MYSQLHOST}}` |
| `DB_PORT` | `${{MySQL.MYSQLPORT}}` |
| `DB_DATABASE` | `${{MySQL.MYSQLDATABASE}}` |
| `DB_USERNAME` | `${{MySQL.MYSQLUSER}}` |
| `DB_PASSWORD` | `${{MySQL.MYSQLPASSWORD}}` |

---

## 2. 🔑 Variables de Entorno de Producción obligatorias

Ve a la pestaña **Variables** de tu servicio de Laravel en Railway y configura las siguientes variables clave para asegurar la estabilidad, seguridad y el rendimiento del blog:

```ini
# Configuración Básica
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:TU_LLAVE_DE_PRODUCCION_AQUÍ # Generada con php artisan key:generate --show
APP_URL=https://tu-dominio-de-railway.up.railway.app

# Registro de logs directamente a la consola de Railway
LOG_CHANNEL=stderr

# Optimizaciones de Caché para producción
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

---

## 3. 💾 Almacenamiento Persistente (¡MUY IMPORTANTE!)

> [!WARNING]
> **El sistema de archivos de Railway es efímero (se borra en cada despliegue o reinicio).**
> Si un pastor o redactor sube una imagen para un artículo, esta imagen se guardará en `storage/app/public/posts` y **desaparecerá** la próxima vez que subas código o reinicies la app.

### Cómo solucionarlo en Railway (2 Opciones):

#### Opción A: Montar un Volumen Persistente (Recomendado y rápido)
1. En tu servicio de Laravel, ve a la pestaña **Settings** -> **Volumes** -> **Add Volume**.
2. Dale un tamaño pequeño (ej. 1GB o 5GB es más que suficiente para imágenes de blog).
3. Configura el **Mount Path** como:
   `/app/storage/app/public`
4. En tus variables de entorno añade:
   `FILESYSTEM_DISK=public`
   
*Esto creará un disco duro persistente montado en tu carpeta de imágenes que sobrevivirá a cualquier despliegue.*

#### Opción B: Usar un servicio en la nube (S3, Cloudinary, etc.)
Si prefieres no usar volúmenes y escalar horizontalmente en el futuro, puedes modificar el driver en `config/filesystems.php` para subir las fotos directamente a servicios como Cloudinary o Amazon S3.

---

## 4. ⚙️ Comando de Compilación y Migraciones Automáticas

Durante la subida, Railway detectará que es un proyecto Laravel, instalará las dependencias de Composer, las de NPM y compilará la aplicación automáticamente con Vite.

Para automatizar la ejecución de migraciones en cada despliegue:

1. Ve a **Settings** en tu servicio de Laravel.
2. En la sección **Deploy** busca **Custom Start Command** o **Pre-Deploy Command** (si lo tienes activado).
3. Configura el comando de arranque o despliegue para asegurarte de que las tablas estén al día:
   ```bash
   php artisan migrate --force
   ```
   *(El flag `--force` es obligatorio en entorno de producción para que no solicite confirmación interactiva).*

---

## 5. 👥 Primer Acceso al Panel de Control en Producción

Una vez desplegada la aplicación, no tendrás los usuarios de prueba creados inicialmente a menos que los siembres. Puedes acceder a la base de datos de Railway con tu cliente preferido (DBeaver, TablePlus, etc.) con las credenciales públicas que te da Railway, o puedes correr el sembrador de base de datos por única vez ejecutando este comando desde la terminal local de Railway (en la pestaña **Deployments** -> haz clic en tu último despliegue -> **Console**):

```bash
php artisan db:seed --force
```
*Esto creará las cuentas iniciales para que puedas iniciar sesión con el correo del Pastor Alexander o crear tu propio usuario desde la pantalla de registro de producción.*
