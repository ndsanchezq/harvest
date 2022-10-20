import { InputAdornment } from '@mui/material';
import { StyledSearch } from './styles';
import Iconify from '@/components/Iconify';
import PropTypes from 'prop-types';

export default function EnhancedTableToolbar({ filterName, onFilterName }) {
  return (
    <StyledSearch
      value={filterName}
      onChange={onFilterName}
      fullWidth
      placeholder="Buscar"
      startAdornment={
        <InputAdornment position="start">
          <Iconify
            icon="eva:search-fill"
            sx={{
              color: 'text.disabled',
              width: 20,
              height: 20
            }} />
        </InputAdornment>
      }
    />
  );
}

EnhancedTableToolbar.propTypes = {
  filterName: PropTypes.string,
  onFilterName: PropTypes.func,
};
