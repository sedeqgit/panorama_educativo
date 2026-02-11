<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomHeaders
{   
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Eliminar cabeceras que exponen información del servidor
        $response->headers->remove('X-Powered-By');

        // Encabezados de seguridad recomendados
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN'); // Previene clickjacking
        $response->headers->set('X-Content-Type-Options', 'nosniff'); // Previene que el navegador interprete archivos con un tipo MIME incorrecto
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin'); // Controla la información de 'referer' enviada
        $response->headers->set('Server', 'SecureApp'); // Ofusca el nombre real del servidor

        // ¡IMPORTANTE! Solo activar si tu sitio funciona 100% con HTTPS.
        // Obliga al navegador a usar siempre HTTPS.
        // $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // --- Política de Seguridad de Contenido (CSP) ---
        // NOTA: Esta configuración es para un entorno de desarrollo con Vite.
        // Es más permisiva para permitir la carga de scripts y la conexión en tiempo real (HMR).
        // Si tu servidor de Vite usa un puerto (ej. 5173), debes añadirlo: 'http://10.5.9.167:5173'
        $dev_server_host = 'http://10.5.9.167';
        $dev_server_websocket = 'ws://10.5.9.167';

        $csp = "default-src 'self'; "
             // Se corrige la sintaxis (fuentes separadas por espacio, no ';') y se permite el servidor de desarrollo.
             . "style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com {$dev_server_host}; " 
             // Se permite el servidor de desarrollo para que los scripts (como charts.js) puedan cargar.
             . "script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com {$dev_server_host}; "
             . "font-src 'self' https://cdnjs.cloudflare.com; " // Permite fuentes locales y de Font Awesome.
             . "img-src 'self' data: https://www.queretaro.gob.mx; " // Permite imágenes locales, data: URIs y la imagen del chatbot.
             . "connect-src 'self' {$dev_server_websocket}; " // Permite la conexión WebSocket para Vite HMR.
             . "object-src 'none'; " // No permite plugins como Flash.
             . "frame-ancestors 'self';"; // Similar a X-Frame-Options, previene que tu sitio sea embebido en iframes.
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}

/*
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Aseguramos que la respuesta sea un objeto Response
        if (! $response instanceof Response) {
            $response = response($response);
        }

        // Encabezados de seguridad recomendados
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN'); // Evita clickjacking
        $response->headers->set('X-Content-Type-Options', 'nosniff'); // Evita detección MIME
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin'); // Controla envío de referer
        $response->headers->set('X-XSS-Protection', '1; mode=block'); // Protección básica contra XSS
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload'); // Obliga HTTPS

        // Content-Security-Policy adaptada para Bootstrap y Google Fonts
        $csp = "default-src 'self'; "
             . "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; "
             . "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; "
             . "font-src 'self' https://fonts.gstatic.com; "
             . "img-src 'self' data:;";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
*/
