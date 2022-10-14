import { useState } from 'react';
import { RootStyle, MainStyle } from './styles';

import Navbar from '@/Components/Navbar';
import Sidebar from '@/Layouts/Sidebar';

export default function Main({ auth, children }) {
  const [open, setOpen] = useState(false);

  return (
    <RootStyle>
      <Navbar
        auth={auth}
        onOpenSidebar={() => setOpen(true)}
      />
      <Sidebar
        auth={auth}
        isOpenSidebar={open}
        onCloseSidebar={() => setOpen(false)}
      />
      <MainStyle>
        {children}
      </MainStyle>
    </RootStyle>
  );
}
