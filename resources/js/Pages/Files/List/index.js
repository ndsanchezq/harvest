import Authenticated from "@/Layouts/Authenticated";
import { Inertia } from "@inertiajs/inertia";
import React, { useEffect, useState } from "react";

function FilesList({ files, auth, errors }) {
  return (
    <Authenticated auth={auth} errors={errors}>
      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="w-full text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            {files?.map((file) => (
              <a
                key={file?.id}
                target="_blank"
                href={`/files/download/${file?.id}`}
                className="inline-flex relative items-center py-2 px-4 w-full text-sm font-medium rounded-b-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white"
              >
                <svg
                  aria-hidden="true"
                  className="mr-2 w-4 h-4 fill-current"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fillRule="evenodd"
                    d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z"
                    clipRule="evenodd"
                  ></path>
                </svg>
                {file?.name}
              </a>
            ))}
          </div>
        </div>
      </div>
    </Authenticated>
  );
}

export default FilesList;
