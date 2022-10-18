require("./bootstrap");

import { render } from "react-dom";
import { createInertiaApp } from "@inertiajs/inertia-react";
import { InertiaProgress } from "@inertiajs/progress";

import ThemeProvider from "@/theme";
import GlobalStyles from "./utils/GlobalStyles";

const appName =
  window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => require(`./pages/${name}`),
  setup({ el, App, props }) {
    return render(
      <ThemeProvider>
        <GlobalStyles />
        <App {...props} />
      </ThemeProvider>,
      el
    );
  },
});

InertiaProgress.init({ color: "#EB6608" });
