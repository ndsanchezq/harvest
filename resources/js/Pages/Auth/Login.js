import { useState } from 'react';
import { Head } from '@inertiajs/inertia-react';
import { Container, Typography, Stack, IconButton, InputAdornment } from '@mui/material';
import { Visibility, VisibilityOff } from '@mui/icons-material';
import { LoadingButton } from '@mui/lab';
import Logo from '@/Components/Logo';
import { FormProvider, BDTextField } from '@/Components/hooks-form';
import useResponsive from '@/Hooks/useResponsive';
import { useForm } from 'react-hook-form';
import { RootStyle, HeaderStyle, SectionStyle, ContentStyle } from './styles';
import { yupResolver } from '@hookform/resolvers/yup';
import * as yup from 'yup';

export default function Login({ status }) {
  const mdUp = useResponsive('up', 'md');
  const [loading, setLoading] = useState(false);
  const [showPassword, setShowPassword] = useState(false);

  const LoginSchema = yup.object().shape({
    username: yup.string().required('Username is required'),
    password: yup.string().required('Password is required')
  }).required();

  const defaultValues = {
    username: '',
    password: ''
  };

  const methods = useForm({
    resolver: yupResolver(LoginSchema),
    defaultValues
  });

  const {
    handleSubmit
  } = methods;

  const onSubmit = async (data) => {
    setLoading(true);

    axios.post(route('login'), data)
      .catch(err => {
        setLoading(false);
      });
  };

  return (
    <RootStyle>
      <Head title="Log in" />

      <HeaderStyle>
        <Logo />
      </HeaderStyle>

      {mdUp && (
        <SectionStyle>
          <Typography variant="h3" sx={{ px: 5, mt: 10, mb: 5 }}>
            Holi, Welcome Back 🤫
          </Typography>
        </SectionStyle>
      )}

      <Container maxWidth="sm">
        <ContentStyle>
          <Typography variant="h4" gutterBottom>
            Sign in
          </Typography>

          <FormProvider methods={methods} onSubmit={handleSubmit(onSubmit)}>
            <Stack spacing={2}>
              <BDTextField
                name="username"
                label="Username"
              />

              <BDTextField
                name="password"
                label="Password"
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

              <LoadingButton fullWidth size="large" type="submit" variant="contained" loading={loading}>
                Login
              </LoadingButton>
            </Stack>
          </FormProvider>
        </ContentStyle>
      </Container>
    </RootStyle>
  );
}
