import { Head } from '@inertiajs/inertia-react';
import { Container, Typography } from '@mui/material';
import { RootStyle, HeaderStyle, SectionStyle, ContentStyle } from './styles';
import useResponsive from '@/hooks/useResponsive';
import Logo from '@/components/Logo';
import LoginForm from './LoginForm';

export default function Login() {
  const mdUp = useResponsive('up', 'md');

  return (
    <RootStyle>
      <Head title="Log in" />

      <HeaderStyle>
        <Logo color="#FFFFFF" />
      </HeaderStyle>

      {mdUp && (
        <SectionStyle />
      )}

      <Container maxWidth="sm">
        <ContentStyle>
          <Typography variant="h4" gutterBottom>
            Sign in
          </Typography>

          <LoginForm />
        </ContentStyle>
      </Container>
    </RootStyle>
  );
}
