<?php

class Usuarios_model extends CI_Model {

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

            if ($vence != "Does not expire" && $vence != "Domain does not expire passwords" 
                    && $vence != "Password has expired") {
                $segundos_diferencia = $fecha_actual[0] - $vence["expiryts"];
                $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
                $dias_diferencia = abs($dias_diferencia);
                $dias_diferencia = floor($dias_diferencia);
                
                if ($dias_diferencia >= 0 && $dias_diferencia <= 20) {
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
    
    public function usuariosSinIniciarSesion(){
        $usuarios = $this->getAllUsers();
        
        for ($z = 0; $z < count($usuarios); $z++) {
            $info = $this->usuarios_model->infoUsuario($usuarios[$z]);
            
            if (!isset($info[0]["lastlogontimestamp"][0])) {
                $data["user"] = $info[0]["samaccountname"][0];
                if (isset($info[0]["displayname"])) {
                    $data["displayName"] = $info[0]["displayname"][0];
                } else {
                    $data["displayName"] = "No especificado";
                }
                $data["fechaCreado"] = substr($info[0]["whencreated"][0], 0, 8);
                $users[] = $data;
            }
        }
        
        return $users;
    }

///****************************USUARIOS*****************************************    
   
}
