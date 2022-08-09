export function Ajax({ type, url, success, error, data, formData }) {
  let request = new XMLHttpRequest();
  let form = new FormData();

  request.onreadystatechange = function () {
    if (request.readyState == XMLHttpRequest.DONE) {
      if (request.status == 200) {
        success && success(request.responseText);
      } else if (request.status == 400) {
        error && error("There was an error 400");
      } else {
        error && error("something else other than 200 was returned");
      }
    }
  };

  if (data) {
    Object.entries(data).forEach((pair) => form.append(pair[0], pair[1]));
  }

  request.open(type, url, true);
  request.send((data ? form : false) || formData);
}

export function ListenToCombo(element, callback) {
  if (element) {
    const items = element.querySelectorAll(".item");

    for (const item of items) {
      item.addEventListener("click", () => {
        const span = item.querySelector("span");
        callback && callback(item.getAttribute("value"), span.textContent);
      });
    }
  }
}
export function GetComboItem(value, element) {
  const items = element.querySelectorAll(".item");

  for (const item of items) {
    const val = item.getAttribute("value");
    const text = item.querySelector("span").textContent;
    const data = { value: val, text };

    if (val === value) {
      return data;
    } else if (text.toLowerCase() === value) {
      return data;
    }
  }

  return null;
}

export function SetComboValue(combo, text, value) {
  const input = combo.querySelector("input");

  input.value = text;

  input.setAttribute("data-value", value);
}

export function GetComboValue(combo) {
  const input = combo.querySelector("input");
  return { value: input.getAttribute("data-value"), text: input.value };
}

export function AddComboItem(combo, text, value, setValue = true) {
  const floatcontainer = combo.querySelector(".floating-container");

  if (setValue) {
    SetComboValue(combo, text, value);
  }

  floatcontainer.appendChild(
    CreateElement({
      el: "DIV",
      className: "item",
      attr: { value },
      child: CreateElement({
        el: "SPAN",
        text: text,
      }),
    })
  );
}

export function ManageComboBoxes() {
  const CUSTOMCOMBOBOXS = document.querySelectorAll(".custom-combo-box");
  for (const combo of CUSTOMCOMBOBOXS) {
    const main = combo.querySelector(".content");
    const floating = combo.querySelector(".floating-container");
    const items = floating.querySelectorAll(".item");
    const input = combo.querySelector("input");

    const reset = () => {
      for (const item of items) {
        item.classList.remove("hide");
      }
    };

    const search = (toSearch) => {
      if (toSearch.length) {
        for (const item of items) {
          const text = item.querySelector("span").textContent.toLowerCase();
          if (text.indexOf(toSearch.toLowerCase()) >= 0) {
            item.classList.remove("hide");
          } else {
            if (!item.classList.contains("hide")) {
              item.classList.add("hide");
            }
          }
        }
      } else reset();
    };

    for (const item of items) {
      item.addEventListener("click", () => {
        input.value = item.querySelector("span").textContent;
        input.setAttribute("data-value", item.getAttribute("value"));
        combo.classList.remove("show");
      });
    }

    main.addEventListener("click", () => combo.classList.add("show"));

    input.addEventListener("input", () => search(input.value));

    input.addEventListener("blur", () => {
      if (input.value.length === 0) {
        reset();
      }
    });

    FNOnClickOutside(combo, (outside) => {
      outside && combo.classList.remove("show");
    });
  }
}

export function ManageCheckBoxes() {
  const CHECKBOXES = document.querySelectorAll(".custom-checkbox-parent");

  for (const ch of CHECKBOXES) {
    const cc = ch.querySelector(".circle");
    const ck = ch.querySelector("input");

    cc.addEventListener("click", (e) => {
      ck.click();
    });
  }
}

export function FNOnClickOutside(element, callback) {
  window.addEventListener("click", function (e) {
    if (callback) {
      callback(!element.contains(e.target), e.target);
    }
  });
}

export function UpdateTable(tableData, ...callbacks) {
  const GRIDTABLE = document.querySelector(".grid-table-container");
  const TABLECONTENT = GRIDTABLE.querySelector(".table-content");

  TABLECONTENT.innerHTML = tableData;
  TableListener(...callbacks);
}

export function TableListener(
  onAdd,
  onEdit,
  onDelete,
  onRefresh,
  onFilter,
  onButton
) {
  const GRIDTABLE = document.querySelector(".grid-table-container");
  const HEADER = document.querySelector(".grid-table-header");
  const BODY = document.querySelector(".grid-table-body");
  const MAINCKBOX = HEADER.querySelector(".table-checkbox");
  const ITEMS = BODY.querySelectorAll(".body-item");
  const FILTERITEMS = GRIDTABLE.querySelectorAll(
    ".table-filter .floating-container .item"
  );

  const SELECTEDBTN = document.querySelector(".table-selected-button");
  const EDITBTN = document.querySelector(".table-edit-button");
  const DELETEBTN = document.querySelector(".table-delete-button");
  const ADDBTN = document.querySelector(".table-add-button");
  const REFRESHBTN = document.querySelector(".table-refresh-button");

  const IDS = [...new Array(ITEMS.length)].map((_, i) => {
    return ITEMS[i].getAttribute("data-id");
  });

  let SELECTEDITEMS = [];

  const show = (element, bool) => {
    if (element) {
      if (bool) {
        element.classList.remove("hide");
      } else {
        element.classList.add("hide");
      }
    }
  };

  const selectItem = (item, select, unselect) => {
    const checkbox = item.querySelector("input");
    const id = item.getAttribute("data-id");

    if (checkbox) {
      if ((select && !unselect) || !checkbox.checked) {
        if (!SELECTEDITEMS.includes(id)) {
          SELECTEDITEMS.push(id);
        }
        item.classList.add("selected");
        checkbox.checked = true;
      } else {
        SELECTEDITEMS = SELECTEDITEMS.filter((i) => i !== id);
        item.classList.remove("selected");
        checkbox.checked = false;
      }
    }
    update();
  };

  const update = () => {
    if (MAINCKBOX) {
      MAINCKBOX.checked = SELECTEDITEMS.length === ITEMS.length;
    }

    show(EDITBTN, SELECTEDITEMS.length === 1);
    show(DELETEBTN, SELECTEDITEMS.length !== 0);
    show(SELECTEDBTN, SELECTEDITEMS.length !== 0);
    if (SELECTEDBTN) {
      SELECTEDBTN.querySelector("span").textContent =
        SELECTEDITEMS.length + " Items Selected";
    }
  };

  const findItem = (id) => {
    for (const item of ITEMS) {
      if (item.getAttribute("data-id") === id) {
        return item;
      }
    }
  };

  const check = (bool, arr) => {
    for (const body of arr || SELECTEDITEMS) {
      selectItem(findItem(body), true, !bool);
    }
  };

  const reset = () => {
    check(false);
    SELECTEDITEMS = [];
    update();
  };

  const listeners = () => {
    for (const item of ITEMS) {
      const button = item.querySelector(".icon-button");
      item.addEventListener("click", () => selectItem(item));

      if (button) {
        button.addEventListener("click", () => {
          onButton && onButton(item.getAttribute("data-id"), reset);
        });
      }
    }

    for (const item of FILTERITEMS) {
      item.addEventListener(
        "click",
        () =>
          onFilter && onFilter(item.querySelector("span").textContent, reset)
      );
    }

    MAINCKBOX &&
      MAINCKBOX.addEventListener("change", () => {
        check(MAINCKBOX.checked, IDS);
        update();
      });

    SELECTEDBTN &&
      SELECTEDBTN.addEventListener("click", () => check(false, SELECTEDITEMS));

    ADDBTN && ADDBTN.addEventListener("click", () => onAdd && onAdd(reset));

    EDITBTN &&
      EDITBTN.addEventListener("click", () => {
        if (SELECTEDITEMS.length !== 0)
          onEdit && onEdit(SELECTEDITEMS[0], reset);
      });

    DELETEBTN &&
      DELETEBTN.addEventListener("click", () => {
        if (SELECTEDITEMS.length !== 0)
          onDelete && onDelete(SELECTEDITEMS, reset);
      });

    REFRESHBTN &&
      REFRESHBTN.addEventListener("click", () => onRefresh && onRefresh(reset));
  };

  reset();
  listeners();
}

export function ToData(obj) {
  const data = new FormData();

  for (const pair of Object.entries(obj)) {
    data.append(pair[0], pair[1]);
  }

  return Object.fromEntries(data);
}

export function PostQuery(url, data) {
  return new Promise((resolve) => {
    Ajax({
      url: url,
      type: "POST",
      data: data,
      success: resolve,
    });
  });
}

export function RemovePopup() {
  const POPUP = document.querySelector(".popup-container");

  if (POPUP) {
    POPUP.innerHTML = "";
  }
}

export const VerifyFormData = (formdata, except = []) => {
  let status = true;
  let empty = [];

  for (const pair of formdata.entries()) {
    if (!except.includes(pair[0])) {
      if (typeof pair[1] == "object") {
        if (!pair[1].size) {
          status = false;
          empty.push(pair[0]);
        }
      } else {
        if (pair[1].length === 0) {
          status = false;
          empty.push(pair[0]);
        }
      }
    }
  }

  return { status, empty };
};

export function ResetForm(form) {
  const inputs = form.querySelectorAll("input");

  for (const input of inputs) {
    const atr = input.getAttribute("input-type");
    input.value = null;

    if (atr && atr === "add-minus") input.value = 1;
  }
}

function FindParent(el, cn) {
  let parent = el.parentNode;

  while (parent && !false) {
    if (parent.classList.contains(cn)) {
      find = true;
      break;
    }

    parent = parent.parentNode;
  }

  return parent;
}

export const ApplyError = (inputErr, INPUTS) => {
  for (const input of INPUTS) {
    const parent = FindParent(input, "error-container");

    if (parent) {
      if (inputErr.includes(input.getAttribute("name"))) {
        parent.classList.add("input-error");
      } else {
        parent.classList.remove("input-error");
      }
    }
  }
};

export const RemoveError = (INPUTS) => {
  for (const input of INPUTS) {
    const parent = FindParent(input, "error-container");
    if (parent) {
      parent.classList.remove("input-error");
    }
  }
};

export function ListenToAddMinusButton(AM, callback) {
  const add = AM.querySelector(".add-btn");
  const minus = AM.querySelector(".minus-btn");
  const input = AM.querySelector("input");

  add.addEventListener("click", () => {
    input.value = parseInt(input.value) + 1;
    callback && callback(input.value);
  });

  minus.addEventListener("click", () => {
    if (parseInt(input.value) - 1 > 0) {
      input.value = parseInt(input.value) - 1;
      callback && callback(input.value);
    }
  });

  input.addEventListener("change", () => {
    callback(input.value);
  });
}

export function OnButtonManual(tableParent, callback) {
  const BODY = tableParent.querySelector(".grid-table-body");
  const ITEMS = BODY.querySelectorAll(".body-item");

  for (const item of ITEMS) {
    const btn = item.querySelector(".icon-button");

    btn.addEventListener("click", () => {
      callback && callback(item.getAttribute("data-id"));
    });
  }
}

export function CreateInfoPopup(data, callback) {
  const POPUP = AddPopup(data);
  const background = POPUP.querySelector(".popup-background");
  const close = POPUP.querySelector(".close-btn");
  close.addEventListener("click", () => POPUP.remove());

  background.addEventListener("click", () => POPUP.remove());

  callback && callback(POPUP);
}

export function CreatePopup(data, callback, somecallback = false, except = []) {
  const POPUP = AddPopup(data);

  const listener = () => {
    const SAVE = POPUP.querySelector(".save-button");
    const CANCEL = POPUP.querySelector(".cancel-button");
    const RESET = POPUP.querySelector(".reset-button");
    const FORM = POPUP.querySelector(".popup-form");
    let INPUTS = FORM ? FORM.querySelectorAll("input") : [];
    const IMAGEUPLOAD = FORM ? FORM.querySelector(".image-upload") : null;
    const PREVIEWIMAGE = POPUP.querySelector(".preview-image");
    const CLOSE = document.querySelector(".close-button");

    const ApplyDisabled = (formdata) => {
      INPUTS = FORM.querySelectorAll("input");
      for (const input of INPUTS) {
        const disabled = input.getAttribute("disabled");

        if (disabled == "true" || disabled === "") {
          formdata.append(input.getAttribute("name"), input.value);
        }
      }
    };

    const Save = () => {
      if (FORM) {
        const formdata = new FormData(FORM);

        ApplyDisabled(formdata);

        const verify = VerifyFormData(formdata, except);

        ApplyError(verify.empty, INPUTS);

        if (verify.status) {
          callback && callback(formdata, POPUP);
        }
      } else {
        callback && callback(POPUP);
      }
    };

    const Reset = () => {
      INPUTS = FORM.querySelectorAll("input");

      if (INPUTS.length) {
        for (const input of INPUTS) {
          input.value = null;
        }
      }
    };

    const Cancel = () => {
      if (confirm("Are you sure you want to cancel?")) {
        POPUP.remove();
      }
    };

    const Preview = (e) => {
      const image = PREVIEWIMAGE.querySelector("img");
      console.log(e.target.files);
      if (e.target.files.length) {
        image.setAttribute("src", URL.createObjectURL(e.target.files[0]));
        PREVIEWIMAGE.classList.remove("hide");
      }
    };

    RESET && RESET.addEventListener("click", () => Reset());
    SAVE && SAVE.addEventListener("click", () => Save());
    CANCEL && CANCEL.addEventListener("click", () => Cancel());
    IMAGEUPLOAD && IMAGEUPLOAD.addEventListener("change", (e) => Preview(e));
    CLOSE && CLOSE.addEventListener("click", () => POPUP.remove());
    somecallback !== false && somecallback(POPUP);
  };

  ManageComboBoxes();
  listener();
}

export function AddPopup(data) {
  const POPUP = document.querySelector(".popup-containers");

  const span = document.createElement("SPAN");

  span.innerHTML = data;

  POPUP.appendChild(span);

  return span;
}

export function CheckOverflow(el) {
  var curOverf = el.style.overflow;

  if (!curOverf || curOverf === "visible") el.style.overflow = "hidden";

  var isOverflowing =
    el.clientWidth < el.scrollWidth || el.clientHeight < el.scrollHeight;

  el.style.overflow = curOverf;

  return isOverflowing;
}

export function NotifAlert(msg, stat, callback) {
  if (stat == 1) {
    callback && callback();
    alert(msg || "Successfully Added!");
  } else {
    alert("Something's not right, please try again!");
  }
}

export function MultiTabListener(tab, listeners = [], onload = null) {
  const tabs = tab.querySelectorAll(".tab-button");
  const leftlists = tab.querySelectorAll(".item-container-list .item");
  const contents = tab.querySelectorAll(".tab-body-content");
  let tabIndex = 0;
  let current = contents[tabIndex];

  const runListener = (name, params = []) => {
    if (listeners.length) {
      if (typeof listeners[tabIndex][name] === "function") {
        listeners[tabIndex][name](...params);
      }
    }
  };

  const switchTab = (index) => {
    contents.forEach((content, i) => {
      if (i === index) {
        content.classList.add("show");
        runListener("onTab", [i, content]);
        current = contents[i];
        tabIndex = i;
      } else {
        content.classList.remove("show");
      }
    });
  };

  const setELementActive = (index, elements) => {
    elements.forEach((tab, i) => {
      if (i === index) {
        tab.classList.add("active");
      } else {
        tab.classList.remove("active");
      }
    });
  };

  const switchItem = (index) => {
    const list = leftlists[index];
    const data = {
      text: list.querySelector("span").textContent,
      id: list.getAttribute("data-id"),
    };

    setELementActive(index, leftlists);
    runListener("onItem", [data, { element: current, index: tabIndex }]);
  };

  const listener = () => {
    tabs.forEach((tab, index) =>
      tab.addEventListener("click", () => {
        switchTab(index);
        setELementActive(index, tabs);
      })
    );

    leftlists.forEach((list, index) => {
      list.addEventListener("click", () => switchItem(index));
    });
  };

  listener();
  switchItem(tabIndex);

  if (onload) onload(tab, tabIndex, current, leftlists, contents);
}

export function AddMinusInputListener() {
  const all = document.querySelectorAll(".add-minus-button");

  for (const adb of all) {
    const add = adb.querySelector(".add-btn");
    const minus = adb.querySelector(".minus-btn");
    const input = adb.querySelector("input");

    add.addEventListener("click", () => {
      input.value = parseInt(input.value) + 1;
    });

    minus.addEventListener("click", () => {
      if (parseInt(input.value) - 1 > 0) {
        input.value = parseInt(input.value) - 1;
      }
    });
  }
}

function addClass(element, className) {
  if (!element || !className) return;

  element.classList.add(className);
}

function addAttr(element, attr, value) {
  if (!element || !attr || !value) return;

  element.setAttribute(attr, value);
}

function append(element, toAppend) {
  if (!element || !toAppend) return;

  if (Array.isArray(toAppend)) {
    for (const a of toAppend) {
      element.appendChild(a);
    }
  } else {
    element.appendChild(toAppend);
  }
}

function addListener(element, listener, callback) {
  if (!element || !listener || !callback) return;

  element.addEventListener(listener, callback);
}

function addText(element, text) {
  if (!element || !text) return;

  element.textContent = text;
}

function addHtml(element, html) {
  if (!element || !html) return;

  element.innerHTML = html;
}

export function CreateElement(element) {
  const { el, className, id, listener, attr } = element;
  const { classes, child, childs, text, html } = element;

  const elem = document.createElement(el || "DIV");

  addClass(elem, className);
  addAttr(elem, "id", id);
  append(elem, child);
  addText(elem, text);
  addHtml(elem, html);

  listener &&
    Object.entries(listener).forEach((pair) => {
      addListener(elem, pair[0], pair[1]);
    });

  attr &&
    Object.entries(attr).forEach((pair) => {
      addAttr(elem, pair[0], pair[1]);
    });

  classes && classes.length && classes.forEach((c) => addClass(elem, c));

  childs && childs.length && childs.forEach((c) => append(elem, c));

  return elem;
}

export function randomDigit() {
  return Math.floor(Math.random() * Math.floor(2));
}

export function generateRandomBinary(binaryLength) {
  let binary = "0b";
  for (let i = 0; i < binaryLength; ++i) {
    binary += randomDigit();
  }
  return binary;
}
