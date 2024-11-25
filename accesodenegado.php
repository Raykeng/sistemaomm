<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acceso Denegado</title>
        <style>
           body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url("assets/images/fondo.jpg"); /* Ruta de la imagen */
            background-size: cover; /* La imagen cubre todo el fondo */
            background-position: center; /* Centra la imagen */
            background-repeat: no-repeat; /* Evita que la imagen se repita */
            font-family: Arial, sans-serif;
        }
            .alert-box {
                text-align: center;
                background-color: #FFFFFF;
                color: #721c24;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
                max-width: 400px;
                width: 100%;
            }
            .alert-box h1 {
                font-size: 1.5em;
                margin-bottom: 10px;
            }
            .alert-box p {
                font-size: 1em;
                margin-bottom: 0;
            }
            .alert-box img {
                width: 50px; /* Ajusta el tamaño del GIF */
                margin-top: 10px;
            }
        </style>
        <script>
            // Redirección a dashboard.php después de 3 segundos
            setTimeout(function() {
                window.location.href = "dashboard.php";
            }, 3000);
        </script>
    </head>
    <body>
        <div class="alert-box">
            <h1>Acceso Denegado</h1>
            <p>Solo los administradores pueden acceder a esta página.</p>
            <p>Redirigiendo al panel de control</p>
            <img src="assets/images/espera.gif" alt="Cargando..."> <!-- GIF de espera -->
        </div>
    </body>
    </html>