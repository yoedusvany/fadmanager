<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ou extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function getOUs() {
        $this->load->model('ou_model');
        $this->load->model('json');
        
        if ($this->input->post("camino")) {
            $camino = substr($this->input->post("camino"), "5", strlen($this->input->post("camino")));
            $temp = explode("/", $camino);

            for ($i = count($temp) - 1; $i > 0; $i--) {
                $ou[] = $temp[$i];
            }
            $OU = $this->ou_model->getOUs($ou);
        } else {
            //DEFINE LA RAIZ DEL LDAP
            //$ou[] = "AREAS";
            $OU = $this->ou_model->getOUs();
        }

        if ($OU) {
            $this->json->GenerarRespJSON($OU, count($OU));
        } else {
            $this->json->setReason('No existen OU');
            $this->json->GenerarMensajeJSON();
        }
    }

    public function getUsersOU() {
        $this->load->model('ou_model');
        $this->load->model('json');

	$camino = $this->input->get("camino");
        $reload = $this->input->get("reload");
        
        if (isset($reload) && $reload != "") {
            //elimino la cadena idnode
            $camino = substr($camino, "6", strlen($camino));
            
            //convierto en un array sin OU
            $temp = explode("OU=", $camino);
            
            //convierte el arreglo anterior a string
            $tempDC = implode("", $temp);
            
            //copio la cadena sin el sufijo de dominio ejemplo: unica.cu
            $temp = substr($tempDC, 0, strpos($tempDC,"DC=")-1);
            
            //lo convierto a un array
            $ou = explode(",", $temp);
            
            $users = $this->ou_model->getUsersOU($ou);
            
        }elseif(is_string($camino)){
            if (strstr($camino, "/")) {
                $camino = substr($camino, "5", strlen($camino));
                $temp = explode("/", $camino);
            } else {
                $camino = substr($camino, "5", strlen($camino));
                $temp = explode("-", $camino);
            }
            for ($i = count($temp) - 1; $i > 0; $i--) {
                $ou[] = $temp[$i];
            }
            $users = $this->ou_model->getUsersOU($ou);
        } else {
            //DEFINE LA RAIZ DEL LDAP
            /* $ou[] = "Estudiantes";
              $ou[] = "AGRONOMIA";
              $ou[] = "FACULTADES"; */
            //$ou[] = "AREAS";
            $users = $this->ou_model->getUsersOU();
        }


        if ($users) {
            $this->json->GenerarRespJSON($users, count($users));
        } else {
            $this->json->setReason('No existen usuarios');
            $this->json->GenerarMensajeJSON();
        }
    }

    public function createOU() {
        $this->load->model('ou_model');
        $this->load->model('json');

        $newOU = $this->input->post("newOU");
        $padreOU = $this->input->post("camino");
        //$padreOU = substr($this->input->post("camino"), 6);
        
        
        if (is_string($padreOU)) {
            //elimino la cadena idnode
            $camino = substr($padreOU, "6", strlen($padreOU));
            
            //convierto en un array sin OU
            $temp = explode("OU=", $camino);
            
            //convierte el arreglo anterior a string
            $tempDC = implode("", $temp);
            
            //copio la cadena sin el sufijo de dominio ejemplo: unica.cu
            $temp = substr($tempDC, 0, strpos($tempDC,"DC=")-1);
            
            //lo convierto a un array
            $ou = explode(",", $temp);
            $ou = array_reverse($ou);

            /*if (count($temp) > 1) {
                for ($i = count($temp) - 1; $i > 0; $i--) {
                    $ou[] = $temp[$i];
                }
            } else {
                $ou[] = $temp[0];
            }*/
        }

        $result = $this->ou_model->createOU($newOU, $ou);
        if ($result) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSONText();
        } else {
            $this->json->setReason('No se pudo crear la OU');
            $this->json->GenerarMensajeJSON();
        }
    }

    public function borrarOU() {
        $this->load->model('ou_model');
        $this->load->model('json');

        $padreOU = $this->input->post("camino");

        if (is_string($padreOU)) {
            $camino = substr($padreOU, "6", strlen($padreOU));
            $temp = explode("/", $camino);

            for ($i = count($temp) - 1; $i >= 0; $i--) {
                $ou[] = $temp[$i];
            }
        }

        $result = $this->ou_model->deleteOU($ou);
        if ($result) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSONText();
        } else {
            $this->json->setReason('No se pudo eliminar la OU');
            $this->json->GenerarMensajeJSON();
        }
    }

}
