import { useMemo } from 'react';
import { CssBaseline } from '@mui/material';
import { ThemeProvider as MUIThemeProvider, createTheme, StyledEngineProvider } from '@mui/material/styles';
import palette from './palette';
import typography from './typography';
import componentsOverride from './overrides';
import shadows, { customShadows } from './shadows';
import { SnackbarProvider } from 'notistack';
import PropTypes from 'prop-types';

export default function ThemeProvider({ children }) {
  const themeOptions = useMemo(() => ({
    palette,
    shape: { borderRadius: 8 },
    typography,
    shadows,
    customShadows,
  }), []);

  const theme = createTheme(themeOptions);
  theme.components = componentsOverride(theme);

  return (
    <StyledEngineProvider injectFirst>
      <MUIThemeProvider theme={theme}>
        <SnackbarProvider anchorOrigin={{ vertical: 'top', horizontal: 'center' }} maxSnack={3}>
          <CssBaseline />
          {children}
        </SnackbarProvider>
      </MUIThemeProvider>
    </StyledEngineProvider>
  );
};

ThemeProvider.propTypes = {
  children: PropTypes.node,
};
