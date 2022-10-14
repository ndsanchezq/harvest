// import React from "react";
// import Main from "@/Layouts/Main";
// import { Link } from '@inertiajs/inertia-react';

// export default function Index(props) {
//   return (
//     <Main
//       auth={props.auth}
//       errors={props.errors}
//       header={
//         <h2 className="font-semibold text-xl text-gray-800 leading-tight">
//           Users
//         </h2>
//       }
//     >
//       <div className="py-12">
//         <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
//           <div className="flex items-center justify-between mb-6">
//             <Link as="button" type="button" className="py-2 px-4 bg-gray-700 text-white font-semibold rounded-lg shadow-md hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75" href={route('users.create')}>
//               Crear
//             </Link>
//           </div>
//           <div className="bg-white rounded-md shadow overflow-x-auto">
//             <table className="w-full whitespace-nowrap">
//               <thead>
//                 <tr className="text-left font-bold">
//                   <th className="pb-4 w-80 pt-6 px-6">Nombre</th>
//                   <th className="pb-4 w-20 pt-6 px-6">Activo</th>
//                 </tr>
//               </thead>
//               <tbody>
//                 {props.users.length ? props.users.map(user => (
//                   <tr className="hover:bg-gray-100 focus-within:bg-gray-100 w-auto" key={user.id}>
//                     <td className="border-t">
//                       <Link className="flex items-center px-6 py-4" href={route('users.edit', user.id)} tabIndex="-1">
//                         {user.name}
//                       </Link>
//                     </td>
//                     <td className="border-t">
//                       <Link className="flex items-center px-6 py-4" href={route('users.edit', user.id)} tabIndex="-1">
//                         {user.status ? 'SI' : 'NO'}
//                       </Link>
//                     </td>
//                   </tr>
//                 )) : (
//                   <tr>
//                     <td className="px-6 py-4 border-t text-center" colSpan={2}>No hay registros.</td>
//                   </tr>
//                 )}
//               </tbody >
//             </table >
//           </div >
//         </div >
//       </div >
//     </Main>
//   );
// };


import { filter } from 'lodash';
import { useState } from 'react';
import Main from '@/Layouts/Main';
// material
import {
  Card,
  Table,
  Stack,
  Avatar,
  Button,
  TableRow,
  TableBody,
  TableCell,
  Container,
  Typography,
  TableContainer,
  TablePagination,
} from '@mui/material';
// components
import Label from '@/Components/Label';
import Scrollbar from '@/Components/Scrollbar';
import Iconify from '@/Components/Iconify';
// import SearchNotFound from '../components/SearchNotFound';
import { Link } from '@inertiajs/inertia-react';
import { UserListHead, UserListToolbar, UserMoreMenu } from '@/Pages/Users/components';


// // ----------------------------------------------------------------------

// const TABLE_HEAD = [
//   { id: 'name', label: 'Name', alignRight: false },
//   { id: 'role', label: 'Role', alignRight: false },
//   { id: 'status', label: 'Status', alignRight: false },
//   { id: '' },
// ];

// // ----------------------------------------------------------------------

// function descendingComparator(a, b, orderBy) {
//   if (b[orderBy] < a[orderBy]) {
//     return -1;
//   }
//   if (b[orderBy] > a[orderBy]) {
//     return 1;
//   }
//   return 0;
// }

// function getComparator(order, orderBy) {
//   return order === 'desc'
//     ? (a, b) => descendingComparator(a, b, orderBy)
//     : (a, b) => -descendingComparator(a, b, orderBy);
// }

// function applySortFilter(array, comparator, query) {
//   const stabilizedThis = array.map((el, index) => [el, index]);
//   stabilizedThis.sort((a, b) => {
//     const order = comparator(a[0], b[0]);
//     if (order !== 0) return order;
//     return a[1] - b[1];
//   });
//   if (query) {
//     return filter(array, (_user) => _user.name.toLowerCase().indexOf(query.toLowerCase()) !== -1);
//   }
//   return stabilizedThis.map((el) => el[0]);
// }

export default function Index() {
  // const [page, setPage] = useState(0);

  // const [order, setOrder] = useState('asc');

  // const [selected, setSelected] = useState([]);

  // const [orderBy, setOrderBy] = useState('name');

  // const [filterName, setFilterName] = useState('');

  // const [rowsPerPage, setRowsPerPage] = useState(5);

  // const handleRequestSort = (event, property) => {
  //   const isAsc = orderBy === property && order === 'asc';
  //   setOrder(isAsc ? 'desc' : 'asc');
  //   setOrderBy(property);
  // };

  // const handleSelectAllClick = (event) => {
  //   if (event.target.checked) {
  //     const newSelecteds = props.users.map((n) => n.name);
  //     setSelected(newSelecteds);
  //     return;
  //   }
  //   setSelected([]);
  // };

  // const handleChangePage = (event, newPage) => {
  //   setPage(newPage);
  // };

  // const handleChangeRowsPerPage = (event) => {
  //   setRowsPerPage(parseInt(event.target.value, 10));
  //   setPage(0);
  // };

  // const handleFilterByName = (event) => {
  //   setFilterName(event.target.value);
  // };

  // const emptyRows = page > 0 ? Math.max(0, (1 + page) * rowsPerPage - props.users.length) : 0;

  // const filteredUsers = applySortFilter(props.users, getComparator(order, orderBy), filterName);

  // const isUserNotFound = filteredUsers.length === 0;

  return (
    <Main>
      <Container>
        <Stack direction="row" alignItems="center" justifyContent="space-between" mb={5}>
          <Typography variant="h4" gutterBottom>
            User
          </Typography>
          <Button variant="contained" component={Link} to="#" startIcon={<Iconify icon="eva:plus-fill" />}>
            New User
          </Button>
        </Stack>

        {/* <Card>
          <UserListToolbar numSelected={selected.length} filterName={filterName} onFilterName={handleFilterByName} />

          <Scrollbar>
            <TableContainer sx={{ minWidth: 800 }}>
              <Table>
                <UserListHead
                  order={order}
                  orderBy={orderBy}
                  headLabel={TABLE_HEAD}
                  rowCount={props.users.length}
                  numSelected={selected.length}
                  onRequestSort={handleRequestSort}
                  onSelectAllClick={handleSelectAllClick}
                />
                <TableBody>
                  {filteredUsers.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage).map((row) => {
                    const { id, name, status } = row;
                    const isItemSelected = selected.indexOf(name) !== -1;

                    return (
                      <TableRow
                        hover
                        key={id}
                        tabIndex={-1}
                        role="checkbox"
                        selected={isItemSelected}
                        aria-checked={isItemSelected}
                      >
                        <TableCell component="th" scope="row" padding="none">
                          <Stack direction="row" alignItems="center" spacing={2}>
                            <Avatar alt={name} src='{avatarUrl}' />
                            <Typography variant="subtitle2" noWrap>
                              {name}
                            </Typography>
                          </Stack>
                        </TableCell>
                        <TableCell align="left">'role'</TableCell>
                        <TableCell align="left">{status ? 'Yes' : 'No'}</TableCell>
                        <TableCell align="left">
                          <Label variant="ghost" color={(!status && 'error') || 'success'}>
                            {status}
                          </Label>
                        </TableCell>

                        <TableCell align="right">
                          <UserMoreMenu />
                        </TableCell>
                      </TableRow>
                    );
                  })}
                  {emptyRows > 0 && (
                    <TableRow style={{ height: 53 * emptyRows }}>
                      <TableCell colSpan={6} />
                    </TableRow>
                  )}
                </TableBody>

                {isUserNotFound && (
                  <TableBody>
                    <TableRow>
                      <TableCell align="center" colSpan={6} sx={{ py: 3 }}>
                        <SearchNotFound searchQuery={filterName} />
                      </TableCell>
                    </TableRow>
                  </TableBody>
                )}
              </Table>
            </TableContainer>
          </Scrollbar>

          <TablePagination
            rowsPerPageOptions={[5, 10, 25]}
            component="div"
            count={props.users.length}
            rowsPerPage={rowsPerPage}
            page={page}
            onPageChange={handleChangePage}
            onRowsPerPageChange={handleChangeRowsPerPage}
          />
        </Card> */}
      </Container>
    </Main>
  );
}
