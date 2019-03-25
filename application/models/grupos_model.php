<?php

class Grupos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('adldap/adldap');
    }

///****************************GRUPOS**********************************************    
    public function addGroupToUser($group, $user) {
        return $this->adldap->group()->addUser($group, $user);
    }

    public function getGruposUser($user) {
        return $this->adldap->user()->groups($user);
    }

    public function removeGroupToUser($group, $user) {
        return $this->adldap->group()->removeUser($group, $user);
    }

    public function borrarGrupo($grupo) {
        return $this->adldap->group()->delete($grupo);
    }

    public function getGrupos() {
        $grupos = $this->adldap->group()->allSecurity();

        foreach ($grupos as $key => $value) {
            $data["grupo"] = $value;
            $result[] = $data;
        }
        //print_r($result);
        return $result;
    }

    public function createGrupo($grupo, $descripcion, $ou) {
        $atributes["group_name"] = $grupo;
        $atributes["container"] = $ou;
        $atributes["description"] = $descripcion;
        $grupos = $this->adldap->group()->create($atributes);

        return $grupos;
    }
    
    /**
     * Agregar varios usuarios a un grupo dado
     * @param array $usuarios
     * @param type $grupo
     * return boolean
     */
    public function addUserstoGroup($usuarios, $grupo){
        if(is_array($usuarios)){
            for($i=0; $i < count($usuarios); $i++){
                $this->adldap->group()->addUser($usuarios[$i]);
            }           
        }else{
            return false;
        }
    }

///****************************GRUPOS**********************************************    
}
