<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Valora a tus proveedores</title>
</head>
<body style="margin:0;padding:0;background:#f9fafb;font-family:'Segoe UI',Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f9fafb;padding:2rem 1rem;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);max-width:600px;width:100%;">

          <!-- Header -->
          <tr>
            <td style="background:linear-gradient(135deg,#f76c6f,#e91e63);padding:2rem 2rem 1.5rem;text-align:center;">
              <p style="margin:0 0 0.5rem;font-size:1.6rem;">💍</p>
              <h1 style="margin:0;color:#ffffff;font-size:1.5rem;font-weight:800;line-height:1.3;">
                ¡Tu boda ya ha pasado!
              </h1>
              <p style="margin:0.5rem 0 0;color:rgba(255,255,255,0.88);font-size:0.95rem;">
                Es momento de compartir tu experiencia
              </p>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:2rem 2rem 1.5rem;">
              <p style="margin:0 0 1rem;color:#374151;font-size:1rem;">
                Hola <strong>{{ $usuario->name }}</strong>,
              </p>
              <p style="margin:0 0 1.25rem;color:#374151;font-size:0.95rem;line-height:1.6;">
                Esperamos que tu gran día haya sido perfecto. Ahora puedes dejar tu valoración a los
                proveedores que participaron en tu boda. Tu opinión ayuda a otras parejas a elegir con confianza.
              </p>

              @if($empresas->count() > 0)
              <p style="margin:0 0 0.75rem;color:#111827;font-weight:700;font-size:0.95rem;">
                Puedes valorar a:
              </p>
              <ul style="margin:0 0 1.5rem;padding-left:1.25rem;">
                @foreach($empresas as $empresa)
                <li style="margin-bottom:0.35rem;color:#374151;font-size:0.93rem;">
                  {{ $empresa->nombre_empresa }}
                </li>
                @endforeach
              </ul>
              @endif

              <div style="text-align:center;margin:1.75rem 0;">
                <a href="{{ env('APP_FRONTEND_URL', 'http://localhost:4200') }}/perfil-user"
                   style="display:inline-block;padding:0.8rem 2rem;background:#f76c6f;color:#ffffff;text-decoration:none;border-radius:10px;font-weight:700;font-size:0.95rem;">
                  Dejar mi reseña
                </a>
              </div>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:1rem 2rem 1.5rem;border-top:1px solid #f3f4f6;text-align:center;">
              <p style="margin:0;color:#9ca3af;font-size:0.8rem;">
                Sueños de Boda &mdash; Tu planificador de bodas<br>
                Has recibido este correo porque tu boda está registrada en nuestra plataforma.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
