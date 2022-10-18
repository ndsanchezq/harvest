export const successToast = {
  variant: "success",
  autoHideDuration: 2500,
};

export const errorToast = {
  variant: "error",
  autoHideDuration: 2500,
};

export const infoToast = {
  variant: "info",
  autoHideDuration: 2500,
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

export const formatCurrency = (currency) => {
  return new Intl.NumberFormat().format(currency);
};

export const metricFormat = (value) => {
  if (value > 0 && value < 1000000) {
    return `${(value / 1000).toFixed(1)}k`;
  }

  if (value >= 1000000) {
    return `${(value / 1000000).toFixed(1)}M`;
  }

  return value;
};
