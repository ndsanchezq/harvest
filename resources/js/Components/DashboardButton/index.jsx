import React from "react";
import { Box, Typography } from "@mui/material";
import styled from "@emotion/styled";

const Container = styled(Box)((props) => ({
  backgroundColor: "#fff",
  width: 150,
  height: 180,
  boxShadow: "-2px 4px 14px -3px rgba(0,0,0,.2)",
  borderRadius: 5,
  padding: 20,
  display: "inline-flex",
  cursor: "pointer",
  transition: "transform .2s",
  "&:hover": {
    transform: "scale(1.1)",
  },
}));

function DashboardButton({ title, iconBackgroundColor, icon, onClick }) {
  return (
    <Container
      display="flex"
      flexDirection="column"
      alignItems="center"
      justifyContent="center"
      onClick={onClick}
    >
      <Box style={{ marginBottom: 10 }}>
        <Box
          display="flex"
          alignItems="center"
          justifyContent="center"
          style={{
            padding: 10,
            borderRadius: "50%",
            backgroundColor: iconBackgroundColor,
            width: "fit-content",
            height: "fit-content",
            boxShadow: "-2px 4px 14px -3px rgba(0,0,0,.2)",
          }}
        >
          {icon}
        </Box>
      </Box>
      <Typography style={{ textAlign: "center" }} variant="caption">
        <b>{title}</b>
      </Typography>
    </Container>
  );
}

export default DashboardButton;
