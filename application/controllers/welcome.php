<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('welcome_message');
        //$this->load->view('login');
    }

    public function indexChangePasswordOut() {
        $this->load->view('change_password');
    }

    /* public function app() {
      if ($this->session->userdata('log') == 1) {
      $data["usuario"] = $this->session->userdata('usuario');
      $this->load->view('welcome_message', $data);
      } else {
      $this->session->sess_destroy();
      redirect('/', 'location');
      }
      } */

//**************************USUARIOS******************************************** 
    public function authenticate() {
        $this->load->model('usuarios_model');
        $this->load->model('json');

        $pass = $this->input->post("pass");
        $user = $this->input->post("usuario");

        $usuarios = array("", "maite", "orielhg");

        $result = $this->usuarios_model->autenticar($user, $pass);

        if ($result == 1 or $result == true) {
            $founded = array_search($user, $usuarios);
            if ($founded) {
                $this->session->set_userdata('log', '1');
                $this->session->set_userdata('usuario', $user);
                $this->json->setSuccess(true);
                $this->json->GenerarMensajeJSONText();
            } else {
                $this->session->sess_destroy();
                $this->json->setReason('Este usuario no está autorizado');
                $this->json->GenerarMensajeJSON();
            }
        } else {
            $this->session->sess_destroy();
            $this->json->setReason('Usuario o contrase&ntilde;a incorrecta');
            $this->json->GenerarMensajeJSON();
        }
    }

    public function enable() {
        $this->load->model('usuarios_model');
        $this->load->model('json');

        // autenticar con el LDAP
        if ($this->usuarios_model->enable($this->input->post("usuario"))) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSONText();
        } else {
            $this->json->setReason('No se pudo realizar la operaci&oacute;n');
            $this->json->GenerarMensajeJSON();
        }
    }

    public function disable() {
        $this->load->model('usuarios_model');
        $this->load->model('json');

        // autenticar con el LDAP
        if ($this->usuarios_model->disable($this->input->post("usuario"))) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSONText();
        } else {
            $this->json->setReason('No se pudo realizar la operaci&oacute;n');
            $this->json->GenerarMensajeJSON();
        }
    }

    public function passwordVence() {
        $this->load->model('usuarios_model');
        $this->load->library('email');

        //capturo todos los usuarios
        //$usuarios = $this->usuarios_model->getMembersofGroup('nac');
        //$usuarios1 = $this->usuarios_model->getMembersofGroup('inter');
        //mezclo los usuarios
        //$users = array_merge($usuarios, $usuarios1);
        $users = $this->usuarios_model->getAllUsers();

        //capturo la fecha actual
        $fecha_actual = getdate();

        for ($i = 0; $i < count($users); $i++) {
            //busco la fecha de vencimiento de password de cada usuario
            $vence = $this->usuarios_model->getPasswordVence($users[$i]);

            if ($vence != "Does not expire" && $vence != 'Password has expired' && $vence != "Domain does not expire passwords") {
                $segundos_diferencia = $fecha_actual[0] - $vence["expiryts"];
                $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
                $dias_diferencia = abs($dias_diferencia);
                $dias_diferencia = floor($dias_diferencia);

                if ($dias_diferencia <= 20) {

                    //busco si el usuario tiene definido el campo email en el AD.
                    $mail = $this->usuarios_model->getMail($users[$i]);

                    if (isset($mail[0]["mail"][0])) {
                        //le envio correo a cada usuario informandole q la passwoed esta a punto de expirar
                        $this->email->from('telematicos@unica.cu', 'Dpto. de Redes UNICA');
                        $this->email->to($mail[0]["mail"][0]);
                        $this->email->subject('GRUPO DE REDES: Contraseña a punto de expirar');
                        $this->email->message('Saludos, se le informa que su contrase&ntilde;a est&aacute; a punto de expirar, le resta(n) ' . $dias_diferencia . ' d&iacute;a(s),
                      cambie la contrase&ntilde;a a trav&eacute;s del servicio online <a href="https://fadmanager.unica.cu/welcome/indexChangePasswordOut">https://fadmanager.unica.cu/welcome/indexChangePasswordOut</a>. <br>
                      Este correo no es un correo spam, es generado por el nuevo sistema Free Active Directory Manager (Administrador Libre para el Directorio Activo). Muchas gracias.');
                        $this->email->send();
                    }
                }
            }
        }

        //mando copia a los administradores para que sepan que el script se ha ejecutado.
        $this->email->from('telematicos@unica.cu', 'Dpto. de Redes UNICA');
        $this->email->to("redes@unica.cu");
        $this->email->subject('GRUPO DE REDES: Se ha enviado el correo de pass');
        $this->email->message('Se ha enviado el correo de pass');
        $this->email->send();
    }

    public function passwordExpira($user) {
        $this->load->model('usuarios_model');
        $this->load->model('json');

        $fecha = $this->usuarios_model->getPasswordVence($user);
        $expiryts = $fecha["expiryts"];
        $expiryformat = $fecha["expiryformat"];

        header('Content-Type: text/javascript');
        echo 'Ext.data.JsonP.callback1({ "data": [{ "expiryts": "' . $expiryts . '","expiryformat": "' . $expiryformat . '"}]})';
    }

    public function changePassword() {
        $this->load->model('usuarios_model');
        $this->load->model('json');

        $usuario = $this->input->post("usuario");
        $pass = $this->input->post("passNueva");

        if ($this->usuarios_model->changePassword($usuario, $pass)) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSONText();
        } else {
            $this->json->setReason('No se pudo realizar la operaci&oacute;n');
            $this->json->GenerarMensajeJSON();
        }
    }

    public function changePasswordOut() {
        $this->load->model('usuarios_model');
        $this->load->model('json');

        $usuario = $this->input->post("usuario");
        $pass = $this->input->post("passNueva");
        $passActual = $this->input->post("passActual");

        //busco si el usuario lo pusieron con el sufijo de dominio, si es asi devuelvo el nick nada mas.
        if (strpos($usuario, "@")) {
            $usuario = substr($usuario, 0, strpos($usuario, "@"));
        }

        if ($this->usuarios_model->autenticar($usuario, $passActual)) {
            if ($this->usuarios_model->changePassword($usuario, $pass)) {
                $this->json->setSuccess(true);
                $this->json->GenerarMensajeJSONText();
            } else {
                $this->json->setReason('No se pudo realizar la operaci&oacute;n');
                $this->json->GenerarMensajeJSON();
            }
        } else {
            $this->json->setReason('El usuario o la contrase&ntilde;a es incorrecta');
            $this->json->GenerarMensajeJSON();
        }
    }

    public function borrarUsuario() {
        $this->load->model('usuarios_model');
        $this->load->model('json');

        // autenticar con el LDAP
        if ($this->usuarios_model->borrarUsuario($this->input->post("usuario"))) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSONText();
        } else {
            $this->json->setReason('No se pudo realizar la operaci&oacute;n');
            $this->json->GenerarMensajeJSON();
        }
    }

    public function crearUsuario() {
        $this->load->model('usuarios_model');
        $this->load->model('json');

        $camino = substr($this->input->post("camino"), strpos($this->input->post("camino"), "OU"), strlen($this->input->post("camino")));

        if (is_string($camino)) {
            $temp = explode(",", $camino);

            for ($i = 0; $i < count($temp) - 2; $i++) {
                if ($temp[$i] != "root") {
                    $ou[] = substr($temp[$i], strpos($temp[$i], "=") + 1, strlen($temp[$i]));
                }
            }
        }

        $ou = array_reverse($ou);

        $attributes = array(
            "username" => strtolower($this->input->post("username")),
            "logon_name" => $this->input->post("username") . "@unica.cu",
            "firstname" => $this->input->post("name"),
            "surname" => $this->input->post("apellidos"),
            "company" => "UNICA",
            "department" => "UNICA",
            "email" => strtolower($this->input->post("mail")),
            "container" => $ou,
            "enabled" => 1,
            "password" => $this->input->post("password")
        );

        if ($this->usuarios_model->createUsuario($attributes)) {
            $this->json->setSuccess(true);
            $this->json->GenerarMensajeJSONText();
        } else {
            $this->json->setReason('No se pudo realizar la operaci&oacute;n');
            $this->json->GenerarMensajeJSON();
        }
    }

    public function infoUsuario($user) {
        $this->load->model('usuarios_model');
        $this->load->model('json');

        $info = $this->usuarios_model->infoUsuario($user);
        return $info;
    }

    public function info() {
        $this->load->model('usuarios_model');
        $this->load->model('grupos_model');
        $this->load->model('json');

        $cantTotal = 0;

        $grupos = $this->grupos_model->getGrupos();

        for ($i = 0; $i <= count($grupos) - 1; $i++) {
            $temp = $this->usuarios_model->getUsersofGroup($grupos[$i]["grupo"]);

            if ($temp) {
                $info["grupo"] = $grupos[$i]["grupo"];
                $info["cantidad"] = count($temp);
                $data[] = $info;
            }
        }

        $this->json->GenerarRespJSON($data, count($data));
    }

    public function cerrarSesion() {
        $this->session->sess_destroy();
        redirect('/', 'location');
    }

    public function allUsers() {
        $this->load->model('usuarios_model');
        $this->load->model('json');

        $info = $this->usuarios_model->getAllUsers();

        $this->json->GenerarRespJSON($info, count($info));
    }

    public function usuariosSinIniciarSesion() {
        $this->load->model('usuarios_model');
        $this->load->model('json');

        $info = $this->usuarios_model->usuariosSinIniciarSesion();

        $this->json->GenerarRespJSON($info, count($info));
    }

    public function usuariosPasswordVencida() {
        $this->load->model('usuarios_model');
        $this->load->model('json');

        $info = $this->usuarios_model->getUsersPassVencida();

        for ($i = 0; $i < count($info); $i++) {
            $user = $this->infoUsuario($info[$i]);
            $data["user"] = $user[0]['samaccountname'][0];

            if (isset($users[0]["displayname"][0])) {
                $data["displayName"] = $users[0]["displayname"][0];
            } else {
                $data["displayName"] = "NO ESPECIFICADO";
            }

            if (!isset($info[0]["lastlogontimestamp"][0])) {
                $data["fechaCreado"] = substr($user[0]["whencreated"][0], 0, 8);
            }

            $objects[] = $data;
        }

        $this->json->GenerarRespJSON($objects, count($objects));
    }

    public function usuariosPassPtoVencer() {
        $this->load->model('usuarios_model');
        $this->load->model('json');

        $info = $this->usuarios_model->getUsersPassPtoVencer();

        if ($info) {
            for ($i = 0; $i < count($info); $i++) {
                $user = $this->infoUsuario($info[$i]);
                $data["user"] = $user[0]['samaccountname'][0];

                if (isset($users[0]["displayname"][0])) {
                    $data["displayName"] = $users[0]["displayname"][0];
                } else {
                    $data["displayName"] = "NO ESPECIFICADO";
                }

                if (!isset($info[0]["lastlogontimestamp"][0])) {
                    $data["fechaCreado"] = substr($user[0]["whencreated"][0], 0, 8);
                }

                $objects[] = $data;
            }
            $this->json->GenerarRespJSON($objects, count($objects));
        } else {
            $this->json->setReason('No se pudo realizar la operaci&oacute;n');
            $this->json->GenerarMensajeJSON();
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
