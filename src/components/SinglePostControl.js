import { useMeta } from '../hooks';
import { CheckboxControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const SinglePostControl = () => {
	const [showInSingle, setShowInSingle] = useMeta('apporprep_show_in_single');
	return (
		<CheckboxControl
			label={__('Display in single post', 'apporprepp')}
			help={__(
				'If the content should appear when a single post is retrieved',
				'apporprepp'
			)}
			checked={showInSingle}
			onChange={setShowInSingle}
		/>
	);
};

export default SinglePostControl;
