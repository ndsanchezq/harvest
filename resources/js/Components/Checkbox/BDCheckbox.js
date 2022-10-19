import { useFormContext, Controller } from 'react-hook-form';
import { Checkbox, FormControlLabel } from '@mui/material';
import PropTypes from 'prop-types';

export default function BDCheckbox({ name, ...other }) {
  const { control } = useFormContext();

  return (
    <FormControlLabel
      control={
        <Controller
          name={name}
          control={control}
          render={({ field }) => <Checkbox {...field} checked={field.value} />}
        />
      }
      {...other}
    />
  );
};

BDCheckbox.propTypes = {
  name: PropTypes.string.isRequired,
};
