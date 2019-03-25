/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Ldapreport.view.NewGrupo', {
    extend: 'Ext.window.Window',
    alias: 'widget.NewGrupo',
    //region: 'center',
    id: 'idWindowNewGrupo',
    bodyPadding: 5, // Don't want content to crunch against the borders
    title: 'Adicionar nuevo Grupo',
    header: {
        titlePosition: 2,
        titleAlign: 'center'
    },
    closable: true,
    closeAction: 'destroy',
    width: 250,
    heigth: 300,
    //layout: 'fit',
    iconCls: 'icon-info',
    animateTarget: 'idCMenuTreePanel',
    items: [{
            xtype: 'textfield',
            name: 'newGrupo',
            id: 'idtfNewGrupo',
            labelWidth: 80,
            fieldLabel: 'Nombre',
            allowBlank: false,
            listeners: {
                keyup: {
                    element: 'el', //bind to the underlying el property on the panel
                    fn: function(t) {
                        var tf = Ext.ComponentQuery.query('#idtfNewGrupo');

                        if (tf[0].getValue().length > 0) {
                            var b = Ext.ComponentQuery.query('#idbsNewGrupo');
                            b[0].setDisabled(false);
                        }
                    }
                }
            }
        }, 
        {
            xtype: 'textfield',
            name: 'descripcion',
            id: 'idtfDesc',
            labelWidth: 80,
            fieldLabel: 'Descripci&oacute;n',
            allowBlank: false
        },
        {
            xtype: 'hiddenfield',
            id: 'idfhCaminoNewGrupo',
            name: 'camino'
        }
    ],
    buttons: [
        {
            text: 'Cancelar',
            id: 'idbCancelNewGrupo',
            iconCls: 'icon-delete'
        },
        {
            text: 'Insertar',
            iconCls: 'icon-add',
            id: 'idbsNewGrupo',
            disabled: true
        }]
});