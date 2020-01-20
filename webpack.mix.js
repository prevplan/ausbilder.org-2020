const mix = require('laravel-mix');

//enable sourcemaps only in dev environment
if (!mix.inProduction()) {
    mix.webpackConfig({
        devtool: 'inline-source-map',
    });
}

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

const vendors = 'node_modules/';
const resourcesAssets = 'resources/';
const srcCss = resourcesAssets + 'css/';
const srcJs = resourcesAssets + 'js/';
const srcSass = resourcesAssets + 'sass/';

//destination path configuration
const dest = 'public/';
const destFonts = dest + 'webfonts/';
const destCss = dest + 'css/';
const destJs = dest + 'js/';
const destImg = dest + 'img/';
const destImages = dest + 'images/';
const destVendors = dest + 'vendors/';

const paths = {
    jquery: vendors + 'jquery/dist/',
    bootstrap: vendors + 'bootstrap/dist/',
    adminlte: vendors + 'admin-lte/dist/',
    fontawesome: vendors + '@fortawesome/fontawesome-free/',
    icheck_bootstrap: vendors + 'icheck-bootstrap/',
    datatables: vendors + 'datatables.net/',
    datatablesbs4: vendors + 'datatables.net-bs4/',
};

// icheck_bootstrap
mix.styles(
    [
        paths.icheck_bootstrap + 'icheck-bootstrap.min.css'
    ],
    destVendors + 'icheckbootstrap/css/icheck-bootstrap.min.css'
);

//datatables
mix.combine(
    [
        paths.datatables + 'js/jquery.dataTables.js',
        paths.datatablesbs4 + 'js/dataTables.bootstrap4.js',
    ],
    destVendors + 'datatables/js/datatables.js'
    );

mix.styles(
    [
        paths.datatablesbs4 + 'css/dataTables.bootstrap4.css'
    ],
    destVendors + 'datatables/css/dataTables.bootstrap4.css'
);


//Copy fonts straight to public
mix.copy(paths.fontawesome + 'webfonts', destFonts);
mix.copy(resourcesAssets + 'fonts', dest + 'fonts');
mix.copy(resourcesAssets + 'img', destImg);

// all global css files into app.css
mix.combine(
    [
        paths.fontawesome + 'css/all.min.css',
        paths.adminlte + 'css/adminlte.min.css',
        srcCss + 'source-sans-pro.css',
    ],
    destCss + 'app.css'
);


// all global js files into app.js
mix.combine(
    [
        paths.jquery + 'jquery.min.js',
        paths.bootstrap + 'js/bootstrap.bundle.min.js',
        paths.adminlte + 'js/adminlte.min.js',
    ],
    destJs + 'app.js'
);
