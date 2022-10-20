import Layout from "@/layouts/Layout";
import { Stack, Container, Typography } from "@mui/material";

export default function Main({ title, createButton, breadcrumbs, children }) {
  return (
    <Layout
      title={title}
    >
      <Container>
        <Stack
          direction="row"
          alignItems="center"
          justifyContent="space-between"
        >
          <Typography variant="h4" gutterBottom>
            {title}
          </Typography>
          {createButton}
        </Stack>
        {breadcrumbs}

        {children}
      </Container>
    </Layout>
  );
}
