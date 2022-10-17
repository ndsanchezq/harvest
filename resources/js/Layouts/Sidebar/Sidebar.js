import { usePage } from '@inertiajs/inertia-react';
import { Box, Link, Drawer, Typography, Avatar } from '@mui/material';
import { RootStyle, AccountStyle, DRAWER_WIDTH } from './styles';
import useResponsive from '@/hooks/useResponsive';
import Scrollbar from '@/components/Scrollbar';
import Logo from '@/components/Logo';
import NavSection from './NavSection';
import navConfig from './NavConfig';
import PropTypes from 'prop-types';

export default function Sidebar({ isOpenSidebar, onCloseSidebar }) {
  const isDesktop = useResponsive('up', 'lg');
  const { auth } = usePage().props;

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
            <Avatar src="/static/images/avatar/1.jpg" />
            <Box sx={{ ml: 2 }}>
              <Typography variant="subtitle2" noWrap>
                {auth.user.name}
              </Typography>
              <Typography variant="body2" sx={{ color: 'text.secondary' }} noWrap>
                {auth.user.email}
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
            sx: { width: DRAWER_WIDTH }
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
              backgroundColor: '#FFFFFF'
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
