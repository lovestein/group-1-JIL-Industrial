import {
  AddMinusInputListener,
  Ajax,
  ApplyError,
  CreateElement,
  generateRandomBinary,
  ManageComboBoxes,
  RemoveError,
  ResetForm,
  ToData,
  VerifyFormData,
} from "./functions.js";

function InsertExpenses(summary) {
  return new Promise((resolve) => {
    Ajax({
      url: "./api/workplace/createExpenses.php",
      type: "POST",
      data: ToData({ summary: JSON.stringify(summary) }),
      success: resolve,
    });
  });
}

function SaleManager() {
  const form = document.querySelector(".container-body .form-container");
  const pos = document.querySelector(".point-of-sales-form");
  const addbtn = form.querySelector(".add-submit-btn");
  const amount = document.querySelector(".total-amount");
  const submitPos = pos.querySelector(".submit-point-of-sale");
  const timeP = document.querySelector(".time");
  const dateP = document.querySelector(".input-date");
  const dateBtn = document.querySelector(".create-date-button");
  const summary = {
    expenses: [],
    total: 0,
    products: 0,
  };

  const RemoveItem = (id) => {
    const expense = summary.expenses.filter((s) => s.id === id)[0];

    if (summary.expenses) {
      const element = expense.item;

      summary.expenses = summary.expenses.filter((s) => s.id !== id);
      element.remove();
    }

    ComputeSales();
  };

  const CreateExpenseItem = (expense, id) => {
    const contents = Object.entries(expense).map((pair) => {
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

  const InsertSale = (expense) => {
    const saleParent = document.querySelector(".point-of-sale-table");
    const body = saleParent.querySelector(".grid-table-body");
    const id = generateRandomBinary(5);
    const item = CreateExpenseItem(expense, id);

    summary.expenses.push({ id, item, expense });
    summary.products = summary.expenses.length;
    body.appendChild(item);
  };

  const ComputeSales = () => {
    if (summary.expenses.length) {
      const totalamount = summary.expenses
        .map((s) => parseFloat(s.expense.price))
        .reduce((a, b) => a + b);

      amount.textContent = totalamount;
    } else {
      amount.textContent = 0;
    }

    summary.total = parseFloat(amount.textContent);
  };

  const SubmitPosForm = () => {
    const inputs = form.querySelectorAll("input");
    const data = new FormData(form);
    const verify = VerifyFormData(data, []);

    if (verify.status) {
      InsertSale(Object.fromEntries(data));
      ResetForm(form);
      ComputeSales();
      RemoveError(inputs);
    } else {
      ApplyError(verify.empty, inputs);
    }
  };

  const ResetAll = () => {
    ResetForm(form);

    summary.total = 0;
    summary.products = 0;
    summary.expenses.forEach(({ id }) => RemoveItem(id));
  };

  const SubmitPOS = () => {
    if (summary.expenses.length) {
      const customdate = dateP.querySelector("input").value;

      if (customdate) {
        summary.date = customdate;
      }

      const data = {
        ...summary,
        expenses: summary.expenses.map(({ expense }) => expense),
      };

      InsertExpenses(data).then((res) => {
        if (parseInt(res)) {
          alert("Added Successfully!");
          ResetAll();
        }
      });
    } else {
      alert("No Expense To Add!");
    }
  };

  addbtn.addEventListener("click", SubmitPosForm);
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
}

document.addEventListener("DOMContentLoaded", () => {
  SaleManager();
  ManageComboBoxes();
  AddMinusInputListener();
});
