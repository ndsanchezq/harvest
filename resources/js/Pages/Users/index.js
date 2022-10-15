import React from "react";
import Authenticated from "@/Layouts/Authenticated";
import Datatable from "@/Components/Datatable";

function Users(props) {
  return (
    <Authenticated auth={props.auth} errors={props.errors}>
      <Datatable></Datatable>
    </Authenticated>
  );
}

export default Users;
