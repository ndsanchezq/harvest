import Breadcrumbs from '@mui/material/Breadcrumbs';
import Stack from '@mui/material/Stack';
import Link from '@/components/Link';
import NavigateNextIcon from '@mui/icons-material/NavigateNext';

export default function CustomSeparator({ children }) {
  return (
    <Stack>
      <Breadcrumbs separator={<NavigateNextIcon fontSize="small" />} aria-label="breadcrumb" sx={{ mb: 2 }}>
        <Link key="1" color="inherit" underline="hover" href={route("dashboard")}>
          Dashboard
        </Link>
        {children}
      </Breadcrumbs>
    </Stack>
  );
}
