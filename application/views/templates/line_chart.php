<div class="dashboard_card">
  <h3 class="dashboard_card_title">輔導人數圖</h3>
    <div class="center" style="width:75%;">
      <canvas id="canvas" height='300' width='450'></canvas>
    </div>
    <br>
    <br>
    <script>
      var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      var config = {
        type: 'line',
        data: {
          labels: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
          datasets: [{
            label: '輔導人數圖',
            backgroundColor: 'red',
            borderColor: 'red',
            data: [1, 2, 3, 4, 5, 6, 8, 4, 5, 6, 8,],
            fill: false,
          }],
        },
        options: {
          responsive: true,
          title: {
            display: true
          },
          tooltips: {
            mode: 'index',
            intersect: false,
          },
          hover: {
            mode: 'nearest',
            intersect: true
          },
          scales: {
            x: {
              display: true,
              scaleLabel: {
                display: true,
                labelString: 'Month'
              }
            },
            y: {
              display: true,
              scaleLabel: {
                display: true,
                labelString: 'Value'
              }
            }
          }
        }
      };
      window.onload = function () {
        var ctx = document.getElementById('canvas').getContext('2d');
        ctx.height = 500;
        window.myLine = new Chart(ctx, config);
      };
    </script>
</div
