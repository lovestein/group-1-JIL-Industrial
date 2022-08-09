import {
  Ajax,
  CreatePopup,
  TableListener,
  ToData,
  UpdateTable,
} from "./functions.js";

function CreateSupplier(supplier) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/supplier/createSupplier.php",
      type: "POST",
      data: ToData({ supplier: JSON.stringify(supplier) }),
      success: resolve,
    });
  });
}

function EditSupplier(supplierID, supplier) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/supplier/editSupplier.php",
      type: "POST",
      data: ToData({
        supplierID: supplierID,
        supplier: JSON.stringify(supplier),
      }),
      success: resolve,
    });
  });
}

function DeleteSuppliers(suppliers) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/supplier/deleteSuppliers.php",
      type: "POST",
      data: ToData({ suppliers }),
      success: resolve,
    });
  });
}

function SearchSuppliers(search) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/supplier/searchSupplier.php",
      type: "POST",
      data: ToData({ search }),
      success: (table) => {
        UpdateTable(table, onAdd, onEdit, onDelete, onRefresh, null, null);
        resolve();
      },
    });
  });
}

function Refresh() {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/supplier/ui/createTable.php",
      type: "POST",
      success: (table) => {
        UpdateTable(table, onAdd, onEdit, onDelete, onRefresh, null, null);
        resolve();
      },
    });
  });
}

function onAdd(reset) {
  Ajax({
    url: "./api/supplier/ui/createSupplier.php",
    type: "POST",
    success: (popup) => {
      CreatePopup(popup, (data, pop) => {
        CreateSupplier(Object.fromEntries(data)).then((res) => {
          if (parseInt(res)) {
            alert("Supplier Successfully Inserted");
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

function onEdit(supplier, reset) {
  Ajax({
    url: "./api/supplier/ui/editSupplier.php",
    type: "POST",
    data: ToData({ supplier }),
    success: (popup) => {
      CreatePopup(popup, (data, pop) => {
        EditSupplier(supplier, Object.fromEntries(data)).then((res) => {
          if (parseInt(res)) {
            alert("Supplier Successfully Edited");
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

function onDelete(items, reset) {
  Ajax({
    url: "./api/global/ui/createDelete.php",
    type: "POST",
    data: ToData({ count: items.length, target: "Supplier" }),
    success: (popup) => {
      CreatePopup(popup, (pop) => {
        DeleteSuppliers(items).then((res) => {
          if (parseInt(res)) {
            alert("Supplier Successfully Deleted");
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

function ManageListeners() {
  TableListener(onAdd, onEdit, onDelete, onRefresh, null, null);
}

document.addEventListener("DOMContentLoaded", () => {
  const SEARCHENGINE = document.querySelector(".table-item-search-engine");

  ManageListeners();

  SEARCHENGINE.addEventListener("input", () => {
    SearchSuppliers(SEARCHENGINE.value);
  });
});
