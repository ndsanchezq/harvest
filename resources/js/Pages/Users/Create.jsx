import { useState } from 'react';
import { useForm } from 'react-hook-form';
import { useSnackbar } from 'notistack';

import Main from './Main';

import { Typography, Card, CardContent, Grid, IconButton, InputAdornment, Button } from '@mui/material';
import { Visibility, VisibilityOff } from '@mui/icons-material';
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

export default function Create() {
  const [loading, setLoading] = useState(false);
  const [showPassword, setShowPassword] = useState(false);
  const { enqueueSnackbar } = useSnackbar();

  const UserSchema = yup.object().shape({
    name: yup.string().required('Name is required'),
    username: yup.string().min(4).max(25).required('Username is required'),
    email: yup.string().email().required('Email is required'),
    password: yup.string().required('Password is required'),
    password_confirmation: yup.string().required('Password confirm is required')
  }).required();

  const defaultValues = {
    name: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
    status: true
  };

  const methods = useForm({
    resolver: yupResolver(UserSchema),
    defaultValues
  });

  const {
    handleSubmit
  } = methods;

  const onSubmit = async (data) => {
    setLoading(true);

    Inertia.post(route('users.store'), data, {
      onSuccess: () => {
        enqueueSnackbar('El usuario ha sido creado!', successToast);
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
              Usuario
            </Link>,
            <Typography key="3" color="text.primary">
              Crear
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
                    label="Nombre"
                  />
                </Grid>

                <Grid item sm={6}>
                  <TextField
                    name="username"
                    label="Usuario"
                  />
                </Grid>

                <Grid item sm={12}>
                  <TextField
                    name="email"
                    type="email"
                    label="Correo"
                  />
                </Grid>

                <Grid item sm={6}>
                  <TextField
                    name="password"
                    label="Contraseña"
                    type={showPassword ? 'text' : 'password'}
                    InputProps={{
                      endAdornment: (
                        <InputAdornment position="end">
                          <IconButton onClick={() => setShowPassword(!showPassword)} edge="end">
                            {showPassword ? <VisibilityOff /> : <Visibility />}
                          </IconButton>
                        </InputAdornment>
                      ),
                    }}
                  />
                </Grid>

                <Grid item sm={6}>
                  <TextField
                    name="password_confirmation"
                    label="Confirmar contraseña"
                    type={showPassword ? 'text' : 'password'}
                    InputProps={{
                      endAdornment: (
                        <InputAdornment position="end">
                          <IconButton onClick={() => setShowPassword(!showPassword)} edge="end">
                            {showPassword ? <VisibilityOff /> : <Visibility />}
                          </IconButton>
                        </InputAdornment>
                      ),
                    }}
                  />
                </Grid>

                <Grid item sm={12}>
                  <Checkbox
                    name="status"
                    label="Activo"
                  />
                </Grid>

                <Grid item sm={3}>
                  <Button
                    size="large"
                    href={route('users.index')}
                    variant="text"
                    color="secondary"
                    fullWidth
                  >
                    Cancelar
                  </Button>
                </Grid>

                <Grid item sm={3}>
                  <LoadingButton
                    type="submit"
                    size="large"
                    variant="contained"
                    loading={loading}
                    fullWidth
                  >
                    Crear
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
