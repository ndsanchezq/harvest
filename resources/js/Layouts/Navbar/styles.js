import { alpha, styled } from '@mui/material/styles';
import { AppBar, Toolbar } from '@mui/material';

const DRAWER_WIDTH = 340;
const APPBAR_MOBILE = 64;
const APPBAR_DESKTOP = 92;

export const AppBarStyled = styled(AppBar)(({ theme }) => ({
  boxShadow: '1',
  backdropFilter: 'blur(6px)',
  WebkitBackdropFilter: 'blur(6px)', // Fix on Mobile
  backgroundColor: alpha(theme.palette.background.default, 0.10),
  [theme.breakpoints.up('lg')]: {
    width: `calc(100% - ${DRAWER_WIDTH + 1}px)`,
  },
}));

export const ToolbarStyled = styled(Toolbar)(({ theme }) => ({
  minHeight: APPBAR_MOBILE,
  [theme.breakpoints.up('lg')]: {
    minHeight: APPBAR_DESKTOP,
    padding: theme.spacing(0, 5),
  },
}));
