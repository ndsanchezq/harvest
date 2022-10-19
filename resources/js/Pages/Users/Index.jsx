import { useState } from 'react';
import { Link } from '@inertiajs/inertia-react';

import Main from '@/Layouts/Layout/Main';

import { Typography, Card, CardActions, CardContent, TableContainer, Table, TablePagination, TableRow, TableCell, TableBody, Button, Chip } from '@mui/material';

import Breadcrumbs from '@/components/Breadcrumbs';
import Iconify from '@/components/Iconify';
import { EnhancedTableToolbar, EnhancedTableHead, MoreOptions } from '@/components/Table';

export default function Index(props) {
  const { data, current_page, total } = props.users;

  const [order, setOrder] = useState('asc');
  const [orderBy, setOrderBy] = useState('name');

  const [filterName, setFilterName] = useState('');

  const [page, setPage] = useState(current_page - 1);
  const [rowsPerPage, setRowsPerPage] = useState(5);

  const handleRequestSort = (event, property) => {
    const isAsc = orderBy === property && order === 'asc';
    setOrder(isAsc ? 'desc' : 'asc');
    setOrderBy(property);
  };

  const handleFilterByName = (event) => {
    setPage(0);
    setFilterName(event.target.value);
  };

  const handleChangePage = (event, newPage) => {
    setPage(newPage);
  };

  const handleChangeRowsPerPage = (event) => {
    setPage(0);
    setRowsPerPage(parseInt(event.target.value, 10));
  };

  return (
    <Main
      title="Usuarios"
      breadcrumbs={
        <Breadcrumbs>
          <Typography key="1" color="text.primary">
            Usuarios
          </Typography>
        </Breadcrumbs>
      }
      createButton={
        <Button variant="contained" component={Link} href={route('users.create')} startIcon={<Iconify icon="eva:plus-fill" />}>
          Nuevo Usuario
        </Button>
      }
    >
      <Card>
        <CardActions sx={{ mt: 2, ml: 2, mr: 2 }}>
          <EnhancedTableToolbar
            filterName={filterName}
            onFilterName={handleFilterByName}
          />
        </CardActions>
        <CardContent>
          <TableContainer>
            <Table sx={{ minWidth: 650 }} aria-label="user table">
              <EnhancedTableHead
                order={order}
                orderBy={orderBy}
                headLabel={[
                  { id: 'name', label: 'Nombre', alignRight: false },
                  { id: 'status', label: 'Estado', width: '10%', alignRight: false },
                  { id: '', width: '5%' }
                ]}
                onRequestSort={handleRequestSort}
              />
              <TableBody>
                {data.map(user => (
                  <TableRow
                    key={user.id}
                    sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                  >
                    <TableCell component="th" scope="user">
                      {user.name}
                    </TableCell>
                    <TableCell align="left">
                      <Chip
                        variant="outlined"
                        label={`${user.status ? "Activo" : "Inactivo"}`}
                        color={`${user.status ? "success" : "error"}`}
                        sx={{
                          width: '100%'
                        }}
                      />
                    </TableCell>
                    <TableCell align="right">
                      <MoreOptions
                        onEdit={route('users.edit', { user: user.id })}
                      />
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </TableContainer>
          <TablePagination
            rowsPerPageOptions={[5, 10, 25]}
            component="div"
            count={total}
            rowsPerPage={rowsPerPage}
            page={page}
            onPageChange={handleChangePage}
            onRowsPerPageChange={handleChangeRowsPerPage}
          />
        </CardContent>
      </Card>
    </Main>
  );
};
