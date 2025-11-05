/**
 * WordPress dependencies
 */
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

/**
 * 保存组件
 */
export default function save({ attributes }) {
    const { title, buttonShow, buttonHide, theme } = attributes;
    
    const blockProps = useBlockProps.save({
        className: `yukicat-spoiler yukicat-spoiler-theme-${theme}`
    });
    
    // 主题图标映射
    const themeIcons = {
        warning: '⚠️',
        danger: '🚫',
        snow: '❄️',
        paw: '🐾'
    };
    
    // 生成唯一ID（在客户端会被替换）
    const uniqueId = `spoiler-${Math.random().toString(36).substr(2, 9)}`;
    
    return (
        <div {...blockProps} data-theme={theme}>
            <div className="yukicat-spoiler-header">
                <span className="yukicat-spoiler-icon">{themeIcons[theme]}</span>
                <span className="yukicat-spoiler-title">{title}</span>
                <button 
                    className="yukicat-spoiler-toggle"
                    data-target={uniqueId}
                    data-show-text={buttonShow}
                    data-hide-text={buttonHide}
                    aria-expanded="false"
                    aria-controls={uniqueId}
                >
                    {buttonShow}
                </button>
            </div>
            <div className="yukicat-spoiler-content" id={uniqueId} aria-hidden="true">
                <div className="yukicat-spoiler-content-inner">
                    <InnerBlocks.Content />
                </div>
            </div>
        </div>
    );
}
