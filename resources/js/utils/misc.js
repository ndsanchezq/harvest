export const successToast = {
  variant: "success",
  autoHideDuration: 2500
};

export const errorToast = {
  variant: "error",
  autoHideDuration: 2500
};

export const infoToast = {
  variant: "info",
  autoHideDuration: 2500
};

export const mapErrors = (error) => {
  if (Array.isArray(error)) {
    return error.map((err) => Object.values(err)).join(",");
  } else if (typeof error === "string") {
    return error;
  } else {
    return Object.values(error).join(",");
  }
};
