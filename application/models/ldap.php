<?php

class Ldap extends CI_Model {

    public function __construct() {
        parent::__construct();
        //$this->load->library('ldap/adldap');
        $this->load->library('adldap/adldap');
    }

///****************************USUARIOS*****************************************    
    public function getMembersofGroup($nameGroup) {
        $users = $this->adldap->group()->members($nameGroup);
        
        return $users;

        /* if ($users) {
          for ($i = 0; $i <= count($users) - 1; $i++) {
          $usuarios[$i]["name"] = $users[$i];
          }

          if (count($usuarios) > 0) {
          for ($i = 0; $i <= count($usuarios) - 1; $i++) {
          $infoUser = $this->adldap->user()->info($usuarios[$i]["name"]);

          $DN = explode(",", $infoUser[0]["dn"]);
          $OU = preg_grep("/OU/", $DN);

          if ($OU[1] == "OU=Estudiantes" || $OU[1] == "OU=Profesores") {
          //if ($OU[1] == "OU=Estudiantes" || $OU[1] == "OU=Trabajadores") {
          $info[$i]["ou"] = substr($OU[2], 3);
          } else {
          $info[$i]["ou"] = substr($OU[1], 3);
          }

          $info[$i]["no"] = $i + 1;
          $info[$i]["user"] = $usuarios[$i]["name"];
          $info[$i]["displayName"] = $infoUser[0]["displayname"][0];
          }
          }


          return $info;
          } 

        return false;*/
    }

    public function getUsersofGroup($nameGroup) {
        $users = $this->adldap->group()->members($nameGroup);

        return $users;
    }

    public function getAllUsers() {
        $info = $this->adldap->user()->all();
        return $info;
    }

    public function getPasswordVence($usuario) {
        $info = $this->adldap->user()->passwordExpiry($usuario);
        return $info;
    }

    public function getMail($user) {
        $info = $this->adldap->user()->info($user);
        return $info;
    }

    public function getUltimoInicioSesion($usuario) {
        $date = getdate($this->adldap->user()->getLastLogon($usuario));
        return $date['mday'] . "-" . $date['mon'] . "-" . $date['year'] . " " . $date['hours'] . ":" . $date['minutes'];
    }

    public function getUsersPassVencida() {
        $users = $this->getAllUsers();
        $fecha_actual = getdate();

        for ($i = 0; $i < count($users); $i++) {
            $vence = $this->getPasswordVence($users[$i]);

            if ($vence != "Does not expire" && $vence != "Domain does not expire passwords") {
                if ($vence == "Password has expired") {
                    $usuarios[] = $users[$i];
                } else {
                    $segundos_diferencia = $fecha_actual[0] - $vence["expiryts"];
                    $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
                    $dias_diferencia = abs($dias_diferencia);
                    $dias_diferencia = floor($dias_diferencia);

                    if ($dias_diferencia <= 0) {
                        $usuarios[] = $users[$i];
                    }
                }
            }
        }

        return $usuarios;
    }

    public function getUsersPassPtoVencer() {
        $users = $this->getAllUsers();
        $fecha_actual = getdate();

        for ($i = 0; $i < count($users); $i++) {
            $vence = $this->getPasswordVence($users[$i]);

            if ($vence != "Does not expire" && $vence != "Domain does not expire passwords" && $vence == "Password has expired") {
                $segundos_diferencia = $fecha_actual[0] - $vence["expiryts"];
                $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
                $dias_diferencia = abs($dias_diferencia);
                $dias_diferencia = floor($dias_diferencia);

                if ($dias_diferencia >= 0 && $dias_diferencia <= 15) {
                    $usuarios[] = $users[$i];
                }
            }
        }

        if (isset($usuarios)) {
            return $usuarios;
        } else {
            return FALSE;
        }
    }

    public function enable($usuario) {
        return $this->adldap->user()->enable($usuario);
    }

    public function disable($usuario) {
        return $this->adldap->user()->disable($usuario);
    }

    public function autenticar($user, $pass) {
        return $this->adldap->user()->authenticate($user, $pass);
    }

    public function borrarUsuario($user) {
        return $this->adldap->user()->delete($user);
    }

    public function infoUsuario($user) {
        return $this->adldap->user()->info($user, array("*"));
    }

    public function createUsuario($attributes) {
        try {
            $result = $this->adldap->user()->create($attributes);
            return $result;
            /* Do something */
        } catch (adLDAPException $e) {
            echo $e;
            exit();
        }
    }

    public function changePassword($user, $pass) {
        $this->adldap->setUseSSL(true);
        return $this->adldap->user()->password($user, $pass);
    }

///****************************USUARIOS*****************************************    
//
//
//
///****************************OU**********************************************    
    public function getOUs($ou = NULL) {
        $dnType = adLDAP::ADLDAP_FOLDER;
        $recursive = false;
        $type = 'folder';

        $info = $this->adldap->folder()->listing($ou, $dnType, $recursive, $type);

        if ($info["count"] != 0) {
            for ($i = 0; $i < $info["count"]; $i++) {
                $temp["text"] = substr(strstr($info[$i]["dn"], "="), 1, strpos(strstr($info[$i]["dn"], "="), ",") - 1);
                $temp["leaf"] = false;
                $temp["id"] = 'idNode' . $info[$i]["dn"];
                $data[] = $temp;
            }

            return $data;
        } else {
            return false;
        }
    }

    public function getUsersOU($ou) {
        $info = $this->adldap->folder()->listing($ou, adLDAP::ADLDAP_FOLDER, false);
        $usuarios = array();
        

        for ($i = 0; $i < $info["count"]; $i++) {
            if ($info[$i]["objectclass"][1] == "person") {
                $fields = array("msnpcallingstationid", "lastLogonTimestamp", "givenName", "sn", "mail");
                $data_user = $this->adldap->user()->info($info[$i]["samaccountname"][0], $fields);

                $temp["tipo"] = "usuario";
                $temp["user"] = $info[$i]["samaccountname"][0];
                //print_r($data_user);
                if (isset($data_user[0]["givenname"][0])) {
                    $temp["givenname"] = $data_user[0]["givenname"][0];
                } else
                    $temp["givenname"] = "";

                if (isset($data_user[0]["sn"][0])) {
                    $temp["sn"] = $data_user[0]["sn"][0];
                } else
                    $temp["sn"] = "";

                if (isset($data_user[0]["msnpcallingstationid"][0])) {
                    $temp["dialin"] = $data_user[0]["msnpcallingstationid"][0];
                } else
                    $temp["dialin"] = "";

                if (isset($data_user[0]["mail"][0])) {
                    $temp["email"] = $data_user[0]["mail"][0];
                } else
                    $temp["email"] = "NO ESTABLECIDO";

                $passwordVence = $this->getPasswordVence($temp["user"]);

                if ($passwordVence == "Does not expire") {
                    $temp["passwordVence"] = "NO";
                } else {
                    $temp["passwordVence"] = $passwordVence["expiryformat"];
                }

                if (isset($data_user[0]["lastlogontimestamp"][0])) {
                    $date = getdate(adLDAPUtils::convertWindowsTimeToUnixTime($data_user[0]["lastlogontimestamp"][0]));
                    //print_r($date);
                    if (strlen($date['mday']) == 1) {
                        $date['mday'] = "0" . $date['mday'];
                    }
                    if (strlen($date['mon']) == 1) {
                        $date['mon'] = "0" . $date['mon'];
                    }
                    if (strlen($date['year']) == 1) {
                        $date['year'] = "0" . $date['year'];
                    }
                    if (strlen($date['hours']) == 1) {
                        $date['hours'] = "0" . $date['hours'];
                    }
                    if (strlen($date['minutes']) == 1) {
                        $date['minutes'] = "0" . $date['minutes'];
                    }

                    $temp["lastInicioSesion"] = $date['year'] . "-" . $date['mon'] . "-" . $date['mday'] . " " . $date['hours'] . ":" . $date['minutes'] . ":" . $date['seconds'];
                } else {
                    $temp["lastInicioSesion"] = "NO";
                }

                $usuarios[] = $temp;
            } elseif ($info[$i]["objectclass"][1] == "group") {
                $data_grupo = $this->adldap->group()->info($info[$i]["samaccountname"][0]);

                $temp["tipo"] = "grupo";
                $temp["user"] = $info[$i]["samaccountname"][0];
                $temp["distinguishedname"] = $data_grupo[0]["distinguishedname"][0];
                $temp["dn"] = $data_grupo[0]["dn"];

                $temp["givenname"] = "";
                $temp["sn"] = "";
                $temp["email"] = "-";
                $temp["passwordVence"] = "-";
                $temp["lastInicioSesion"] = "-";
                $temp["dialin"] = "-";

                $usuarios[] = $temp;
            }
        }

        return $usuarios;
    }

    public function createOU($newOU, $padreOU) {
        $atributes["ou_name"] = $newOU;
        $atributes["container"] = $padreOU;
        $result = $this->adldap->folder()->create($atributes);

        return $result;
    }

    public function deleteOU($padreOU) {
        $dn = '';
        for ($i = 0; $i < count($padreOU); $i++) {
            $dn .= "OU=" . $padreOU[$i] . ",";
        }

        $dn .= $this->adldap->findBaseDn();

        $result = $this->adldap->folder()->delete($dn);

        return $result;
    }

///****************************OU**********************************************    
//
//
//
//
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
