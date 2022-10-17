import Main from "@/layouts/Layout";
import { Container, Typography } from '@mui/material';

export default function Dashboard() {
  return (
    <Main title="Dashboard">
      <Container>
        <Typography variant="h4" sx={{ mb: 5 }}>
          Holi, Welcome back
        </Typography>
      </Container>
    </Main>
  );
}
