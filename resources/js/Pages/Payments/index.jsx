import { useState } from "react";

import { Typography, Card, CardContent, TableContainer, Table, TableBody, TableRow, TableCell } from '@mui/material';

import Main from "@/Layouts/Layout/Main";

import { EnhancedTableHead } from '@/components/Table';
import Breadcrumbs from "@/components/Breadcrumbs";
import Iconify from "@/components/Iconify";

export default function Index(props) {
  const [order, setOrder] = useState('asc');
  const [orderBy, setOrderBy] = useState('name');

  const handleRequestSort = (event, property) => {
    const isAsc = orderBy === property && order === 'asc';
    setOrder(isAsc ? 'desc' : 'asc');
    setOrderBy(property);
  };

  return (
    <Main
      title="Pagos"
      breadcrumbs={
        <Breadcrumbs>
          <Typography>Pagos</Typography>
        </Breadcrumbs>
      }
    >
      <Card>
        <CardContent>
          <TableContainer>
            <Table sx={{ minWidth: 650 }} aria-label="user table">
              <EnhancedTableHead
                order={order}
                orderBy={orderBy}
                headLabel={[
                  { id: 'id', label: 'ID', width: '10%', alignRight: false },
                  { id: 'customer', label: 'Cliente', alignRight: false },
                  { id: 'amount', label: 'Valor', width: '15%', alignRight: false },
                  { id: 'payment_type_id', label: 'Tipo de pago', width: '20%', alignRight: false },
                  { id: 'payment_date', label: 'Fecha/Hora', width: '20%', alignRight: false },
                  { id: '', label: 'Factura', width: '5%' },
                ]}
                onRequestSort={handleRequestSort}
              />
              <TableBody>
                {props.payments.map(row => (
                  <TableRow
                    key={row.id}
                    sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                  >
                    <TableCell component="th" scope="payment">
                      {row.id}
                    </TableCell>
                    <TableCell align="left">
                      {row.agreement.customer.first_name} {row.agreement.customer.last_name}
                    </TableCell>
                    <TableCell align="left">
                      {row.amount}
                    </TableCell>
                    <TableCell align="left">
                      {row.type.label}
                    </TableCell>
                    <TableCell align="left">
                      {row.payment_date}
                    </TableCell>
                    <TableCell align="left">
                      {row.invoice.pdf ? (
                        <a href={row.invoice.pdf} target="_blank">
                          <Iconify
                            icon="ant-design:file-pdf-filled"
                            color="red"
                            width={24}
                            height={24}
                          />
                        </a>
                      ) : '--'}
                    </TableCell>
                  </TableRow>
                ))}

                {props.payments.length < 0 && (
                  <TableRow style={{ height: 53 * emptyRows }}>
                    <TableCell colSpan={5} />
                  </TableRow>
                )}
              </TableBody>
            </Table>
          </TableContainer>
        </CardContent>
      </Card>
    </Main>
  );
};
