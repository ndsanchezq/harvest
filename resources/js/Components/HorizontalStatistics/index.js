import { Grid, Typography } from "@mui/material";
import React from "react";
import CounterIndicator from "../CounterIndicator";
import AccountBalanceIcon from "@mui/icons-material/AccountBalance";
import ReceiptIcon from "@mui/icons-material/Receipt";
import PriceCheckIcon from "@mui/icons-material/PriceCheck";
import ShoppingCartCheckoutIcon from "@mui/icons-material/ShoppingCartCheckout";
import TaskIcon from "@mui/icons-material/Task";
import CurrencyExchangeIcon from "@mui/icons-material/CurrencyExchange";

function HorizontalStatistics(props) {
  return (
    <Grid
      container
      style={{
        height: 200,
        borderRadius: 10,
        padding: 30,
        backgroundColor: "#fff",
        boxShadow: "-2px 4px 14px -3px rgba(0,0,0,.2)",
      }}
    >
      <Grid item xs={12}>
        <Typography variant="h4">Resumen Débito</Typography>
      </Grid>

      <Grid item xs={3}>
        <CounterIndicator
          title="Pagos realizados"
          value={1320}
          icon={<PriceCheckIcon style={{ color: "#fff" }} />}
          backgroundIconColor="#57c900"
        />
      </Grid>

      <Grid item xs={3}>
        <CounterIndicator
          title="Pagos en proceso"
          value={500}
          icon={<CurrencyExchangeIcon style={{ color: "#fff" }} />}
          backgroundIconColor="#fc0"
        />
      </Grid>

      <Grid item xs={3}>
        <CounterIndicator
          title="Cuentas en validación"
          value={20}
          icon={<AccountBalanceIcon style={{ color: "#fff" }} />}
        />
      </Grid>

      <Grid item xs={3}>
        <CounterIndicator
          title="Cuentas validadas"
          value={721}
          icon={<TaskIcon style={{ color: "#fff" }} />}
          backgroundIconColor={"#804BDF"}
        />
      </Grid>
    </Grid>
  );
}

export default HorizontalStatistics;
