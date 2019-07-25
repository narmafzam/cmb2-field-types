let Encore = require('@symfony/webpack-encore');

Encore
    .disableSingleRuntimeChunk()
    .configureFilenames({
        js: 'js/[name].js',
        css: 'css/[name].css',
        images: 'img/[name].[ext]',
        fonts: 'font/[name].[ext]'
    })
    .setOutputPath('./dist')
    .setPublicPath('/dist')
    .setManifestKeyPrefix('dist')
    .cleanupOutputBeforeBuild()
    .enableSassLoader(function (sassOptions) {
    }, {
        resolveUrlLoader: true
    })
    .addEntry('field', './asset/js/field.js')
    .enableVersioning()
    .enableSourceMaps(!Encore.isProduction())
;

let webpackConfig = Encore.getWebpackConfig();

module.exports = webpackConfig;