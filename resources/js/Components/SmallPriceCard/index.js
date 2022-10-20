import React from "react";
import styled from "@emotion/styled";
import { Box, Typography } from "@mui/material";

const Container = styled(Box)((props) => ({
  backgroundColor: "#fff",
  width: 160,
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

function SmallPriceCard({
  title,
  value,
  subtitle,
  icon,
  iconBackgroundColor = "#3c3c3b",
}) {
  return (
    <Container
      display="flex"
      flexDirection="column"
      justifyContent="space-between"
    >
      <Box>
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
      <Typography variant="body2">
        <b>{title}</b>
      </Typography>
      <Typography variant="h5">{value}</Typography>
      <Typography variant="caption">{subtitle}</Typography>
    </Container>
  );
}

export default SmallPriceCard;
