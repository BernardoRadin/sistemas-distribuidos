1<?php

$servidor1 = 'http://localhost/sistemasdistribuidos/';
$servidor2 = 'http://IP_SERVIDOR/sistemasdistribuidos2/';

$arquivos = glob("arquivos/" . "/*");
$numeroarquivos = count($arquivos);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "{$servidor2}arquivos.php",
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,        
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);

$infoservidor2 = json_decode($response,true);

if(isset($infoservidor2['numarquivos'])){
    $numeroarquivos2 = $infoservidor2['numarquivos'];
    $arquivos2 = $infoservidor2['arquivos'];
}


if($numeroarquivos < 4){
    $servidor = $servidor1."recebe_arquivo.php";
}else if(isset($numeroarquivos2) && $numeroarquivos2 <= 4){
    $servidor = $servidor2;
}else{
    $servidor = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Sistemas Distribuídos</title>
</head>
<style>

    .principal{
        display: flex;
        align-items: center;
        justify-content: center;
    }

    body{
        background-color: #efefef;
    }

    .form-label{
        font-size: 20px !important;
    }

</style>
<body>
    <div class="container vh-100">
        <div class="principal">
            <div class="mb-2 mt-4">
                <form class="row gy-2 gx-3 align-items-center" id="formulario">
                    <label for="formFileLg" class="form-label">Selecione o arquivo: </label>
                    <input name="imagem" class="form-control form-control-lg" id="imagem" type="file">
                    <button type="button" class="btn btn-primary btn-lg" onClick="Enviar('<?php echo $servidor; ?>')">Enviar</button>
                </form>
            </div>
        </div>
        <div style="width: 90%; margin-top: 30px; margin: 0 auto">
        <?php
        foreach($arquivos as $arquivo){
            echo "<img src=".$arquivo." class='img-thumbnail' style='width: 140px !important;'>";
        }
        if(isset($arquivos2)){
            foreach($arquivos2 as $arquivo2){
                echo "<img src=\"".$servidor2.$arquivo2."\" class='img-thumbnail' style='width: 140px !important;'>";
            }
        }
        ?>
        </div>
    </div>
    <script>
      function Enviar(servidor){

        if(servidor === ''){
            Swal.fire({
                title: 'Espaço insuficiente em todos servidores!',
                icon: "error"
            });
            return;
        }

        var formData = new FormData();
        formData.append("imagem", $("#imagem")[0].files[0]);

        $.ajax({
          type: "POST",
          url: servidor,
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
             $('.container').load('');
            Swal.fire({
                title: response,
                icon: "success"
            });
          },
        });

      };
  </script>
</body>
</html>
