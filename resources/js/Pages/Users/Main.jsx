import Layout from '@/layouts/Layout';
import { Stack, Container, Typography } from '@mui/material';

export default function Main({ createButton, breadcrumbs, children }) {
  return (
    <Layout title="Users">
      <Container>
        <Stack direction="row" alignItems="center" justifyContent="space-between">
          <Typography variant="h4" gutterBottom>
            Usuarios
          </Typography>
          {createButton}
        </Stack>
        {breadcrumbs}

        {children}
      </Container>
    </Layout>
  );
}
