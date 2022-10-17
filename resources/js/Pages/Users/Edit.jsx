import { useState } from 'react';
import { useForm } from 'react-hook-form';
import { useSnackbar } from 'notistack';

import Main from './Main';

import { Typography, Card, CardContent, Grid } from '@mui/material';
import { LoadingButton } from '@mui/lab';

import Breadcrumbs from '@/components/Breadcrumbs';
import Link from '@/components/Link';
import Form from '@/components/Form';
import TextField from '@/components/TextField';
import Checkbox from '@/components/Checkbox';

import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { Inertia } from '@inertiajs/inertia';
import { successToast, errorToast, mapErrors } from '@/utils/misc';

export default function Edit(props) {
  const { id, name, username, email, status } = props.user;

  const [loading, setLoading] = useState(false);
  const { enqueueSnackbar } = useSnackbar();

  const LoginSchema = yup.object().shape({
    name: yup.string().required('Name is required'),
    username: yup.string().min(4).max(25).required('Username is required'),
    email: yup.string().email().required('Email is required')
  }).required();

  const defaultValues = { name, username, email, status };

  const methods = useForm({
    resolver: yupResolver(LoginSchema),
    defaultValues
  });

  const {
    handleSubmit
  } = methods;

  const onSubmit = async (data) => {
    setLoading(true);

    Inertia.put(route('users.update', { user: id }), data, {
      onSuccess: (resp) => {
        enqueueSnackbar('The user has been updated!', successToast);
      },
      onError: (error) => {
        setLoading(false);

        enqueueSnackbar(mapErrors(error), errorToast);
      }
    });
  };

  return (
    <Main
      breadcrumbs={
        <Breadcrumbs
          children={([
            <Link underline="hover" key="1" color="inherit" href={route('users.index')}>
              Users
            </Link>,
            <Typography key="2" color="text.primary">
              {name}
            </Typography>,
            <Typography key="3" color="text.primary">
              Edit
            </Typography>
          ])}
        />
      }
      children={(
        <Card>
          <CardContent>
            <Form methods={methods} onSubmit={handleSubmit(onSubmit)}>
              <Grid container justifyContent="center" alignItems="center" spacing={2}>
                <Grid item sm={6}>
                  <TextField
                    name="name"
                    label="Name"
                  />
                </Grid>

                <Grid item sm={6}>
                  <TextField
                    name="username"
                    label="Username"
                  />
                </Grid>

                <Grid item sm={12}>
                  <TextField
                    name="email"
                    type="email"
                    label="Email"
                  />
                </Grid>

                <Grid item sm={12}>
                  <Checkbox
                    name="status"
                    label="Active"
                  />
                </Grid>

                <Grid item sm={6}>
                  <LoadingButton
                    type="submit"
                    size="large"
                    variant="contained"
                    loading={loading}
                    fullWidth
                  >
                    Save
                  </LoadingButton>
                </Grid>
              </Grid>
            </Form>
          </CardContent>
        </Card>
      )}
    />
  );
};
