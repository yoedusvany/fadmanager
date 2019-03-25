<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grupos extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function getGruposUser() {
        $this->load->model('grupos_model');
        $this->load->model('json');
        $user = $this->input->get("user");
        $grupos = $this->grupos_model->getGruposUser($user);

        for ($i = 0; $i <= count($grupos) - 1; $i++) {
            $groups[]["grupo"] = $grupos[$i];
        }

        // autenticar con el LDAP
        if ($groups) {
            $this->json->GenerarRespJSON($groups, count($groups));
        } else {
            $this->json->setReason('No existen grupos para este usuario');
            $this->json->GenerarMensajeJSON();
        }
    }

    public function addGroupToUser() {
        $this->load->model('grupos_model');
        $this->load->model('json');

        $group = $this->input->post("group");
        $user = $this->input->post("user");

        $grupos = $this->grupos_model->getGruposUser($user);

        $founded = array_search($group, $grupos);

        if ($founded) {
            $this->json->setReason('Este grupo ya est&aacute; asignado a este usuario');
            $this->json->GenerarMensajeJSON();
            exit();
        } else {
            if ($this->grupos_model->addGroupToUser($group, $user)) {
                $this->json->setSuccess(true);
                $this->json->GenerarMensajeJSONText();
            } else {
                $this->json->setReason('No se pudo realizar la operaci&oacute;n');
                $this->json->GenerarMensajeJSON();
            }
        }
    }

    public function removeGroupToUser() {
        $this->load->model('grupos_model');
        $this->load->model('json');

        $group = $this->input->post("grupo");
        $user = $this->input->post("usuario");

        $grupos = $this->grupos_model->getGruposUser($user);
        $i = 0;
        $esta = false;

        while ($i <= count($grupos) && !$esta) {
            if ($grupos[$i] == $group) {
                $this->grupos_model->removeGroupToUser($group, $user);
                $this->json->setSuccess(true);
                $this->json->GenerarMensajeJSONText();
                $esta = true;
                exit();
            }
            $i++;
        }

        $this->json->setReason('No se pudo realizar la operaci&oacute;n');
        $this->json->GenerarMensajeJSON();
    }

    public function getAllGroups() {
        $this->load->model('grupos_model');
        $this->load->model('json');

        $grupos = $this->grupos_model->getGrupos();

        if ($grupos) {
            $this->json->GenerarRespJSON($grupos, count($grupos));
        } else {
            $this->json->setReason('No existen grupos');
            $this->json->GenerarMensajeJSON();
        }
    }

    public function createGrupo() {
        $this->load->model('grupos_model');
        $this->load->model('json');

        $newGrupo = $this->input->post("newGrupo");
        $padreOU = $this->input->post("camino");
        $desc = $this->input->post("descripcion");
        
        $camino = substr($padreOU,strpos($padreOU, "OU"),  strlen($padreOU));
        
        if (is_string($camino)) {
            $temp = explode(",", $camino);
            
            for ($i = 0; $i < count($temp)-2; $i++) {
                if ($temp[$i] != "root") {
                    $ou[] = substr($temp[$i], strpos($temp[$i], "=")+1,  strlen($temp[$i]));
                }
            }
        }
        
        $ou = array_reverse($ou);
        
        $result = $this->grupos_model->createGrupo($newGrupo, $desc, $ou);
        if ($result) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSONText();
        } else {
            $this->json->setReason('No se pudo crear la OU');
            $this->json->GenerarMensajeJSON();
        }
    }

    public function borrarGrupo() {
        $this->load->model('grupos_model');
        $this->load->model('json');

        // autenticar con el LDAP
        if ($this->grupos_model->borrarGrupo($this->input->post("usuario"))) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSONText();
        } else {
            $this->json->setReason('No se pudo realizar la operaci&oacute;n');
            $this->json->GenerarMensajeJSON();
        }
    }

}
