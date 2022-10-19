import { useTheme } from '@mui/material/styles';
import useMediaQuery from '@mui/material/useMediaQuery';

export default function useResponsive(query, key, start, end) {
  const theme = useTheme();

  const SCREEN = {
    'up': useMediaQuery(theme.breakpoints.up(key)),
    'down': useMediaQuery(theme.breakpoints.down(key)),
    'between': useMediaQuery(theme.breakpoints.between(start, end)),
    'only': useMediaQuery(theme.breakpoints.only(key))
  };

  return SCREEN[query] || null;
}
