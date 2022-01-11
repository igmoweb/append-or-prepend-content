import { useMeta } from '../hooks';
import { CheckboxControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const ArchiveControl = () => {
	const [showInArchive, setShowInArchive] = useMeta(
		'apporprep_show_in_archive'
	);
	return (
		<CheckboxControl
			label={__('Display in archives', 'apporprepp')}
			help={__(
				'If the content should appear when a list of posts is retrieved (in search, archives...). Does not apply in excerpts',
				'apporprepp'
			)}
			checked={showInArchive}
			onChange={setShowInArchive}
		/>
	);
};

export default ArchiveControl;
