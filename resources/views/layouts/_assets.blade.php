{{-- Tema antes de pintar: la eleccion guardada o, si no hay, la del sistema. Evita el parpadeo al cargar. --}}
<script>
    (function () {
        var raiz = document.documentElement;
        var sistema = window.matchMedia('(prefers-color-scheme: dark)');
        var guardado = null;
        try { guardado = localStorage.getItem('gv-tema'); } catch (e) {}

        function aplicar(tema) {
            raiz.dataset.theme = tema;
            document.querySelectorAll('meta[name="theme-color"]').forEach(function (meta) {
                meta.content = tema === 'dark' ? '#0f0f0e' : '#eeede8';
            });
            document.querySelectorAll('[data-theme-toggle]').forEach(function (boton) {
                boton.setAttribute('aria-pressed', String(tema === 'dark'));
            });
        }

        aplicar(guardado === 'light' || guardado === 'dark' ? guardado : (sistema.matches ? 'dark' : 'light'));

        window.gvCambiarTema = function () {
            var nuevo = raiz.dataset.theme === 'dark' ? 'light' : 'dark';
            try { localStorage.setItem('gv-tema', nuevo); } catch (e) {}
            aplicar(nuevo);
        };

        document.addEventListener('DOMContentLoaded', function () { aplicar(raiz.dataset.theme); });

        // Sin eleccion guardada, el tema sigue al sistema aunque cambie con la pagina abierta.
        sistema.addEventListener('change', function (evento) {
            var elegido = null;
            try { elegido = localStorage.getItem('gv-tema'); } catch (e) {}
            if (!elegido) { aplicar(evento.matches ? 'dark' : 'light'); }
        });
    })();
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist:wght@300..700&family=Geist+Mono:wght@400;500&display=swap">
<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
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
