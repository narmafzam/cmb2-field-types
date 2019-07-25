let Encore = require('@symfony/webpack-encore');

Encore
    .disableSingleRuntimeChunk()
    .configureFilenames({
        js: 'js/[name].[contenthash].js',
        css: 'css/[name].[contenthash].css',
        images: 'img/[name].[hash:4].[ext]',
        fonts: 'font/[name].[hash:4].[ext]'
    })
    .setOutputPath('./asset/b/')
    .setPublicPath('/b')
    .setManifestKeyPrefix('b')
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