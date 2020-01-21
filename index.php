<!DOCTYPE html>
    <script type="text/javascript">
    //This entire block of script should be in a separate file, and included in each doc in which you want scanner capabilities
        function zxinglistener(e){
            localStorage["zxingbarcode"] = "";
            if(e.url.split("\#")[0] == window.location.href){
                window.focus();
                processBarcode(decodeURIComponent(e.newValue));
            }
            window.removeEventListener("storage", zxinglistener, false);
        }
        if(window.location.hash != ""){
            localStorage["zxingbarcode"] = window.location.hash.substr(1);
            self.close();
            window.location.href="about:blank";//In case self.close is disabled
        }else{
            window.addEventListener("hashchange", function(e){
                window.removeEventListener("storage", zxinglistener, false);
                var hash = window.location.hash.substr(1);
                if (hash != "") {
                    window.location.hash = "";
                    processBarcode(decodeURIComponent(hash));
                }
            }, false);
        }
        function getScan(){
            var href = window.location.href.split("\#")[0];
            window.addEventListener("storage", zxinglistener, false);
            zxingWindow = window.open("zxing://scan/?ret=" + encodeURIComponent(href + "#{CODE}"),'_self');
        }

    </script>

    <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
            <link href="node_modules/fontawesome/css/all.css" rel="stylesheet">
            <link rel="stylesheet" href="style/css/style.css">
            <script type="text/javascript">
                function processBarcode(b){
					document.getElementById("inputId").value = b;
                    document.forms["formId"].submit();
                }
            </script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                <style>
                  .imgLogo{
                      height: 10%;
                      width: 35%;
                  }
                  .greyColor{
                      background-image: linear-gradient(#474545, #302a2a);
                  }
                </style>
        </head>
        <body>
            <div class="container-fluid">
                
             <nav class="navbar fixed-top navbar-expand-lg navbar-dark greyColor">
                 <div class="container mb-0">
                     <a class="navbar-brand h1 text-white mt-1" href="#">
                     <img src="img/banner4.png" width="40" height="30" alt="" class="d-inline-block align-top" >
                        Central Logística
                     </a>
                     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSite">
                         <span class="navbar-toggler-icon"></span>
                     </button>
                     <div class="collapse navbar-collapse" id="navbarSite">
                         <ul class="navbar-nav mr-auto">
                             <li class="nav-item">
                                 <a class="nav-link" href="index.php">Informações ID</a>
                             </li>
                         </ul>
                         <ul class="navbar-nav ml-auto">
                             <li class="nav-item dropdown">
                                 <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="navDrop">
                                     Social 
                                 </a>
                                 <div class="dropdown-menu">
                                     <a class="dropdown-item" target="_blank" href="https://www.facebook.com/Servi%C3%A7os-Central-log%C3%ADstica-e-Armaz%C3%A9ns-Gerais-LTDA-186523182080635/">Facebook</a>
                                     <a class="dropdown-item" href="#">Twitter</a>
                                     <a class="dropdown-item" href="#">Instagran</a>
                                 </div>
                             </li>
                         </ul>
                         <ul class="navbar-nav">
                             <a class="nav-link" href="#">
                                 Tel.(11)3054-3400
                             </a>
                         <ul>
                     </div>
                 </div>
             </nav>
                <br>
                <h1 class="dysplay-4 mt-5">Informações ID</h1>
                <form action="index.php" method="POST" id="formId">
                <div class="row">
                    <div class="col-12 text-right">
                        <input type="text" class="form-control " id="inputId" name="id" plasehorder="Entre com ID">
                    </div>
                    <div class="col-6 mt-1">
                        <button onclick="getScan()" class="form-control btn btn-primary">SCAN</button>
                    </div>
                    <div class="col-6 mt-1">
                        <input type="submit" class="form-control btn btn-danger" value= "enviar">
                    </div>
                </div>
                </form>
            </div>
            <div class="container">
            <?php
                include("Id.php");
                if(!empty($_POST['id'])){
                    $id = new Id;
            
                    $idInfo = $id->getInfoId($_POST['id']);

                    if($idInfo){
                        echo "<div class='row d-flex justify-content-center mt-2'>";
                        echo "<div class='card' style='width: 18rem;'>";
                        echo "<div class='card-header'>
                                    Informação 
                              </div>";
                        echo "<ul class='list-group list-group-flush'></li>";
                        echo "<li class='list-group-item'><b>NOME: </b>" . $idInfo['CLIENTE'] ."</li>";
                        echo "<li class='list-group-item'><b>SERIE: </b>" . $idInfo['SERIE'] ."</li>";
                        echo "<li class='list-group-item'><b>LOTE: </b>" . $idInfo['LOTE'] ."</li>";
                        echo "<li class='list-group-item'><b>PEDIDO: </b>" . $idInfo['PEDIDO'] ."</li>";
                        echo "<li class='list-group-item'><b>CÓDIGO: </b>" . $idInfo['CODIGO'] ."</li>";
                        echo "<li class='list-group-item'><b>DESCRIÇÃO: </b>" . $idInfo['DESCRICAO'] ."</li>";
                        echo "<li class='list-group-item'><b>P. LIQUIDO: </b>" .number_format($idInfo['LIQUIDO'],3,",",".") ." Kg</li>";
                        echo "<li class='list-group-item'><b>FABRICAÇÃO: </b>" . date("d/m/Y",strtotime($idInfo['FABRICACAO'])) ."</li>";
                        echo "<li class='list-group-item'><b>VENCIMENTO: </b>" . date("d/m/Y",strtotime($idInfo['VALIDADE']));
                        echo "</ul></div>";
                        echo "</div>";
                    }else{

                        $idInfo = $id->getInfoPallet($_POST['id']);
                        if($idInfo){
                            print_r($idInfo);
                        }else{
                            echo "id ou palete Inexistente na base de dados!";
                        }
                    }
                }else{
                    echo "Nenhum ID para consulta!";
                }

            
            ?>
            </div>
            <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center  p-2">
                    <a href="#">@Copyright Central Logística</a>
                </div>
            </div>
            </div>
            <script src="node_modules/jquery/jquery.js"></script>
            <script src="node_modules/popper.js/dist/umd/popper.js"></script>
            <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
        </body>
		
    </html>