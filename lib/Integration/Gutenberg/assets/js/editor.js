import {registerBlockType} from "@wordpress/blocks";
import {__} from '@wordpress/i18n';
import {withSelect} from '@wordpress/data';
import {useBlockProps} from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

import {
	PanelBody,
	SelectControl,
	__experimentalNumberControl as NumberControl,
	TextControl
} from '@wordpress/components';

import {
	InspectorControls
} from "@wordpress/block-editor";

/**
 * Block: Feed
 */
registerBlockType('yadore-widget/feed', {
	title: 'Yadore Widget - Feed',
	description: 'Integrate a Yadore Feed with this block, easily.',
	category: 'yadore-widget',
	icon: 'grid-view',
	attributes: {
		id: {
			default: '',
		},
		layout: {
			default: 'grid'
		},
		col: {
			default: '3',
		}
	},
	edit: withSelect((select) => {
		return {
			posts: select('core').getEntityRecords('postType', 'yadore_widget_feed', {per_page: -1})
		};
	})
	(props => {
		const attributes = props.attributes;
		const setAttributes = props.setAttributes;
		var feedOptions = [];

		if (!props.posts) {
			return __('Loading feeds...', 'yadore-widget');
		}

		if (props.posts.length === 0) {
			return __('No feeds found, please create one first', 'yadore-widget');
		}

		feedOptions.push({
			label: __('Choose a feed', 'yadore-widget'),
			value: ''
		});

		for (var i = 0; i < props.posts.length; i++) {
			feedOptions.push({
				label: props.posts[i].title.raw,
				value: props.posts[i].id
			});
		}

		function changeId(id) {
			setAttributes({id});
		}

		function changeLayout(layout) {
			setAttributes({layout});
		}

		function changeCol(col) {
			setAttributes({col});
		}

		return (
			<div {...useBlockProps()}>
				<ServerSideRender
					block="yadore-widget/feed"
					attributes={attributes}
				/>

				<InspectorControls key="setting">
					<PanelBody>
						<SelectControl
							label={__('Select a feed', 'yadore-widget')}
							value={attributes.id}
							onChange={changeId}
							options={feedOptions}
						/>

						<SelectControl
							label={__('Layout', 'yadore-widget')}
							value={attributes.layout}
							onChange={changeLayout}
							options={[
								{label: 'Grid', value: 'grid'},
								{label: 'List', value: 'list'},
							]}
						/>

						<SelectControl
							label={__('Items per row', 'yadore-widget')}
							value={attributes.col}
							onChange={changeCol}
							options={[
								{label: '2', value: '2'},
								{label: '3', value: '3'},
								{label: '4', value: '4'},
								{label: '6', value: '6'},
							]}
						/>
					</PanelBody>
				</InspectorControls>
			</div>
		)
	}),
	save() {
		return null;
	}
});

/**
 * Block: Search
 */
registerBlockType('yadore-widget/search', {
	title: 'Yadore Widget - Search',
	description: 'Integrate the Yadore search.',
	category: 'yadore-widget',
	icon: 'search',
	attributes: {
		layout: {
			default: 'grid'
		},
		col: {
			default: '3',
		},
		limit: {
			default: '12'
		}
	},
	edit: (props => {
		const attributes = props.attributes;
		const setAttributes = props.setAttributes;

		function changeLayout(layout) {
			setAttributes({layout});
		}

		function changeCol(col) {
			setAttributes({col});
		}

		function changeLimit(limit) {
			setAttributes({limit});
		}

		return (
			<div {...useBlockProps()}>
				<ServerSideRender
					block="yadore-widget/search"
					attributes={attributes}
				/>

				<InspectorControls key="setting">
					<PanelBody>
						<SelectControl
							label={__('Layout', 'yadore-widget')}
							value={attributes.layout}
							onChange={changeLayout}
							options={[
								{label: 'Grid', value: 'grid'},
								{label: 'List', value: 'list'},
							]}
						/>

						<SelectControl
							label={__('Items per row', 'yadore-widget')}
							value={attributes.col}
							onChange={changeCol}
							options={[
								{label: '2', value: '2'},
								{label: '3', value: '3'},
								{label: '4', value: '4'},
								{label: '6', value: '6'},
							]}
						/>

						<NumberControl
							label={__('Limit', 'yadore-widget')}
							value={attributes.limit}
							onChange={changeLimit}
							shiftStep={1}
							min={1}
							max={100}
						/>
					</PanelBody>
				</InspectorControls>
			</div>
		)
	}),
	save() {
		return null;
	}
});

/**
 * Block: Price compare
 */
registerBlockType('yadore-widget/price-compare', {
	title: 'Yadore Widget - Price Compare',
	description: 'Integrate the Yadore price compare.',
	category: 'yadore-widget',
	icon: 'chart-area',
	attributes: {
		ean: {
			default: '',
		}
	},
	edit: (props => {
		const attributes = props.attributes;
		const setAttributes = props.setAttributes;

		function changeEan(ean) {
			setAttributes({ean});
		}

		return (
			<div {...useBlockProps()}>
				<ServerSideRender
					block="yadore-widget/price-compare"
					attributes={attributes}
				/>

				<InspectorControls key="setting">
					<PanelBody>
						<TextControl
							label={__('EAN', 'yadore-widget')}
							value={attributes.ean}
							onChange={changeEan}
						/>
					</PanelBody>
				</InspectorControls>
			</div>
		)
	}),
	save() {
		return null;
	}
});
