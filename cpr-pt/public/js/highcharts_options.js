function newSessionChart(){
   return  {
            chart: {
               type: 'line',
               animation: false,
               backgroundColor: null,
            },
            boost: {
                useGPUTranslations: true
            },
            title: {
                text: ''
            },
            xAxis:{
                min: 0,
                softmin: 0,
                minRange: 20000,
                type: 'datetime',

               title: {
                    text: 'Tempo'
                },
            },
            yAxis: {
                min: 0,
                minRange: 5000,
                title: {
                    text: 'Sensor (Definir Unidades)'
                },
            },

            tooltip: {
             enabled: false,
            },

            legend: {
                align: 'right',
            },
            series: [{
                name: 'Sensor1',
                data: [],
                 states: {
                      hover: {
                          enabled: false
                      }
                  }
            }, {
                name: 'Sensor2',
                data: [],
                 states: {
                    hover: {
                        enabled: false
                    }
                }
            },{
                name: 'Picos1',
                data: [],
                 states: {
                      hover: {
                          enabled: false
                      }
                  }
            }, {
                name: 'Picos2',
                data: [],
                 states: {
                    hover: {
                        enabled: false
                    }
                }
            }],
             credits: {
                  enabled: false
             },
            scrollbar:{
             enabled: false,
            }
  };
}

function progresss_options(){
   return {
            chart: {
                zoomType: 'x',
                backgroundColor: null,
            },
        title: {
            text: null
        },

        xAxis:{
            type: 'datetime',
            title: {
                text: xTitle
            },
            categories: [],
            tickInterval: 3600*24,
        },

        yAxis: {
           softMax: 120,
            title: {
                text: yTitle
            },

         },


        plotOptions: {
            series: {
                pointStart: 0
            }
        },

        series: [{
            name: 'Sensor',
            data: []
        }]
   };
}
