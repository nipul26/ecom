/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	var fontName = 'Montserrat';

	// Add the custom font to CKEditor
	CKEDITOR.plugins.addExternal(fontName, '/fonts/' + fontName + '.js');

	// Set the font as an option in the toolbar
	CKEDITOR.config.font_names = fontName + '/' + fontName + ';' + CKEDITOR.config.font_names;
	
};


// Add the font family to the styles dropdown in the toolbar
	CKEDITOR.config.font_names =
    '/fonts/' + 
    'Montserrat.ttf' + 
    ';'+
    CKEDITOR.config.font_names;