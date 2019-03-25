/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



Ext.define('Ldapreport.view.VpFadmanager', {
    extend: 'Ext.container.Viewport',
    alias: 'widget.vpFadmanager',
    renderTo: Ext.getBody(),
    layout: 'border',
    items: [
        {
            xtype: 'toolbar',
            region: 'north',
            cls: 'header',
            height: 35,
            items: [
                '<IMG SRC="' + BASE_URL + 'web/images/logo.ico">',
                '<b class="menu-title">Free Active Directory Manager (FADManager)</b>',
                '-',
                // begin using the right-justified button container
                '->', // same as { xtype: 'tbfill' }
                {
                    xtype: 'splitbutton',
                    text: 'Reportes',
                    iconCls: 'icon-reportes',
                    listeners: {
                        click: function (t) {
                            t.showMenu();
                        }
                    },
                    menu: new Ext.menu.Menu({
                        items: [
                            {
                                text: 'Usuarios sin iniciar sesi&oacute;n',
                                id: 'idRepUserSinSesion',
                                listeners: {
                                    click: function (t) {
                                        //window.open(BASE_URL + "reportes/reporteUsuariosSinInicicarSesion/");
                                        Ext.create('Ext.window.Window', {
                                            title: 'Usuarios sin iniciar sesi&oacute;n',
                                            height: '50%',
                                            width: '50%',
                                            modal: true,
                                            iconCls: 'icon-grid',
                                            layout: 'fit',
                                            animateTarget: 'idRepUserSinSesion',
                                            items: {// Let's put an empty grid in just to illustrate fit layout
                                                xtype: 'gridUsuariosSinIniciarSesion'
                                            }
                                        }).show();

                                        var g = Ext.ComponentQuery.query('#idGridUsuariosSinIniciarSesion');
                                        g[0].getStore().load();

                                    }
                                }
                            },
                            {
                                text: 'Usuarios dado un Grupo',
                                id: 'idRepUserXGrupo'
                            },
                            {
                                text: 'Usuarios con contrase&ntilde;a vencida',
                                id: 'idRepUserPassVencida',
                                listeners: {
                                    click: function (t) {
                                        //window.open(BASE_URL + "reportes/reporteUsuariosSinInicicarSesion/");
                                        Ext.create('Ext.window.Window', {
                                            title: 'Usuarios con contrase&ntilde;a vencida',
                                            height: '50%',
                                            width: '50%',
                                            modal: true,
                                            iconCls: 'icon-grid',
                                            layout: 'fit',
                                            animateTarget: 'idRepUserPassVencida',
                                            items: {// Let's put an empty grid in just to illustrate fit layout
                                                xtype: 'gridUsuariosPasswordVencida'
                                            }
                                        }).show();

                                        var g = Ext.ComponentQuery.query('#idGridUsuariosPasswordVencida');
                                        g[0].getStore().load();
                                    }
                                }
                            },
                            {
                                text: 'Usuarios con contrase&ntilde;a a punto de vencer',
                                id: 'idRepUserPassPtoVencer',
                                listeners: {
                                    click: function (t) {
                                        //window.open(BASE_URL + "reportes/reporteUsuariosSinInicicarSesion/");
                                        var w = Ext.create('Ext.window.Window', {
                                            title: 'Usuarios con contrase&ntilde;a a punto de vencer',
                                            height: '50%',
                                            width: '50%',
                                            iconCls: 'icon-grid',
                                            layout: 'fit',
                                            animateTarget: 'idRepUserPassPtoVencer',
                                            items: {// Let's put an empty grid in just to illustrate fit layout
                                                xtype: 'gridUsuariosPassPtoVencer'
                                            }
                                        });
                                        
                                        w.show();

                                        var g = Ext.ComponentQuery.query('#idGridUsuariosPassPtoVencer');
                                        g[0].getStore().load(function (records, operation, success) {
                                            console.log(success);
                                            if (success == false) {
                                                Ext.MessageBox.show({
                                                    title: 'Error',
                                                    msg: 'No existen usuarios con password a punto de vencer',
                                                    buttons: Ext.MessageBox.OK,
                                                    icon: Ext.MessageBox.ERROR
                                                });
                                                w.hide();
                                            }
                                        });
                                    }
                                }
                            }, {
                                text: 'Info. General',
                                id: 'idbInfo',
                                iconCls: 'icon-info',
                                listeners: {
                                    click: function (t, e) {
                                        var temp = Ext.create('Ext.window.Window', {
                                            title: 'Informaci&oacute;n general sobre totales de usuarios',
                                            titleAlign: 'center',
                                            height: 350,
                                            width: 450,
                                            layout: 'fit',
                                            animateTarget: 'idbInfo',
                                            items: {
                                                xtype: 'gridInfo'
                                            }
                                        }).show();

                                        var g = Ext.ComponentQuery.query("#idGInfo");
                                        g[0].getStore().load();

                                    }
                                }
                            }
                        ]
                    })
                },
                '-',
                {
                    xtype: 'splitbutton',
                    text: 'Opciones',
                    iconCls: 'icon-options',
                    listeners: {
                        click: function (t) {
                            t.showMenu();
                        }
                    },
                    menu: new Ext.menu.Menu({
                        items: [
                            {
                                text: 'Cerrar sesi&oacute;n',
                                id: 'idSalir',
                                iconCls: 'icon-salir',
                                listeners: {
                                    click: function () {
                                        window.location = BASE_URL + 'welcome/cerrarSesion';
                                    }
                                }
                            }
                        ]
                    })
                }
            ]
        },
        {
            xtype: 'treeLdapPanel'

        }, {
            xtype: 'gridUsuarios',
            region: 'center'
        }
    ]
});