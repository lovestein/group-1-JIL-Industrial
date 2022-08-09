import {
  Ajax,
  CreatePopup,
  TableListener,
  ToData,
  UpdateTable,
} from "./functions.js";

function CreateAccessory(accessory) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/products/createAccessory.php",
      type: "POST",
      data: ToData({ accessory: JSON.stringify(accessory) }),
      success: resolve,
    });
  });
}

function EditAccessory(accessoryID, accessory) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/products/editAccessory.php",
      type: "POST",
      data: ToData({
        accessoryID: accessoryID,
        accessory: JSON.stringify(accessory),
      }),
      success: resolve,
    });
  });
}

function DeleteAccessories(accessories) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/products/deleteAccessories.php",
      type: "POST",
      data: ToData({ accessories }),
      success: resolve,
    });
  });
}

function SearchAccessories(search) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/products/searchAccessories.php",
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
      url: "./api/products/ui/createAccTable.php",
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
    url: "./api/products/ui/createAccessory.php",
    type: "POST",
    success: (popup) => {
      CreatePopup(popup, (data, pop) => {
        CreateAccessory(Object.fromEntries(data)).then((res) => {
          if (parseInt(res)) {
            alert("Accessory Inserted");
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

function onEdit(accessory, reset) {
  Ajax({
    url: "./api/products/ui/editAccessory.php",
    type: "POST",
    data: ToData({ accessory }),
    success: (popup) => {
      CreatePopup(popup, (data, pop) => {
        EditAccessory(accessory, Object.fromEntries(data)).then((res) => {
          if (parseInt(res)) {
            alert("Accessory Edited");
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
    data: ToData({ count: items.length, target: "Accessory" }),
    success: (popup) => {
      CreatePopup(popup, (pop) => {
        DeleteAccessories(items).then((res) => {
          if (parseInt(res)) {
            alert("Accessories Deleted");
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

  SEARCHENGINE.addEventListener("input", () =>
    SearchAccessories(SEARCHENGINE.value)
  );
});
