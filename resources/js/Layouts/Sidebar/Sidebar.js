import { Box, Link, Drawer, Typography, Avatar, Stack } from '@mui/material';
import { RootStyle, AccountStyle, DRAWER_WIDTH } from './styles';
import useResponsive from '@/Hooks/useResponsive';
import Scrollbar from '@/Components/Scrollbar';
import Logo from '@/Components/Logo';
import NavSection from './NavSection';
import navConfig from './NavConfig';
import PropTypes from 'prop-types';

export default function Sidebar({ auth, isOpenSidebar, onCloseSidebar }) {
  const isDesktop = useResponsive('up', 'lg');

  const renderContent = (
    <Scrollbar
      sx={{
        height: 1,
        '& .simplebar-content': { height: 1, display: 'flex', flexDirection: 'column' },
      }}
    >
      <Box sx={{ px: 2.5, py: 1, display: 'inline-flex' }}>
        <Logo height={50} width={80} />
      </Box>

      <Box sx={{ mb: 2, mx: 2.5 }}>
        <Link underline="none" to="#">
          <AccountStyle>
            <Avatar src='{account.photoURL}' alt="photoURL" />
            <Box sx={{ ml: 2 }}>
              <Typography variant="subtitle2" sx={{ color: 'text.primary' }}>
                {/* {auth.user.name} */}
              </Typography>
            </Box>
          </AccountStyle>
        </Link>
      </Box>

      <NavSection navConfig={navConfig} />

      <Box sx={{ flexGrow: 1 }} />
    </Scrollbar>
  );

  return (
    <RootStyle>
      {!isDesktop && (
        <Drawer
          open={isOpenSidebar}
          onClose={onCloseSidebar}
          PaperProps={{
            sx: { width: DRAWER_WIDTH },
          }}
        >
          {renderContent}
        </Drawer>
      )}

      {isDesktop && (
        <Drawer
          open
          variant="persistent"
          PaperProps={{
            sx: {
              width: DRAWER_WIDTH,
              bgcolor: 'background.default',
              borderRightStyle: 'dashed',
            },
          }}
        >
          {renderContent}
        </Drawer>
      )}
    </RootStyle>
  );
};

Sidebar.propTypes = {
  isOpenSidebar: PropTypes.bool,
  onCloseSidebar: PropTypes.func,
};
