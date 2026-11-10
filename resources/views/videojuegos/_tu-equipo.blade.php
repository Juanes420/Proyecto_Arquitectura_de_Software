{{-- Detecta en el navegador lo que se puede saber del equipo y lo compara con los requisitos. --}}
<x-card class="p-6" data-tu-equipo
        data-ram-minima="{{ $datos['ram_minima'] }}" data-ram-recomendada="{{ $datos['ram_recomendada'] }}"
        data-requiere-windows="{{ $datos['requiere_windows'] ? '1' : '0' }}">
    <p class="gv-label text-muted">{{ __('messages.tu_equipo') }}</p>
    <p data-veredicto class="mt-3 text-[15px] font-medium leading-snug">{{ __('messages.veredicto_sin_datos') }}</p>
    <p class="mt-2 text-sm leading-relaxed text-muted">{{ __('messages.tu_equipo_ayuda') }}</p>

    <dl class="mt-5 divide-y divide-line border-y border-line">
        @foreach(['sistema_operativo', 'procesador', 'memoria_ram', 'tarjeta_grafica', 'almacenamiento'] as $componente)
            <div class="grid grid-cols-[1fr_auto] items-start gap-x-4 gap-y-1 py-3">
                <dt class="text-[13px] text-muted">{{ __('messages.' . $componente) }}</dt>
                <dd data-estado="{{ $componente }}" class="row-span-2 self-center"></dd>
                <dd data-detectado="{{ $componente }}" class="text-[14px] leading-snug">-</dd>
            </div>
        @endforeach
    </dl>

    <p class="mt-4 text-xs leading-relaxed text-muted">{{ __('messages.tu_equipo_limite') }}</p>
</x-card>

<script>
    document.querySelectorAll('[data-tu-equipo]').forEach((panel) => {
        const textos = @js([
            'cumple' => __('messages.estado_cumple'),
            'cumple_recomendado' => __('messages.estado_cumple_recomendado'),
            'no_cumple' => __('messages.estado_no_cumple'),
            'revisar' => __('messages.estado_revisar'),
            'no_confirmable' => __('messages.estado_no_confirmable'),
            'no_verificable' => __('messages.estado_no_verificable'),
            'veredicto_cumple' => __('messages.veredicto_cumple'),
            'veredicto_no_cumple' => __('messages.veredicto_no_cumple'),
            'veredicto_sin_datos' => __('messages.veredicto_sin_datos'),
            'nucleos' => __('messages.nucleos', ['cantidad' => ':n']),
            'ram' => __('messages.ram_detectada', ['cantidad' => ':n']),
            'ram_tope' => __('messages.ram_tope'),
            'no_disponible' => __('messages.no_disponible'),
            'no_detectable' => __('messages.no_detectable'),
        ]);
        const colores = {
            cumple: 'border-accent/50 text-accent', cumple_recomendado: 'border-accent/50 text-accent',
            no_cumple: 'border-danger/50 text-danger', no_confirmable: 'border-warning/50 text-warning',
            revisar: 'border-line-strong text-muted', no_verificable: 'border-line-strong text-muted',
        };

        const sistema = (() => {
            const plataforma = (navigator.userAgentData?.platform || navigator.userAgent).toLowerCase();
            if (/android/.test(plataforma)) return 'Android';
            if (/iphone|ipad|ios/.test(plataforma)) return 'iOS';
            if (/win/.test(plataforma)) return 'Windows';
            if (/mac/.test(plataforma)) return 'macOS';
            if (/linux|cros/.test(plataforma)) return 'Linux';
            return null;
        })();

        const grafica = (() => {
            try {
                const gl = document.createElement('canvas').getContext('webgl');
                const extension = gl && gl.getExtension('WEBGL_debug_renderer_info');
                const nombre = extension ? gl.getParameter(extension.UNMASKED_RENDERER_WEBGL) : null;
                if (!nombre) return null;
                // "ANGLE (NVIDIA, NVIDIA GeForce RTX 3060 (0x2503) Direct3D11 ...)" => "NVIDIA GeForce RTX 3060"
                const partes = nombre.replace(/^ANGLE \((.*)\)$/, '$1').split(', ');
                return (partes[1] ?? partes[0])
                    .replace(/^ANGLE \w+ Renderer: /, '')
                    .replace(/\s*\(0x[0-9a-f]+\)/i, '')
                    .replace(/\s+(Direct3D|OpenGL|vs_|D3D).*$/i, '')
                    .trim();
            } catch (error) {
                return null;
            }
        })();

        const ram = navigator.deviceMemory ?? null;
        const ramMinima = parseFloat(panel.dataset.ramMinima) || null;
        const ramRecomendada = parseFloat(panel.dataset.ramRecomendada) || null;
        const requiereWindows = panel.dataset.requiereWindows === '1';

        // Chrome y Edge redondean la RAM a una potencia de 2: un valor r significa una RAM real entre 0,75r y 1,5r.
        // Solo se afirma algo cuando todo ese rango queda de un lado del requisito.
        const estadoRam = () => {
            if (!ram || !ramMinima) return 'no_verificable';
            if (ramRecomendada && ram * 0.75 >= ramRecomendada) return 'cumple_recomendado';
            if (ram * 0.75 >= ramMinima) return 'cumple';
            if (ram * 1.5 < ramMinima && ram < 8) return 'no_cumple';
            return 'no_confirmable';
        };

        const componentes = {
            // En macOS o Linux muchos juegos tienen version nativa o corren con Proton: no se descarta, se pide revisar.
            sistema_operativo: [sistema ?? textos.no_disponible, !sistema ? 'no_verificable' : (['Android', 'iOS'].includes(sistema) ? 'no_cumple' : (requiereWindows && sistema === 'Windows' ? 'cumple' : 'revisar'))],
            procesador: [navigator.hardwareConcurrency ? textos.nucleos.replace(':n', navigator.hardwareConcurrency) : textos.no_disponible, 'revisar'],
            memoria_ram: [ram ? textos.ram.replace(':n', ram) + (ram === 8 && estadoRam() === 'no_confirmable' ? ' · ' + textos.ram_tope : '') : textos.no_disponible, estadoRam()],
            tarjeta_grafica: [grafica ?? textos.no_disponible, 'revisar'],
            almacenamiento: [textos.no_detectable, 'revisar'],
        };

        Object.entries(componentes).forEach(([clave, [detectado, estado]]) => {
            panel.querySelector(`[data-detectado="${clave}"]`).textContent = detectado;
            const insignia = document.createElement('span');
            insignia.className = 'inline-flex whitespace-nowrap rounded-[4px] border px-1.5 py-0.5 text-[11px] font-medium uppercase tracking-[0.06em] ' + colores[estado];
            insignia.textContent = textos[estado];
            panel.querySelector(`[data-estado="${clave}"]`).replaceChildren(insignia);
        });

        const estados = Object.values(componentes).map(([, estado]) => estado);
        const veredicto = estados.includes('no_cumple') ? 'veredicto_no_cumple'
            : estados.some((estado) => estado.startsWith('cumple')) ? 'veredicto_cumple' : 'veredicto_sin_datos';
        panel.querySelector('[data-veredicto]').textContent = textos[veredicto];
    });
</script>
