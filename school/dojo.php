<script djconfig="parseOnLoad: true" src="http://ajax.googleapis.com/ajax/libs/dojo/1.6/dojo/dojo.xd.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$('body').addClass('claro');
});
</script>
<link href="http://ajax.googleapis.com/ajax/libs/dojo/1.6/dijit/themes/claro/claro.css" rel="stylesheet" type="text/css" />
<?php if($dojoeditor ==true){ ?>
<link href="http://ajax.googleapis.com/ajax/libs/dojo/1.6/dojox/editor/plugins/resources/css/Blockquote.css" rel="stylesheet" type="text/css" />
<link href="http://ajax.googleapis.com/ajax/libs/dojo/1.6/dojox/editor/plugins/resources/css/FindReplace.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
dojo.require("dijit.Editor");dojo.require("dijit._editor.plugins.FontChoice");dojo.require("dijit._editor.plugins.TextColor");dojo.require("dijit._editor.plugins.LinkDialog");dojo.require("dijit._editor.plugins.FullScreen");dojo.require("dijit._editor.plugins.ViewSource");dojo.require("dijit._editor.plugins.AlwaysShowToolbar");dojo.require("dojox.editor.plugins.FindReplace");dojo.require("dojox.editor.plugins.Blockquote");dojo.require("dojox.editor.plugins.ToolbarLineBreak");dojo.require("dojox.editor.plugins.PrettyPrint");
</script>
<?php } ?>