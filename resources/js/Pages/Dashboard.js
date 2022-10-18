import SmallPriceCard from "@/Components/SmallPriceCard";
import Main from "@/layouts/Layout";
import { Container, Grid, Typography } from "@mui/material";
import PaymentIcon from "@mui/icons-material/Payment";
import AccountBalanceWalletIcon from "@mui/icons-material/AccountBalanceWallet";
import { formatCurrency, metricFormat } from "@/utils/misc";

export default function Dashboard() {
  return (
    <Main title="Dashboard">
      <Container>
        <Grid container spacing={2}>
          <Grid item>
            <SmallPriceCard
              title="Mercado pago"
              subtitle={"Beneficio semanal"}
              value={`$${metricFormat(25400000)}`}
              iconBackgroundColor={"#57C900"}
              icon={<PaymentIcon style={{ color: "#fff" }} />}
            />
          </Grid>
          <Grid item>
            <SmallPriceCard
              title="Debito bancario"
              subtitle={"Beneficio semanal"}
              value={`$${metricFormat(10000)}`}
              iconBackgroundColor={"#3c3c3b"}
              icon={<AccountBalanceWalletIcon style={{ color: "#fff" }} />}
            />
          </Grid>
        </Grid>
      </Container>
    </Main>
  );
}
