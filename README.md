# 雪猫剧透提醒 (YukiCat Spoiler Alert)

一个功能强大的WordPress剧透内容警告插件，支持短代码和古腾堡区块，提供多种主题样式和多语言支持。

## ✨ 特性

- 🎨 **4种精美主题**: Warning(警告黄)、Danger(危险红)、Snow(雪花蓝)、Paw(猫爪橙)
- 📝 **双重调用方式**: 短代码 `[spoiler]` 和古腾堡区块
- 🌍 **多语言支持**: 简体中文、繁体中文、英文、日文
- 🎭 **精美动画**: 条纹移动、图标脉冲、雪花飘落、猫爪淡入
- 📱 **响应式设计**: 完美适配桌面、平板、手机
- ♿ **无障碍支持**: ARIA标签、键盘操作
- 🖨️ **打印友好**: 打印时自动显示全部内容
- 🌓 **深色模式**: 自动适配系统深色模式
- ⚡ **高性能**: 无jQuery依赖，纯原生JavaScript
- 🔧 **高度可定制**: 自定义标题、按钮文本、主题样式

## 📦 安装

### 方式一：从源代码构建

1. **克隆或下载插件到WordPress插件目录**
```bash
cd wp-content/plugins/
git clone https://github.com/YukiCat-Dev/YukiCat-Spoiler-Alert/yukicat-spoiler-alert.git
cd yukicat-spoiler-alert
```

2. **安装依赖**
```bash
npm install
```

3. **构建插件**
```bash
npm run build
```

4. **在WordPress后台启用插件**
- 进入 `插件` > `已安装的插件`
- 找到 "雪猫剧透提醒" 并点击 "启用"

### 方式二：直接上传

如果您已经有构建好的版本，只需上传以下文件/文件夹到 `wp-content/plugins/yukicat-spoiler-alert/`:

- `yukicat-spoiler-alert.php` (主文件)
- `assets/` (前端资源)
- `build/` (构建后的区块文件)
- `languages/` (翻译文件)

然后在WordPress后台启用插件。

## 🚀 使用方法

### 方法1: 短代码（适用于所有编辑器）

**基础用法:**
```
[spoiler]这里是剧透内容[/spoiler]
```

**高级用法（自定义参数）:**
```
[spoiler title="结局剧透" button_show="查看结局" button_hide="隐藏结局" theme="danger"]
小明最后成为了英雄！
[/spoiler]
```

**参数说明:**
- `title` - 警告标题（默认：根据语言自动显示）
- `button_show` - 展开按钮文本（默认：根据语言自动显示）
- `button_hide` - 收起按钮文本（默认：根据语言自动显示）
- `theme` - 主题样式: `warning`(默认), `danger`, `snow`, `paw`

### 方法2: 古腾堡区块（推荐）

1. 在编辑器中点击 **"+"** 添加区块
2. 搜索 **"Spoiler Alert"** 或在 **"设计"** 分类中查找
3. 插入区块后，在右侧面板设置:
   - 警告标题
   - 展开按钮文本
   - 收起按钮文本
   - 主题样式（4选1）
4. 在区块内部添加任意内容（段落、图片、标题、列表等）

## 🎨 主题预览

### ⚠️ Warning (警告黄)
渐变黄色背景，带条纹动画，适合一般性提醒。

### 🚫 Danger (危险红)
渐变红色背景，带条纹动画，适合重要剧透警告。

### ❄️ Snow (雪花蓝)
渐变冰蓝色背景，带雪花飘落动画，雪猫特色主题。

### 🐾 Paw (猫爪橙)
渐变暖橙色背景，带猫爪淡入动画，雪猫特色主题。

## 🌐 多语言支持

插件会根据WordPress语言设置自动切换默认文本：

| 语言 | 默认标题 | 默认展开按钮 | 默认收起按钮 |
|------|----------|--------------|--------------|
| 简体中文 (zh_CN) | 剧透警告 | 点击查看剧透内容 | 收起内容 |
| 繁体中文 (zh_TW) | 劇透警告 | 點擊查看劇透內容 | 收起內容 |
| 英文 (en_US) | Spoiler Warning | Click to reveal | Collapse content |
| 日文 (ja) | ネタバレ警告 | クリックして表示 | 内容を隠す |

### 添加自定义翻译

1. 复制 `languages/yukicat-spoiler-alert.pot` 文件
2. 使用 Poedit 或类似工具创建 `.po` 文件
3. 翻译后生成 `.mo` 文件
4. 将 `.mo` 文件放入 `languages/` 目录
5. 文件命名格式: `yukicat-spoiler-alert-{locale}.mo`

## 💻 开发

### 项目结构
```
yukicat-spoiler-alert/
├── yukicat-spoiler-alert.php    # 主插件文件
├── package.json                  # npm配置
├── README.md                     # 说明文档
├── src/                          # 源代码
│   ├── index.js                  # 区块入口
│   ├── edit.js                   # 编辑器组件
│   ├── save.js                   # 保存组件
│   ├── block.json                # 区块配置
│   ├── editor.scss               # 编辑器样式
│   └── style.scss                # 前端样式
├── assets/                       # 静态资源
│   ├── css/
│   │   └── frontend.css          # 前端CSS
│   └── js/
│       └── frontend.js           # 前端JS
├── build/                        # 构建输出（npm run build后生成）
│   ├── index.js
│   ├── index.css
│   ├── style-index.css
│   └── index.asset.php
└── languages/                    # 翻译文件
    ├── yukicat-spoiler-alert.pot
    ├── yukicat-spoiler-alert-zh_CN.po
    ├── yukicat-spoiler-alert-zh_TW.po
    ├── yukicat-spoiler-alert-ja.po
    └── yukicat-spoiler-alert-en_US.po
```

### 开发命令

```bash
# 安装依赖
npm install

# 开发模式（自动监听文件变化）
npm start

# 生产构建
npm run build

# 更新WordPress包
npm run packages-update
```

### 技术栈

- **WordPress**: 6.0+
- **PHP**: 7.4+
- **React**: 通过 @wordpress/element
- **Build Tool**: @wordpress/scripts (webpack)
- **CSS**: SCSS预处理器
- **JavaScript**: ES6+ (原生，无jQuery)

## 🔧 自定义开发

### 添加新主题

1. 在 `src/style.scss` 中添加新主题样式:
```scss
&.yukicat-spoiler-theme-custom {
    .yukicat-spoiler-header {
        background: linear-gradient(135deg, #color1 0%, #color2 100%);
        color: #textcolor;
    }
}
```

2. 在 `src/edit.js` 中添加主题选项:
```javascript
{ label: __('🌟 Custom Theme', 'yukicat-spoiler-alert'), value: 'custom' }
```

3. 更新 `src/block.json` 的 `theme` 枚举值

### JavaScript API

插件提供全局API供其他脚本使用:

```javascript
// 重新初始化所有剧透区块
window.YukiCatSpoiler.init();

// 获取版本
console.log(window.YukiCatSpoiler.version);
```

## 📝 更新日志

### 1.0.0 (2025-11-05)
- 🎉 首次发布
- ✅ 短代码支持
- ✅ 古腾堡区块支持
- ✅ 4种主题样式
- ✅ 多语言支持（中文、英文、日文）
- ✅ 响应式设计
- ✅ 无障碍支持
- ✅ 深色模式适配

## 🤝 贡献

欢迎提交 Issues 和 Pull Requests！

## 📄 许可证

GPL v2 or later

## 💖 支持

如果您觉得这个插件有用，请给我们一个⭐星标！

## 🔗 链接

- [WordPress插件目录](#)
- [GitHub仓库](#)
- [问题反馈](#)
- [文档](#)

---

Made with ❤️ by YukiCat
