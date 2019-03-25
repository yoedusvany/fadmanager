<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Reportes extends CI_Controller {
    
    public $page;

    function __construct() {
        parent::__construct();
        $this->page = 0;
    }

    //funcion para generar el encabezado del documento RTF
    private function generateHeadRTF($titulo) {
        $this->rtf->set_default_font("Arial", 10);
        //$this->rtf->add_image(base_url() . "web/images/SNTECDlogo.jpg", 70, "center");
        $this->rtf->new_line();

        //$this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", ""), "center");
        $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", strtoupper($titulo)), "center");
        $this->rtf->new_line();
        $this->rtf->paragraph();

        $this->rtf->add_text($this->rtf->bold(1) . date("Y-m-d"), "right");
        $this->rtf->new_line();
        $this->rtf->paragraph();
    }

    private function generateHeadTable($fields, $size) {
        $this->rtf->ln(1);
        $this->rtf->set_table_font("Arial", 11);

        $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(8) . "No.", "5", "center", "10");
        if (is_array($fields)) {
            for ($i = 0; $i <= count($fields) - 1; $i++) {
                $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $fields[$i]), $size[$i], "center", "10");
            }
        }
        $this->page++;
        $this->rtf->close_line();
    }

    private function generateSignature($msg = NULL) {
        $this->rtf->ln(1);
        $this->rtf->tab(13);
        $this->rtf->paragraph();
        $this->rtf->new_line();

        if (is_null($msg)) {
            $msg = "Generado por: FADMANAGER";
        }

        $this->rtf->set_table_font("Arial", 9);
        $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", strtoupper($msg)), "left");
        $this->rtf->new_line();
    }
    
    

    public function reporteUsuariosOU($ou) {
        $this->load->model('ou_model');
        $this->load->library('rtf');
        $quantpag = 46;
        $j = 0;
        $i = 0;
        $corFundo = 0;

        $ou = str_replace("%20", " ", $ou);

        $camino = substr($ou, "6", strlen($ou));
        $temp = explode("-", $camino);

        for ($z = count($temp) - 1; $z >= 0; $z--) {
            $UnidadO[] = $temp[$z];
        }

        $this->generateHeadRTF("LISTADO DE USUARIOS DEL AREA: " . $UnidadO[0]);
        $usuarios = $this->ou_model->getUsersOU($UnidadO);

        if ($usuarios) {
            $this->cant = count($usuarios);
            $this->n_page = ceil($this->cant / $quantpag);

            if ($this->cant > 0) {
                while ($j <= $this->cant - 1) {

                    if ($i == 0) {
                        $encabezado = array("Nombre y Apellidos", "Usuario", "Último inicio de sesión");
                        $sizes = array(40, 20, 30);
                        $this->generateHeadTable($encabezado, $sizes);
                    }

                    ($corFundo == "8") ? ($corFundo = "16") : ($corFundo = "8");

                    $this->rtf->set_table_font("Arial", 10);
                    $this->rtf->open_line();

                    $no = $j + 1;

                    if (isset($usuarios[$i]["displayName"])) {
                        $displayName = $usuarios[$i]["displayName"];
                    } else {
                        $displayName = $usuarios[$i]["givenname"] . " " . $usuarios[$i]["sn"];
                    }


                    $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $displayName), "40", "left", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $usuarios[$i]["user"]), "20", "center", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $usuarios[$i]["lastInicioSesion"]), "30", "center", $corFundo);
                    $this->rtf->close_line();

                    $i++;
                    $j++;
                }
            }
        }

        $this->generateSignature();
        $this->rtf->display();
    }
    
    public function reporteUsuariosGrupo($grupo) {
        $this->load->model('usuarios_model');
        $this->load->library('rtf');
        $quantpag = 46;
        $j = 0;
        $i = 0;
        $corFundo = 0;
        $this->generateHeadRTF("LISTADO DE USUARIOS DEL GRUPO: " . $grupo);

        $usuarios = $this->usuarios_model->getUsersofGroup($grupo);

        if ($usuarios) {
            $this->cant = count($usuarios);
            $this->n_page = ceil($this->cant / $quantpag);

            if ($this->cant > 0) {
                while ($j <= $this->cant - 1) {

                    if ($i == 0 OR $i == $quantpag) {
                        $encabezado = array("Nombre y Apellidos", "Usuario", "AREA");
                        $sizes = array(40, 20, 20);
                        $this->generateHeadTable($encabezado, $sizes);
                    }

                    ($corFundo == "8") ? ($corFundo = "16") : ($corFundo = "8");

                    $this->rtf->set_table_font("Arial", 10);
                    $this->rtf->open_line();

                    $info = $this->usuarios_model->infoUsuario($usuarios[$j]);

                    $str = substr($info[0]["dn"], strpos($info[0]["dn"], "OU"));
                    $ou = substr($str, strpos($str, "=") + 1, strpos($str, ",") - 3);

                    if (isset($info[0]["displayname"][0])) {
                        $displatName = $info[0]["displayname"][0];
                    } else {
                        $displatName = "NO ESPECIFICADO";
                    }

                    //print_r($ou);

                    $no = $j + 1;
                    $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $displatName), "40", "left", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $info[0]["samaccountname"][0]), "20", "center", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $ou), "20", "center", $corFundo);
                    $this->rtf->close_line();

                    $i++;
                    $j++;
                }
            }
        } else {
            $this->rtf->new_line();
            $this->rtf->new_line();

            $this->rtf->set_table_font("Arial", 9);
            $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "Este grupo no posee usuarios"), "left");
            $this->rtf->new_line();
        }

        $this->generateSignature();
        $this->rtf->display();
    }

    public function reporteUsuariosSinInicicarSesion() {
        $this->load->model('usuarios_model');
        $this->load->library('rtf');
        $quantpag = 45;
        $j = 0;
        $i = 0;
        $corFundo = 0;

        //$users1 = $this->ldap->getMembersofGroup("nac");
        //$users2 = $this->ldap->getMembersofGroup("inter");
        //$usuarios = array_merge($users1, $users2);
        
        $usuarios = $this->usuarios_model->getAllUsers();
        
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
        
        if ($users) {
            $this->generateHeadRTF("LISTADO DE USUARIOS SIN INICIAR SESION");

            $this->cant = count($users);
            $this->n_page = ceil($this->cant / $quantpag);

            $this->rtf->new_line();

            $this->rtf->set_table_font("Arial", 9);
            $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "Cantidad de usuarios: " . $this->cant), "left");
            $this->rtf->new_line();

            if ($this->cant > 0) {
                while ($j <= $this->cant - 1) {

                    if ($i == 0) {
                        $encabezado = array("Nombre y Apellidos", "Usuario", "Fecha de creación");
                        $sizes = array(40, 20, 20);
                        $this->generateHeadTable($encabezado, $sizes);
                    }

                    ($corFundo == "8") ? ($corFundo = "16") : ($corFundo = "8");

                    $this->rtf->set_table_font("Arial", 10);
                    $this->rtf->open_line();

                    $no = $j + 1;
                    $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $users[$i]["displayName"]), "40", "left", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $users[$i]["user"]), "20", "center", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $users[$i]["fechaCreado"]), "20", "center", $corFundo);
                    $this->rtf->close_line();

                    $i++;
                    $j++;
                }
            } else {
                $this->rtf->new_line();
                $this->rtf->new_line();

                $this->rtf->set_table_font("Arial", 9);
                $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "No existen usuarios sin iniciar sesion"), "left");
                $this->rtf->new_line();
            }
        }

        $this->generateSignature();
        $this->rtf->display();
    }

    public function reporteUsuariosPasswordVencida() {
        $this->load->model('usuarios_model');
        $this->load->library('rtf');
        $quantpag = 46;
        $j = 0;
        $i = 0;
        $corFundo = 0;

        $this->generateHeadRTF("LISTADO DE USUARIOS CON PASSWORD VENCIDO");

        $usuarios = $this->usuarios_model->getUsersPassVencida();

        if ($usuarios) {
            $this->cant = count($usuarios);
            $this->n_page = ceil($this->cant / $quantpag);

            if ($this->cant > 0) {
                while ($j <= $this->cant - 1) {

                    if ($i == 0 OR $i == $quantpag) {
                        $encabezado = array("Nombre y Apellidos", "Usuario", "AREA");
                        $sizes = array(40, 20, 20);
                        $this->generateHeadTable($encabezado, $sizes);
                    }

                    ($corFundo == "8") ? ($corFundo = "16") : ($corFundo = "8");

                    $this->rtf->set_table_font("Arial", 10);
                    $this->rtf->open_line();

                    $info = $this->usuarios_model->infoUsuario($usuarios[$j]);

                    $str = substr($info[0]["dn"], strpos($info[0]["dn"], "OU"));
                    $ou = substr($str, strpos($str, "=") + 1, strpos($str, ",") - 3);

                    if (isset($info[0]["displayname"][0])) {
                        $displatName = $info[0]["displayname"][0];
                    } else {
                        $displatName = "NO ESPECIFICADO";
                    }

                    //print_r($ou);

                    $no = $j + 1;
                    $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $displatName), "40", "left", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $info[0]["samaccountname"][0]), "20", "center", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $ou), "20", "center", $corFundo);
                    $this->rtf->close_line();

                    $i++;
                    $j++;
                }
            }
        } else {
            $this->rtf->new_line();
            $this->rtf->new_line();

            $this->rtf->set_table_font("Arial", 9);
            $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "Este grupo no posee usuarios"), "left");
            $this->rtf->new_line();
            $this->rtf->new_line();
        }

        $this->generateSignature();
        $this->rtf->display();
    }

    public function reporteUsuariosPasswordPtoVencer() {
        $this->load->model('usuarios_model');
        $this->load->library('rtf');
        $quantpag = 46;
        $j = 0;
        $i = 0;
        $corFundo = 0;

        $this->generateHeadRTF("LISTADO DE USUARIOS CON PASSWORD A PUNTO DE VENCER");

        $usuarios = $this->usuarios_model->getUsersPassPtoVencer();

        if ($usuarios) {
            $this->cant = count($usuarios);
            $this->n_page = ceil($this->cant / $quantpag);

            if ($this->cant > 0) {
                while ($j <= $this->cant - 1) {

                    if ($i == 0 OR $i == $quantpag) {
                        $encabezado = array("Nombre y Apellidos", "Usuario", "AREA");
                        $sizes = array(40, 20, 20);
                        $this->generateHeadTable($encabezado, $sizes);
                    }

                    ($corFundo == "8") ? ($corFundo = "16") : ($corFundo = "8");

                    $this->rtf->set_table_font("Arial", 10);
                    $this->rtf->open_line();

                    $info = $this->usuarios_model->infoUsuario($usuarios[$j]);

                    $str = substr($info[0]["dn"], strpos($info[0]["dn"], "OU"));
                    $ou = substr($str, strpos($str, "=") + 1, strpos($str, ",") - 3);

                    if (isset($info[0]["displayname"][0])) {
                        $displatName = $info[0]["displayname"][0];
                    } else {
                        $displatName = "NO ESPECIFICADO";
                    }

                    //print_r($ou);

                    $no = $j + 1;
                    $this->rtf->cell($this->rtf->bold(1) . $this->rtf->color(0) . $no, "5", "center", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $displatName), "40", "left", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $info[0]["samaccountname"][0]), "20", "center", $corFundo);
                    $this->rtf->cell(iconv("UTF-8", "ISO-8859-1", $ou), "20", "center", $corFundo);
                    $this->rtf->close_line();

                    $i++;
                    $j++;
                }
            }
        } else {
            $this->rtf->new_line();
            $this->rtf->new_line();

            $this->rtf->set_table_font("Arial", 9);
            $this->rtf->add_text($this->rtf->bold(1) . iconv("UTF-8", "ISO-8859-1", "No existen usuarios con password a punto de vencer"), "left");
            $this->rtf->new_line();
            $this->rtf->new_line();
        }

        $this->generateSignature();
        $this->rtf->display();
    }

}
