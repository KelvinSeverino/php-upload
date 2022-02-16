<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo de Uso | Upload</title>
</head>
<body> 

    <p></p>

    <form action="sendFile.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>
                Envio de Arquivo
            </legend>

            <!-- Input de arquivo -->
            <p>
                Selecione um arquivo <input type="file" name="file">
            </p>

            <p>
                <button type="submit">Enviar</button>
            </p>
        </fieldset>
    </form>

    <p><hr></p>

    <form action="sendImage.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>
                Envio de Imagem
            </legend>

            <!-- Input de imagem -->
            <p>
                Selecione uma imagem <input type="file" name="image">
            </p>

            <p>
                <button type="submit">Enviar</button>
            </p>
        </fieldset>
    </form>

    <p><hr></p>

    <form action="sendDocument.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>
                Envio de Documento
            </legend>

            <!-- Input de imagem -->
            <p>
                Selecione uma imagem <input type="file" name="document">
            </p>

            <p>
                <button type="submit">Enviar</button>
            </p>
        </fieldset>
    </form>
    
</body>
</html>