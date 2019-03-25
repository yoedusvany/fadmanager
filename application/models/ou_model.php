<?php

class Ou_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('adldap/adldap');
    }


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
        $this->load->model("usuarios_model");
        
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

                $passwordVence = $this->usuarios_model->getPasswordVence($temp["user"]);

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
   
}
