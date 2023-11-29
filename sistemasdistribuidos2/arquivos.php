<?php

header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: *');

$arquivos = glob("arquivos/" . "/*");
$numeroarquivos = count($arquivos);

echo json_encode(["numarquivos" => $numeroarquivos, "arquivos" => $arquivos]);