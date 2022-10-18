import { Box, Stack, IconButton } from '@mui/material';
import { AppBarStyled, ToolbarStyled } from './styles';

import Iconify from '@/components/Iconify';
import AccountPopover from '@/components/AccountPopover';

import PropTypes from 'prop-types';

export default function Navbar({ onOpenSidebar }) {
  return (
    <AppBarStyled>
      <ToolbarStyled>
        <IconButton
          onClick={onOpenSidebar}
          sx={{
            mr: 1,
            color: 'text.primary',
            display: {
              lg: 'none'
            }
          }}
        >
          <Iconify icon="eva:menu-2-fill" />
        </IconButton>

        <Box sx={{ flexGrow: 1 }} />

        <Stack direction="row" alignItems="center" spacing={{ xs: 0.5, sm: 1.5 }}>
          <AccountPopover />
        </Stack>
      </ToolbarStyled>
    </AppBarStyled>
  );
};

Navbar.propTypes = {
  onOpenSidebar: PropTypes.func
};
