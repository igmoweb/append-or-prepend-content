import { useMeta } from '../hooks';
import { SelectControl } from '@wordpress/components';
import { __, _x } from '@wordpress/i18n';

const ActionControl = () => {
	const [action, setAction] = useMeta('apporprep_action');
	return (
		<SelectControl
			label={__('Action', 'apporprepp')}
			value={action}
			options={[
				{
					label: _x(
						'-- Select an option --',
						'select an action: prepend/append',
						'apporprepp'
					),
					value: '',
				},
				{ label: __('Prepend', 'apporprepp'), value: 'prepend' },
				{ label: __('Append', 'apporprepp'), value: 'append' },
			]}
			onChange={setAction}
		/>
	);
};

export default ActionControl;
