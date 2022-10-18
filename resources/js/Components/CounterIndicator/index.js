import React from "react";
import { Box, Typography } from "@mui/material";
import styled from "@emotion/styled";

const IconContainer = styled(Box)((props) => ({
  padding: 10,
  borderRadius: 10,
  backgroundColor: `${props?.backgroundIconColor}`,
  width: "fit-content",
  height: "fit-content",
  marginRight: 10,
  boxShadow: "-2px 4px 14px -3px rgba(0,0,0,.2)",
}));

const Container = styled(Box)((props) => ({
  cursor: "pointer",
  transition: "transform .2s",
  "&:hover": {
    transform: "scale(1.1)",
  },
}));

function CounterIndicator({
  title,
  value,
  icon,
  backgroundIconColor = "#3c3c3b",
}) {
  return (
    <Container display="flex" justifyContent="center" alignItems="center">
      <IconContainer
        backgroundIconColor={backgroundIconColor}
        display="flex"
        justifyContent="center"
        alignItems="center"
      >
        {icon}
      </IconContainer>
      <Box>
        <Typography variant="caption">{title}</Typography>
        <Typography variant="h5">{value}</Typography>
      </Box>
    </Container>
  );
}

export default CounterIndicator;
