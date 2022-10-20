import { useState } from 'react';
import { RootStyle, MainStyle } from './styles';
import { Head } from '@inertiajs/inertia-react';

import Navbar from '@/layouts/Navbar';
import Sidebar from '@/layouts/Sidebar';

export default function Layout({ title, children }) {
  const [open, setOpen] = useState(false);

  return (
    <RootStyle>
      <Head title={title} />
      <Navbar
        onOpenSidebar={() => setOpen(true)}
      />
      <Sidebar
        isOpenSidebar={open}
        onCloseSidebar={() => setOpen(false)}
      />
      <MainStyle>
        {children}
      </MainStyle>
    </RootStyle>
  );
}
