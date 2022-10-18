import Iconify from '@/components/Iconify';

const getIcon = (name) => <Iconify icon={name} width={22} height={22} />;

const navConfig = [
  {
    title: 'Dashboard',
    match: 'Dashboard',
    path: route('dashboard'),
    icon: getIcon('eva:pie-chart-2-fill'),
  },
  {
    title: 'Usuarios',
    match: 'Users',
    path: route('users.index'),
    icon: getIcon('eva:people-fill'),
  },
  {
    title: 'Archivos',
    match: 'Files',
    path: route('files.index'),
    icon: getIcon('akar-icons:file'),
  }
];

export default navConfig;
