import Main from "./Main";

import { Typography, Card, CardContent, Grid, Link } from "@mui/material";

import Breadcrumbs from "@/components/Breadcrumbs";
import TextField from "@mui/material/TextField";

export default function Index({ files }) {
  return (
    <Main
      breadcrumbs={
        <Breadcrumbs
          children={[
            <Typography key="1" color="text.primary">
              Files
            </Typography>,
          ]}
        />
      }
      children={
        <Grid container spacing={2}>
          <Grid item sm={6}>
            <Card>
              <CardContent>
                <TextField fullWidth variant="standard" type="file" />
              </CardContent>
            </Card>
          </Grid>

          <Grid item xs={12} spacing={2}>
            {files?.map((file) => (
              <Card key={file?.id}>
                <CardContent>
                  <Link href={`/files/${file?.id}`}>{file?.name}</Link>
                </CardContent>
              </Card>
            ))}
          </Grid>
        </Grid>
      }
    />
  );
}
