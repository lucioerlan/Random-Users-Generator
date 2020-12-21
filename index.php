<?php
error_reporting(0);
function _curl($url, $post = false, $header = '', $header_out = true, $follow_loc = true, $json = false)
{
    $ckfile = 'cookies.txt';
    $randIP = "" . mt_rand(0, 255) . "." . mt_rand(0, 255) . "." . mt_rand(0, 255) . "." . mt_rand(0, 255);
    $ch = curl_init();
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, $header_out);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow_loc);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.81 Safari/537.36");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    if ($json) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=UTF-8',
            'Connection: Keep-Alive',
            'Accept: application/json, text/plain, */*',
            $header,
        ));
    } else {
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
            'Connection: Keep-Alive',
            "REMOTE_ADDR: $randIP",
            "HTTP_X_FORWARDED_FOR: $randIP",
            $header,
        ));
    }
    curl_setopt($ch, CURLOPT_COOKIESESSION, $ckfile);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
    curl_setopt($ch, CURLOPT_COOKIE, $ckfile);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
if (isset($_POST['x'])) {
    $busca = _curl('https://api.namefake.com/portuguese-brazil', false, false, false, true);
    $decoder = json_decode($busca, true);

    $lista = "Nome: " . $nome = $decoder['name'] .
    "\nApelido: " . $apelido = $decoder['maiden_name'] .
    "\nEndereço: " . $endereco = $decoder['address'] .
    "\nData de Nascimento: " . $data = $decoder['birth_data'] .
    "\nTelefone: " . $telefone = $decoder['phone_h'] .
    "\nTipo Sanguinio: " . $sangue = $decoder['blood'] .
    "\nEmail: " . $email = $decoder['email_d'] .
    "\nAltura: " . $altura = $decoder['height'] .
    "\nPeso: " . $peso = $decoder['weight'] .
    "\nNumero de Ip: " . $numero_ip = $decoder['ipv4'];

}
?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta charset="utf-8" />
      <title>Gerador de Dados</title>
      <meta name="author" content="Erlan Lucio">
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
      <link rel="icon" href="images/favi.ico" type="image/x-icon" />
      <link href="styles/bootstrap.css" rel='stylesheet' type='text/css'>
      <link href="styles/animate.css" rel='stylesheet' type='text/css'>
      <link href='styles/form.css' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" href="styles/font-awesome.min.css">
   </head>
   <style type="text/css">
      @font-face {
      font-family: BebasNeue;
      src: url(fonts/BebasNeueThin.otf);
      }
      #down {
      margin: 20px;
      }
   </style>
   <body>
      <form method="POST" align="center">
         <div id="down" class="animated bounceInDown" id="formulario">
            <table class="display" id="example">
               <i style="font-size:180px;" class="fa fa-user-plus" aria-hidden="true"></i><br>
               <span style="font: 50px BebasNeue, serif;">Gerador de Dados</span>
               <div class="form-inline">
                  <textarea name="ccs" id="down" class="btn btn-success" class="form-control"
                     style=" cursor: auto; width: 550px; height: 220px;  30px; max-height:text-align: center;"> <?php echo "$lista"; ?>  </textarea>
                  <div class="form-inline">
                     <button type="submit" name="x" value="Iniciar " onclick="start()"
                        class="fcbtn btn btn-warning btn-outline btn-1e btn-squared">Gerar Dados</button>
            </table>
            </div>
      </form>
      <!-- Copyright -->
      <div id="down" class="footer-copyright text-center py-3">© 2019 Copyright:
      <a href="https://www.linkedin.com/in/erlanlucio/" target="_blank" rel="noreferrer noopener"> Erlan Lucio</a>
      </div>
      </div>
      <!-- Copyright -->
   </body>
</html>