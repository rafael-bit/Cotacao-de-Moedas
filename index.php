<?php
    $url = 'https://economia.awesomeapi.com.br/last/';
    $coins = 'USD-BRL,EUR-BRL';

    $curl = curl_init($url . $coins);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);

    if ($response === false) {
        die('Erro ao fazer a requisição.');
    }

    $data = json_decode($response, true);

    // Moedas disponíveis
    $moedas = array(
        'USD' => 'Dólar',
        'EUR' => 'Euro',
        // Adicione mais moedas aqui, se necessário
    );

    // Cotação do Dólar
    $dolarReal = $data['USDBRL'];
    $dolarBid = (float)$dolarReal['bid'];

    // Cotação do Euro
    $euroReal = $data['EURBRL'];
    $euroBid = (float)$euroReal['bid'];

    $valorConvertido = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $moedaSelecionada = $_POST['moeda'];
        $valor = $_POST['valor'];

        if ($moedaSelecionada === 'USD') {
            $valorConvertido = number_format($valor * $dolarBid, 2, ',', '.');
        } elseif ($moedaSelecionada === 'EUR') {
            $valorConvertido = number_format($valor * $euroBid, 2, ',', '.');
        }
    }




    $url = 'https://economia.awesomeapi.com.br/last/';
    $coins = 'USD-BRL,EUR-BRL';

    $curl = curl_init($url . $coins);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);

    if ($response === false) {
        die('Erro ao fazer a requisição.');
    }

    $data = json_decode($response, true);

    // Cotação do Dólar
    $dolarReal = $data['USDBRL'];

    $estaData = new DateTime($dolarReal['create_date']);

    $titleEua = $dolarReal['name'];
    $thisDateEua = $estaData->format('d/m/Y H:i:s');
    $valueEua = number_format((float)$dolarReal['bid'], 2, ',', '.');

    // Cotação do Euro
    $euroReal = $data['EURBRL'];

    $estaData = new DateTime($euroReal['create_date']);

    $titleEur = $euroReal['name'];
    $thisDateEur = $estaData->format('d/m/Y H:i:s');
    $valueEur = number_format((float)$euroReal['bid'], 2, ',', '.');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotação de moedas</title>
</head>
<body>
    <form method="POST" action="">
        <div>
            <label for="moeda">Moeda:</label>
            <select name="moeda" id="moeda">
                <?php foreach ($moedas as $codigo => $nome) { ?>
                    <option value="<?php echo $codigo; ?>"><?php echo $nome; ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <label for="valor">Valor:</label>
            <input type="text" name="valor" id="valor" placeholder="Digite o valor" required>
        </div>
        <div>
            <input type="submit" value="Converter">
        </div>
    </form>

    <?php if (!empty($valorConvertido)) { ?>
        <div>
            <label for="valorConvertido">Valor Convertido:</label>
            <input type="text" id="valorConvertido" value="<?php echo $valorConvertido; ?>" readonly>
        </div>
    <?php } ?>

    <div>
        <h2 id="titleeua"><?php echo $titleEua; ?></h2>
        <p id="thisdateeua"><?php echo $thisDateEua; ?></p>
        <p id="valueeua"><?php echo 'R$ ' . $valueEua; ?></p>
    </div>

    <div>
        <h2 id="titleeur"><?php echo $titleEur; ?></h2>
        <p id="thisdateeur"><?php echo $thisDateEur; ?></p>
        <p id="valueeur"><?php echo 'R$ ' . $valueEur; ?></p>
    </div>
</form>
</body>
</html>