/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('Ldapreport.controller.Password', {
    extend: 'Ext.app.Controller',
    views: [
        'FormPassword',
        'WindowPassword'
    ],
    //donde se inicializan todos los eventos
    init: function() {
        this.control({
            '#idButtonSumbitFormPassword': {
                click: function(b, e, eo) {
                    //var user = Ext.ComponentQuery.query('#idUsuario');
                    //var passActual = Ext.ComponentQuery.query('#idPassActual');
                    //var passNueva = Ext.ComponentQuery.query('#idPassNew');

                    var form = b.up('form').getForm();
                    if (form.isValid()) {
                        form.submit({
                            success: function(f, action) {
                                Ext.MessageBox.show({
                                    title: 'Informaci&oacute;n',
                                    msg: 'Contrase&ntilde;a actualizada correctamente',
                                    buttons: Ext.MessageBox.OK,
                                    icon: Ext.MessageBox.INFO
                                });
                            },
                            failure: function() {        //task on failed request    
                                Ext.MessageBox.show({
                                    title: 'Informaci&oacute;n',
                                    msg: 'No se ha podido realizar la operaci&oacute;n',
                                    buttons: Ext.MessageBox.OK,
                                    icon: Ext.MessageBox.INFO
                                });
                            }
                        });
                    }
                }
            },
            '#idWindowRequerimientos': {
                close: function(p) {
                    if (Ext.getCmp("idWindowPassword")) {
                        var w = Ext.ComponentQuery.query('#idWindowPassword');
                        w[0].show();
                    } else {
                        var wR = Ext.create('Ldapreport.view.WindowPassword');
                        wR.show();
                    }

                }
            },
            '#idButtonCerrar': {
                click: function() {
                    var w = Ext.ComponentQuery.query('#idWindowRequerimientos');
                    var checkbox = Ext.ComponentQuery.query('#checkRequerimientos');

                    if (checkbox[0].getValue() === true) {
                        w[0].close();
                    } else {
                        Ext.MessageBox.show({
                            title: 'Error',
                            msg: 'Debe leerse los requerimientos y marcar la caja de chequeo.',
                            buttons: Ext.MessageBox.OK,
                            icon: Ext.MessageBox.ERROR
                        });
                    }
                }
            },
            '#idButtonCerrarPass': {
                click: function(p) {
                    var w = Ext.ComponentQuery.query('#idWindowPassword');
                    w[0].hide();
                }
            }
        });
    }





});