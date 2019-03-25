Ext.define('Ldapreport.controller.TreeLdap', {
    extend: 'Ext.app.Controller',
    //especificar los model q manejara el controlador
    models: ['TreeLdap'],
    //especificar los stores q manejara el controlador
    stores: [
        //'TreeLdap'
    ],
    //vistas que manejara el controlador
    views: [
        'TreePanel',
        'NewOU',
        'NewGrupo',
        'NewUser'
    ],
    //donde se inicializan todos los eventos
    init: function () {
        this.control({
            '#idTreePanel': {
                itemexpand: function (t) {
                    var b = Ext.ComponentQuery.query("#idBAddUsuario");
                    b[0].setDisabled(false);
                    var b1 = Ext.ComponentQuery.query("#idBGridAddGrupo");
                    b1[0].setDisabled(false);
                    
                    var camino = t.getPath("text");
                    var tree = Ext.ComponentQuery.query('#idTreePanel');
                    tree[0].getSelectionModel().select(t);

                    Ext.Ajax.request({
                        disableCaching: true,
                        url: BASE_URL + 'ou/getOUs/',
                        params: {
                            "camino": camino
                        },
                        success: function (response) {
                            var text = Ext.decode(response.responseText);
                            if (text.total > 0) {
                                Ext.each(text.data, function (name) {
                                    if (!Ext.isObject(t.findChild('id', name.id))) {
                                        t.appendChild(name);
                                    }
                                });

                            }
                        }
                    });

                    var grid = Ext.ComponentQuery.query("#idGridUsuarios");
                    grid[0].getStore().removeAll();
                    grid[0].getStore().load({
                        params: {
                            "camino": camino
                        }
                    });
                },
                itemclick: function (t, r) {
                    var b = Ext.ComponentQuery.query("#idBAddUsuario");
                    b[0].setDisabled(false);
                    var b1 = Ext.ComponentQuery.query("#idBGridAddGrupo");
                    b1[0].setDisabled(false);
                    
                    var tree = Ext.ComponentQuery.query('#idTreePanel');
                    var camino = tree[0].getRootNode().findChild('id', r.data.id, true).getPath("text");
                    tree[0].getSelectionModel().select(tree[0].getRootNode().findChild('id', r.data.id, true));

                    var grid = Ext.ComponentQuery.query("#idGridUsuarios");
                    grid[0].getStore().removeAll();
                    grid[0].getStore().load({
                        params: {
                            "camino": camino
                        }
                    });
                },
                afterrender: function (t) {
                    var camino = t.getRootNode().data.id;

                    Ext.Ajax.request({
                        disableCaching: true,
                        url: BASE_URL + 'ou/getOUs/',
                        success: function (response) {
                            var text = Ext.decode(response.responseText);
                            if (text.total > 0) {
                                Ext.each(text.data, function (name) {
                                    t.getRootNode().appendChild(name);
                                });

                            }
                        }
                    });
                },
                itemcontextmenu: function (t, record, item, index, e, eOpts) {
                    scope: this;
                    var contextMenu = Ext.create('Ext.menu.Menu', {
                        items: [
                            {
                                text: 'Crear OU',
                                iconCls: 'icon-addou',
                                handler: function () {
                                    if (Ext.isObject(Ext.getCmp('idWindowNewOU'))) {
                                        console.log("AAAA");
                                        Ext.getCmp('idWindowNewOU').show();
                                    } else {
                                        var newOU = Ext.widget('NewOU');
                                        newOU.show();
                                    }

                                    var pathOU = Ext.ComponentQuery.query('#idfhCaminoNewOU');
                                    pathOU[0].setValue(record.data.id);
                                }
                            }, {
                                text: 'Crear Grupo',
                                iconCls: 'icon-addgroup',
                                handler: function () {
                                    if (Ext.isObject(Ext.getCmp('idWindowNewGrupo'))) {
                                        Ext.getCmp('idWindowNewGrupo').show();
                                    } else {
                                        var newGroup = Ext.widget('NewGrupo');
                                        newGroup.show();
                                    }

                                    var pathOU = Ext.ComponentQuery.query('#idfhCaminoNewGrupo');
                                    pathOU[0].setValue(record.data.id);
                                }
                            }, {
                                text: 'Crear Usuario',
                                iconCls: 'icon-adduser',
                                handler: function () {
                                    if (Ext.isObject(Ext.getCmp('idWindowNewUser'))) {
                                        Ext.getCmp('idWindowNewUser').show();
                                    } else {
                                        var newUser = Ext.widget('NewUser');
                                        newUser.show();
                                    }

                                    var pathOU = Ext.ComponentQuery.query('#idfhCaminoNewUser');
                                    pathOU[0].setValue(record.data.id);
                                }
                            }, {
                                text: 'Eliminar OU',
                                iconCls: 'icon-delete',
                                handler: function () {
                                    var tree = Ext.ComponentQuery.query('#idTreePanel');
                                    var node = tree[0].getRootNode().findChild('id', record.data.id, true);
                                    var nodeParent = node.parentNode;

                                    Ext.Ajax.request({
                                        disableCaching: true,
                                        url: BASE_URL + 'ou/borrarOU/',
                                        params: {
                                            "camino": node.getPath('text')
                                        },
                                        success: function (response) {
                                            var respuesta = Ext.decode(response.responseText);
                                            if (respuesta.success == true) {
                                                Ext.MessageBox.show({
                                                    title: 'Informe',
                                                    msg: 'Operaci&oacute;n realizada con &eacute;xito',
                                                    buttons: Ext.MessageBox.OK,
                                                    icon: Ext.MessageBox.OK
                                                });

                                                nodeParent.removeChild(node);
                                                tree[0].collapseAll();
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
                            }]
                    });

                    e.stopEvent();
                    contextMenu.showAt(e.getXY());
                    return false;
                }
            }

            , '#idbsNewOU': {
                click: function (t) {
                    Ext.getCmp('idWindowNewOU').getEl().mask("Creando...");

                    var pathOU = Ext.ComponentQuery.query('#idfhCaminoNewOU');
                    var newOU = Ext.ComponentQuery.query('#idtfNewOU');

                    Ext.Ajax.request({
                        disableCaching: true,
                        url: BASE_URL + 'ou/createOU/',
                        params: {
                            "newOU": newOU[0].getValue(),
                            "camino": pathOU[0].getValue()
                        },
                        success: function (response) {
                            var respuesta = Ext.decode(response.responseText);
                            if (respuesta.success == true) {
                                Ext.MessageBox.show({
                                    title: 'Informe',
                                    msg: 'Operaci&oacute;n realizada con &eacute;xito',
                                    buttons: Ext.MessageBox.OK,
                                    icon: Ext.MessageBox.OK
                                });

                                Ext.getCmp('idWindowNewOU').getEl().unmask();

                                var t = Ext.ComponentQuery.query('#idTreePanel');
                                t[0].collapseAll();
                                Ext.getCmp('idWindowNewOU').close();
                            } else {
                                Ext.MessageBox.show({
                                    title: 'Error',
                                    msg: respuesta.errors.reason,
                                    buttons: Ext.MessageBox.OK,
                                    icon: Ext.MessageBox.ERROR
                                });

                                Ext.getCmp('idWindowNewOU').getEl().unmask();
                            }


                        }
                    });
                }
            }
            , '#idbCancelNewOU': {
                click: function (t) {
                    var pathOU = Ext.ComponentQuery.query('#idfhCaminoNewOU');
                    var newOU = Ext.ComponentQuery.query('#idtfNewOU');
                    pathOU[0].reset();
                    newOU[0].reset();

                    var w = Ext.ComponentQuery.query('#idWindowNewOU');
                    w[0].close();
                }
            }
            , '#idbsNewGrupo': {
                click: function (t) {
                    Ext.getCmp('idWindowNewGrupo').getEl().mask("Creando...");

                    var pathOU = Ext.ComponentQuery.query('#idfhCaminoNewGrupo');
                    var newGrupo = Ext.ComponentQuery.query('#idtfNewGrupo');
                    var desc = Ext.ComponentQuery.query('#idtfDesc');

                    Ext.Ajax.request({
                        disableCaching: true,
                        url: BASE_URL + 'grupos/createGrupo/',
                        params: {
                            "newGrupo": newGrupo[0].getValue(),
                            "camino": pathOU[0].getValue(),
                            "descripcion": desc[0].getValue()
                        },
                        success: function (response) {
                            var result = Ext.decode(response.responseText);

                            if (result.success) {
                                Ext.Msg.show(
                                        {
                                            title: 'Informaci&oacute;n',
                                            msg: 'Grupo creado', //mensaje de la inserción
                                            buttons: Ext.Msg.OK,
                                            icon: Ext.MessageBox.INFO
                                        });


                                Ext.getCmp('idWindowNewGrupo').getEl().unmask();

                                //var t = Ext.ComponentQuery.query('#idTreePanel');
                                //t[0].collapseAll();

                                var grid = Ext.ComponentQuery.query("#idGridUsuarios");
                                grid[0].getStore().removeAll();
                                grid[0].getStore().reload({
                                    params: {
                                        "camino": pathOU[0].getValue(),
                                        "reload": true
                                    }
                                });

                                pathOU[0].reset();
                                newGrupo[0].reset();
                                desc[0].reset();

                                Ext.getCmp('idWindowNewGrupo').close();
                            } else {
                                Ext.Msg.show({
                                    title: 'Error',
                                    msg: "Grupo existente o se produjo un error de red inesperado.",
                                    buttons: Ext.Msg.OK,
                                    icon: Ext.Msg.ERROR
                                });
                                Ext.getCmp('idWindowNewGrupo').getEl().unmask();
                            }
                        }
                    });
                }
            }
            , '#idbCancelNewGrupo': {
                click: function (t) {
                    var pathOU = Ext.ComponentQuery.query('#idfhCaminoNewGrupo');
                    var newGrupo = Ext.ComponentQuery.query('#idtfNewGrupo');
                    var desc = Ext.ComponentQuery.query('#idtfDesc');

                    pathOU[0].reset();
                    newGrupo[0].reset();
                    desc[0].reset();

                    var w = Ext.ComponentQuery.query('#idWindowNewGrupo');
                    w[0].close();
                }
            }
            , '#idbsNewUser': {
                click: function (t) {
                    var pathOU = Ext.ComponentQuery.query('#idfhCaminoNewUser');
                    var username = Ext.ComponentQuery.query('#idtfUsername');
                    var name = Ext.ComponentQuery.query('#idtfName');
                    var apellidos = Ext.ComponentQuery.query('#idtfApellidos');
                    var mail = Ext.ComponentQuery.query('#idtfMail');
                    var password = Ext.ComponentQuery.query('#idtfPassword');

                    if (username != '' && name != '' && apellidos != '' && mail != '') {
                        Ext.getCmp('idWindowNewUser').getEl().mask("Creando...");

                        Ext.Ajax.request({
                            disableCaching: true,
                            url: BASE_URL + 'welcome/crearUsuario/',
                            params: {
                                "username": username[0].getValue(),
                                "camino": pathOU[0].getValue(),
                                "name": name[0].getValue(),
                                "apellidos": apellidos[0].getValue(),
                                "mail": mail[0].getValue(),
                                "password": password[0].getValue()
                            },
                            success: function (response) {
                                var result = Ext.decode(response.responseText);

                                if (result.success) {
                                    Ext.Msg.show(
                                            {
                                                title: 'Informaci&oacute;n',
                                                msg: 'Usuario creado', //mensaje de la inserción
                                                buttons: Ext.Msg.OK,
                                                icon: Ext.MessageBox.INFO
                                            });
                                    Ext.getCmp('idWindowNewUser').getEl().unmask();

                                    var grid = Ext.ComponentQuery.query("#idGridUsuarios");
                                    grid[0].getStore().removeAll();
                                    grid[0].getStore().reload({
                                        params: {
                                            "camino": pathOU[0].getValue(),
                                            "reload": true
                                        }
                                    });

                                    pathOU[0].reset();
                                    username[0].reset();
                                    name[0].reset();
                                    apellidos[0].reset();
                                    mail[0].reset();
                                    password[0].reset();

                                    Ext.getCmp('idWindowNewUser').close();
                                } else {
                                    Ext.Msg.show({
                                        title: 'Error',
                                        msg: "Usuario existente o se produjo un error de red inesperado.",
                                        buttons: Ext.Msg.OK,
                                        icon: Ext.Msg.ERROR
                                    });
                                    Ext.getCmp('idWindowNewUser').getEl().unmask();
                                }

                            }
                        });
                    } else {
                        Ext.Msg.show({
                            title: 'Error',
                            msg: "Error al crear el usuario.",
                            buttons: Ext.Msg.OK,
                            icon: Ext.Msg.ERROR
                        });
                    }
                }
            }
        });
    }
});