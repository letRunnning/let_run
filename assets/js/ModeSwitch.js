(() => {
  function ModeSwitch() {
    this.readMode = false;
    this.toggle = () => {
      readMode = !this.readMode;
      this.readMode = readMode;
      // change submit button mode
      document.querySelector(`button[type="submit"]`).disabled = readMode;
      // change input mode
      const inputs = document.querySelectorAll(`input`);
      for(let i=0; i<inputs.length; i++) {
        inputs[i].disabled = readMode;
      }
      // change select mode
      const selects = document.querySelectorAll(`select`);
      for(let i=0; i<selects.length; i++) {
        selects[i].disabled = readMode;
      }
      // change textarea mode
      const textareas = document.querySelectorAll(`textarea`);
      for(let i=0; i<textareas.length; i++) {
        textareas[i].disabled = readMode;
      }
      // change button mode
      const buttons = document.querySelectorAll(`button`);
      for(let i=0; i<buttons.length; i++) {
        buttons[i].disabled = readMode;
      }
      if(readMode) {
        document.getElementById("modeSwitch").innerText = "切換編輯模式";
      } else {
        document.getElementById("modeSwitch").innerText = "切換閱讀模式";
        M.FormSelect.init(selects, {});
      }
    }
    // initialize
    const button = document.getElementById("modeSwitch");
    button.addEventListener('click', this.toggle);
    this.toggle();
  }
  window.modeSwitch = new ModeSwitch();
})();