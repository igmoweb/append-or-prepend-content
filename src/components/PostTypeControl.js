import { useMeta } from '../hooks';
import { useSelect } from '@wordpress/data';
import { SelectControl } from '@wordpress/components';

const PostTypeControl = () => {
	const postTypes = (
		useSelect((select) => select('core').getPostTypes()) || []
	).filter(
		({ viewable, slug }) => viewable === true && slug !== 'attachment'
	);

	const [action] = useMeta('apporprep_action');
	const [postType, setPostType] = useMeta('apporprep_post_type');
	return (
		<SelectControl
			label={`${action.charAt(0).toUpperCase() + action.slice(1)} to`}
			value={postType}
			options={[
				{
					label: '-- Select a post type --',
					value: '',
				},
				...postTypes.map(({ slug, name }) => ({
					label: name,
					value: slug,
				})),
			]}
			onChange={setPostType}
		/>
	);
};

export default PostTypeControl;
