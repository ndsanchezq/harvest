import { useState } from 'react';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-react';
import { Chip, Avatar, Divider, MenuItem, ListItem, ListItemAvatar, ListItemText } from '@mui/material';
import MenuPopover from '@/components/MenuPopover';

export default function AccountPopover() {
  const { auth } = usePage().props;
  const [open, setOpen] = useState(null);

  const handleOpen = (event) => {
    setOpen(event.currentTarget);
  };

  const handleClose = () => {
    setOpen(null);
  };

  return (
    <>
      <Chip
        variant="outlined"
        color="primary"
        label={`Hola, ${auth.user.name}`}
        avatar={<Avatar src="/static/images/avatar/1.jpg" />}
        onClick={handleOpen}
      />

      <MenuPopover
        open={Boolean(open)}
        anchorEl={open}
        onClose={handleClose}
        sx={{
          p: 0,
          mt: 1.5,
          ml: 0.75,
          '& .MuiMenuItem-root': {
            typography: 'body2',
            borderRadius: 0.75,
          },
        }}
      >
        <ListItem>
          <ListItemAvatar>
            <Avatar src="/static/images/avatar/1.jpg" />
          </ListItemAvatar>
          <ListItemText
            primary={auth.user.name}
            secondary={auth.user.email}
            secondaryTypographyProps={{
              style: {
                whiteSpace: 'nowrap',
                overflow: 'hidden',
                textOverflow: 'ellipsis'
              }
            }} />
        </ListItem>

        <Divider />

        <MenuItem onClick={() => Inertia.post(route('logout'))} sx={{ m: 1 }}>
          Cerrar sesión
        </MenuItem>
      </MenuPopover>
    </>
  );
}
