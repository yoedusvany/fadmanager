Ext.define('Ldapreport.controller.Usuarios', {
    extend: 'Ext.app.Controller',
    //especificar los model q manejara el controlador
    models: ['Usuarios', 'GruposUser', 'Usuario-reporte'],
    //especificar los stores q manejara el controlador
    stores: [
        'Usuarios',
        'Grupos',
        'GruposUser',
        'UsuariosSinIniciarSesion',
        'UsuariosPasswordVencida',
        'UsuariosPassPtoVencer'
    ],
    //vistas que manejara el controlador
    views: [
        'GridUsuarios',
        'WindowAddGroup',
        'GridInfo',
        //'GridInfoUser',
        'WindowPassword',
        'VpFadmanager',
        'reportes.UsuariosSinIniciarSesion',
        'reportes.UsuariosPasswordVencida',
        'reportes.UsuariosPassPtoVencer'
    ],
    //donde se inicializan todos los eventos
    init: function () {

        this.getStore('Usuarios').on('load', function (t, r) {
            if (t.totalCount > 0) {
                var b = Ext.ComponentQuery.query('#idBModeloUsuarios');
                b[0].setDisabled(false);
            }
        });
        this.control({
//****************************************************GRUPOS****************************            
            '#idGridUsuarios': {
                cellclick: function (t, td, cellIndex, record) {
                    var b3 = Ext.ComponentQuery.query('#idBAddGroup');
                    var b4 = Ext.ComponentQuery.query('#idBChangePass');
                    //var b5 = Ext.ComponentQuery.query('#idBInfo');

                    if (record.data.tipo === "usuario") {
                        b3[0].setDisabled(false);
                        b4[0].setDisabled(false);
                        //b5[0].setDisabled(false);
                    } else {
                        b3[0].setDisabled(true);
                        b4[0].setDisabled(true);
                        //b5[0].setDisabled(true);
                    }
                }
            },
            '#idBChangePass': {
                click: function (t, e) {
                    if (Ext.getCmp("idWindowPassword")) {
                        var wR = Ext.ComponentQuery.query('#idWindowPassword');
                        wR[0].show();
                    } else {
                        var wR = Ext.create('Ldapreport.view.WindowPassword');
                        wR.show();
                    }

                    var h = Ext.ComponentQuery.query("#idhUsuario");

                    var g = Ext.ComponentQuery.query('#idGridUsuarios');
                    var record = g[0].getSelectionModel().getSelection();
                    var user = record[0].data.user;
                    h[0].setValue(user);
                    console.log(h[0]);
                }
            },
            '#idBModeloUsuarios': {
                click: function (c, r) {
                    var tree = Ext.ComponentQuery.query('#idTreePanel');
                    var ou = tree[0].getSelectionModel().getSelection();
                    var camino = tree[0].getRootNode().findChild('id', ou[0].data.id, true).getPath("text", "-");
                    //window.open(BASE_URL + "welcome/reporteUsuarios/" + c[0].getRawValue());
                    window.open(BASE_URL + "reportes/reporteUsuariosOU/" + camino);
                }
            },
            '#idtfUser': {
                keyup: function (t, e) {
                    if (t.getRawValue().length > 0) {
                        this.getStore('Usuarios').clearFilter();
                        this.getStore('Usuarios').filter('user', t.getRawValue());
                    } else {
                        this.getStore('Usuarios').clearFilter();
                    }
                }
            },
            '#idbsAgregarGrupo': {
                click: function (t, e) {
                    var combo = Ext.ComponentQuery.query('#idcGrupos');
                    var grupo = combo[0].getValue();
                    var h = Ext.ComponentQuery.query('#idhUser');
                    var user = h[0].getValue();
                    Ext.Ajax.request({
                        url: BASE_URL + 'grupos/addGroupToUser',
                        params: {
                            group: grupo,
                            user: user
                        },
                        success: function (response, options) {
                            var respuesta = Ext.decode(response.responseText);
                            if (respuesta.success == true) {
                                Ext.MessageBox.show({
                                    title: 'Informe',
                                    msg: 'Operaci&oacute;n realizada con &eacute;xito',
                                    buttons: Ext.MessageBox.OK,
                                    icon: Ext.MessageBox.OK
                                });
                                var wAddGroup = Ext.ComponentQuery.query('#idWindowAddGroup');
                                wAddGroup[0].close();
                            } else {
                                Ext.MessageBox.show({
                                    title: 'Error',
                                    msg: respuesta.errors.reason,
                                    buttons: Ext.MessageBox.OK,
                                    icon: Ext.MessageBox.ERROR
                                });
                            }
                        }
                    });
                }
            },
            '#idBAddUsuario': {
                click: function (t, e) {
                    if (Ext.isObject(Ext.getCmp('idWindowNewUser'))) {
                        Ext.getCmp('idWindowNewUser').show();
                    } else {
                        var newOU = Ext.widget('NewUser');
                        newOU.show();
                    }

                    //capturo el arbol y busco el nodo seleccionado 
                    var t = Ext.ComponentQuery.query('#idTreePanel');
                    var record = t[0].getSelectionModel().getSelection();

                    // paso el id del nodo seleccionado al campo oculto camino
                    var pathOU = Ext.ComponentQuery.query('#idfhCaminoNewUser');
                    pathOU[0].setValue(record[0].data.id);
                }
            },
            '#idBAddGroup': {
                click: function (t, e) {
                    var g = Ext.ComponentQuery.query('#idGridUsuarios');
                    var record = g[0].getSelectionModel().getSelection();
                    var user = record[0].data.user;
                    this.getStore('GruposUser').load({
                        params: {
                            user: user
                        },
                        scope: this
                    });
                    if (Ext.getCmp("idWindowAddGroup")) {
                        var wAddGroup = Ext.ComponentQuery.query('#idWindowAddGroup');
                        wAddGroup[0].show();
                        wAddGroup[0].setTitle("Adicionar Grupo al usuario: " + user);
                        this.getStore('Grupos').reload();
                    } else {
                        var wAddGroup = Ext.create('Ldapreport.view.WindowAddGroup');
                        wAddGroup.show();
                        wAddGroup.setTitle("Adicionar Grupo al usuario: " + user);
                        this.getStore('Grupos').reload();
                    }

                    var h = Ext.ComponentQuery.query('#idhUser');
                    h[0].setValue(user);
                }
            },
            '#idBGridAddGrupo': {
                click: function (t, e) {
                    if (Ext.isObject(Ext.getCmp('idWindowNewGrupo'))) {
                        Ext.getCmp('idWindowNewGrupo').show();
                    } else {
                        var newGroup = Ext.widget('NewGrupo');
                        newGroup.show();
                    }

                    //capturo el arbol y busco el nodo seleccionado 
                    var t = Ext.ComponentQuery.query('#idTreePanel');
                    var record = t[0].getSelectionModel().getSelection();

                    // paso el id del nodo seleccionado al campo oculto camino
                    var pathOU = Ext.ComponentQuery.query('#idfhCaminoNewGrupo');
                    pathOU[0].setValue(record[0].data.id);
                }
            },
            '#idbDeleteGroupForm': {
                click: function (t, e) {
                    var ms = Ext.ComponentQuery.query('#multiselect-field');
                    var grupo = ms[0].getSelected();
                    var h = Ext.ComponentQuery.query('#idhUser');
                    var user = h[0].getValue();
                    Ext.Ajax.request({
                        url: BASE_URL + "grupos/removeGroupToUser",
                        params: {
                            grupo: grupo[0].raw.grupo,
                            usuario: user
                        },
                        success: function (response) {
                            Ext.MessageBox.show({
                                title: 'Informe',
                                msg: 'Operaci&oacute;n realizada con &eacute;xito',
                                buttons: Ext.MessageBox.OK,
                                icon: Ext.MessageBox.OK
                            });
                            ms[0].getStore().reload();
                        }
                    });
                }
            },
            '#idcGrupos': {
                select: function (c, r) {
                    var b = Ext.ComponentQuery.query('#idbsAgregarGrupo');
                    b[0].setDisabled(false);
                }
            },
//****************************************************GRUPOS****************************



//////////////------------------------------------------            

            '#idBHabilitar': {
                click: function (c, r) {
                    var g = Ext.ComponentQuery.query('#idGridUsuarios');
                    var record = g[0].getSelectionModel().getSelection();
                    var user = record[0].data.user;
                    Ext.Ajax.request({
                        url: BASE_URL + "welcome/enable",
                        params: {
                            usuario: user
                        },
                        success: function (response) {
                            Ext.MessageBox.show({
                                title: 'Informe',
                                msg: 'Operaci&oacute;n realizada con &eacute;xito',
                                buttons: Ext.MessageBox.OK,
                                icon: Ext.MessageBox.OK
                            });
                        }
                    });
                }
            },
            '#idBDeshabilitar': {
                click: function (c, r) {
                    var g = Ext.ComponentQuery.query('#idGridUsuarios');
                    var record = g[0].getSelectionModel().getSelection();
                    var user = record[0].data.user;
                    Ext.Ajax.request({
                        url: BASE_URL + "welcome/disable",
                        params: {
                            usuario: user
                        },
                        success: function (response) {
                            Ext.MessageBox.show({
                                title: 'Informe',
                                msg: 'Operaci&oacute;n realizada con &eacute;xito',
                                buttons: Ext.MessageBox.OK,
                                icon: Ext.MessageBox.OK
                            });
                        }
                    });
                }
            },
            '#idRepUserXGrupo': {
                click: function () {
                    // Create the combo box, attached to the states data store
                    var combo = Ext.create('Ext.form.ComboBox', {
                        fieldLabel: 'Grupo',
                        store: this.getStore('Grupos'),
                        displayField: 'grupo',
                        valueField: 'grupo',
                        listeners: {
                            'select': function (c, r) {
                                window.open(BASE_URL + "reportes/reporteUsuariosGrupo/" + r[0].data.grupo);
                            }
                        }
                    });
                    Ext.create('Ext.window.Window', {
                        title: 'Seleccione grupo',
                        height: 80,
                        bodyStyle: {
                            padding: '5px'
                        },
                        width: 275,
                        items: [
                            combo
                        ]
                    }).show();
                }
            }
            /*'#idBInfo': {
                click: function (t, e) {
                    var w = Ext.create('Ext.window.Window', {
                        title: 'Informaci&oacute;n detallada del usuario',
                        height: '50%',
                        width: '50%',
                        iconCls: 'icon-grid',
                        layout: 'fit',
                        animateTarget: 'idBInfo',
                        items: {// Let's put an empty grid in just to illustrate fit layout
                            xtype: 'gridInfoUser'
                        }
                    });

                    w.show();
                    
                    var gUsuarios = Ext.ComponentQuery.query("#idGridUsuarios");
                    var record = gUsuarios[0].getSelectionModel().getSelection();
                    var user = record[0].data.user;

                    var g = Ext.ComponentQuery.query("#idGInfoUser");
                    g[0].getStore().load({
                        params: {
                            'user': user
                        }});
                }
            },*/
        });
    }





});