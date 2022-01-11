import { useMeta } from '../hooks';
import { CheckboxControl } from '@wordpress/components';
const SinglePostControl = () => {
	const [showInSingle, setShowInSingle] = useMeta('apporprep_show_in_single');
	return (
		<CheckboxControl
			label="Display in single post"
			help="If the content should appear when a single post is retrieved"
			checked={showInSingle}
			onChange={setShowInSingle}
		/>
	);
};

export default SinglePostControl;
