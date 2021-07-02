<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>

    <h2>Hola {{ $name }}, gracias por registrarte en <strong> MAGIN </strong> !</h2>
    <p>Por favor confirma tu correo electrónico.</p>

    <p>Despúes de confirmar el correo, inicia sesion con la contraseña: {{$password_social}} </p>

    <p>Para ello simplemente debes hacer click en el siguiente enlace:</p>
    <a href="{{ url('api/register/verify/' . $confirmation_code) }}">
        Clic para confirmar tu email
    </a>


</body>
</html>
