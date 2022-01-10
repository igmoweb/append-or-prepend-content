import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { useDispatch, useSelect } from '@wordpress/data';
import { SelectControl, CheckboxControl } from '@wordpress/components';

const AppOrPrepOptionsPanel = () => {
	const isNewPost = useSelect((select) =>
		select('core/editor').isEditedPostNew()
	);

	const postTypes = (
		useSelect((select) => select('core').getPostTypes()) || []
	).filter(
		({ viewable, slug }) => viewable === true && slug !== 'attachment'
	);

	const {
		apporprep_action: action = '',
		apporprep_post_type: postType = '',
		apporprep_show_in_single: showInSingle = '',
		apporprep_show_in_archive: showInArchive = '',
	} = useSelect((select) =>
		select('core/editor').getEditedPostAttribute('meta')
	);

	const { editPost } = useDispatch('core/editor');

	const setAction = (value) => {
		editPost({
			meta: { apporprep_action: value },
		});
	};

	const setPostType = (value) => {
		editPost({
			meta: { apporprep_post_type: value },
		});
	};

	const setShowInSingle = (value) => {
		editPost({
			meta: { apporprep_show_in_single: value },
		});
	};

	const setShowInArchive = (value) => {
		editPost({
			meta: { apporprep_show_in_archive: value },
		});
	};

	return (
		<PluginDocumentSettingPanel
			name="apporprepend-panel"
			title="Append or Prepend Options"
			opened
		>
			{isNewPost ? (
				<p>Please, save the post first in order to select an action.</p>
			) : (
				<>
					<SelectControl
						label="Action"
						value={action}
						options={[
							{ label: '-- Select an option --', value: '' },
							{ label: 'Prepend', value: 'prepend' },
							{ label: 'Append', value: 'append' },
						]}
						onChange={setAction}
					/>

					{action !== '' && (
						<>
							<SelectControl
								label={`${
									action.charAt(0).toUpperCase() +
									action.slice(1)
								} to`}
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
							<CheckboxControl
								label="Display in single post"
								help="If the content should appear when a single post is retrieved"
								checked={showInSingle}
								onChange={setShowInSingle}
							/>
							<CheckboxControl
								label="Display in archives"
								help="If the content should appear when a list of posts is retrieved (in search, archives...). Does not apply in excerpts"
								checked={showInArchive}
								onChange={setShowInArchive}
							/>
						</>
					)}
				</>
			)}
		</PluginDocumentSettingPanel>
	);
};

registerPlugin('apporprepend-plugin', {
	render: AppOrPrepOptionsPanel,
	icon: 'schedule',
});
