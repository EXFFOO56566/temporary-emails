$(document).ready(function() {

    "use strict";

var options = {
    series: [{
    name: 'Messages Received',
    data: data1
  }],
    chart: {
    type: 'bar',
    height: 350
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '55%',
      endingShape: 'rounded'
    },
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
  },
  xaxis: {
    categories: cat1,
  },
  yaxis: {
    title: {
      text: 'Messages Received'
    }
  },
  fill: {
    opacity: 1
  },
  colors:['#008062']
  ,
  tooltip: {
    y: {
      formatter: function (val) {
        return  val 
      }
    }
  }
  };

var chart = new ApexCharts(document.querySelector("#messges_chart"), options);
chart.render();


var options = {
    series: [{
    name: 'Emails Created',
    data: data2
  }],
    chart: {
    type: 'bar',
    height: 350
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '55%',
      endingShape: 'rounded'
    },
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
  },
  xaxis: {
    categories: cat2,
  },
  yaxis: {
    title: {
      text: 'Emails Created'
    }
  },
  fill: {
    opacity: 1
  },
  colors:['#7d05d8']
  ,
  tooltip: {
    y: {
      formatter: function (val) {
        return val 
      }
    }
  }
  };

var chart = new ApexCharts(document.querySelector("#email_chart"), options);
chart.render();

});