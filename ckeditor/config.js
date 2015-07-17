/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
/*
CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
};*/

CKEDITOR.editorConfig = function(config) {
   config.filebrowserBrowseUrl = '../electro/kcfinder/browse.php?type=files';
   config.filebrowserImageBrowseUrl = '../electro/kcfinder/browse.php?type=images';
   config.filebrowserFlashBrowseUrl = '../electro/kcfinder/browse.php?type=flash';
   config.filebrowserUploadUrl = '../electro/kcfinder/upload.php?type=files';
   config.filebrowserImageUploadUrl = '../electro/kcfinder/upload.php?type=images';
   config.filebrowserFlashUploadUrl = '../electro/kcfinder/upload.php?type=flash';
   config.entities_greek = false;
};
