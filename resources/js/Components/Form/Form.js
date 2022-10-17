import { FormProvider } from 'react-hook-form';
import PropTypes from 'prop-types';

export default function Form({ children, onSubmit, methods }) {
  return (
    <FormProvider {...methods}>
      <form onSubmit={onSubmit}>
        {children}
      </form>
    </FormProvider>
  );
};

Form.propTypes = {
  children: PropTypes.node.isRequired,
  methods: PropTypes.object.isRequired,
  onSubmit: PropTypes.func,
};
