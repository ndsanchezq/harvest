import { useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-react";
import { useSnackbar } from "notistack";

import Main from "./Main";

import {
  Typography,
  Card,
  CardContent,
  Grid,
  TextField,
  Table,
  TableHead,
  TableRow,
  TableCell,
  TableBody,
} from "@mui/material";
import { LoadingButton } from "@mui/lab";
import { errorToast, mapErrors } from "@/utils/misc";

import Breadcrumbs from "@/components/Breadcrumbs";

export default function Index({ files }) {
  const { enqueueSnackbar } = useSnackbar();
  const [loading, setLoading] = useState(false);
  const [file, setFile] = useState({});

  const handleButton = () => {
    if (file.type !== "text/plain") return;

    setLoading(true);
    Inertia.post(
      route("files.store"),
      { file },
      {
        forceFormData: true,
        onError: (error) => {
          enqueueSnackbar(mapErrors(error), errorToast);
        },
        onFinish: () => {
          setLoading(false);
        },
      }
    );
  };

  return (
    <Main
      breadcrumbs={
        <Breadcrumbs
          children={[
            <Typography key="1" color="text.primary">
              Archivos
            </Typography>,
          ]}
        />
      }
      children={
        <Grid container spacing={2}>
          <Grid item sm={12}>
            <Card>
              <CardContent>
                <Grid
                  container
                  justifyContent="center"
                  alignItems="center"
                  spacing={2}
                >
                  <Grid item sm={5}>
                    <TextField
                      fullWidth
                      variant="standard"
                      onChange={(e) => setFile(e.target.files[0])}
                      type="file"
                    />
                  </Grid>

                  <Grid item sm={2}>
                    <LoadingButton
                      type="button"
                      size="small"
                      variant="contained"
                      onClick={handleButton}
                      loading={loading}
                      fullWidth
                    >
                      Subir archivo
                    </LoadingButton>
                  </Grid>
                </Grid>
              </CardContent>
            </Card>
          </Grid>

          <Grid item sm={12}>
            <Card>
              <CardContent>
                <Table sx={{ minWidth: 650 }} aria-label="simple table">
                  <TableHead>
                    <TableRow>
                      <TableCell>Nombre</TableCell>
                    </TableRow>
                  </TableHead>
                  <TableBody>
                    {files?.map((file) => (
                      <TableRow
                        key={file.id}
                        sx={{
                          "&:last-child td, &:last-child th": { border: 0 },
                        }}
                      >
                        <TableCell scope="user">
                          <a href={route("files.show", { file: file.id })}>
                            {file.name}
                          </a>
                        </TableCell>
                      </TableRow>
                    ))}
                  </TableBody>
                </Table>
              </CardContent>
            </Card>
          </Grid>
        </Grid>
      }
    />
  );
}
