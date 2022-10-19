import { usePage } from '@inertiajs/inertia-react';
import { Box, List } from '@mui/material';
import NavItem from './NavItem';
import PropTypes from 'prop-types';

export default function NavSection({ navConfig, ...other }) {
  const { component } = usePage()

  const match = (path) => component.startsWith(path);

  return (
    <Box {...other}>
      <List disablePadding sx={{ p: 1 }}>
        {navConfig.map((item) => (
          <NavItem key={item.title} item={item} active={match} />
        ))}
      </List>
    </Box>
  );
};

NavSection.propTypes = {
  navConfig: PropTypes.array,
};
