<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Entidad</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        .card {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 16px;
            margin-top: 15px;
        }
        .grid { width: 100%; border-collapse: collapse; }
        .grid td { padding: 6px; vertical-align: top; }
        .label { color: #666; font-size: 11px; }
        .value { font-weight: bold; font-size: 12px; }

        table.table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        .table th, .table td { border: 1px solid #000; padding: 6px; }
        .table th { background: #f2f2f2; }
        .op-header {
            background: #eaeaea;
            font-weight: bold;
            padding: 6px;
            margin-top: 14px;
        }
    </style>
</head>
<body>

{{-- Encabezado con logo y título --}}
<table style="width:100%; margin-bottom: 10px;">
    <tr>
        <td style="width:25%; text-align:left; vertical-align:top;">
            @php $logoPath = public_path('img/logo.png'); @endphp
            @if(file_exists($logoPath))
                <img src="{{ $logoPath }}" alt="Logo" style="height: 48px;">
            @else
                <div style="color:#999;">[LOGO]</div>
            @endif
        </td>
        <td style="width:75%;"></td>
    </tr>

    <tr>
        <td colspan="2" style="text-align:center; padding-top:8px;">
            <div style="font-weight:bold; font-size:14px;">
                REGISTRO DE INDICADORES DE SEGUIMIENTO
            </div>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="text-align:left; padding-top:8px;">
            <div style="font-size:12px;">
                <span style="font-weight:normal;">ENTIDAD:</span><br>
                <span style="font-weight:bold;">
                    {{ strtoupper($data->entidad->nombre ?? 'No especificada') }}
                </span>
            </div>
        </td>
    </tr>
</table>

{{-- Datos de cabecera --}}
<div class="card">
    <table class="grid">
        <tr>
            <td style="width:25%;">
                <div class="label">DEPARTAMENTO</div>
                <div class="value">{{ $data->entidad->distrito->provincia->departamento->nombre ?? '-' }}</div>
            </td>
            <td style="width:25%;">
                <div class="label">PROVINCIA</div>
                <div class="value">{{ $data->entidad->distrito->provincia->nombre ?? '-' }}</div>
            </td>
            <td style="width:25%;">
                <div class="label">DISTRITO</div>
                <div class="value">{{ $data->entidad->distrito->nombre ?? '-' }}</div>
            </td>
            <td style="width:25%;">
                <div class="label">UBIGEO</div>
                <div class="value">{{ $data->entidad->distrito->codigo ?? '-' }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="label">CATEGORÍA</div>
                <div class="value">{{ $data->entidad->categoria->nombre ?? '-' }}</div>
            </td>
            <td colspan="2" style="text-align:right;">
                <div class="label">FECHA DE ACTUALIZACIÓN DE INDICADORES</div>
                <div class="value">
                    {{ $data->updated_at ? $data->updated_at->format('d-m-Y') : now()->format('Y-m-d') }}
                </div>
            </td>
        </tr>
    </table>
</div>

{{-- Indicadores agrupados --}}
<h4 style="margin-top:20px;">INDICADORES</h4>

       {{--
oreach($respuestasAgrupadas as $op => $grupo)
    <div class="op-header">
        {{ $op }} - {{ $grupo->first()->titulo ?? '' }}
    </div>
--}}

    <table class="table">
        <thead>
            <tr>
                <th>Instrumento</th>
                <th>Respuesta</th>
                <th>Adjuntos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($respuestasAgrupadas as $instrumento => $resp)
                <tr>
                    <td>{{ $instrumento ?? '-' }}</td>
                    <td>{{ strtoupper($resp[0]->respuesta ?? '-') }}</td>
                    <td>
                        @if($resp[0]->files && $resp[0]->files->count())
                            @foreach($resp[0]->files as $file)
                            <div>
                                    {{-- Mostrar descripción si existe, sino el nombre --}}
                                    <a href="{{ $file->url }}" target="_blank">
                                        {{ $file->descripcion ?? basename($file->url) }}
                                    </a>
                                    <br>
                                    <small style="color:#666;">{{ $file->url }}</small>
                            </div>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
        {{--endforeach--}}

</body>
</html>




