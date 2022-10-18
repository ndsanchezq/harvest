import { Box, Typography } from "@mui/material";
import React from "react";

function SmallPriceCard({
  title,
  value,
  subtitle,
  icon,
  iconBackgroundColor = "#3c3c3b",
}) {
  return (
    <Box
      style={{
        backgroundColor: "#fff",
        width: 170,
        height: 180,
        boxShadow: "-2px 4px 14px -3px rgba(0,0,0,.2)",
        borderRadius: 5,
        padding: 20,
        display: "inline-flex",
      }}
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
    </Box>
  );
}

export default SmallPriceCard;
