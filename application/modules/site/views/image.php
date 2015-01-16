<!-- Load widget code -->
<script type="text/javascript" src="http://feather.aviary.com/imaging/v1/editor.js"></script>

<!-- Instantiate the widget -->
<script type="text/javascript">

    var featherEditor = new Aviary.Feather({
        apiKey: '3c427cac998746a69d186dfe011cfc23',
		//db303e64-5d1a-4662-a13d-4e3cb26e5594
        tools: ['draw', 'stickers', 'orientation', 'resize', 'crop', 'brightness', 'text'],
        onSave: function(imageID, newURL) {
            var img = document.getElementById(imageID);
            img.src = newURL;
        }
    });

    function launchEditor(id, src) {
        featherEditor.launch({
            image: id,
            url: src
        });
        return false;
    }

</script>                         

        <div class="content light-grey-background">
        	<div class="container">
        		<div class="search-flights terms">
<!-- Add an edit button, passing the HTML id of the image
    and the public URL to the image -->
<a href="#" onclick="return launchEditor('editableimage1', 
    'http://development.instorelook.com.au/assets/images/products/images/ecdda479bdf70629a7ba3bf27d1d9297.jpg');">Edit!</a>

<!-- original line of HTML here: -->
<img id="editableimage1" src="http://development.instorelook.com.au/assets/images/products/images/ecdda479bdf70629a7ba3bf27d1d9297.jpg"/>
                </div>
            </div>
        </div>
        <!-- End Join -->