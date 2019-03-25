<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>FADMANAGER - CAMBIO DE CONTRASE&Ntilde;A</title>

        <link rel="stylesheet" type="text/css" href="<? echo base_url(); ?>web/ext4/resources/css/ext-all-neptune.css" />
        <script type="text/javascript" src="<? echo base_url(); ?>web/ext4/bootstrap.js"></script>
        <script type="text/javascript" src="<? echo base_url(); ?>web/ext4/ext-theme-neptune.js"></script>
        <script type="text/javascript" src="<? echo base_url(); ?>web/ext4/locale/ext-lang-es.js"></script>

        <script language="javascript">
            if (history.forward(1)) {
                location.replace(history.forward(1))
            }
        </script>

        <script type="text/javascript">
            var BASE_URL = "<? echo base_url(); ?>";
            Ext.onReady(function () {

                Ext.create('Ext.form.Panel', {
                    title: 'Actualizar Contrase&ntilde;a',
                    height: 280,
                    width: 415,
                    renderTo: 'idBody',
                    //layout: 'vbox',
                    msgTarget: 'none',
                    url: BASE_URL + 'welcome/changePasswordOut',
                    bodyPadding: 10,
                    method: 'POST',
                    defaults: {
                        labelWidth: 200,
                        msgTarget: 'side'
                    },
                    iconCls: 'icon-usuario', header: {
                        titlePosition: 2,
                        titleAlign: 'center'
                    },
                    items: [{
                            xtype: 'textareafield',
                            grow: true,
                            width: '100%',
                            disabled: true,
                            value: 'Recuerde que la contraseña debe tener 7 caracteres al menos. Además debe poseer al menos 1 mayúscula, minúscula y otro tipo de caracter, como números.'
                        }, {
                            xtype: 'textfield',
                            fieldLabel: 'Usuario',
                            name: 'usuario',
                            id: 'idUsuario',
                            allowBlank: false
                        }, {
                            xtype: 'textfield',
                            fieldLabel: 'Contrase&ntilde;a Actual',
                            name: 'passActual',
                            inputType: 'password',
                            id: 'idPassActual',
                            minLength: 7,
                            maxLength: 50,
                            allowBlank: false
                        }, {
                            xtype: 'textfield',
                            fieldLabel: 'Contrase&ntilde;a',
                            name: 'passNueva',
                            id: 'idPassNew',
                            inputType: 'password',
                            minLength: 7,
                            maxLength: 50,
                            allowBlank: false
                        }, {
                            xtype: 'textfield',
                            fieldLabel: 'Confirmar Contrase&ntilde;a',
                            name: 'passConfirm',
                            inputType: 'password',
                            id: 'passnewConfirm',
                            minLength: 7,
                            maxLength: 50,
                            allowBlank: false
                        }],
                    buttons: [
                        {
                            text: 'Resetear',
                            iconCls: 'icon-cancel',
                            handler: function () {
                                this.up('form').getForm().reset();
                            }
                        }, {
                            text: 'Actualizar',
                            id: 'idButtonSumbitFormPassword',
                            iconCls: 'icon-add',
                            formBind: true, //only enabled once the form is valid
                            disabled: true,
                            handler: function () {
                                var form = this.up('form').getForm();
                                if (form.isValid()) {
                                    form.submit({
                                        success: function (form, action) {
                                            Ext.MessageBox.show({
                                                title: 'Informe',
                                                msg: 'Operaci&oacute;n realizada con &eacute;xito',
                                                buttons: Ext.MessageBox.OK,
                                                icon: Ext.MessageBox.INFO
                                            });
                                            
                                            form.reset();
                                        },
                                        failure: function (form, action) {
                                            Ext.Msg.alert('Failed', action.result.msg);
                                        }
                                    });
                                }
                            }
                        }]

                }).show();


            });
        </script>

        <style type="text/css">
            .menu-title{
                margin:-2px -2px 0;
                color:#FFFFFF;
                font:bold 15px tahoma,arial,verdana,sans-serif;
                display:block;
                padding:3px;
            }

            .header {
                background:#7F99BE url(<?php echo base_url(); ?>web/images/layout-browser-hd-bg.gif) repeat-x scroll center center;
            }

            .icon-form {
                background-image:url(<?php echo base_url(); ?>web/images/application_go.png) !important;
            }

            .icon-reset {
                background-image:url(<?php echo base_url(); ?>web/images/reset.png) !important;
            }

            .icon-cancel {
                background-image:url(<?php echo base_url(); ?>web/images/cancel.gif) !important;
            }




            .icon-delete {
                background-image:url(<?php echo base_url(); ?>web/images/delete.gif) !important;
            }
            .icon-add {
                background-image:url(<?php echo base_url(); ?>web/images/add.png) !important;
            }
            .icon-rtf {
                background-image:url(<?php echo base_url(); ?>web/images/report_add.png) !important;
            }
            .icon-options {
                background-image:url(<?php echo base_url(); ?>web/images/options.ico) !important;
            }
            .icon-salir {
                background-image:url(<?php echo base_url(); ?>web/images/salir.png) !important;
            }
            .icon-filtro {
                background-image:url(<?php echo base_url(); ?>web/images/filtro.png) !important;
            }
            .icon-addgrupo {
                background-image:url(<?php echo base_url(); ?>web/images/addgrupo.ico) !important;
            }
            .icon-info {
                background-image:url(<?php echo base_url(); ?>web/images/info.png) !important;
            }
            .icon-reportes {
                background-image:url(<?php echo base_url(); ?>web/images/verReportes2.ico) !important;
            }
            .icon-usuario {
                background-image:url(<?php echo base_url(); ?>web/images/usuario.ico) !important;
            }
            .icon-grid {
                background-image:url(<?php echo base_url(); ?>web/images/grid.png) !important;
            }

        </style>

    </head>
    <body>
        <div id="idBody" align="center">
        </div>
    </body>
</html>