/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('Ldapreport.view.TreePanel', {
    extend: 'Ext.tree.Panel',
    alias: 'widget.treeLdapPanel',
    //region: 'center',
    id: 'idTreePanel',
    root: {
        text: "root",
        expanded: true,
        id: 'root',
        leaf:false
    },
    rootVisible: false,
    useArrows: true,
    animate: true,
    autoScroll: true,
    region: 'west',
    collapsible: true,
    title: 'LDAP UNICA',
    width: 180,
     dockedItems: [{
            xtype: 'toolbar',
            items: [{
                text: 'Expandir',
                handler: function(t){
                    var t = Ext.ComponentQuery.query('#idTreePanel');
                    t[0].expandAll();
                }
            }, {
                text: 'Colapsar',
                handler: function(t){
                    var t = Ext.ComponentQuery.query('#idTreePanel');
                    t[0].collapseAll();
                }
            }]
        }]
});