(() => {
    function removeElementsByClass(className){
        var elements = document.getElementsByClassName(className);
        while(elements.length > 0){
            elements[0].parentNode.removeChild(elements[0]);
        }
      }
    const createElementFromString = ( domString ) => {
        const html = new DOMParser().parseFromString( domString , 'text/html');
        return html.body.firstChild;
      };
    const groups = document.querySelectorAll('.yourUlId');
    for ( i=0, n=groups.length; i < n; i++) {
    const target = groups[i];
    const items = target.children;
    // const btn = createElementFromString('<div class="col-md-11 m-3" style="text-align:right;"><a class="btn btn-info">新增</a></div>');
    const btn = createElementFromString('<div class="row" style="padding-left: 89px;"><div class="col-10 m-3" style="text-align:left;"><button type="button" class="btn btn-info text-white"><i class="fas fa-plus"></i></button></div></div>');
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      let cloneElement = target.cloneNode(true)
      target.parentNode.insertBefore(cloneElement, target.nextSibling);
      removeElementsByClass('select-dropdown');
      const selects = document.querySelectorAll('select');
      M.FormSelect.init(selects, {});

      // const datepickers = document.querySelectorAll('.datepicker');
      // for ( j=0, m=datepickers.length; j < m; j++) {
      //   datepickers[j].id = 'datepickers'+j;
      //   createDatePicker(datepickers[j]);
      // }
    });

    target.parentNode.insertBefore(btn, target);
  }

})();