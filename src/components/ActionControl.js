import { useMeta } from '../hooks';
import { SelectControl } from '@wordpress/components';

const ActionControl = () => {
	const [action, setAction] = useMeta('apporprep_action');
	return (
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
	);
};

export default ActionControl;
