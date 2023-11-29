<?php

if(isset($_FILES['imagem'])){
    $imagem = $_FILES['imagem'];
    $type = $imagem['type'];
    $caminho = "arquivos/".$imagem['name'];

    if(move_uploaded_file($imagem["tmp_name"], $caminho)){
        echo "A imagem foi salva no servidor 1!";
        return ;
    }
}