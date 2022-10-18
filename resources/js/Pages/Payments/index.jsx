import React from "react";
import { Container, Typography } from "@mui/material";

import Main from "@/Layouts/Layout/main";
import Breadcrumbs from "@/components/Breadcrumbs";

function ListPayments(props) {
  return (
    <Main
      title="Pagos"
      breadcrumbs={<Breadcrumbs children={<Typography>Pagos</Typography>} />}
    >
      <Container>Pagos</Container>
    </Main>
  );
}

export default ListPayments;
