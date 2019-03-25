/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// Set up a model to use in our Store
Ext.define('Info', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'atributo', type: 'string'},
        {name: 'valor', type: 'string'}
    ]
});

var myStore = Ext.create('Ext.data.Store', {
    model: 'Info',
    proxy: {
        type: 'ajax',
        url: BASE_URL + "welcome/infoUsuario",
        reader: {
            type: 'json',
            root: 'data'
        }
    },
    autoLoad: false
});

Ext.define("Ldapreport.view.GridInfoUser", {
    extend: 'Ext.grid.Panel',
    alias: "widget.gridInfoUser",
    //configuracion del grid
    stripeRows: true,
    store: myStore,
    id: 'idGInfoUser',
    //columnas
    columns: [
        {
            xtype: 'rownumberer',
            width: 30
        },
        {
            text: 'Atributo',
            dataIndex: 'atributo',
            flex: 1,
            renderer: function (att) {
                return '<font bold>'+ att + '</font>';
            }
        },
        {
            text: 'Valor',
            dataIndex: 'valor',
            flex: 1
        }
    ],
    //forma de modificacion
    selType: 'rowmodel'
});
