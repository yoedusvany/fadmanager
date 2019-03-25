/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Ldapreport.view.NewOU', {
    extend: 'Ext.window.Window',
    alias: 'widget.NewOU',
    //region: 'center',
    id: 'idWindowNewOU',
    bodyPadding: 5, // Don't want content to crunch against the borders
    title: 'Adicionar nueva OU',
    header: {
        titlePosition: 2,
        titleAlign: 'center'
    },
    closable: true,
    closeAction: 'destroy',
    labelWidth: 300,
    width: 250,
    heigth: 300,
    layout: 'fit',
    iconCls: 'icon-info',
    animateTarget: 'idCMenuTreePanel',
    items: [{
            xtype: 'textfield',
            name: 'newOU',
            id: 'idtfNewOU',
            labelWidth: 50,
            fieldLabel: 'Nombre',
            allowBlank: false,
            listeners: {
                keyup: {
                    element: 'el', //bind to the underlying el property on the panel
                    fn: function(t) {
                        var tf = Ext.ComponentQuery.query('#idtfNewOU');

                        if (tf[0].getValue().length > 0) {
                            var b = Ext.ComponentQuery.query('#idbsNewOU');
                            b[0].setDisabled(false);
                        }
                    }
                }
            }
        }, {
            xtype: 'hiddenfield',
            id: 'idfhCaminoNewOU',
            name: 'camino'
        }
    ],
    buttons: [
        {
            text: 'Cancelar',
            id: 'idbCancelNewOU',
            iconCls: 'icon-delete'
        },
        {
            text: 'Insertar',
            iconCls: 'icon-add',
            id: 'idbsNewOU',
            disabled: true
        }]
});