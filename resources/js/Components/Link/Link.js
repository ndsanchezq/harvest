import Link from '@mui/material/Link';
import { Link as LinkInertia } from "@inertiajs/inertia-react";

export default function CustomLink(props) {
  return (
    <Link
      {...props}
      component={LinkInertia}
    >
      {props.children}
    </Link>
  );
}
