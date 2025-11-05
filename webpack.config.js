/**
 * WordPress Scripts 配置覆盖
 * 
 * 如果需要自定义webpack配置，可以在这里添加
 * 目前使用默认配置即可满足需求
 */

const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
    ...defaultConfig,
    // 可以在这里添加自定义配置
    // 例如: 添加额外的插件、修改输出路径等
};
