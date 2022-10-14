import Iconify from '@/Components/Iconify';

const getIcon = (name) => <Iconify icon={name} width={22} height={22} />;

const navConfig = [
  {
    title: 'dashboard',
    path: '/',
    icon: getIcon('eva:pie-chart-2-fill'),
  },
  {
    title: 'Users',
    path: '/users',
    icon: getIcon('eva:people-fill'),
  },
  {
    title: 'files',
    path: '/files',
    icon: getIcon('akar-icons:file'),
  }
];

export default navConfig;
