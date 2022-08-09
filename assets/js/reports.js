import {
  AddMinusInputListener,
  Ajax,
  CreateInfoPopup,
  ManageComboBoxes,
  OnButtonManual,
  TableListener,
  ToData,
  UpdateTable,
} from "./functions.js";

let ALREADYREFRESHED = false;

function Refresh() {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/reports/ui/createOverViewTable.php",
      type: "POST",
      success: (table) => {
        UpdateTable(table, null, null, null, onRefresh, null, onButton);
        resolve();
      },
    });
  });
}

function FilterTable(fromDate, toDate) {
  const data = fromDate ? { data: { fromDate, toDate } } : {};
  return new Promise((resolve) => {
    Ajax({
      url: "./api/reports/ui/filterOverview.php",
      type: "POST",
      ...data,
      success: (res) => {
        try {
          const data = JSON.parse(res);

          if (data) {
            UpdateTable(
              data.table,
              null,
              null,
              null,
              onRefresh,
              null,
              onButton
            );

            resolve(data.data);
          }
        } catch (error) {
          console.log(error);
          resolve(null);
        }
      },
    });
  });
}

function ManageFilters() {
  const fromDate = document.querySelector("input[name=from-date]");
  const toDate = document.querySelector("input[name=to-date]");
  const salesInput = document.querySelector("input[name=total-sales]");
  const expensesInput = document.querySelector("input[name=total-expenses]");
  const incomeInput = document.querySelector("input[name=total-income]");

  const updateData = (data) => {
    if (data) {
      let totalSales = data.total_sales || 0;
      let totalExpenses = data.total_expenses || 0;
      let totalIncome = data.total_income || 0;

      salesInput.value = totalSales + " PHP";
      expensesInput.value = totalExpenses + " PHP";
      incomeInput.value = totalIncome + " PHP";
    }
  };

  const filterTable = () => {
    if (!fromDate.value || !toDate.value) return;
    const fd = new Date(fromDate.value).getTime();
    const td = new Date(toDate.value).getTime();

    if (fd <= td) {
      FilterTable(fromDate.value, toDate.value).then(updateData);
    } else {
      alert("Incorrect Dates!");
    }
  };

  fromDate.addEventListener("change", filterTable);
  toDate.addEventListener("change", filterTable);
  FilterTable().then(updateData);
}

function onRefresh(reset) {
  if (!ALREADYREFRESHED) {
    ALREADYREFRESHED = true;
    Refresh().then(() => {
      alert("Table Updated!");
      reset();

      ALREADYREFRESHED = false;
    });
  }
}

function onButton(id) {
  Ajax({
    url: "./api/reports/ui/createSalesInfo.php",
    type: "POST",
    data: ToData({ id }),
    success: (popup) => {
      CreateInfoPopup(popup, (parent) => {
        OnButtonManual(parent, (transID) => {
          Ajax({
            url: "./api/reports/ui/createSalesTransacInfo.php",
            type: "POST",
            data: ToData({ id: transID }),
            success: (transPopup) => {
              CreateInfoPopup(transPopup);
            },
          });
        });
      });
    },
  });
}

document.addEventListener("DOMContentLoaded", () => {
  TableListener(null, null, null, onRefresh, null, onButton);
  ManageFilters();
  ManageComboBoxes();
  AddMinusInputListener();
});
