# Session Context: Blog IPUC

Este documento resume el estado actual del proyecto para facilitar la continuidad entre sesiones.

## 1. Estado Técnico
- **Framework:** Laravel 11 + Docker (Sail).
- **Frontend Híbrido:** 
    - **Público:** Blade + Tailwind CSS (Optimizado para SEO).
    - **Admin:** React + Inertia.js (SPA para mejor UX).
- **Servicios:** MySQL activo vía Sail.
- **Imágenes:** Sistema configurado para usar WebP (Premium/Performance).

## 2. Lo que YA funciona
- [x] CRUD de Categorías (Admin).
- [x] CRUD de Posts (Admin) con carga de imágenes.
- [x] Landing Page dinámica con listado de posts reales.
- [x] Optimización automática/manual a WebP.

## 3. Próximos Pasos (Roadmap Inmediato)
1. **Versículo del Día:** Integrar un componente dinámico en la home.
2. **Vista de Detalle (Show Post):** Crear la plantilla `show.blade.php` para lectura completa.
3. **Responsividad:** Pulir el diseño mobile de la home ("Luz y Paz").

## 4. Comandos de Supervivencia
- `sail up -d` -> Iniciar el proyecto.
- `sail npm run dev` -> Servidor de desarrollo frontend.
- `sail artisan db:show` -> Verificar base de datos.
- `sail stop` -> Detener servicios.

---
*Última actualización: 15 de Junio, 2026*
