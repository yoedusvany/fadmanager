/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define("Ldapreport.view.reportes.UsuariosPasswordVencida", {
    extend: 'Ext.grid.Panel',
    alias: "widget.gridUsuariosPasswordVencida",
    //configuracion del grid
    //title: 'Usuarios sin iniciar sesi&oacute;n',
    id: 'idGridUsuariosPasswordVencida',
    stripeRows: true,
    store: "UsuariosPasswordVencida",
    dockedItems: [
        {
            xtype: 'toolbar',
            items: [
                {
                    xtype: 'button',
                    text: 'Exportar a RTF',
                    iconCls: 'icon-rtf',
                    handler: function () {
                       window.open(BASE_URL + "reportes/reporteUsuariosPasswordVencida/");
                    }
                }
            ]
        }],
    //columnas
    columns: [
        {
            xtype: 'rownumberer',
            width: 30
        },
        {
            text: 'Usuario',
            dataIndex: 'user',
            flex: 0.4
        },
        {
            text: 'Nombre y Apellidos',
            dataIndex: 'displayName',
            flex: 0.5
        },
        {
            text: 'Fecha creaci&oacute;n',
            dataIndex: 'fechaCreado',
            flex: 0.6
        }
    ],
    //forma de modificacion
    selType: 'rowmodel'
});
