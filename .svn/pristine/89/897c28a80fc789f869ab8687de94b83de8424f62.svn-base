/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Ldapreport.store.GruposUser', {
    extend: 'Ext.data.Store',
    model: "Ldapreport.model.GruposUser",
    //autoLoad: true,
    //autoSync : true,

    proxy: {
        type: 'ajax',
        api: {
            read: BASE_URL + "grupos/getGruposUser"
        },
        reader: {
            type: "json",
            root: "data",
            successProperty: 'success',
            totalProperty: 'total'
        }
    }
});