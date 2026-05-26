<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Informe de Presupuesto</title>

    <style>
        {!! file_get_contents(resource_path('css/pdf/pdf.css')) !!}
    </style>
</head>

<body>

    @php
        $fechaBoda = filled($boda->fecha_boda) ? \Carbon\Carbon::parse($boda->fecha_boda)->format('d/m/Y') : null;

        $alertas = collect($categorias)->filter(fn($c) => $c['monto_pagado'] > $c['monto_total'])->values();

        $porcentajeSeguro = min($porcentajeEjecutado, 100);
    @endphp


    <header class="pdf-header">
        <div>
            <h1>Informe de Presupuesto</h1>

            @if ($boda->nombre_pareja)
                <p class="pdf-header__couple">{{ $boda->nombre_pareja }}</p>
            @endif

            <p class="pdf-header__meta">
                @if ($fechaBoda)
                    Fecha de boda: {{ $fechaBoda }} ·
                @endif
                Generado el {{ $fechaGeneracion }}
            </p>
        </div>
    </header>

    <main class="pdf-content">

        <table class="kpi-table">
            <tr>
                <td>
                    <span>Total presupuestado</span>
                    <strong class="text-blue">{{ number_format($totalPresupuestado, 0, ',', '.') }} €</strong>
                </td>

                <td>
                    <span>Total pagado</span>
                    <strong class="text-green">{{ number_format($totalPagado, 0, ',', '.') }} €</strong>
                </td>

                <td>
                    <span>Pendiente</span>
                    <strong class="text-red">{{ number_format($totalPendiente, 0, ',', '.') }} €</strong>
                </td>

                <td>
                    <span>% Ejecutado</span>
                    <strong
                        class="{{ $porcentajeEjecutado >= 80 ? 'text-green' : ($porcentajeEjecutado >= 40 ? 'text-blue' : 'text-red') }}">
                        {{ $porcentajeEjecutado }}%
                    </strong>
                </td>
            </tr>
        </table>

        <section class="progress-box">
            <div class="progress-box__top">
                <span>Progreso de pago</span>
                <strong>{{ $porcentajeEjecutado }}%</strong>
            </div>

            <div class="progress">
                <div class="progress__bar" style="width: {{ $porcentajeSeguro }}%;"></div>
            </div>
        </section>

        @if ($alertas->isNotEmpty())
            <section class="alert-box">
                <h2>Categorías con gasto superior al presupuestado</h2>

                @foreach ($alertas as $alerta)
                    <p>
                        <strong>{{ $alerta['nombre'] }}</strong> —
                        presupuestado {{ number_format($alerta['monto_total'], 0, ',', '.') }} € /
                        pagado {{ number_format($alerta['monto_pagado'], 0, ',', '.') }} €
                        <span>
                            +{{ number_format($alerta['monto_pagado'] - $alerta['monto_total'], 0, ',', '.') }} €
                        </span>
                    </p>
                @endforeach
            </section>
        @endif

        <h2 class="section-title">Desglose por categoría</h2>

        @foreach ($categorias as $cat)
            <section class="category-card">
                <div class="category-card__header">
                    <strong>{{ $cat['nombre'] }}</strong>

                    <span>
                        Presupuestado:
                        <b>{{ number_format($cat['monto_total'], 0, ',', '.') }} €</b>
                        · Pagado:
                        <b>{{ number_format($cat['monto_pagado'], 0, ',', '.') }} €</b>
                        · Pendiente:
                        <b>{{ number_format($cat['pendiente'], 0, ',', '.') }} €</b>
                    </span>
                </div>

                <table class="detail-table">
                    <thead>
                        <tr>
                            <th>Tipo / Concepto</th>
                            <th class="text-right">Presupuestado</th>
                            <th class="text-right">Pagado</th>
                            <th class="text-right">Pendiente</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($cat['tipos'] as $tipo)
                            @php
                                $isPaid = $tipo['monto_total'] > 0 && $tipo['monto_pagado'] >= $tipo['monto_total'];
                                $isPartial = $tipo['monto_pagado'] > 0 && $tipo['monto_pagado'] < $tipo['monto_total'];
                            @endphp

                            <tr>
                                <td>
                                    <strong class="concept-title">{{ $tipo['tipo'] }}</strong>

                                    @if (!empty($tipo['items']))
                                        <div class="concept-items">
                                            @foreach ($tipo['items'] as $item)
                                                {{ $item['nombre'] }}

                                                @if (!empty($item['notas']))
                                                    — {{ $item['notas'] }}
                                                @endif

                                                ({{ number_format($item['monto_estimado'], 0, ',', '.') }} €)
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </td>

                                <td class="text-right">
                                    {{ number_format($tipo['monto_total'], 0, ',', '.') }} €
                                </td>

                                <td class="text-right text-green">
                                    {{ number_format($tipo['monto_pagado'], 0, ',', '.') }} €
                                </td>

                                <td class="text-right {{ $tipo['pendiente'] > 0 ? 'text-red' : 'text-green' }}">
                                    {{ number_format($tipo['pendiente'], 0, ',', '.') }} €
                                </td>

                                <td class="text-center">
                                    @if ($isPaid)
                                        <span class="badge badge--success">Pagado</span>
                                    @elseif($isPartial)
                                        <span class="badge badge--info">Parcial</span>
                                    @else
                                        <span class="badge badge--warning">Pendiente</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endforeach

    </main>

    <footer class="pdf-footer">
        <span>Informe generado automáticamente · Wedding Planner</span>
        <span>{{ $fechaGeneracion }}</span>
    </footer>

</body>

</html>
