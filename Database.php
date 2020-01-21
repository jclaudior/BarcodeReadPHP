<?php

class Database{
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $db_port;
    private $con = false;
    private $resultSelect;
    
    
    function __construct($host="localhost",$user="root",$pass="",$port="3306"){
        $this->db_host=$host;
        $this->db_user=$user;
        $this->db_pass=$pass;
        $this->db_port=$port;
    }
	
	public function getHost(){
		return $this->db_host;
	}
	
	public function getUser(){
		return $this->db_user;
	}
	
	public function getPass(){
		return $this->db_pass;
	}
	
	public function getPort(){
		return $this->db_port;
	}
	
    public function connect(){
        if(!$this->con){
            $this->con = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,"",$this->db_port);
            if(!$this->con){
                echo "Erro ao conectar ao Host Mysql.((".mysqli_connect_error().")|(".mysqli_connect_errno()."))";
                return false;
            }
        }
        else{
            return true;
        }
        return true;
    }

    public function setDB($db){
        if($this->con){
            $this->db_name = $db;
            $this->db_name = mysqli_select_db($this->con,$this->db_name);
            if(!$this->db_name){
                return false;
            }
        }
        else{
            
            return false;
        }
        return true;

    }

    

    public function select($campos,$tabela,$condicao="",$ordem=""){
        if($this->con && $this->db_name){
            $sql=false;
            if($condicao=="" && $ordem==""){
                $sql = "SELECT $campos FROM $tabela";
            }else if($condicao <> "" && $ordem==""){
                $sql= "SELECT $campos FROM $tabela WHERE $condicao";
            }else if($condicao == "" && $ordem<>""){
                $sql= "SELECT $campos FROM $tabela ORDER BY $ordem";
            }else if($condicao <> "" && $ordem <> ""){
                $sql = "SELECT $campos FROM $tabela WHERE $condicao ORDER BY $ordem";
            }
            if($sql){
                $resultados = mysqli_query($this->con,$sql);
                if($resultados){
                    $linhas = mysqli_num_rows($resultados);
                    if($linhas > 0){
                        for($i=0;$i < $linhas;$i++){
                            $this->resultSelect[$i] = mysqli_fetch_array($resultados);
                        }
                        return $this->resultSelect;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        else{
            echo "Não Conectado ao Host Mysql ou Nenhuma Base de Dados para Função Select";
        }
    }

    public function selectQuery($sql){
        if($this->con && $this->db_name){
            $resultados = mysqli_query($this->con,$sql);
            if($resultados){
                $linhas = mysqli_num_rows($resultados);
                if($linhas > 0){
                    for($i=0;$i < $linhas;$i++){
                        $this->resultSelect[$i] = mysqli_fetch_array($resultados);
                    }
                    return $this->resultSelect;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function insert($tabela,$colunas,$valores,$condicao=""){
        if($this->con && $this->db_name){
            $sql="";
            if($condicao==""){
                $sql="INSERT INTO $tabela ($colunas) VALUES ($valores)";
            }else{
                $sql="INSERT INTO $tabela ($colunas) VALUES ($valores) WHERE $condicao";
            }
            if($sql){
                $insert = mysqli_query($this->con,$sql);
                if($insert){
                    return true;
                }else{
                    return false; 
                }
            }else{
                return false;
            }
        }else{
            echo "Não Conectado ao Host Mysql ou Nenhuma Base de Dados para Função Insert";
        }
    }
    public function update(){
        if($this->con && $this->db_name){

        }else{
            echo "Não Conectado ao Host Mysql ou Nenhuma Base de Dados para Função Update";
        }

    }
    public function delete(){
        if($this->con && $this->db_name){

        }else{
            echo "Não Conectado ao Host Mysql ou Nenhuma Base de Dados para Função Delete";
        }
    }

}





?>