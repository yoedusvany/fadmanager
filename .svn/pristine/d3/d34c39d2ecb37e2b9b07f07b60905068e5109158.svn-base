/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Ldapreport.store.UsuariosPasswordVencida', {
    extend: 'Ext.data.Store',
    model: "Ldapreport.model.Usuario-reporte",
    //autoLoad: true,
    //autoSync : true,

    proxy: {
        type: 'ajax',
        api: {
            read: BASE_URL + "welcome/usuariosPasswordVencida"
        },
        reader: {
            type: "json",
            root: "data",
            successProperty: 'success',
            totalProperty: 'total'
        }
    }
});