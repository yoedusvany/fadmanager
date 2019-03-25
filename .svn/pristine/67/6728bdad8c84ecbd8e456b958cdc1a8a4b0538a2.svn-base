/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Ldapreport.store.Usuario',{
    extend: 'Ext.data.Store',
    model : "Ldapreport.model.Usuario",
    
    //autoLoad : true,
    autoSync : true,
    pageSize: 50,

    proxy       : {
        type    : 'ajax',
        
        
        api     : {
            read : BASE_URL+"usuario/listar",
            update : BASE_URL+"usuario/actualizar",
            destroy : BASE_URL+"usuario/borrar"
        },
        
        reader  : {
            type    : "json",
            root    : "data",
            successProperty : 'success',
            totalProperty : 'total'
        },
        
        writer: {
            type: 'json',
            encode : true,
            writeAllFields: false,
            root: 'data'
        }
    }
});