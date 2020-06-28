module.exports = {
    devServer: {
        proxy: {
            '/api': {
                target: 'http://www.education.com',
                ws: true,
                changeOrigin: true
            },
            '/uploads': {
                target: 'http://www.education.com',
                ws: true,
                changeOrigin: true
            },
        },
    },
    publicPath: "./",
    chainWebpack: config => {
        config
            .module
            .rule('vue')
            .use('vue-loader')
            .loader('vue-loader')
            .tap(options => {
                options.transformAssetUrls = {
                    audio: 'src',
                };
                return options;
            });
        },
};