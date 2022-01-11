import { useMeta } from '../hooks';
import { CheckboxControl } from '@wordpress/components';

const ArchiveControl = () => {
	const [showInArchive, setShowInArchive] = useMeta(
		'apporprep_show_in_archive'
	);
	return (
		<CheckboxControl
			label="Display in archives"
			help="If the content should appear when a list of posts is retrieved (in search, archives...). Does not apply in excerpts"
			checked={showInArchive}
			onChange={setShowInArchive}
		/>
	);
};

export default ArchiveControl;
