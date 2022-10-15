import React, { useState } from "react";
import Sidebar from "@/Layouts/Sidebar";
import Navbar from "./Navbar";
import { ThemeProvider } from "@mui/material";
import HarvestTheme from "@/Utils/HarvestTheme";
import GlobalStyles from "@/Utils/GlobalStyles";

export default function Authenticated({ auth, header, children }) {
  return (
    <ThemeProvider theme={HarvestTheme}>
      <GlobalStyles />
      <div className="min-h-screen bg-gray-100">
        <Navbar auth={auth} />

        <div className="min-h-screen lg:flex">
          <Sidebar />

          <main className="flex-auto w-full min-w-0 lg:static lg:max-h-full lg:overflow-visible">
            {children}
          </main>
        </div>
      </div>
    </ThemeProvider>
  );
}
