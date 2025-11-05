=== YukiCat Spoiler Alert ===
Contributors: yukicat
Tags: spoiler, alert, gutenberg, block, shortcode
Requires at least: 6.0
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A powerful spoiler warning plugin with Gutenberg block support, multiple themes, and multilingual support.

== Description ==

雪猫剧透提醒 (YukiCat Spoiler Alert) is a feature-rich WordPress plugin that allows you to hide spoiler content behind a warning with a reveal button. Perfect for movie reviews, book discussions, game guides, and any content containing spoilers.

= Features =

* 🎨 **4 Beautiful Themes**: Warning (Yellow), Danger (Red), Snow (Blue), Paw (Orange)
* 📝 **Dual Usage**: Both shortcode `[spoiler]` and Gutenberg block
* 🌍 **Multilingual**: Chinese (Simplified/Traditional), English, Japanese
* 🎭 **Beautiful Animations**: Stripe motion, icon pulse, snowfall, paw fade-in
* 📱 **Responsive Design**: Perfect on desktop, tablet, and mobile
* ♿ **Accessibility**: ARIA labels, keyboard navigation
* 🖨️ **Print Friendly**: Auto-reveal content when printing
* 🌓 **Dark Mode**: Auto-adapts to system dark mode
* ⚡ **High Performance**: No jQuery, pure vanilla JavaScript
* 🔧 **Highly Customizable**: Custom title, button text, theme styles

= Usage =

**Shortcode:**
```
[spoiler]Your spoiler content here[/spoiler]

[spoiler title="Ending Spoiler" button_show="View Ending" button_hide="Hide Ending" theme="danger"]
The hero wins!
[/spoiler]
```

**Gutenberg Block:**
1. Click "+" to add a block
2. Search for "Spoiler Alert" or find in "Design" category
3. Configure settings in the right panel
4. Add any content blocks inside

= Languages =

* English
* 简体中文 (Chinese Simplified)
* 繁體中文 (Chinese Traditional)
* 日本語 (Japanese)

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/yukicat-spoiler-alert/` directory
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the shortcode `[spoiler]` or add "Spoiler Alert" block in Gutenberg editor

= Build from Source =

1. Run `npm install` to install dependencies
2. Run `npm run build` to build the production files
3. Upload `yukicat-spoiler-alert.php`, `assets/`, `build/`, and `languages/` folders

== Frequently Asked Questions ==

= Does it work with classic editor? =

Yes! Use the `[spoiler]` shortcode in both classic and block editors.

= Can I customize the appearance? =

Yes! The plugin provides 4 built-in themes and all parameters are customizable. You can also add custom CSS.

= Is it compatible with my theme? =

Yes! The plugin follows WordPress coding standards and should work with any well-coded theme.

= Does it support RTL languages? =

Yes! The plugin includes RTL support.

= Will it slow down my site? =

No! The plugin is optimized for performance with no jQuery dependency and minimal CSS/JS.

== Screenshots ==

1. Warning theme with yellow gradient
2. Danger theme with red gradient
3. Snow theme with snowflake animation
4. Paw theme with paw print animation
5. Gutenberg block editor interface
6. Settings panel in block editor
7. Mobile responsive view

== Changelog ==

= 1.0.0 =
* Initial release
* Shortcode support
* Gutenberg block support
* 4 theme styles
* Multilingual support (Chinese, English, Japanese)
* Responsive design
* Accessibility support
* Dark mode adaptation

== Upgrade Notice ==

= 1.0.0 =
First release of YukiCat Spoiler Alert plugin.
