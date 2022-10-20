import SmallPriceCard from "@/Components/SmallPriceCard";
import Main from "@/layouts/Layout";
import { Button, Container, Grid, Link, Typography } from "@mui/material";
import PaymentIcon from "@mui/icons-material/Payment";
import AccountBalanceWalletIcon from "@mui/icons-material/AccountBalanceWallet";
import { formatCurrency, metricFormat, successToast } from "@/utils/misc";
import HorizontalStatistics from "@/Components/HorizontalStatistics";
import DescriptionIcon from "@mui/icons-material/Description";
import DashboardButton from "@/Components/DashboardButton";
import { useEffect } from "react";
import { useSnackbar } from "notistack";
import { Inertia } from "@inertiajs/inertia";
import { useState } from "react";

export default function Dashboard({
  payments_made,
  payments_in_process,
  accounts_in_process,
  validates_accounts,
  mercado_pago,
  bank_debit,
  files,
}) {
  const { enqueueSnackbar } = useSnackbar();
  const [loading, setLoading] = useState(false);

  const handlePostCreditCardPayments = () => {
    setLoading(true);
    Inertia.post(route("credit_card.payments"), {});
  };

  useEffect(() => {
    success && enqueueSnackbar(success, successToast);
  }, []);

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
              title="Débito bancario"
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

          <Grid item>
            <DashboardButton
              title="Generar Archivo Validación Cuentas"
              iconBackgroundColor={"#09D9EC"}
              icon={<DescriptionIcon style={{ color: "#fff" }} />}
            />
          </Grid>

          <Grid item>
            <DashboardButton
              title="Generar Archivo Cobro Bancario"
              iconBackgroundColor={"#EB071D"}
              icon={<DescriptionIcon style={{ color: "#fff" }} />}
            />
          </Grid>

          <Grid item>
            <DashboardButton
              onClick={handlePostCreditCardPayments}
              title="Generar Pagos Tarjeta Crédito"
              iconBackgroundColor={"#D3EB07"}
              icon={<PaymentIcon style={{ color: "#fff" }} />}
            />
          </Grid>
        </Grid>
      </Container>
    </Main>
  );
}
