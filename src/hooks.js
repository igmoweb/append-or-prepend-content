import { useDispatch, useSelect } from '@wordpress/data';

export const useMeta = (metaKey) => {
	if (!metaKey) {
		return null;
	}

	const meta = useSelect((select) =>
		select('core/editor').getEditedPostAttribute('meta')
	);

	const { editPost } = useDispatch('core/editor');

	const updateMeta = (value) => {
		editPost({
			meta: { [metaKey]: value },
		});
	};

	return [meta[metaKey] || '', updateMeta];
};
