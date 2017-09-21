tinymce.init({
	selector: "textarea.mceAdvanced",
	theme: "modern",
	language : "pt_BR",
	plugins: [
		"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
		"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
		"save table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker codesample"
	],
	external_plugins: {
		//"moxiemanager": "/moxiemanager-php/plugin.js"
	},
	content_css: "css/development.css",
	add_unload_trigger: false,
	autosave_ask_before_unload: false,

	toolbar1: "cut copy paste | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent blockquote | fontselect fontsizeselect",
	toolbar2: "bullist numlist | undo redo | link unlink code | forecolor backcolor | subscript superscript",
	toolbar3: "",
	menubar: false,
	toolbar_items_size: 'small',

	style_formats: [
		{title: 'Bold text', inline: 'b'},
		{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
		{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
		{title: 'Example 1', inline: 'span', classes: 'example1'},
		{title: 'Example 2', inline: 'span', classes: 'example2'},
		{title: 'Table styles'},
		{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
	],

	templates: [
		{title: 'My template 1', description: 'Some fancy template 1', content: 'My html'},
		{title: 'My template 2', description: 'Some fancy template 2', url: 'development.html'}
	],

	spellchecker_callback: function(method, data, success) {
		if (method == "spellcheck") {
			var words = data.match(this.getWordCharPattern());
			var suggestions = {};

			for (var i = 0; i < words.length; i++) {
				suggestions[words[i]] = ["First", "second"];
			}

			success({words: suggestions, dictionary: true});
		}

		if (method == "addToDictionary") {
			success();
		}
	}
});

function novaJanela(){
	var opcoes = "menubar=no,toolbar=no,width=500";
	Variavel = window.open ("imagens.php", "Nome da janela", opcoes) ;
}