/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { 
    InspectorControls, 
    InnerBlocks, 
    useBlockProps 
} from '@wordpress/block-editor';
import { 
    PanelBody, 
    TextControl, 
    SelectControl 
} from '@wordpress/components';
import { useEffect } from '@wordpress/element';

/**
 * 编辑器组件
 */
export default function Edit({ attributes, setAttributes }) {
    const { title, buttonShow, buttonHide, theme } = attributes;
    
    // 获取默认值
    const defaults = window.yukicatSpoilerDefaults || {
        title: __('Spoiler Warning', 'yukicat-spoiler-alert'),
        buttonShow: __('Click to reveal', 'yukicat-spoiler-alert'),
        buttonHide: __('Collapse content', 'yukicat-spoiler-alert')
    };
    
    // 初始化默认值
    useEffect(() => {
        if (!title) {
            setAttributes({ title: defaults.title });
        }
        if (!buttonShow) {
            setAttributes({ buttonShow: defaults.buttonShow });
        }
        if (!buttonHide) {
            setAttributes({ buttonHide: defaults.buttonHide });
        }
    }, []);
    
    const blockProps = useBlockProps({
        className: `yukicat-spoiler-editor yukicat-spoiler-theme-${theme}`
    });
    
    // 主题选项
    const themeOptions = [
        { label: __('⚠️ Warning (Yellow)', 'yukicat-spoiler-alert'), value: 'warning' },
        { label: __('🚫 Danger (Red)', 'yukicat-spoiler-alert'), value: 'danger' },
        { label: __('❄️ Snow (Blue)', 'yukicat-spoiler-alert'), value: 'snow' },
        { label: __('🐾 Paw (Orange)', 'yukicat-spoiler-alert'), value: 'paw' }
    ];
    
    // 主题图标映射
    const themeIcons = {
        warning: '⚠️',
        danger: '🚫',
        snow: '❄️',
        paw: '🐾'
    };
    
    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Spoiler Settings', 'yukicat-spoiler-alert')} initialOpen={true}>
                    <TextControl
                        label={__('Warning Title', 'yukicat-spoiler-alert')}
                        value={title}
                        onChange={(value) => setAttributes({ title: value })}
                        placeholder={defaults.title}
                        help={__('The title shown in the warning header', 'yukicat-spoiler-alert')}
                    />
                    <TextControl
                        label={__('Show Button Text', 'yukicat-spoiler-alert')}
                        value={buttonShow}
                        onChange={(value) => setAttributes({ buttonShow: value })}
                        placeholder={defaults.buttonShow}
                        help={__('Text for the expand button', 'yukicat-spoiler-alert')}
                    />
                    <TextControl
                        label={__('Hide Button Text', 'yukicat-spoiler-alert')}
                        value={buttonHide}
                        onChange={(value) => setAttributes({ buttonHide: value })}
                        placeholder={defaults.buttonHide}
                        help={__('Text for the collapse button', 'yukicat-spoiler-alert')}
                    />
                    <SelectControl
                        label={__('Theme Style', 'yukicat-spoiler-alert')}
                        value={theme}
                        options={themeOptions}
                        onChange={(value) => setAttributes({ theme: value })}
                        help={__('Choose a visual theme for the spoiler', 'yukicat-spoiler-alert')}
                    />
                </PanelBody>
            </InspectorControls>
            
            <div {...blockProps}>
                <div className="yukicat-spoiler-header">
                    <span className="yukicat-spoiler-icon">{themeIcons[theme]}</span>
                    <TextControl
                        className="yukicat-spoiler-title-input"
                        value={title}
                        onChange={(value) => setAttributes({ title: value })}
                        placeholder={defaults.title}
                    />
                    <button className="yukicat-spoiler-toggle" disabled>
                        {buttonShow || defaults.buttonShow}
                    </button>
                </div>
                
                <div className="yukicat-spoiler-content-editor">
                    <InnerBlocks
                        placeholder={__('Add spoiler content blocks here...', 'yukicat-spoiler-alert')}
                        templateLock={false}
                    />
                </div>
            </div>
        </>
    );
}
