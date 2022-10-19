import SmallPriceCard from "@/Components/SmallPriceCard";
import Main from "@/layouts/Layout";
import { Container, Grid, Typography } from "@mui/material";
import PaymentIcon from "@mui/icons-material/Payment";
import AccountBalanceWalletIcon from "@mui/icons-material/AccountBalanceWallet";
import { formatCurrency, metricFormat } from "@/utils/misc";
import HorizontalStatistics from "@/Components/HorizontalStatistics";
import DescriptionIcon from "@mui/icons-material/Description";

export default function Dashboard(props) {
  const { payments_made, payments_in_process, accounts_in_process, validates_accounts, mercado_pago, bank_debit, files } = props;

  return (
    <Main title="Dashboard">
      <Container>
        <Grid item xs={12} style={{ marginBottom: 20 }}>
          <HorizontalStatistics
            paymentsMade={payments_made}
            paymentsInProcess={payments_in_process}
            accountsInProcess={accounts_in_process}
            validatesAccounts={validates_accounts}
          />
        </Grid>
        <Grid container spacing={2}>
          <Grid item>
            <SmallPriceCard
              title="Mercado pago"
              subtitle={"Beneficio semanal"}
              value={`$${metricFormat(mercado_pago)}`}
              iconBackgroundColor={"#57C900"}
              icon={<PaymentIcon style={{ color: "#fff" }} />}
            />
          </Grid>
          <Grid item>
            <SmallPriceCard
              title="Debito bancario"
              subtitle={"Beneficio semanal"}
              value={`$${metricFormat(bank_debit)}`}
              iconBackgroundColor={"#3c3c3b"}
              icon={<AccountBalanceWalletIcon style={{ color: "#fff" }} />}
            />
          </Grid>

          <Grid item>
            <SmallPriceCard
              title="Archivos"
              subtitle={"Registro semanal"}
              value={`${metricFormat(files)}`}
              iconBackgroundColor={"#EB6608"}
              icon={<DescriptionIcon style={{ color: "#fff" }} />}
            />
          </Grid>
        </Grid>
      </Container>
    </Main>
  );
}
