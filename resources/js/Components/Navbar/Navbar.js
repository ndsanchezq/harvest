import { Box, Stack, IconButton } from '@mui/material';
import { AppBarStyled, ToolbarStyled } from './styles';
import Iconify from '@/Components/Iconify';
import AccountPopover from '@/Components/AccountPopover';
import PropTypes from 'prop-types';

export default function Navbar({ auth, onOpenSidebar }) {
  return (
    <AppBarStyled>
      <ToolbarStyled>
        <IconButton onClick={onOpenSidebar} sx={{mr: 1, color: 'text.primary', display: { lg: 'none' } }}>
          <Iconify icon="eva:menu-1-fill" />
        </IconButton>

        <Box sx={{ flexGrow: 1 }} />

        <Stack direction="row" alignItems="center" spacing={{ xs: 0.5, sm: 1.5 }}>
          <AccountPopover auth={auth} />
        </Stack>
      </ToolbarStyled>
    </AppBarStyled>
  );
};

Navbar.propTypes = {
  onOpenSidebar: PropTypes.func
};
