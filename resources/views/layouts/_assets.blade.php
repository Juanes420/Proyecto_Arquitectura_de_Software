{{-- Carga los assets con Vite si hay build (npm run build) o servidor de desarrollo (npm run dev). --}}
{{-- Si no, usa Tailwind desde CDN para que la app funcione sin Node instalado. --}}
@if(file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        {!! str_replace('@import "tailwindcss";', '', file_get_contents(resource_path('css/app.css'))) !!}
    </style>
@endif
