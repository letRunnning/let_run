function ElementBinder() {
  const checkboxEvent = (checkboxName, input) => {
    let containsOther = false;
    const checkboxes = document.querySelectorAll(`input[name="${checkboxName}"]:checked`);
    let wrapperElement = input.closest(".row");
    for(let i=0; i<checkboxes.length; i++) {
      if(checkboxes[i].labels[0].innerText === '其他') containsOther = true;
    }
    if(containsOther) {
      wrapperElement.style.display = 'block';
    } else {
      input.value = '';
      wrapperElement.style.display = 'none';
    }
  }
  this.checkboxInput = (checkboxName, inputName) => {
    const input = document.querySelector(`input[name="${inputName}"]`);
    const allNamedCheckbox = document.querySelectorAll(`input[name="${checkboxName}"]`);
    checkboxEvent(checkboxName, input);
    for(let i=0; i<allNamedCheckbox.length; i++) {
      allNamedCheckbox[i].addEventListener('click', () => {
        checkboxEvent(checkboxName, input);
      });
    }
  }
  const selectEvent = (select, input, optionLabel) => {
    let wrapperElement = input.closest(".row");
    if(select.querySelector(`option:checked`).text === optionLabel) {
      wrapperElement.style.display = 'block';
    } else {
      input.value = '';
      wrapperElement.style.display = 'none';
    }
  }
  this.selectInput = (selectName, inputName, optionLabel) => {
    const input = document.querySelector(`input[name="${inputName}"]`) 
      || document.querySelector(`textarea[name="${inputName}"]`) 
      || document.querySelector(`select[name="${inputName}"]`);
    const select = document.querySelector(`select[name="${selectName}"]`);
    selectEvent(select, input, optionLabel);
    select.addEventListener('change', () => {
      selectEvent(select, input, optionLabel);
    });
  } 
}