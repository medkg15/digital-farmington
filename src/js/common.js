requirejs.config({
	paths: {
		"jquery": "../vendor/jquery/dist/jquery.min"
        , "bootstrap": "../vendor/bootstrap/dist/js/bootstrap.min"
        , "underscore": "../vendor/underscore/underscore-min"
        , 'async': '/vendor/requirejs-plugins/src/async'
	}
	, shim: {
		"bootstrap": ['jquery']
	}
    //, urlArgs: "v=11"
});