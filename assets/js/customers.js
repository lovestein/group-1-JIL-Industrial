import {
  Ajax,
  CreateInfoPopup,
  CreatePopup,
  ListenToCombo,
  ManageComboBoxes,
  TableListener,
  ToData,
  UpdateTable,
} from "./functions.js";

function CreateCustomer(basic, details) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/customers/createCustomer.php",
      type: "POST",
      data: ToData({
        basic: JSON.stringify(basic),
        details: JSON.stringify(details),
      }),
      success: resolve,
    });
  });
}

function EditCustomer(customerID, basic, details) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/customers/editCustomer.php",
      type: "POST",
      data: ToData({
        customerID: customerID,
        basic: JSON.stringify(basic),
        details: JSON.stringify(details),
      }),
      success: resolve,
    });
  });
}

function DeleteCustomers(customers) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/customers/deleteCustomers.php",
      type: "POST",
      data: ToData({ customers }),
      success: resolve,
    });
  });
}

function SearchCustomers(search) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/customers/searchCustomers.php",
      type: "POST",
      data: ToData({ search }),
      success: (table) => {
        UpdateTable(table, onAdd, onEdit, onDelete, onRefresh, null, onButton);
        resolve();
      },
    });
  });
}

function Refresh() {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/customers/ui/createTable.php",
      type: "POST",
      success: (table) => {
        UpdateTable(table, onAdd, onEdit, onDelete, onRefresh, null, onButton);
        resolve();
      },
    });
  });
}

function ToCustomer(data) {
  const datas = Object.fromEntries(data);

  delete datas.tank_deposited_bool;
  const basicFields = [
    "cust_type",
    "cust_name",
    "cust_address",
    "cust_contact_no",
  ];

  const basic = {};
  const details = {};

  for (const pair of Object.entries(datas)) {
    if (basicFields.includes(pair[0])) {
      basic[pair[0]] = pair[1];
    }
  }

  for (const pair of Object.entries(datas)) {
    if (!basicFields.includes(pair[0])) {
      details[pair[0]] = pair[1];
    }
  }

  return { basic, details };
}

function GetDepositedTankForm(deposited, customerID) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/customers/ui/getDepositedTankForm.php",
      type: "POST",
      data: ToData({ deposited, customerID }),
      success: resolve,
    });
  });
}

function onAdd(reset) {
  Ajax({
    url: "./api/customers/ui/createCustomer.php",
    type: "POST",
    success: (popup) => {
      const callback = (parent) => {
        const combo = parent.querySelector(".tank_deposited_bool");
        const info = parent.querySelector(".tank-diposited-info");

        ListenToCombo(combo, (_, val) => {
          GetDepositedTankForm(val).then((content) => {
            info.innerHTML = content;
            ManageComboBoxes();
          });
        });
      };

      CreatePopup(
        popup,
        (data, pop) => {
          const { basic, details } = ToCustomer(data);

          CreateCustomer(basic, details).then((res) => {
            if (parseInt(res)) {
              alert("New Customer Successfuly Added!");
            } else {
              alert("Something is not right!");
            }

            pop.remove();
            reset();
            Refresh();
          });
        },
        callback
      );
    },
  });
}

function onEdit(customer, reset) {
  Ajax({
    url: "./api/customers/ui/editCustomers.php",
    type: "POST",
    data: ToData({ customer }),
    success: (popup) => {
      const callback = (parent) => {
        const combo = parent.querySelector(".tank_deposited_bool");
        const info = parent.querySelector(".tank-diposited-info");
        const comboInput = combo.querySelector(
          "input[name=tank_deposited_bool]"
        );

        const update = (val) => {
          GetDepositedTankForm(val, customer).then((content) => {
            info.innerHTML = content;
            ManageComboBoxes();
          });
        };

        ListenToCombo(combo, (_, val) => update(val));
        update(comboInput.value);
      };

      CreatePopup(
        popup,
        (data, pop) => {
          const { basic, details } = ToCustomer(data);
          EditCustomer(customer, basic, details).then((res) => {
            if (parseInt(res)) {
              alert("Customer Successfully Edited");
            } else {
              alert("Something is not right!");
            }

            pop.remove();
            reset();
            Refresh();
          });
        },
        callback
      );
    },
  });
}

function onDelete(items, reset) {
  Ajax({
    url: "./api/global/ui/createDelete.php",
    type: "POST",
    data: ToData({ count: items.length, target: "Customer" }),
    success: (popup) => {
      CreatePopup(popup, (pop) => {
        DeleteCustomers(items).then((res) => {
          if (parseInt(res)) {
            alert("Customer Successfully Deleted");
          } else {
            alert("Something is not right!");
          }

          pop.remove();
          reset();
          Refresh();
        });
      });
    },
  });
}

function onRefresh(reset) {
  Refresh().then(() => {
    alert("Table Updated!");
    reset();
  });
}

function onButton(id) {
  Ajax({
    url: "./api/customers/ui/createInfo.php",
    type: "POST",
    data: ToData({ id }),
    success: (popup) => {
      CreateInfoPopup(popup, () => {});
    },
  });
}

function ManageListeners() {
  TableListener(onAdd, onEdit, onDelete, onRefresh, null, onButton);
}

document.addEventListener("DOMContentLoaded", () => {
  const SEARCHENGINE = document.querySelector(".table-item-search-engine");

  ManageListeners();

  SEARCHENGINE.addEventListener("input", () =>
    SearchCustomers(SEARCHENGINE.value)
  );
});
