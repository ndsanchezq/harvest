import React from "react";
import Authenticated from "@/Layouts/Authenticated";

function About(props) {
  return (
    <Authenticated
      auth={props.auth}
      errors={props.errors}
      header={
        <h2 className="font-semibold text-xl text-gray-800 leading-tight">
          Dashboard
        </h2>
      }
    >
      about
    </Authenticated>
  );
}

export default About;
