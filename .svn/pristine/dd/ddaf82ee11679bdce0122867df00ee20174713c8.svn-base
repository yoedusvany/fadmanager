/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('Ldapreport.controller.Usuario', {
    extend: 'Ext.app.Controller',
    //especificar los model q manejara el controlador
    models: ['Usuario'],
    //especificar los stores q manejara el controlador
    stores: [
        'Usuario'
    ],
    //vistas que manejara el controlador
    views: [
        'FormLogin'
    ],
    //donde se inicializan todos los eventos
    init: function() {
        this.control({
            '#idButtonSumbitFormUsuario': {
                click: function(b, e, eo) {
                    var form = b.up('form').getForm();
                    if (form.isValid()) {
                        form.submit({
                            success: function(f, action) {
                                var wLogin = Ext.ComponentQuery.query('#idwLogin');
                                wLogin[0].hide();
                                
                                var vp = Ext.create('Ldapreport.view.VpFadmanager');
                                vp.show();
                                
                            },
                            failure: function(form, action) {
                                obj = Ext.decode(action.response.responseText);
                                Ext.MessageBox.show({
                                    title: 'Error',
                                    msg: obj.errors.reason,
                                    buttons: Ext.MessageBox.OK,
                                    icon: Ext.MessageBox.ERROR
                                });
                            }
                        });
                    }
                }
            },
            '#idtfPass': {
                keypress: function(t, e) {
                    if (e.getKey() === e.ENTER) {
                        var form = t.up('form').getForm();
                        if (form.isValid()) {
                            form.submit({
                                success: function(form, action) {
                                    var wLogin = Ext.ComponentQuery.query('#idwLogin');
                                    wLogin[0].hide();
                                    
                                    var vp = Ext.create('Ldapreport.view.VpFadmanager');
                                    vp.show();
                                },
                                failure: function(form, action) {
                                    Ext.MessageBox.show({
                                        title: 'Error',
                                        msg: 'Usuario o contrase&ntilde;a no v&aacute;lido.',
                                        buttons: Ext.MessageBox.OK,
                                        icon: Ext.MessageBox.ERROR
                                    });
                                }
                            });
                        }
                    }

                }
            }
        });
    }





});