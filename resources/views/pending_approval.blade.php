<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esperando Aprobación</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        .container {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .clock {
            margin-bottom: 20px;
        }
        .clock img {
            height: 400px; /* Aumenta el tamaño del GIF */
            width: auto;   /* Mantiene la proporción */
        }
        .message {
            font-size: 1.25rem;
            margin-bottom: 20px;
            color: #555;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #3490dc;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #2779bd;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="container">
        <div class="clock">
            <img src="{{ asset('images/imagen3.gif') }}" alt="Cargando">
        </div>
        <h1 class="text-2xl font-bold mb-4">Esperando Aprobación</h1>
        <p class="message">Tu cuenta está en espera de aprobación. Por favor, contacta al administrador para más información.</p>
        <form action="{{ route('logout.and.redirect') }}" method="POST">
            @csrf
            <button type="submit" class="button">Aceptar</button>
        </form>
    </div>
</body>
</html>
