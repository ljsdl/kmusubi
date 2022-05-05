/**
 * External dependencies
 */
 import classnames from 'classnames';

 /**
  * WordPress dependencies
  */
 import { useBlockProps } from '@wordpress/block-editor';
 
 /**
  * Internal dependencies
  */
 import Spacers from './spacers';
 
 export default function save({ attributes, anchor }) {
	 const { spaceType, unit, pc, tablet, mobile } = attributes;
	 return (
		 <div
			 {...useBlockProps.save({
				 className: classnames('vk_spacer'),
				 id: anchor,
			 })}
		 >
			 <Spacers
				 type={spaceType}
				 pcSize={pc}
				 tabletSize={tablet}
				 mobileSize={mobile}
				 unit={unit}
			 />
		 </div>
	 );
 }