<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo mensaje de contacto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #6b46c1; /* Color morado */
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content p {
            margin: 10px 0;
            line-height: 1.5;
        }
        .content p strong {
            color: #6b46c1; /* Morado */
        }
        .footer {
            background-color: #f3f4f6;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #555555;
        }
        .footer a {
            color: #6b46c1; /* Morado */
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nuevo mensaje de contacto</h1>
        </div>
        <div class="content">
            <p><strong>Nombre:</strong> {{ $details['name'] }}</p>
            <p><strong>Email:</strong> {{ $details['email'] }}</p>
            <p><strong>Mensaje:</strong> {{ $details['message'] }}</p>
        </div>
        <div class="footer">
            <p>Este mensaje fue enviado desde el formulario de contacto de tu perfil.</p>
            <p><a href="{{ url('/') }}">Volver al sitio web</a></p>
        </div>
    </div>
</body>
</html>
