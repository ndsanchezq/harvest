import { useState } from 'react';
import { Inertia } from '@inertiajs/inertia';
import { useSnackbar } from 'notistack';

import Main from './Main';

import { Typography, Card, CardContent, Grid, FormControlLabel, TextField, Link, Checkbox } from '@mui/material';
import { LoadingButton } from '@mui/lab';
import { errorToast, mapErrors } from '@/utils/misc';

import Breadcrumbs from "@/components/Breadcrumbs";

export default function Index({ files }) {
  const { enqueueSnackbar } = useSnackbar();
  const [loading, setLoading] = useState(false);
  const [file, setFile] = useState({});

  const handleButton = () => {
    if (file.type !== 'text/plain') return;

    setLoading(true);
    Inertia.post(route('files.store'), { file }, {
      forceFormData: true,
      onError: (error) => {
        setLoading(false);
        enqueueSnackbar(mapErrors(error), errorToast);
      }
    });
  }

  const handleChange = (e) => {
    if (e.target.type == 'file') setFile(e.target.files[0]);
  }

  return (
    <Main
      breadcrumbs={
        <Breadcrumbs
          children={[
            <Typography key="1" color="text.primary">
              Archivos
            </Typography>,
          ]}
        />
      }
      children={
        <Grid container spacing={2}>
          <Grid item sm={12}>
            <Card>
              <CardContent>
                <Grid container justifyContent="center" alignItems="center" spacing={2}>
                  <Grid item sm={10}>
                    <TextField
                      fullWidth
                      variant="standard"
                      onChange={handleChange}
                      type="file"
                    />
                  </Grid>

                  <Grid item sm={2}>
                    <LoadingButton
                      type="button"
                      size="large"
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

          {files?.map((file) => (
            <Grid item sm={12}>
              <Card key={file?.id}>
                <CardContent>
                  <Link href={`/files/${file?.id}`}>{file?.name}</Link>
                </CardContent>
              </Card>
            </Grid>
          ))}
        </Grid>
      }
    />
  );
}
