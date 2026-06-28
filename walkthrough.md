# Walkthrough - Sistema de Autenticación de Autores

Hemos implementado un sistema completo de autenticación y protección de rutas para el blog. La pantalla de acceso sigue una estética limpia y serena (tonos beige y tierra) coherente con el resto del sitio.

## Implementación Detallada

### 1. Control de Acceso y Backend
- **Controlador de Autenticación** ([AuthController.php](file:///media/cristian/6b35405d-e91d-420d-8f66-4edfeb7015ed5/cristian/blog-Iglesia-ipuc/app/Http/Controllers/AuthController.php)): 
  - `showLoginForm()` renderiza la pantalla de login con Inertia.
  - `login()` valida las credenciales y autentica de forma segura con regeneración de sesión.
  - `logout()` invalida la sesión y limpia los tokens para máxima seguridad.
- **Seguridad en Rutas** ([routes/web.php](file:///media/cristian/6b35405d-e91d-420d-8f66-4edfeb7015ed5/cristian/blog-Iglesia-ipuc/routes/web.php)):
  - El grupo `/admin` ahora requiere el middleware `auth` nativo de Laravel. Cualquier usuario no autenticado que intente entrar será redirigido automáticamente al login.
  - Las rutas de login están restringidas para invitados (`guest`).
  - La ruta `/logout` está protegida para usuarios autenticados.

### 2. Frontend de Autenticación (React + Inertia)
- **Vista de Acceso** ([Login.jsx](file:///media/cristian/6b35405d-e91d-420d-8f66-4edfeb7015ed5/cristian/blog-Iglesia-ipuc/resources/js/Pages/Auth/Login.jsx)): Una pantalla de login premium que gestiona los estados de envío, errores de validación de forma reactiva (con `useForm` de Inertia) y cuenta con un checkbox de recordar sesión.

### 3. Carga de Datos de Prueba (Seeder)
- **DatabaseSeeder** ([DatabaseSeeder.php](file:///media/cristian/6b35405d-e91d-420d-8f66-4edfeb7015ed5/cristian/blog-Iglesia-ipuc/database/seeders/DatabaseSeeder.php)): Siembra la base de datos con un autor y un post devocional inicial para validar de inmediato la tabla del Dashboard.

## Cómo Probar el Sistema de Login

1. **Re-arrancar Vite si es necesario**:
   Asegúrate de que el servidor de desarrollo de Vite esté activo para compilar en vivo:
   ```bash
   ./vendor/bin/sail npm run dev
   ```
2. **Intentar acceso directo**:
   Ingresa a [http://localhost/admin](http://localhost/admin). Comprobarás que eres redirigido inmediatamente a la pantalla de login en [http://localhost/login](http://localhost/login).
3. **Iniciar sesión**:
   Utiliza las credenciales de prueba creadas por el Seeder:
   - **Correo**: `admin@vocesdegracia.com`
   - **Contraseña**: `password`
4. **Validación del Dashboard**:
   Tras iniciar sesión, accederás al panel de administración y verás el artículo sembrado de ejemplo.
5. **Cierre de sesión**:
   Haz clic en el botón "Salir" en la barra lateral para volver de forma segura al blog público.
