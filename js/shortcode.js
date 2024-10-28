(function() {
	tinymce.create('tinymce.plugins.atwi_interview', {
        
		init : function(ed, url) {
           ed.addButton('qabut', {
                title : 'Insert Q&A Block',
                cmd : 'qabut',
                image :  url + '/../img/atwi_interview.png'
            });
 
            ed.addCommand('qabut', function() {		
				ed.windowManager.open({
					title: "Q&A Block",
					url:  url + '/../html/atwi-qa-dialog.html',
					width: 1280 ,
					height: 720
					
				});
            });
			

			}
			
    });
    // Register plugin
    tinymce.PluginManager.add( 'atwi_interview', tinymce.plugins.atwi_interview );


})();