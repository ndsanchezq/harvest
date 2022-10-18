import { Link } from '@inertiajs/inertia-react';

import Main from './Main';

import { Typography, Card, CardContent, Table, TableHead, TableRow, TableCell, TableBody, Button, Chip } from '@mui/material';

import Breadcrumbs from '@/components/Breadcrumbs';
import Iconify from '@/components/Iconify';
import { MoreOptions } from '@/components/Table';

export default function Index(props) {
  const { data } = props.users;

  return (
    <Main
      breadcrumbs={
        <Breadcrumbs
          children={([
            <Typography key="1" color="text.primary">
              Users
            </Typography>
          ])}
        />
      }
      createButton={
        <Button variant="contained" component={Link} href={route('users.create')} startIcon={<Iconify icon="eva:plus-fill" />}>
          New User
        </Button>
      }
      children={(
        <Card>
          <CardContent>
            <Table sx={{ minWidth: 650 }} aria-label="simple table">
              <TableHead>
                <TableRow>
                  <TableCell>Name</TableCell>
                  <TableCell width="15%" align="left">Status</TableCell>
                  <TableCell width="10%" align="right"></TableCell>
                </TableRow>
              </TableHead>
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
                        label={`${user.status ? "Active" : "Inactive"}`}
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
          </CardContent>
        </Card>
      )}
    />
  );
};
