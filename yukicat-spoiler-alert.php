<?php
/**
 * Plugin Name: 雪猫剧透提醒 (YukiCat Spoiler Alert)
 * Plugin URI: https://github.com/YukiCat-Dev/YukiCat-Spoiler-Alert/
 * Description: 一个功能强大的剧透内容警告插件，支持短代码和古腾堡区块，提供多种主题样式和多语言支持。
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: YukiCat
 * Author URI: https://www.yukicat.net
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: yukicat-spoiler-alert
 * Domain Path: /languages
 */

// 防止直接访问
if (!defined('ABSPATH')) {
    exit;
}

// 定义插件常量
define('YUKICAT_SPOILER_VERSION', '1.0.0');
define('YUKICAT_SPOILER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('YUKICAT_SPOILER_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * 主插件类
 */
class YukiCat_Spoiler_Alert {
    
    /**
     * 单例实例
     */
    private static $instance = null;
    
    /**
     * 获取单例实例
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * 构造函数
     */
    private function __construct() {
        // 加载文本域
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        
        // 注册短代码
        add_action('init', array($this, 'register_shortcode'));
        
        // 注册古腾堡区块
        add_action('init', array($this, 'register_block'));
        
        // 加载前端资源
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        
        // 加载编辑器资源
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_editor_assets'));
    }
    
    /**
     * 加载文本域
     */
    public function load_textdomain() {
        load_plugin_textdomain(
            'yukicat-spoiler-alert',
            false,
            dirname(plugin_basename(__FILE__)) . '/languages'
        );
    }
    
    /**
     * 注册短代码
     */
    public function register_shortcode() {
        add_shortcode('spoiler', array($this, 'render_shortcode'));
    }
    
    /**
     * 渲染短代码
     */
    public function render_shortcode($atts, $content = null) {
        // 解析参数
        $atts = shortcode_atts(
            array(
                'title' => $this->get_default_title(),
                'button_show' => $this->get_default_button_show(),
                'button_hide' => $this->get_default_button_hide(),
                'theme' => 'warning'
            ),
            $atts,
            'spoiler'
        );
        
        // 转义属性
        $title = esc_html($atts['title']);
        $button_show = esc_html($atts['button_show']);
        $button_hide = esc_html($atts['button_hide']);
        $theme = esc_attr($atts['theme']);
        
        // 验证主题
        $valid_themes = array('warning', 'danger', 'snow', 'paw');
        if (!in_array($theme, $valid_themes)) {
            $theme = 'warning';
        }
        
        // 处理内容
        $content = do_shortcode($content);
        
        // 生成唯一ID
        $unique_id = 'spoiler-' . uniqid();
        
        // 生成HTML
        $html = sprintf(
            '<div class="yukicat-spoiler yukicat-spoiler-theme-%s" data-theme="%s">
                <div class="yukicat-spoiler-header">
                    <span class="yukicat-spoiler-icon">%s</span>
                    <span class="yukicat-spoiler-title">%s</span>
                    <button class="yukicat-spoiler-toggle" 
                            data-target="%s" 
                            data-show-text="%s" 
                            data-hide-text="%s"
                            aria-expanded="false"
                            aria-controls="%s">
                        %s
                    </button>
                </div>
                <div class="yukicat-spoiler-content" id="%s" aria-hidden="true">
                    <div class="yukicat-spoiler-content-inner">
                        %s
                    </div>
                </div>
            </div>',
            $theme,
            $theme,
            $this->get_theme_icon($theme),
            $title,
            $unique_id,
            esc_attr($button_show),
            esc_attr($button_hide),
            $unique_id,
            $button_show,
            $unique_id,
            $content
        );
        
        return $html;
    }
    
    /**
     * 注册古腾堡区块
     */
    public function register_block() {
        // 检查是否存在构建文件
        $asset_file = YUKICAT_SPOILER_PLUGIN_DIR . 'build/index.asset.php';
        
        if (!file_exists($asset_file)) {
            return;
        }
        
        $asset = include $asset_file;
        
        // 注册区块脚本
        wp_register_script(
            'yukicat-spoiler-block-editor',
            YUKICAT_SPOILER_PLUGIN_URL . 'build/index.js',
            $asset['dependencies'],
            $asset['version'],
            true
        );
        
        // 注册区块样式（编辑器和前端共用）
        wp_register_style(
            'yukicat-spoiler-block-style',
            YUKICAT_SPOILER_PLUGIN_URL . 'build/style-index.css',
            array(),
            YUKICAT_SPOILER_VERSION
        );
        
        // 注册编辑器样式
        wp_register_style(
            'yukicat-spoiler-block-editor-style',
            YUKICAT_SPOILER_PLUGIN_URL . 'build/index.css',
            array('wp-edit-blocks'),
            YUKICAT_SPOILER_VERSION
        );
        
        // 注册区块类型
        register_block_type('yukicat/spoiler-alert', array(
            'editor_script' => 'yukicat-spoiler-block-editor',
            'editor_style' => 'yukicat-spoiler-block-editor-style',
            'style' => 'yukicat-spoiler-block-style',
            'render_callback' => array($this, 'render_block')
        ));
        
        // 传递默认文本到编辑器
        wp_localize_script('yukicat-spoiler-block-editor', 'yukicatSpoilerDefaults', array(
            'title' => $this->get_default_title(),
            'buttonShow' => $this->get_default_button_show(),
            'buttonHide' => $this->get_default_button_hide()
        ));
    }
    
    /**
     * 渲染区块
     */
    public function render_block($attributes, $content) {
        $title = isset($attributes['title']) ? esc_html($attributes['title']) : $this->get_default_title();
        $button_show = isset($attributes['buttonShow']) ? esc_html($attributes['buttonShow']) : $this->get_default_button_show();
        $button_hide = isset($attributes['buttonHide']) ? esc_html($attributes['buttonHide']) : $this->get_default_button_hide();
        $theme = isset($attributes['theme']) ? esc_attr($attributes['theme']) : 'warning';
        
        // 验证主题
        $valid_themes = array('warning', 'danger', 'snow', 'paw');
        if (!in_array($theme, $valid_themes)) {
            $theme = 'warning';
        }
        
        // 生成唯一ID
        $unique_id = 'spoiler-' . uniqid();
        
        // 生成HTML
        return sprintf(
            '<div class="yukicat-spoiler yukicat-spoiler-theme-%s" data-theme="%s">
                <div class="yukicat-spoiler-header">
                    <span class="yukicat-spoiler-icon">%s</span>
                    <span class="yukicat-spoiler-title">%s</span>
                    <button class="yukicat-spoiler-toggle" 
                            data-target="%s" 
                            data-show-text="%s" 
                            data-hide-text="%s"
                            aria-expanded="false"
                            aria-controls="%s">
                        %s
                    </button>
                </div>
                <div class="yukicat-spoiler-content" id="%s" aria-hidden="true">
                    <div class="yukicat-spoiler-content-inner">
                        %s
                    </div>
                </div>
            </div>',
            $theme,
            $theme,
            $this->get_theme_icon($theme),
            $title,
            $unique_id,
            esc_attr($button_show),
            esc_attr($button_hide),
            $unique_id,
            $button_show,
            $unique_id,
            $content
        );
    }
    
    /**
     * 加载前端资源
     */
    public function enqueue_frontend_assets() {
        // 加载前端样式
        wp_enqueue_style(
            'yukicat-spoiler-frontend',
            YUKICAT_SPOILER_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            YUKICAT_SPOILER_VERSION
        );
        
        // 加载前端脚本
        wp_enqueue_script(
            'yukicat-spoiler-frontend',
            YUKICAT_SPOILER_PLUGIN_URL . 'assets/js/frontend.js',
            array(),
            YUKICAT_SPOILER_VERSION,
            true
        );
    }
    
    /**
     * 加载编辑器资源（用于经典编辑器）
     */
    public function enqueue_editor_assets() {
        // 古腾堡编辑器样式已在register_block中注册
    }
    
    /**
     * 获取主题图标
     */
    private function get_theme_icon($theme) {
        $icons = array(
            'warning' => '⚠️',
            'danger' => '🚫',
            'snow' => '❄️',
            'paw' => '🐾'
        );
        
        return isset($icons[$theme]) ? $icons[$theme] : $icons['warning'];
    }
    
    /**
     * 获取默认标题（多语言）
     */
    private function get_default_title() {
        $locale = get_locale();
        
        $titles = array(
            'zh_CN' => '剧透警告',
            'zh_TW' => '劇透警告',
            'zh_HK' => '劇透警告',
            'en_US' => 'Spoiler Warning',
            'ja' => 'ネタバレ警告'
        );
        
        return isset($titles[$locale]) ? $titles[$locale] : __('Spoiler Warning', 'yukicat-spoiler-alert');
    }
    
    /**
     * 获取默认展开按钮文本（多语言）
     */
    private function get_default_button_show() {
        $locale = get_locale();
        
        $texts = array(
            'zh_CN' => '点击查看剧透内容',
            'zh_TW' => '點擊查看劇透內容',
            'zh_HK' => '點擊查看劇透內容',
            'en_US' => 'Click to reveal',
            'ja' => 'クリックして表示'
        );
        
        return isset($texts[$locale]) ? $texts[$locale] : __('Click to reveal', 'yukicat-spoiler-alert');
    }
    
    /**
     * 获取默认收起按钮文本（多语言）
     */
    private function get_default_button_hide() {
        $locale = get_locale();
        
        $texts = array(
            'zh_CN' => '收起内容',
            'zh_TW' => '收起內容',
            'zh_HK' => '收起內容',
            'en_US' => 'Collapse content',
            'ja' => '内容を隠す'
        );
        
        return isset($texts[$locale]) ? $texts[$locale] : __('Collapse content', 'yukicat-spoiler-alert');
    }
}

// 初始化插件
function yukicat_spoiler_alert_init() {
    return YukiCat_Spoiler_Alert::get_instance();
}

// 运行插件
add_action('plugins_loaded', 'yukicat_spoiler_alert_init');
