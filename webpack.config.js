const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            vue$: path.join(__dirname, 'node_modules/vue/dist/vue.esm-bundler.js'),
        },
    },
};
