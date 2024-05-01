function chart() {
     var sd = new Date();

     var sDate = 2022 + '-' + 10 + '-' + 10;
     let start_day = sDate;
     var d = new Date();

     var month = d.getMonth() + 1;
     var day = d.getDate();

     var currentDate = d.getFullYear() + '-' +
          (month < 10 ? '0' : '') + month + '-' +
          (day < 10 ? '0' : '') + day;
     let end_day = currentDate;
     totalSum(start_day, end_day);
     $('#listProSold').html(``);

     listProSold(start_day, end_day);
     $.ajax({
          url: "statistics.php/displayChart",
          method: "POST",
          data: { start_day: start_day, end_day: end_day },
          success: function (response) {
               let indexX = 0;
               let xValues = [];
               let yValues = [];
               let indexobj = 0;
               let obj = [];
               for (var key in response) {
                    obj[indexobj] = response[key];
                    indexobj++;
               }
               for (var index in obj) {
                    xValues[indexX] = obj[index]['created_date'];
                    yValues[indexX] = obj[index]['total_money'];
                    indexX++;
               }
               console.log(xValues);
               new Chart("myChart", {
                    type: "line",
                    data: {
                         labels: xValues,
                         datasets: [{
                              fill: false,
                              lineTension: 0,
                              backgroundColor: "rgba(0,0,255,1.0)",
                              borderColor: "rgba(0,0,255,0.1)",
                              data: yValues
                         }]
                    },
                    options: {
                         legend: { display: false },
                    }
               });
          }
     });
};
function totalSum(start_day, end_day) {
     $.ajax({
          url: "statistics.php/totalSum",
          method: "POST",
          data: { start_day: start_day, end_day: end_day },
          success: function (response) {
               $('#totalSum').val(response);
          }
     })
}
function listProSold(start_day, end_day) {
     $.ajax({
          url: "statistics.php/listProSold",
          method: "POST",
          data: { start_day: start_day, end_day: end_day },
          success: function (response) {
               $('#listProSold').append(response);
          }
     })
}
$(document).ready(function () {
     chart();
     $('#statistics').click(function () {
          let start_day = $('#s-day').val();
          let end_day = $('#e-day').val();
          totalSum(start_day, end_day);
          $('#listProSold').html(``);
          listProSold(start_day, end_day);
          console.log(start_day);
          $.ajax({
               url: "statistics.php/displayChart",
               method: "POST",
               data: { start_day: start_day, end_day: end_day },
               success: function (response) {
                    let indexX = 0;
                    let xValues = [];
                    let yValues = [];
                    let indexobj = 0;
                    let obj = [];
                    for (var key in response) {
                         obj[indexobj] = response[key];
                         indexobj++;
                    }
                    for (var index in obj) {
                         xValues[indexX] = obj[index]['created_date'];
                         yValues[indexX] = obj[index]['total_money'];
                         indexX++;
                    }
                    console.log(xValues);
                    new Chart("myChart", {
                         type: "line",
                         data: {
                              labels: xValues,
                              datasets: [{
                                   fill: false,
                                   lineTension: 0,
                                   backgroundColor: "rgba(0,0,255,1.0)",
                                   borderColor: "rgba(0,0,255,0.1)",
                                   data: yValues
                              }]
                         },
                         options: {
                              legend: { display: false },
                         }
                    });
               }
          });
     });

});