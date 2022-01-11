import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { useMeta } from './hooks';
import ActionControl from './components/ActionControl';
import ArchiveControl from './components/ArchiveControl';
import PostTypeControl from './components/PostTypeControl';
import SinglePostControl from './components/SinglePostControl';

const AppOrPrepOptionsPanel = () => {
	const isNewPost = useSelect((select) =>
		select('core/editor').isEditedPostNew()
	);

	const [action] = useMeta('apporprep_action');

	return (
		<PluginDocumentSettingPanel
			name="apporprepend-panel"
			title="Append or Prepend Options"
			opened
		>
			{isNewPost ? (
				<p>
					{__(
						'Please, save the post first in order to select an action.',
						'appor'
					)}
				</p>
			) : (
				<>
					<ActionControl />
					{action !== '' && (
						<>
							<PostTypeControl />
							<SinglePostControl />
							<ArchiveControl />
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
