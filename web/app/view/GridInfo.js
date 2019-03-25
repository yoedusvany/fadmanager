/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// Set up a model to use in our Store
Ext.define('Info', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'grupo', type: 'string'},
        {name: 'cantidad', type: 'int'}
    ]
});

var myStore = Ext.create('Ext.data.Store', {
    model: 'Info',
    proxy: {
        type: 'ajax',
        url: BASE_URL + "welcome/info",
        reader: {
            type: 'json',
            root: 'data'
        }
    },
    autoLoad: false
});

Ext.define("Ldapreport.view.GridInfo", {
    extend: 'Ext.grid.Panel',
    alias: "widget.gridInfo",
    //configuracion del grid
    stripeRows: true,
    store: myStore,
    id: 'idGInfo',
    features: [{
            ftype: 'summary'
        }],
    //columnas
    columns: [
        {
            xtype: 'rownumberer',
            width: 30
        },
        {
            text: 'Grupo',
            dataIndex: 'grupo',
            flex: 1/*,
            summaryType: 'count'
            ,
            summaryRenderer: function(value, summaryData, dataIndex) {
                return Ext.String.format('{0} grupo{1}', value, value !== 1 ? 's' : '');
            }*/
        },
        {
            text: 'Cantidad',
            dataIndex: 'cantidad',
            flex: 1/*,
            summaryType: 'sum'
            ,
            summaryRenderer: function(value, summaryData, dataIndex) {
                Ext.Ajax.request({
                        url: BASE_URL + 'welcome/allUsers',
                        success: function (response, options) {
                            var respuesta = Ext.decode(response.responseText);
                            if (respuesta.success == true) {
                                return Ext.String.format('{0} usuario{1}', respuesta.total, respuesta.total !== 1 ? 's' : '');
                                //return respuesta.total;
                            }
                        }
                    });
                
                
            }*/
        }
    ],
    //forma de modificacion
    selType: 'rowmodel'
});
