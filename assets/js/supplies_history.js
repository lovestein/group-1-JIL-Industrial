import {
  AddMinusInputListener,
  Ajax,
  CreateInfoPopup,
  CreatePopup,
  ManageComboBoxes,
  OnButtonManual,
  ResetForm,
  TableListener,
  ToData,
  UpdateTable,
} from "./functions.js";

function Refresh() {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/reports/ui/createSuppliesTable.php",
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
      url: "./api/reports/ui/filterSupplies.php",
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
          resolve(null);
        }
      },
    });
  });
}

function ManageFilters() {
  const fromDate = document.querySelector("input[name=from-date]");
  const toDate = document.querySelector("input[name=to-date]");
  const expensesInput = document.querySelector("input[name=total-expenses]");

  const updateData = (data) => {
    if (data) {
      let total = 0;
      if (data && data.length) {
        total = data
          .map((ob) => parseFloat(ob.delivery_price))
          .reduce((a, b) => a + b);
      }
      expensesInput.value = total + " PHP";
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
  Refresh().then(() => {
    alert("Table Updated!");
    reset();
  });
}

function onButton(id) {
  Ajax({
    url: "./api/reports/ui/createSuppliesInfo.php",
    type: "POST",
    data: ToData({ id }),
    success: (popup) => {
      CreateInfoPopup(popup, (parent) => {
        OnButtonManual(parent, (suppID) => {
          Ajax({
            url: "./api/reports/ui/createSuppliesProdInfo.php",
            type: "POST",
            data: ToData({ id: suppID }),
            success: (suppPopup) => {
              console.log(suppPopup);
              CreateInfoPopup(suppPopup);
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
