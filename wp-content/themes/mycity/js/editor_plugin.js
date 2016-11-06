(function() {
    tinymce.PluginManager.add('custom_mce_button', function(editor, url) {
        editor.addButton('custom_mce_button', {
        icon: 'mce-ico ',
        text: 'fonts',
            onclick: function() {
                var win = editor.windowManager.open({
                width: 800,
                minHeight:450,
                title: 'Insert icons',
                body: [
                    {
                        type   : 'container',
                        name   : 'container',
                        label  : 'icons',
                        html   : mycity_obj.TinyMCE_html

                    },
                    ],
                onsubmit: function(e) {
                    /*console.log(e);
                    console.log(e.data);*/
                    //console.log(jQuery(".extra_admin_1.active").data('icon'));
                    editor.insertContent(
                        '[' +jQuery(".extra_admin_1.active").data('icon') + ']'
                    );
                }
            });
        }
    });
});
})();