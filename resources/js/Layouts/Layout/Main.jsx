import Layout from "@/layouts/Layout";
import { Stack, Container, Typography } from "@mui/material";

export default function Main({ breadcrumbs, children, title }) {
  return (
    <Layout title="Files">
      <Container>
        <Stack
          direction="row"
          alignItems="center"
          justifyContent="space-between"
        >
          <Typography variant="h4" gutterBottom>
            {title}
          </Typography>
        </Stack>
        {breadcrumbs}

        {children}
      </Container>
    </Layout>
  );
}