/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('Ldapreport.view.FormLogin', {
    extend: 'Ext.form.Panel',
    alias: 'widget.formLogin',
    
    //configuracion
    url: BASE_URL + 'welcome/authenticate',
    id: 'idformUsuario',
    bodyPadding: 10,
    
    //items
    items: [{
            xtype: 'textfield',
            fieldLabel: 'Usuario',
            name: 'usuario',
            id: 'idtfUsuario',
            allowBlank: false
        }, {
            xtype: 'textfield',
            id : 'idtfPass',
            fieldLabel: 'Contrase&ntilde;a',
            name: 'pass',
            allowBlank: false,
            enableKeyEvents : true,
            inputType : 'password'
        }],
    
    //botones
    buttons: [{
            text: 'Resetear',
            iconCls : 'icon-cancel',
            handler: function() {
                this.up('form').getForm().reset();
            }
        }, {
            text: 'Iniciar',
            iconCls : 'icon-add',
            id: 'idButtonSumbitFormUsuario',
            formBind: true, //only enabled once the form is valid
            disabled: true
        }]
});
