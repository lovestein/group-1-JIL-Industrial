import {
  Ajax,
  CreateInfoPopup,
  CreatePopup,
  GetComboValue,
  TableListener,
  ToData,
  UpdateTable,
} from "./functions.js";

function CreateTank(name, types) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/products/createTank.php",
      type: "POST",
      data: ToData({ name, types: JSON.stringify(types) }),
      success: resolve,
    });
  });
}

function EditTank(tankID, name, types, created) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/products/editTank.php",
      type: "POST",
      data: ToData({
        tankID: tankID,
        name,
        types: JSON.stringify(types),
        created: JSON.stringify(created),
      }),
      success: resolve,
    });
  });
}

function DeleteTanks(tanks) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/products/deleteTanks.php",
      type: "POST",
      data: ToData({ tanks }),
      success: resolve,
    });
  });
}

function SearchTank(search) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/products/searchTanks.php",
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
      url: "./api/products/ui/createTable.php",
      type: "POST",
      success: (table) => {
        UpdateTable(table, onAdd, onEdit, onDelete, onRefresh, null, onButton);
        resolve();
      },
    });
  });
}

function CreateProductType(tank, type, refID) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/products/ui/createTankType.php",
      type: "POST",
      data: ToData({ tank, type, refID }),
      success: (popup) => {
        CreatePopup(popup, (data, pop) => {
          resolve(Object.fromEntries(data));
          pop.remove();
        });
      },
    });
  });
}

function onAdd(reset) {
  Ajax({
    url: "./api/products/ui/createTanks.php",
    type: "POST",
    success: (popup) => {
      const types = [];

      const callback = (parent) => {
        const createBtn = parent.querySelector(".create-type");
        const typeText = parent.querySelector(".type-text");

        createBtn.addEventListener("click", () => {
          CreateProductType().then((data) => {
            types.push(data);
            typeText.textContent = types.length + " Type/s Applied";
          });
        });
      };

      CreatePopup(
        popup,
        (data, pop) => {
          if (types.length) {
            const name = Object.fromEntries(data).tank_name;
            CreateTank(name, types).then((res) => {
              if (parseInt(res)) {
                alert("Tank Inserted");
              } else {
                alert("Something is not right!");
              }

              pop.remove();
              reset();
              Refresh();
            });
          } else {
            alert("Types cannot be empty!");
          }
        },
        callback
      );
    },
  });
}

function EditProductType(tank) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/products/ui/createProductTypeEdit.php",
      type: "POST",
      data: ToData({ tank }),
      success: (popup) => {
        CreatePopup(popup, (data, pop) => {
          const TANKTYPE = pop.querySelector(".tank_type");
          const REF_ID = GetComboValue(TANKTYPE).value;
          const TYPENAME = Object.fromEntries(data).tank_type;

          resolve({ REF_ID, TYPENAME });
          pop.remove();
        });
      },
    });
  });
}

function GetProductTypes(tank) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/products/getTankTypes.php",
      type: "POST",
      data: ToData({ tank }),
      success: (types) => {
        resolve(JSON.parse(types));
      },
    });
  });
}

function onEdit(tank, reset) {
  Ajax({
    url: "./api/products/ui/editTank.php",
    type: "POST",
    data: ToData({ tank }),
    success: (popup) => {
      let types = {};
      let created = [];

      const callback = (parent) => {
        const createBtn = parent.querySelector(".create-type");
        const editBtn = parent.querySelector(".edit-type");
        const typeText = parent.querySelector(".type-text");
        const count = parseInt(typeText.getAttribute("data-count"));

        const applyData = (REF_ID, data) => {
          types[REF_ID] = data;
          typeText.textContent = count + " Type/s Applied";
        };

        editBtn.addEventListener("click", () => {
          if (count) {
            EditProductType(tank).then(({ REF_ID, TYPENAME }) => {
              TYPENAME = TYPENAME.split("(")[0].trim();
              CreateProductType(tank, TYPENAME, REF_ID).then((data) => {
                applyData(REF_ID, data);
              });
            });
          } else {
            CreateProductType().then(applyData);
          }
        });

        createBtn.addEventListener("click", () => {
          CreateProductType().then((data) => {
            created.push(data);
            const c = count + created.length;
            typeText.textContent = c + " Type/s Applied";
          });
        });
      };

      CreatePopup(
        popup,
        (data, pop) => {
          const name = Object.fromEntries(data).tank_name;
          EditTank(tank, name, types, created).then((res) => {
            if (parseInt(res)) {
              alert("Tank Edited");
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
    data: ToData({ count: items.length, target: "Tank" }),
    success: (popup) => {
      CreatePopup(popup, (pop) => {
        DeleteTanks(items).then((res) => {
          if (parseInt(res)) {
            alert("Tank Deleted");
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
    url: "./api/products/ui/createInfo.php",
    type: "POST",
    data: ToData({ tank: id }),
    success: (popup) => {
      CreateInfoPopup(popup, (pop) => {});
    },
  });
}

function ManageListeners() {
  TableListener(onAdd, onEdit, onDelete, onRefresh, null, onButton);
}

document.addEventListener("DOMContentLoaded", () => {
  const SEARCHENGINE = document.querySelector(".table-item-search-engine");

  ManageListeners();

  SEARCHENGINE.addEventListener("input", () => SearchTank(SEARCHENGINE.value));
});
