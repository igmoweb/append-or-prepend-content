import { useMeta } from '../hooks';
import { useSelect } from '@wordpress/data';
import { SelectControl } from '@wordpress/components';
import { _x, __, sprintf } from '@wordpress/i18n';

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
			label={sprintf(
				_x(
					'%s to ',
					'Action to perform on a post type. i.e. Append to/Prepend to where %s is the post type',
					'apporprepp'
				),
				action.charAt(0).toUpperCase() + action.slice(1)
			)}
			value={postType}
			options={[
				{
					label: __('-- Select a post type --', 'apporprepp'),
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
