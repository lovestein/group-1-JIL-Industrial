import {
  AddComboItem,
  AddMinusInputListener,
  Ajax,
  ApplyError,
  CreateElement,
  CreatePopup,
  generateRandomBinary,
  GetComboValue,
  ListenToAddMinusButton,
  ListenToCombo,
  ManageComboBoxes,
  RemoveError,
  ResetForm,
  ToData,
  VerifyFormData,
} from "./functions.js";

const GetCategories = (cat) => {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/workplace/getCategories.php",
      type: "POST",
      success: (i) => resolve(JSON.parse(i)),
    });
  });
};

const GetComboCategories = (tank) => {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/workplace/ui/getComboTT.php",
      type: "POST",
      data: ToData({ tank }),
      success: resolve,
    });
  });
};

const GetComboAccCategories = (accessory) => {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/workplace/ui/getComboAA.php",
      type: "POST",
      data: ToData({ accessory }),
      success: resolve,
    });
  });
};

function CreateCustomer() {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/global/ui/createCustomer.php",
      type: "POST",
      success: (popup) => {
        CreatePopup(popup, (data, pop) => {
          resolve(Object.fromEntries(data));
          pop.remove();
        });
      },
    });
  });
}

function InsertCustomer(customer) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/global/createCustomer.php",
      type: "POST",
      data: ToData({ basic: JSON.stringify(customer) }),
      success: resolve,
    });
  });
}

function PayPOS(summary) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/global/ui/createPayPOS.php",
      type: "POST",
      data: ToData({ summary: JSON.stringify(summary) }),
      success: (popup) => {
        const payData = {
          cash: 0,
          change: 0,
        };

        const some = (parent) => {
          const cash = parent.querySelector("input[name=cash]");
          const change = parent.querySelector(".change");

          cash.addEventListener("input", () => {
            const t = summary.total;
            const c = cash.value;
            const nc = parseInt(c) - parseInt(t);

            change.textContent = nc;
            payData.cash = c;
            payData.change = nc;
          });
        };

        CreatePopup(
          popup,
          (fd, pop) => {
            const data = Object.fromEntries(fd);
            if (parseInt(data.cash) >= summary.total) {
              resolve(payData);
              pop.remove();
            } else {
              alert("Cash not satisfy!");
            }
          },
          some
        );
      },
    });
  });
}

function InsertPOS(payData, summary) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/workplace/insertPOS.php",
      type: "POST",
      data: ToData({
        payData: JSON.stringify(payData),
        summary: JSON.stringify(summary),
      }),
      success: resolve,
    });
  });
}

function GetTypeInfo(tank, type) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/workplace/getTypeInfo.php",
      type: "POST",
      data: ToData({ tank, type }),
      success: resolve,
    });
  });
}

function GetAccInfo(accessory) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/workplace/getAccInfo.php",
      type: "POST",
      data: ToData({ accessory }),
      success: resolve,
    });
  });
}

function SaleManager() {
  const form = document.querySelector(".container-body .form-container");
  const pos = document.querySelector(".point-of-sales-form");
  const product_category = form.querySelector(".product_category");
  const category = form.querySelector("input[name=product_category]");
  const tanks = form.querySelector(".tanks");
  const acc = form.querySelector(".accessories");
  const Tproducts = form.querySelector(".product_tank");
  const Aproducts = form.querySelector(".product_acc");
  const forTanks = form.querySelector(".for-tanks");
  const forAcc = form.querySelector(".for-acc");
  const priceTxt = form.querySelector("input[name=price]");
  const addbtn = form.querySelector(".add-submit-btn");
  const amount = document.querySelector(".total-amount");
  const createCustomerBtn = document.querySelector(".create-customer-button");
  const customerCombo = pos.querySelector(".customer");
  const submitPos = pos.querySelector(".submit-point-of-sale");
  const timeP = document.querySelector(".time");
  const dateP = document.querySelector(".input-date");
  const dateBtn = document.querySelector(".create-date-button");
  const quantity = document.querySelector(".quantity-add-minus");
  const summary = {
    sales: [],
    total: 0,
    products: 0,
    customer: null,
    date: null,
  };

  let availableQuantity = 0;

  const RemoveItem = (id) => {
    const sale = summary.sales.filter((s) => s.id === id)[0];

    if (sale) {
      const element = sale.item;

      summary.sales = summary.sales.filter((s) => s.id !== id);
      element.remove();
    }

    ComputeSales();
  };

  const ResetAll = () => {
    ResetForm(form);

    summary.total = 0;
    summary.products = 0;
    summary.sales.forEach(({ id }) => RemoveItem(id));
  };

  const CreateSaleItem = (sale, id) => {
    const isTank = sale.product_category === "Tanks";
    const data = {
      name: isTank ? sale.product_tank : sale.accessory,
      quantity: sale.quantity,
      price: sale.price,
      total: sale.total,
    };

    const contents = Object.entries(data).map((pair) => {
      return CreateElement({
        el: "td",
        text: pair[1],
      });
    });

    contents.push(
      CreateElement({
        el: "td",
        child: CreateElement({
          el: "DIV",
          classes: ["icon-button", "normal"],
          listener: {
            click: () => RemoveItem(id),
          },
          child: CreateElement({
            el: "DIV",
            className: "text",
            child: CreateElement({
              el: "span",
              text: "Delete",
            }),
          }),
        }),
      })
    );

    const element = CreateElement({
      el: "tr",
      childs: contents,
    });

    return element;
  };

  const InsertSale = (sale) => {
    sale.total = parseInt(sale.quantity) * parseFloat(sale.price);
    sale.tank_type = sale.tank_type.split("(")[0].trim();

    const saleParent = document.querySelector(".point-of-sale-table");
    const body = saleParent.querySelector(".grid-table-body");
    const id = generateRandomBinary(5);
    const item = CreateSaleItem(sale, id);

    summary.sales.push({ id, item, sale });
    summary.products = summary.sales.length;
    body.appendChild(item);
  };

  const toggleCombos = (cat, res = []) => {
    if (cat === res[0]) {
      tanks.classList.remove("hide");
      acc.classList.add("hide");
      forTanks.classList.remove("hide");
      forAcc.classList.add("hide");
    } else if (cat === res[1]) {
      tanks.classList.add("hide");
      acc.classList.remove("hide");
      forTanks.classList.add("hide");
      forAcc.classList.remove("hide");
    } else {
      tanks.classList.add("hide");
      acc.classList.add("hide");
      forTanks.classList.add("hide");
      forAcc.classList.add("hide");
    }
  };

  const ComputeSales = () => {
    if (summary.sales.length) {
      const totalamount = summary.sales
        .map((s) => parseFloat(s.sale.total))
        .reduce((a, b) => a + b);

      amount.textContent = totalamount;
    } else {
      amount.textContent = 0;
    }

    summary.total = parseFloat(amount.textContent);
  };

  const SubmitSaleForm = () => {
    const inputs = form.querySelectorAll("input");
    const verify = VerifyFormData(new FormData(form), [
      "product_tank",
      "product_acc",
      "tank_type",
      "tank_size",
    ]);

    if (verify.status) {
      InsertSale(Object.fromEntries(new FormData(form)));
      ResetForm(form);
      toggleCombos(category.value);
      ComputeSales();
      RemoveError(inputs);
    } else {
      ApplyError(verify.empty, inputs);
    }
  };

  const SubmitPOS = () => {
    if (summary.sales.length) {
      const customdate = dateP.querySelector("input").value;

      if (customdate) {
        summary.date = customdate;
      }

      PayPOS(summary).then((payData) => {
        InsertPOS(payData, summary).then((res) => {
          if (parseInt(res)) {
            alert("Successfully Purchased!");
            ResetAll();
          } else {
            console.log(res);
          }
        });
      });
    } else {
      alert("No Products!");
    }
  };

  const applyPrice = (k) => {
    priceTxt.value = k;
  };

  const getTproducts = (prod) => {
    GetComboCategories(prod).then((d) => {
      forTanks.innerHTML = d;

      const tankTypeCombo = forTanks.querySelector(".tank_type");
      const tankSize = forTanks.querySelector("input[name=tank_size]");
      const quantityStock = forTanks.querySelector(
        "input[name=tank_quantity_on_hand]"
      );

      availableQuantity = parseInt(quantityStock.value);

      ManageComboBoxes();

      ListenToCombo(tankTypeCombo, (d, v) => {
        const name = v.split("(")[0].trim();

        applyPrice(d);
        GetTypeInfo(prod, name).then((tank) => {
          const data = JSON.parse(tank);

          tankSize.value = data.type_size;
          quantityStock.value = data.type_on_hand + " Available";
        });
      });

      applyPrice(GetComboValue(tankTypeCombo).value);
    });
  };

  const getAproducts = (prod) => {
    GetComboAccCategories(prod).then((d) => {
      forAcc.innerHTML = d;
      const accessorycombo = forAcc.querySelector(".accessory");
      const quantityStock = forAcc.querySelector(
        "input[name=acc_quantity_on_hand]"
      );

      ManageComboBoxes();

      if (accessorycombo) {
        ListenToCombo(accessorycombo, (d, v) => {
          applyPrice(d, v);

          GetAccInfo(v).then((acc) => {
            const data = JSON.parse(acc);
            quantityStock.value = data.acc_on_hand + " Available";
          });
        });
        applyPrice(GetComboValue(accessorycombo).value);
      }
    });
  };

  ListenToCombo(product_category, (cat) => {
    GetCategories(cat).then((res) => {
      toggleCombos(cat, res);
      getTproducts(GetComboValue(Tproducts).value);
      getAproducts(GetComboValue(Aproducts).value);
    });
  });

  ListenToCombo(customerCombo, (customer) => {
    summary.customer = customer;
  });

  ListenToCombo(Tproducts, getTproducts);

  ListenToCombo(Aproducts, getAproducts);

  ListenToAddMinusButton(quantity, (input) => {
    const i = quantity.querySelector("input");

    if (parseInt(input) > availableQuantity) {
      alert("You've reach the maximum");

      i.value = availableQuantity;
    }
  });

  addbtn.addEventListener("click", SubmitSaleForm);
  submitPos.addEventListener("click", SubmitPOS);
  dateBtn.addEventListener("click", () => {
    if (dateP.classList.contains("hide")) {
      dateP.classList.remove("hide");
      timeP.classList.add("hide");
    } else {
      dateP.classList.add("hide");
      timeP.classList.remove("hide");
    }
  });

  createCustomerBtn.addEventListener("click", () => {
    CreateCustomer().then((data) =>
      InsertCustomer(data).then((id) => {
        AddComboItem(customerCombo, data.cust_name, id);
      })
    );
  });
}

document.addEventListener("DOMContentLoaded", () => {
  SaleManager();
  ManageComboBoxes();
});
