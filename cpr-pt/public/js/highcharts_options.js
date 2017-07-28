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

function progresssChart(){
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

function exerciseFeedbackChart(){
   return {

        chart: {
           type: 'line',
           panning: true,
          panKey: 'shift',
            zoomType: 'x',
            backgroundColor:'transparent',
        },

        plotOptions: {
            series: {
                animation: false
            }
        },

        boost: {
            useGPUTranslations: true
        },


        title: {
            text: 'Dados da Sessão de Treino'
        },

        subtitle: {
            text: 'CPR PT'
        },

        xAxis:{
            min: 0,
            minRange: 10000,
            type: 'datetime',

           title: {
                text: 'Tempo'
            },

        },

        yAxis: {
            min: 0,
            title: {
                text: 'Sensor (Definir Unidades)'
            },

        },

        tooltip: {
            headerFormat: '<b>{series.name}</b><br />',
            pointFormat: 'x = {point.x}, y = {point.y}'
        },

        legend: {

            align: 'right',

        },

          credits: {
             enabled: false
          },


        series: [{
            name: 'Compressões',
            data: []
        }, {
            name: 'Pos_Mãos',
            data: []
        },{
            name: 'Picos1',
            data: []
        }, {
            name: 'Picos2',
            data: []
        }],

        scrollbar:{
          enabled: true,
        }


   };
}
