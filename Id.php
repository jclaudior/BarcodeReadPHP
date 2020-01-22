<?php

include("Database.php");



class Id{ 
    private $novaConexao;
    private $banco;

    function __construct() {
        $this->banco = new Database("192.168.1.246","consu","consulta123","3306");
        
        $novaConexao = $this->banco->connect();
        if($novaConexao){
            $this->novaConexao = $this->banco->setDB("econ");
        }else{
            echo "Erro ao conectar ao servidor Mysql!";
            return false;
        }
    }

    function getInfoId($id){
        if($this->novaConexao == true){
            $idInfo = $this->banco->selectQuery("select fanta_cli as CLIENTE, codigo_cli as CODCLI, serie_ide as SERIE,lote_ide as LOTE,pedido_ide as PEDIDO,codpro_ide as CODIGO,descri_pro as DESCRICAO,pl_ide as LIQUIDO,fabrica_ide as FABRICACAO,valida_ide as VALIDADE 
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
    }

    function getInfoPallet($id){
        if($this->novaConexao == true){
            $lote = substr($id, 0, 8);
            $pallet = substr($id, 8, 4);
            $idInfo = $this->banco->selectQuery("SELECT codigo_cli,fanta_cli,lote_en4,numpal_en4,codpro_en1,descri_pro,saldoc_en4 from caden4,caden1,cadent,cadpro,cadcli 
            where  numero_ent=left(lote_en4,6) and  lote_en4=lote_en1 and lote_en4='$lote' and numpal_en4='$pallet' and codcli_ent=codcli_pro and codigo_pro=codpro_en1 and codigo_cli=codcli_ent
            ");
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
    }
}



?>