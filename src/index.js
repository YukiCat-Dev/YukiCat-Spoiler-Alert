/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import Edit from './edit';
import save from './save';
import metadata from './block.json';

/**
 * Styles
 */
import './editor.scss';
import './style.scss';

/**
 * 注册区块
 */
registerBlockType(metadata.name, {
    edit: Edit,
    save: save,
});
