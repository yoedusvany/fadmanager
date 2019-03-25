/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Ldapreport.view.NewUser', {
    extend: 'Ext.window.Window',
    alias: 'widget.NewUser',
    //region: 'center',
    id: 'idWindowNewUser',
    bodyPadding: 5, // Don't want content to crunch against the borders
    title: 'Adicionar nuevo Usuario',
    header: {
        titlePosition: 2,
        titleAlign: 'center'
    },
    closable: true,
    closeAction: 'destroy',
    width: 250,
    heigth: 400,
    //layout: 'fit',
    iconCls: 'icon-info',
    animateTarget: 'idCMenuTreePanel',
    items: [{
            xtype: 'textfield',
            name: 'username',
            id: 'idtfUsername',
            labelWidth: 80,
            fieldLabel: 'Username',
            allowBlank: false,
            fieldStyle: 'text-transform: lowercase'

        },
        {
            xtype: 'textfield',
            name: 'name',
            id: 'idtfName',
            labelWidth: 80,
            fieldLabel: 'Nombre',
            allowBlank: false
        },
        {
            xtype: 'textfield',
            name: 'apellidos',
            id: 'idtfApellidos',
            labelWidth: 80,
            fieldLabel: 'Apellidos',
            allowBlank: false
        },
        {
            xtype: 'textfield',
            name: 'mail',
            id: 'idtfMail',
            labelWidth: 80,
            fieldLabel: 'Correo',
            allowBlank: false,
            vtype: 'mail'
        },
        {
            xtype: 'textfield',
            id: 'idtfPassword',
            fieldLabel: 'Contrase&ntilde;a',
            name: 'password',
            allowBlank: false,
            enableKeyEvents: true,
            inputType: 'password',
            labelWidth: 80
        },
        {
            xtype: 'hiddenfield',
            id: 'idfhCaminoNewUser',
            name: 'camino'
        }
    ],
    buttons: [
        {
            text: 'Cancelar',
            id: 'idbCancelNewUser',
            iconCls: 'icon-delete',
            handler: function () {
                var pathOU = Ext.ComponentQuery.query('#idfhCaminoNewUser');
                var username = Ext.ComponentQuery.query('#idtfUsername');
                var name = Ext.ComponentQuery.query('#idtfName');
                var apellidos = Ext.ComponentQuery.query('#idtfApellidos');
                var mail = Ext.ComponentQuery.query('#idtfMail');
                var password = Ext.ComponentQuery.query('#idtfPassword');

                pathOU[0].reset();
                username[0].reset();
                name[0].reset();
                apellidos[0].reset();
                mail[0].reset();
                password[0].reset();
            }

        },
        {
            text: 'Insertar',
            iconCls: 'icon-add',
            id: 'idbsNewUser'
        }]
});