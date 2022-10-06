const path = require('path');
const fs = require('fs-extra');
let mix = require('laravel-mix');
const { existsSync } = require('fs');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.js('resources/js/client/app.js', 'public/client/js')
   .disableNotifications();

// mix.sourceMaps()
mix.webpackConfig({
   plugins: [
      // new BundleAnalyzerPlugin()
   ],
   resolve: {
      extensions: ['.js', '.json', '.vue'],
   },
   output: {
      publicPath: '/laravel-porto/client/js/',
      chunkFilename: 'dist/[chunkhash].js',
      path: mix.config.hmr ? '/' : path.resolve(__dirname, './public/build')
   }
})

mix.then(() => {
   if (!mix.config.hmr) {
      process.nextTick(() => publishAseets())
   }
});

function publishAseets() {
   const publicDir = path.resolve(__dirname, './public')

   // fs.removeSync( path.join( publicDir, 'client/js' ) );
   // fs.removeSync( path.join( publicDir, 'server/js/app.js' ) );

   fs.copySync(path.join(publicDir, 'build', 'client', 'js'), path.join(publicDir, 'client', 'js'));
   fs.copySync(path.join(publicDir, 'build', 'dist'), path.join(publicDir, 'client', 'js', 'dist'));

   if (fs.existsSync(path.join(publicDir, 'build/server/js/app.js'))) {
      fs.copySync(path.join(publicDir, 'build/server/js/app.js'), path.join(publicDir, 'server/js/app.js'));
   }

   fs.removeSync(path.join(publicDir, 'build'));
}