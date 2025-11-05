/**
 * 前端交互脚本 - 原生JavaScript，无jQuery依赖
 */

(function() {
    'use strict';
    
    /**
     * 初始化所有剧透区块
     */
    function initSpoilers() {
        const spoilers = document.querySelectorAll('.yukicat-spoiler');
        
        spoilers.forEach(function(spoiler) {
            const toggle = spoiler.querySelector('.yukicat-spoiler-toggle');
            const content = spoiler.querySelector('.yukicat-spoiler-content');
            
            if (!toggle || !content) {
                return;
            }
            
            // 为每个内容区域生成唯一ID（如果没有的话）
            if (!content.id) {
                content.id = 'spoiler-' + Math.random().toString(36).substr(2, 9);
                toggle.setAttribute('data-target', content.id);
                toggle.setAttribute('aria-controls', content.id);
            }
            
            // 绑定点击事件
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                toggleSpoiler(toggle, content);
            });
            
            // 键盘支持（Enter和Space键）
            toggle.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleSpoiler(toggle, content);
                }
            });
        });
    }
    
    /**
     * 切换剧透内容的显示/隐藏
     */
    function toggleSpoiler(toggle, content) {
        const isExpanded = content.classList.contains('is-expanded');
        const showText = toggle.getAttribute('data-show-text') || 'Show';
        const hideText = toggle.getAttribute('data-hide-text') || 'Hide';
        
        if (isExpanded) {
            // 收起内容
            content.classList.remove('is-expanded');
            toggle.textContent = showText;
            toggle.setAttribute('aria-expanded', 'false');
            content.setAttribute('aria-hidden', 'true');
            
            // 平滑滚动到顶部（如果内容在视口外）
            const spoilerTop = toggle.closest('.yukicat-spoiler').offsetTop;
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > spoilerTop) {
                window.scrollTo({
                    top: spoilerTop - 20,
                    behavior: 'smooth'
                });
            }
        } else {
            // 展开内容
            content.classList.add('is-expanded');
            toggle.textContent = hideText;
            toggle.setAttribute('aria-expanded', 'true');
            content.setAttribute('aria-hidden', 'false');
            
            // 设置焦点到内容区域（可访问性）
            content.setAttribute('tabindex', '-1');
            setTimeout(function() {
                content.focus({ preventScroll: true });
            }, 300);
        }
    }
    
    /**
     * 处理动态添加的内容（AJAX加载等）
     */
    function observeNewContent() {
        if (typeof MutationObserver === 'undefined') {
            return;
        }
        
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length) {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1) { // 元素节点
                            if (node.classList && node.classList.contains('yukicat-spoiler')) {
                                initSpoilers();
                            } else if (node.querySelectorAll) {
                                const spoilers = node.querySelectorAll('.yukicat-spoiler');
                                if (spoilers.length > 0) {
                                    initSpoilers();
                                }
                            }
                        }
                    });
                }
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
    
    /**
     * 页面加载完成后初始化
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initSpoilers();
            observeNewContent();
        });
    } else {
        initSpoilers();
        observeNewContent();
    }
    
    /**
     * 全局API（可选，供其他脚本使用）
     */
    window.YukiCatSpoiler = {
        init: initSpoilers,
        version: '1.0.0'
    };
    
})();
