/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define("Ldapreport.model.Usuario-reporte",{
    extend: "Ext.data.Model",
    
    fields: [
        {name: 'user', type: 'string'},
        {name: 'displayName', type: 'string'},
        {name: 'fechaCreado', type: 'string',}
    ]
});