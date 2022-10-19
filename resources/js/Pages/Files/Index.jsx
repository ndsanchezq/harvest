import { useState } from 'react';
import { Inertia } from '@inertiajs/inertia';
import { useSnackbar } from 'notistack';

import Main from '@/Layouts/Layout/Main';

import { Typography, Card, CardContent, Grid, TextField, Table, TableRow, TableCell, TableBody } from '@mui/material';
import { LoadingButton } from '@mui/lab';
import { errorToast, mapErrors, metricFormat } from '@/utils/misc';

import Breadcrumbs from "@/components/Breadcrumbs";
import Iconify from "@/components/Iconify";
import { EnhancedTableHead } from "@/components/Table";

export default function Index({ files }) {
  const { enqueueSnackbar } = useSnackbar();
  const [loading, setLoading] = useState(false);
  const [file, setFile] = useState({});
  const [order, setOrder] = useState('asc');
  const [orderBy, setOrderBy] = useState('name');

  const handleButton = () => {
    if (file.type !== "text/plain") return;

    setLoading(true);
    Inertia.post(
      route("files.store"),
      { file },
      {
        forceFormData: true,
        onError: (error) => {
          enqueueSnackbar(mapErrors(error), errorToast);
        },
        onFinish: () => {
          setLoading(false);
        },
      }
    );
  };

  const handleRequestSort = (event, property) => {
    const isAsc = orderBy === property && order === 'asc';
    setOrder(isAsc ? 'desc' : 'asc');
    setOrderBy(property);
  };

  return (
    <Main
      title="Archivos"
      breadcrumbs={
        <Breadcrumbs>
          <Typography key="1" color="text.primary">
            Archivos
          </Typography>,
        </Breadcrumbs>
      }
    >
      <Grid container spacing={2}>
        <Grid item sm={12}>
          <Card>
            <CardContent>
              <Grid container justifyContent="center" alignItems="center" spacing={2}>
                <Grid item sm={5}>
                  <TextField
                    fullWidth
                    variant="standard"
                    onChange={(e) => setFile(e.target.files[0])}
                    type="file"
                  />
                </Grid>

                <Grid item sm={2}>
                  <LoadingButton
                    type="button"
                    size="small"
                    variant="contained"
                    onClick={handleButton}
                    loading={loading}
                    fullWidth
                  >
                    Subir archivo
                  </LoadingButton>
                </Grid>
              </Grid>
            </CardContent>
          </Card>
        </Grid>

        <Grid item sm={12}>
          <Card>
            <CardContent>
              <Table sx={{ minWidth: 650 }} aria-label="simple table">
                <EnhancedTableHead
                  order={order}
                  orderBy={orderBy}
                  headLabel={[
                    { id: 'name', label: 'Nombre', alignRight: false },
                    { id: 'delivery_date', label: 'Fecha creación', width: '15%', alignRight: false },
                    { id: 'size', label: 'Tamaño', width: '20%', alignRight: false },
                    { id: '', label: '', width: '5%' }
                  ]}
                  onRequestSort={handleRequestSort}
                />
                <TableBody>
                  {files?.map(row => (
                    <TableRow
                      key={row.id}
                      sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                    >
                      <TableCell align="left">
                        {row.name}
                      </TableCell>
                      <TableCell align="left">
                        {row.created_at.split('T', 1)}
                      </TableCell>
                      <TableCell align="left">
                        {`${metricFormat(row.size)}b`}
                      </TableCell>
                      <TableCell align="left">
                        <a href={route('files.show', { file: row.id })} target="_blank">
                          <Iconify
                            icon="akar-icons:file"
                            width={24}
                            height={24}
                          />
                        </a>
                      </TableCell>
                    </TableRow>
                  ))}
                </TableBody>
              </Table>
            </CardContent>
          </Card>
        </Grid>
      </Grid>
    </Main>
  );
}
