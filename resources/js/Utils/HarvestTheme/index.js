import { createTheme } from "@mui/material";

const HarvestTheme = createTheme({
  typography: {
    h1: {
      fontStyle: "normal",
      fontWeight: 700,
      fontSize: "32px",
      lineHeight: "40px",
    },
    h2: {
      fontStyle: "normal",
      fontWeight: 700,
      fontSize: "20px",
      lineHeight: "24px",
    },
    h3: {
      fontStyle: "normal",
      fontWeight: 400,
      fontSize: "16px",
      lineHeight: "24px",
    },
    body1: {
      fontStyle: "normal",
      fontWeight: 400,
      fontSize: "12px",
      lineHeight: "16px",
    },
    fontFamily: [
      "-apple-system",
      "BlinkMacSystemFont",
      '"Segoe UI"',
      "Roboto",
      '"Helvetica Neue"',
      "Arial",
      "sans-serif",
      '"Apple Color Emoji"',
      '"Segoe UI Emoji"',
      '"Segoe UI Symbol"',
    ].join(","),
  },
  components: {
    MuiButton: {
      styleOverrides: {
        root: {
          height: 40,
          fontStyle: "normal",
          fontWeight: 400,
          fontSize: "12px",
          lineHeight: "16px",
          borderRadius: "12px",
          textTransform: "none",
        },
      },
    },
    MuiRadio: {
      styleOverrides: {
        root: {
          "& svg": {
            width: "0.7em",
            height: "0.7em",
          },
        },
      },
    },
    MuiFormControl: {
      styleOverrides: {
        root: {
          "& .MuiInputBase-root": {
            borderRadius: "12px",
            height: "40px",
            paddingLeft: 15,
            paddingRight: 15,
            lineHeight: "17px",
            borderColor: "#c4c4c4",
          },
          "& .MuiInputBase-input": {
            fontSize: "12px",
            lineHeight: "17px",
            textTransform: "none",
          },
          "& .MuiFormLabel-root": {
            fontSize: "12px",
            lineHeight: "17px",
            paddingLeft: 0,
            paddingRight: 0,
            color: "#979797",
            textTransform: "none",
          },
        },
      },
    },
  },
  palette: {
    primary: {
      main: "#ffcd38",
    },
    secondary: {
      main: "#ff007e",
    },
    accent: {
      dark: "#00a996",
      main: "#00f2d7",
      light: "#33f4df",
    },
    purple: {
      main: "#7C8CF9",
    },
    rose: {
      main: "#FBD7E1",
    },
    green: {
      main: "#00D77F",
    },
    burn: {
      main: "#F9C638",
    },
  },
});

export default HarvestTheme;
