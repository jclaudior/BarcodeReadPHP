<?php

include("Database.php");

class Id{

    function getInfo($id){
        $banco= new Database("192.168.5.253","webteste","102030","33306");
        $novaConexao = $banco->connect();

        if($novaConexao){
            $novaConexao = $banco->setDB("clcr");

            if($novaConexao == true){
                $idInfo = $banco->selectQuery("select fanta_cli as CLIENTE,serie_ide as SERIE,lote_ide as LOTE,pedido_ide as PEDIDO,codpro_ide as CODIGO,descri_pro as DESCRICAO,pl_ide as LIQUIDO,fabrica_ide as FABRICACAO,valida_ide as VALIDADE 
                from cadide,cadcli,cadpro 
                where  serie_ide='$id' and codcli_ide=codigo_cli and codpro_ide=codigo_pro");
                if($idInfo){
                    foreach($idInfo as $id){
                        return $id;
                    }
                }else{
                    return false;
                }
            }else{
                echo "Erro ao selecionar Banco!";
                return false;
            }
        }else{
            echo "Erro ao conectar ao servidor Mysql!";
            return false;
        }
    }
}



?>