import { createStyles, makeStyles } from "@mui/styles";

const useStyles = makeStyles(() =>
  createStyles({
    "@global": {
      html: {
        boxSizing: "border-box",
      },
      "*, *:before, *:after": {
        boxSizing: "inherit",
      },
      body: {
        padding: 0,
        margin: 0,
        height: "100%",
        width: "100%",
        color: "#4d4d4d",
      },
      "h1, h2, h3, h4, h5, p": {
        margin: 0,
      },
      "#root": {
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
        height: "100vh",
        width: "100vw",
      },
      a: {
        textDecoration: "none",
        color: "#393939",
      },
      ".Mui-disabled": { opacity: 0.5, cursor: "not-allowed" },
    },
  })
);

const GlobalStyles = () => {
  useStyles();

  return null;
};

export default GlobalStyles;
