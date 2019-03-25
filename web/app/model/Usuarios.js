/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define("Ldapreport.model.Usuarios",{
    extend: "Ext.data.Model",
    
    fields: [
        {name: 'no', type: 'int'},
        {name: 'user', type: 'string'},
        {name: 'tipo', type: 'string'},
        {name: 'givenname', type: 'string'},
        {name: 'sn', type: 'string'},
        {name: 'email', type: 'string'},
        {name: 'passwordVence', type: 'string'},
        {name: 'lastInicioSesion', type: 'string'},
        {name: 'dialin', type: 'string'}
    ]
});