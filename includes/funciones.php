<?php

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

function estaAutenticado()
{

    empty($_SESSION) ? session_start() : '';

    !isset($_SESSION['login']) ? header('Location: /') : '';
}

function esAdmin()
{
    empty($_SESSION) ? session_start() : '';

    !isset($_SESSION['admin']) ?  header('Location: /') : '';
}


function cerrarSesion()
{
    session_start();
    if (!empty($_SESSION)) {
        $_SESSION = [];
        return true;
    }
    return false;
}

function esUltimo(string $actual, string  $proximo): bool
{
    $resultado = $actual !== $proximo ? true : false;

    return $resultado;
}
