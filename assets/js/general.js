(() => {
  document.addEventListener('DOMContentLoaded', function() {
    var collapsibles = document.querySelectorAll('.collapsible');
    M.Collapsible.init(collapsibles, {});
    
    // M.Datepicker.init(datepickers, {
    //   autoClose: true,
    //   format: 'yyyy-mm-dd'
    // });
    const sidenav = document.querySelectorAll('.sidenav')[0];
    const sidebar = M.Sidenav.init(sidenav, {
      edge: 'left',
      draggable: true,
      inDuration: 250,
      outDuration: 200,
      onOpenStart: null,
      onOpenEnd: null,
      onCloseStart: null,
      onCloseEnd: null,
      preventScrolling: true
    });
    const logo = document.querySelectorAll('.logo')[0];
    logo.onmouseover = () => {
      sidebar.open();
    };
    const materialbox = document.querySelectorAll('.materialboxed');
    M.Materialbox.init(materialbox, {});
    // const datetimepickers = document.querySelectorAll('.datetimepicker');
    // for(i=0, n=datetimepickers.length; i<n; i++) {
    //   datetimepickers[i].flatpickr({
    //     enableTime: true,
    //     dateFormat: "Y-m-d H:i:00",
    //   });
    // }
    // const selects = document.querySelectorAll('select');
    // M.FormSelect.init(selects, {});
    // const requiredSelects = document.querySelectorAll('select[required]');
    // for ( i=0, n=requiredSelects.length; i < n; i++) {
    //   const select = requiredSelects[i];
    //   select.style['display'] = 'inline';
    //   select.style['height'] = 0;
    //   select.style['padding'] = 0;
    //   select.style['width'] = 0;
    // }
  });

  // const requiredSelects = document.querySelectorAll('select[required]');
  // for ( i=0, n=requiredSelects.length; i < n; i++) {
  //   const select = requiredSelects[i];
  //   select.style['display'] = 'inline';
  //   select.style['height'] = 0;
  //   select.style['padding'] = 0;
  //   select.style['width'] = 0;
  // }

  function removeElementsByClass(className){
    var elements = document.getElementsByClassName(className);
    while(elements.length > 0){
        elements[0].parentNode.removeChild(elements[0]);
    }
  }

  const groups = document.querySelectorAll('.group');
  for ( i=0, n=groups.length; i < n; i++) {
    const target = groups[i];
    const items = target.children;
    const btn = createElementFromString('<button class="btn waves-effect add blue darken-4">新增</button>');
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
