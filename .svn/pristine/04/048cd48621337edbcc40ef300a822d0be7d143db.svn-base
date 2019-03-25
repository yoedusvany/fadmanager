/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Ldapreport.store.Usuarios', {
    extend: 'Ext.data.Store',
    model: "Ldapreport.model.Usuarios",
    //autoLoad: true,
    //autoSync : true,

    proxy: {
        type: 'ajax',
        api: {
            read: BASE_URL + "ou/getUsersOU"
        },
        reader: {
            type: "json",
            root: "data",
            successProperty: 'success',
            totalProperty: 'total'
        }
    }
});