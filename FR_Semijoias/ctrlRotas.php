<?php

// Rotas aceitas
$routes = [
    ""          => "app/views/index.html",
    "inicio"    => "app/views/inicio.html",
    "cadastro"  => "app/views/cadastro.html",
];

// Captura a URI
$uri = $_GET["uri"] ?? "";

if (!array_key_exists($uri, $routes)) {
    http_response_code(404);
    echo "404 - Página não encontrada.";
    exit;
}

// Proteção contra acessos diretos não permitidos
if (str_starts_with($uri, "app/")) {
    http_response_code(403);
    echo "Acesso proibido.";
    exit;
}

// Verifica se a rota existe
if (isset($routes[$uri])) {
    $filePath = $routes[$uri];

    if (file_exists($filePath)) {
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        headerMimeTypes($ext);
        readfile($filePath);
        exit;
    } else {
        http_response_code(500);
        echo "Erro 404 - Página não encontrada.";
        exit;
    }
}

// Página não encontrada
http_response_code(404);
echo "404 - Página não encontrada.";

function headerMimeTypes($extension) {
    $mimes = [
        "html" => "text/html",
        "css"  => "text/css",
        "js"   => "application/javascript",
        "png"  => "image/png",
        "jpg"  => "image/jpeg",
        "jpeg" => "image/jpeg",
        "svg"  => "image/svg+xml",
        "woff" => "font/woff",
        "woff2"=> "font/woff2",
    ];
    header("Content-Type: " . ($mimes[$extension] ?? "application/octet-stream"));
}
