/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Ldapreport.view.WindowAddGroup', {
    extend: 'Ext.window.Window',
    alias: 'widget.WindowAddGroup',
    //region: 'center',
    id: 'idWindowAddGroup',
    bodyPadding: 5, // Don't want content to crunch against the borders
    //title: 'Adicionar Grupo a un usuario',
    header: {
        titlePosition: 2,
        titleAlign: 'center'
    },
    closable: true,
    closeAction: 'hide',
    labelWidth: 300,
    width: 350,
    heigth: 300,
    iconCls: 'icon-info',
    animateTarget: 'idBAddGroup',
    items: [{
            xtype: 'combo',
            id: 'idcGrupos',
            name: 'grupo',
            fieldLabel: 'Seleccione grupo',
            labelWidth: 120,
            displayField: 'grupo',
            valueField: 'grupo',
            store: 'Grupos',
            queryMode: 'local',
            typeAhead: false,
            editable: false,
            allowBlank: false
        }, {
            xtype: 'hiddenfield',
            id: 'idhUser',
            allowBlank: false,
            name: 'usuario'
        }, /*{
         anchor: '100%',
         xtype: 'multiselect',
         msgTarget: 'side',
         fieldLabel: 'Grupos asignados',
         labelWidth : 120,
         name: 'multiselect',
         id: 'multiselect-field',
         allowBlank: false,
         store: 'GruposUser',
         valueField: 'grupo',
         displayField: 'grupo'
         }*/{
            xtype: 'multiselect',
            fieldLabel: 'Grupos asignados',
            labelWidth: 120,
            name: 'multiselect',
            id: 'multiselect-field',
            width: 250,
            height: 200,
            allowBlank: false,
            store: 'GruposUser',
            valueField: 'grupo',
            displayField: 'grupo',
            tbar: [{
                    text: 'clear',
                    handler: function() {
                        msForm.getForm().findField('multiselect').reset();
                    }
                }],
            ddReorder: true
        }
    ],
    buttons: [
        {
            text: 'Borrar Grupo',
            id: 'idbDeleteGroupForm',
            iconCls: 'icon-delete',
            disabled: true
        },
        {
            text: 'Insertar',
            iconCls: 'icon-add',
            id: 'idbsAgregarGrupo',
            disabled: true
        }]
});