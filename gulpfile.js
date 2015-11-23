var elixir = require('laravel-elixir');

elixir(function(mix) {
    // Compile CSS
    mix

        .sass('app.scss')

        .styles(
            [
                'magnific-popup/magnific-popup.css'
            ], // Source files
            'public/css/custom.css' // Destination file
            //'bower_components/foundation/js/' // Source files base directory
        )

        // Compile JavaScript
        .scripts(
            [
                'vue/vue.js',
                'vue-resource/vue-resource.js',
                'underscore/underscore-min.js',
                'magnific-popup/jquery.magnific-popup.min.js'
            ],
            'public/js/custom.js' // Destination file
        );
        
        /*.browserSync({
            port: 4242,
            proxy: 'betrapust.dev',
            notify: false
        });*/
});
