/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('Ldapreport.view.FormPassword', {
    extend: 'Ext.form.Panel',
    alias: 'widget.formPassword',
    
    //configuracion
    url: BASE_URL + 'welcome/changePassword',
    id : 'idformPassword',
    bodyPadding: 10,
    method: 'POST',
    
    defaults: {
        labelWidth: 200,
        msgTarget : 'side'
    },
    
    //items
    items: [
        {
            xtype: 'hiddenfield',
            id: 'idhUsuario',
            name: 'usuario',
            allowBlank: false
        },/*{
            xtype: 'textfield',
            fieldLabel: 'Contrase&ntilde;a Actual',
            name: 'passActual',
            inputType: 'password',
            id: 'idPassActual',
            minLength : 7,
            maxLength : 50,
            allowBlank: false
        },*/{
            xtype: 'textfield',
            fieldLabel: 'Contrase&ntilde;a',
            name: 'passNueva',
            id: 'idPassNew',
            inputType: 'password',
            minLength : 7,
            maxLength : 50,
            allowBlank: false
        },{
            xtype: 'textfield',
            fieldLabel: 'Confirmar Contrase&ntilde;a',
            name: 'passConfirm',
            inputType: 'password',
            id: 'passnewConfirm',            
            minLength : 7,
            maxLength : 50,
            allowBlank: false
        }
        
    ],
    
    //botones
    buttons: [
        {
            text: 'Resetear',
            handler: function() {
                this.up('form').getForm().reset();
            }
        }, {
            text: 'Actualizar',
            id : 'idButtonSumbitFormPassword',
            formBind: true, //only enabled once the form is valid
            disabled: true
        }]
});
