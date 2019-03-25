Ext.Loader.setConfig({
    enabled: true,
    paths: {
        'Ldapreport': "../web/app", //camino a la carpeta de la aplicacion
        'Ext.ux': "../web/app/ux"
    }
});

//Ext.require('Ldapreport.view.WindowPassword');
Ext.require('Ext.ux.form.MultiSelect');



Ext.application({
    name: "Ldapreport",
    appFolder: "web/app",
    controllers: [
        'Usuario',
        'Usuarios',
        'Password',
        'TreeLdap'
    ],
    launch: function() {
        
        var v = Ext.create('Ext.window.Window', {
            renderTo: Ext.getBody(),
            iconCls : 'icon-form',
            title : 'Iniciar sesi&oacute;n',
            closable : false,
            id:'idwLogin',
            items: [
                {
                    xtype: 'formLogin'
                }
            ]
        });
        
        v.show();
    }
});