/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define("Ldapreport.view.GridUsuarios", {
    extend: 'Ext.grid.Panel',
    alias: "widget.gridUsuarios",
    //configuracion del grid
    title: 'Usuarios UNICA',
    id: 'idGridUsuarios',
    stripeRows: true,
    store: "Usuarios",
    iconCls: 'icon-grid',
    dockedItems: [
        {
            xtype: 'toolbar',
            items: [
                {
                    text: 'Filtros',
                    iconCls: 'icon-filtro'
                },
                '-',
                {
                    xtype: 'textfield',
                    id: 'idtfUser',
                    name: 'usuario',
                    enableKeyEvents: true,
                    labelWidth: 120,
                    fieldLabel: 'Usuario espec&iacute;fico'
                },
                "-",
                {
                    xtype: 'button',
                    text: 'Adicionar Usuario',
                    iconCls: 'icon-adduser',
                    disabled: true,
                    id: 'idBAddUsuario'
                },
                {
                    xtype: 'button',
                    text: 'Adicionar Grupo',
                    iconCls: 'icon-addgroup',
                    disabled: true,
                    id: 'idBGridAddGrupo'
                }
            ]
        },
        {
            xtype: 'pagingtoolbar',
            store: 'Usuarios',
            dock: 'bottom',
            displayInfo: true,
            items: [
                {
                    xtype: 'button',
                    text: 'RTF',
                    iconCls: 'icon-rtf',
                    disabled: true,
                    id: 'idBModeloUsuarios'
                },
                "-",
                {
                    xtype: 'button',
                    text: 'Resetear Password',
                    iconCls: 'icon-password',
                    disabled: true,
                    id: 'idBChangePass'
                },
                {
                    xtype: 'button',
                    text: 'Incluir en Grupo...',
                    iconCls: 'icon-addgroupuser',
                    disabled: true,
                    id: 'idBAddGroup'
                },
                '-'/*,
                {
                    xtype: 'button',
                    text: 'Info',
                    iconCls: 'icon-info',
                    disabled: true,
                    id: 'idBInfo'
                }*/
            ]
        }],
    //columnas
    columns: [
        {
            xtype: 'rownumberer',
            width: 30
        },
        {
            xtype: 'actioncolumn',
            text: 'T. O.',
            dataIndex: 'tipo',
            id: 'idcolumnTO',
            flex: 0.2,
            items: [
                {
                    icon: BASE_URL + 'web/images/usuario.ico',
                    tooltip: 'Tipo de objeto USUARIO'
                }],
            renderer: function (tipo) {
                var to = Ext.ComponentQuery.query("#idcolumnTO");
                if (tipo === 'grupo') {
                    to[0].items[0].icon = BASE_URL + 'web/images/addgrupo.ico';
                    to[0].items[0].tooltip = 'Tipo de objeto GRUPO';
                } else {
                    to[0].items[0].icon = BASE_URL + 'web/images/usuario.ico';
                    to[0].items[0].tooltip = 'Tipo de objeto USUARIO';
                }
            }
        },
        {
            text: 'Usuario',
            dataIndex: 'user',
            flex: 0.4
        },
        {
            text: 'Nombre',
            dataIndex: 'givenname',
            flex: 0.3
        },
        {
            text: 'Apellidos',
            dataIndex: 'sn',
            flex: 0.5
        },
        {
            text: 'Email',
            dataIndex: 'email',
            flex: 0.6
        },
        {
            xtype: 'datecolumn',
            text: 'Password Vence',
            dataIndex: 'passwordVence',
            format: 'Y-m-d H:i:s',
            flex: 0.5,
            renderer: function (date) {
                var myDate = Ext.Date.parse(date, "Y-m-d H:i:s", true);

                if (Ext.isDate(myDate)) {
                    var fecha_actual = new Date();
                    var fecha_warning = Ext.Date.add(fecha_actual, Ext.Date.DAY, 20);

                    if (Ext.Date.between(myDate, fecha_actual, fecha_warning)) {
                        return '<font color="blue">' + Ext.Date.format(myDate, 'Y-m-d H:i:s') + '</font>';
                    } else {
                        if (fecha_actual > myDate) {
                            return '<font color="red">' + Ext.Date.format(myDate, 'Y-m-d H:i:s') + '</font>';
                        }
                    }
                }

                return date;
            }
        },
        {
            text: '&Uacute;ltimo Inicio S.',
            dataIndex: 'lastInicioSesion',
            xtype: 'datecolumn',
            //format: 'Y-m-d H:i:s',
            flex: 0.5,
            renderer: function (date) {
                return date;
            }
        },
        {
            text: '# Tel RAS',
            dataIndex: 'dialin',
            flex: 0.5
        },
        {
            xtype: 'actioncolumn',
            flex: 0.2,
            items: [
                {
                    icon: BASE_URL + 'web/images/delete.gif',
                    tooltip: 'Borrar',
                    handler: function (grid, rowIndex, colIndex) {
                        var rec = grid.getStore().getAt(rowIndex);
                        var url = '';

                        if (rec.data.tipo === "usuario") {
                            url = BASE_URL + 'welcome/borrarUsuario';
                        } else {
                            url = BASE_URL + 'grupos/borrarGrupo';
                        }

                        Ext.Ajax.request({
                            url: url,
                            params: {
                                usuario: rec.data.user
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

                                    var tree = Ext.ComponentQuery.query('#idTreePanel');
                                    var r = tree[0].getSelectionModel().getSelection();
                                    var camino = tree[0].getRootNode().findChild('id', r[0].data.id, true).getPath("text");

                                    grid.getStore().removeAll();
                                    grid.getStore().load({
                                        params: {
                                            "camino": camino
                                        }
                                    });
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
        }
    ],
    //forma de modificacion
    selType: 'rowmodel'
});
