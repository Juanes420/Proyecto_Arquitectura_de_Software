<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist:wght@300..700&family=Geist+Mono:wght@400;500&display=swap">
<meta name="theme-color" content="#eeede8" media="(prefers-color-scheme: light)">
<meta name="theme-color" content="#0f0f0e" media="(prefers-color-scheme: dark)">

{{-- Carga los assets con Vite si hay build (npm run build) o servidor de desarrollo (npm run dev). --}}
{{-- Si no, usa Tailwind desde CDN para que la app funcione sin Node instalado. --}}
@if(file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        {!! preg_replace('/^@(import|source) .*$/m', '', file_get_contents(resource_path('css/app.css'))) !!}
    </style>
@endif
