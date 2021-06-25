// global variable
const today = new Date();
const thisYear = today.getFullYear();
const taiwanYear = thisYear-1911;
let thisMonth = today.getMonth()+1;
thisMonth = String(thisMonth).length > 1 ? thisMonth : '0'+thisMonth;
let thisDate = today.getDate();
thisDate = String(thisDate).length > 1 ? thisDate : '0'+thisDate;
let thisHour = today.getHours();
thisHour = String(thisHour).length > 1 ? thisHour : '0'+thisHour;
let thisMinute = today.getMinutes();
thisMinute = '00';
// global function
const getDaysInMonth = (year, month) => {
  month = month-1;
  var date = new Date(year, month, 1);
  var days = [];
  while (date.getMonth() === month) {
    days.push(date.getDate());
    date.setDate(date.getDate() + 1);
  }
  return days;
}

const createElementFromString = ( domString ) => {
  const html = new DOMParser().parseFromString( domString , 'text/html');
  return html.body.firstChild;
};

const makeDateElement = (picker) => {
  picker.parentNode.hidden = true;
  const pickerId = picker.getAttribute('id');
  const pickerValue = picker.getAttribute('value') || `${thisYear}-${thisMonth}-${thisDate}`;
  picker.value = pickerValue;
  const defaultYear = pickerValue.slice(0, 4);
  const defaultMonth = Number(pickerValue.slice(5, 7));
  const defaultDate = Number(pickerValue.slice(8, 10));
  const createYearOption = (k, i) => `<option value="${thisYear-20+i}" ${thisYear-20+i == defaultYear && "selected"}>${taiwanYear-20+i}</option>`;
  const yearOptions = [ ...Array(30) ].map(createYearOption);
  const createMonthOption = (k, i) => 
    `<option value="${String(i+1).length > 1 ? String(i+1) : '0'+String(i+1)}" ${i+1 == defaultMonth && "selected"}>${i+1}</option>`;
  const monthOptions = [ ...Array(12) ].map(createMonthOption);
  const days = getDaysInMonth(defaultYear, 3);
  const createDateOption = (v) => 
    `<option value="${String(v).length > 1 ? String(v) : '0'+String(v)}" ${v == defaultDate && "selected"}>${v}</option>`;
  const dayOptions = days.map(createDateOption);
  const newLabel = createElementFromString(
    `<p class="col s2" style="margin-top:10px;">${picker.nextSibling.nextSibling.textContent}</p>`);
  const newYear = createElementFromString(
    ` <div class="input-field col s2">
        <select target="${pickerId}">
          ${yearOptions}
        </select>
        <label>民國</label>
      </div>
    `);
  const newMonth = createElementFromString(
    ` <div class="input-field col s2">
        <select target="${pickerId}">
          ${monthOptions}
        </select>
        <label>月</label>
      </div>
    `);
  const newDate = createElementFromString(
    ` <div class="input-field col s2">
        <select target="${pickerId}">
          ${dayOptions}
        </select>
        <label>日</label>
      </div>
    `);
  return [newLabel, newYear, newMonth, newDate];
}

const createDatePicker = (picker) => {
  const pickerParent = picker.parentNode.parentNode;
  const [newLabel, newYear, newMonth, newDate] = makeDateElement(picker);
  newYear.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = e.target.value + target.value.slice(4, 10);
  });
  newMonth.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = target.value.slice(0, 5) + e.target.value + target.value.slice(7, 10);
  });
  newDate.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = target.value.slice(0, 8) + e.target.value;
  });
  pickerParent.append(newLabel);
  pickerParent.append(newYear);
  pickerParent.append(newMonth);
  pickerParent.append(newDate);

}

const makeTimeElement = (picker) => {
  picker.parentNode.hidden = true;
  const pickerId = picker.getAttribute('id');
  const pickerValue = picker.getAttribute('value') || `${thisYear}-${thisMonth}-${thisDate} ${thisHour}:${thisMinute}:00`;
  picker.value = pickerValue;
  const defaultHour = Number(pickerValue.slice(11, 13));
  const defaultMinute = Number(pickerValue.slice(14, 16));
  const createHourOption = (v, i) => `<option value="${String(i).length > 1 ? String(i) : '0'+String(i)}" ${i == defaultHour && "selected"}>${i}</option>`;
  const hourOptions = [ ...Array(24) ].map(createHourOption);
  const newHour = createElementFromString(
    ` <div class="input-field col s2">
        <select target="${pickerId}">
          ${hourOptions}
        </select>
        <label>時</label>
      </div>
    `);
  const createMinuteOption = (v, i) => `<option value="${String(i*15).length > 1 ? String(i*15) : '0'+String(i*15)}" ${i*15 == defaultMinute && "selected"}>${i*15}</option>`;
  const minuteOptions = [ ...Array(4) ].map(createMinuteOption);
  const newMinute = createElementFromString(
    ` <div class="input-field col s2">
        <select target="${pickerId}">
          ${minuteOptions}
        </select>
        <label>分</label>
      </div>
    `);
  return [newHour, newMinute];
}

const createDateTimePicker = (picker) => {
  const pickerParent = picker.parentNode.parentNode;
  const [newLabel, newYear, newMonth, newDate] = makeDateElement(picker);
  const [newHour, newMinute] = makeTimeElement(picker);
  
  newYear.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = e.target.value + target.value.slice(4, 19);
  });
  newMonth.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = target.value.slice(0, 5) + e.target.value + target.value.slice(7, 19);
  });
  newDate.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = target.value.slice(0, 8) + e.target.value + target.value.slice(10, 19);
  });
  newHour.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = target.value.slice(0, 11) + e.target.value + target.value.slice(13, 19);
  });
  newMinute.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = target.value.slice(0, 14) + e.target.value + target.value.slice(16, 19);
  });
  pickerParent.append(newLabel);
  pickerParent.append(newYear);
  pickerParent.append(newMonth);
  pickerParent.append(newDate);
  pickerParent.append(newHour);
  pickerParent.append(newMinute);
}

const makeOnlyOneDateElement = (picker) => {
  picker.parentNode.hidden = true;
  const pickerId = picker.getAttribute('id');
  const pickerValue = picker.getAttribute('value') || `${thisYear}-${thisMonth}-${thisDate}`;
  picker.value = pickerValue;
  const defaultYear = pickerValue.slice(0, 4);
  const defaultMonth = Number(pickerValue.slice(5, 7));
  const defaultDate = Number(pickerValue.slice(8, 10));
  const createYearOption = (k, i) => `<option value="${thisYear+i}" ${thisYear+i == defaultYear && "selected"}>${taiwanYear-20+i}</option>`;
  const yearOptions = [ ...Array(1) ].map(createYearOption);
  const createMonthOption = (k, i) => 
    `<option value="${String(i+1).length > 1 ? String(i+1) : '0'+String(i+1)}" ${i+1 == defaultMonth && "selected"}>${i+1}</option>`;
  const monthOptions = [ ...Array(12) ].map(createMonthOption);
  const days = getDaysInMonth(defaultYear, 3);
  const createDateOption = (v) => 
    `<option value="${String(v).length > 1 ? String(v) : '0'+String(v)}" ${v == defaultDate && "selected"}>${v}</option>`;
  const dayOptions = days.map(createDateOption);
  const newLabel = createElementFromString(
    `<p class="col s2" style="margin-top:10px;">${picker.nextSibling.nextSibling.textContent}</p>`);
  const newYear = createElementFromString(
    ` <div class="input-field col s2">
        <select target="${pickerId}">
          ${yearOptions}
        </select>
        <label>民國</label>
      </div>
    `);
  const newMonth = createElementFromString(
    ` <div class="input-field col s2">
        <select target="${pickerId}">
          ${monthOptions}
        </select>
        <label>月</label>
      </div>
    `);
  const newDate = createElementFromString(
    ` <div class="input-field col s2">
        <select target="${pickerId}">
          ${dayOptions}
        </select>
        <label>日</label>
      </div>
    `);
  return [newLabel, newYear, newMonth, newDate];
}

const createOnlyOneDatePicker = (picker) => {
  const pickerParent = picker.parentNode.parentNode;
  const [newLabel, newYear, newMonth, newDate] = makeOnlyOneDateElement(picker);
  newYear.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = e.target.value + target.value.slice(4, 10);
  });
  newMonth.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = target.value.slice(0, 5) + e.target.value + target.value.slice(7, 10);
  });
  newDate.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = target.value.slice(0, 8) + e.target.value;
  });
  pickerParent.append(newLabel);
  pickerParent.append(newYear);
  pickerParent.append(newMonth);
  pickerParent.append(newDate);

}

const createOnlyOneDateTimePicker = (picker) => {
  const pickerParent = picker.parentNode.parentNode;
  const [newLabel, newYear, newMonth, newDate] = makeOnlyOneDateElement(picker);
  const [newHour, newMinute] = makeTimeElement(picker);
  
  newYear.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = e.target.value + target.value.slice(4, 19);
  });
  newMonth.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = target.value.slice(0, 5) + e.target.value + target.value.slice(7, 19);
  });
  newDate.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = target.value.slice(0, 8) + e.target.value + target.value.slice(10, 19);
  });
  newHour.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = target.value.slice(0, 11) + e.target.value + target.value.slice(13, 19);
  });
  newMinute.addEventListener('change', (e) => {
    const target = document.getElementById(e.target.getAttribute('target'));
    target.value = target.value.slice(0, 14) + e.target.value + target.value.slice(16, 19);
  });
  pickerParent.append(newLabel);
  pickerParent.append(newYear);
  pickerParent.append(newMonth);
  pickerParent.append(newDate);
  pickerParent.append(newHour);
  pickerParent.append(newMinute);
}

// main
const datepickers = document.querySelectorAll('.datepicker');
for(i=0, n=datepickers.length; i<n; i++) {
  const picker = datepickers[i];
  createDatePicker(picker);
}

const datetimepickers = document.querySelectorAll('.datetimepicker');
for(i=0, n=datetimepickers.length; i<n; i++) {
  const picker = datetimepickers[i];
  createDateTimePicker(picker);
}

const datetpickersonly = document.querySelectorAll('.datepickers');
for(i=0, n=datetpickersonly.length; i<n; i++) {
  const picker = datetpickersonly[i];
  createOnlyOneDatePicker(picker);
}

const datetimepickersonly = document.querySelectorAll('.datetimepickers');
for(i=0, n=datetimepickersonly.length; i<n; i++) {
  const picker = datetimepickersonly[i];
  createOnlyOneDateTimePicker(picker);
}
