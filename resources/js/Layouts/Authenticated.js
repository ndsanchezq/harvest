import React, { useState } from "react";
import Sidebar from "@/Layouts/Sidebar";
import Navbar from "./Navbar";

export default function Authenticated({ auth, header, children }) {
  return (
    <div className="min-h-screen bg-gray-100">
      <Navbar auth={auth} />

      <div className="min-h-screen lg:flex">
        <Sidebar />

        <main className="flex-auto w-full min-w-0 lg:static lg:max-h-full lg:overflow-visible">
          {children}
        </main>
      </div>
    </div>
  );
}
