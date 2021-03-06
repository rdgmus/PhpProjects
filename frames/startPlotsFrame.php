<html>
    <head>

        <!----------
        jqPlot 
       ---------->
<!--  <script language="javascript" type="text/javascript" src="jqplot/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="jqplot/jquery.jqplot.min.css" />

<script type="text/javascript" src="jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="jqPlot/plugins/jqplot.pointLabels.min.js"></script>
<script type="text/javascript" src="jqPlot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="jqPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>-->


        <?php
        /*
         * Copyright (C) 2014 rdgmus
         *
         * This program is free software: you can redistribute it and/or modify
         * it under the terms of the GNU General Public License as published by
         * the Free Software Foundation, either version 3 of the License, or
         * (at your option) any later version.
         *
         * This program is distributed in the hope that it will be useful,
         * but WITHOUT ANY WARRANTY; without even the implied warranty of
         * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
         * GNU General Public License for more details.
         *
         * You should have received a copy of the GNU General Public License
         * along with this program.  If not, see <http://www.gnu.org/licenses/>.
         */
        ?>
        <script type="text/javascript">
            $(document).ready(function () {

                function test() {
                    var line1 = [['Cup Holder Pinion Bob', 7], ['Generic Fog Lamp', 9], ['HDTV Receiver', 15],
                        ['8 Track Control Module', 12], [' Sludge Pump Fourier Modulator', 3],
                        ['Transcender/Spice Rack', 6], ['Hair Spray Danger Indicator', 18]];
                    var line2 = [['Nickle', 28], ['Aluminum', 13], ['Xenon', 54], ['Silver', 47],
                        ['Sulfer', 16], ['Silicon', 14], ['Vanadium', 23]];

                    var plot2 = $.jqplot('chart2', [line1, line2], {
                        series: [{renderer: $.jqplot.BarRenderer}, {xaxis: 'x2axis', yaxis: 'y2axis'}],
                        axesDefaults: {
                            tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                            tickOptions: {
                                angle: 30
                            }
                        },
                        axes: {
                            xaxis: {
                                renderer: $.jqplot.CategoryAxisRenderer
                            },
                            x2axis: {
                                renderer: $.jqplot.CategoryAxisRenderer
                            },
                            yaxis: {
                                autoscale: true
                            },
                            y2axis: {
                                autoscale: true
                            }
                        }
                    });
                }
                /**
                 * Grafico delle connessioni giornaliere
                 * @returns {NULL}
                 */
                function connectionsPerDayGraph() {

                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: {"page": "index.php",
                            "action": "getConnectionPerDay"},
                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
//                            alert("getConnectionPerDay success:" + response);
                            var connectionPerDay = jQuery.parseJSON(response);
                            var arr = [[]];
                            var labels = [];
                            for (key in connectionPerDay) {
                                var giorno = connectionPerDay[key].giorno;
                                var mese = connectionPerDay[key].mese;
                                var anno = connectionPerDay[key].anno;
                                var connessioni = parseInt(connectionPerDay[key].connessioni);

                                arr.push([giorno + "\n" + mese + "\n" + anno, connessioni]);
                                labels[key] = connessioni;
                            }
                            $('#connectionsPerDayGraph').jqplot([arr], {
                                title: 'Login / Giorno',
                                seriesDefaults: {
                                    renderer: $.jqplot.BarRenderer,
                                    pointLabels: {show: true, labels: labels},
                                    rendererOptions: {
                                        // Set the varyBarColor option to true to use different colors for each bar.
                                        // The default series colors are used.
                                        varyBarColor: true
                                    }
                                },
                                axesDefaults: {
                                    tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                                    tickOptions: {
                                        fontFamily: 'Georgia',
                                        fontSize: '8pt',
                                        angle: -90
                                    }
                                },
                                axes: {
                                    xaxis: {
                                        renderer: $.jqplot.CategoryAxisRenderer
                                    }
                                }
                            });
//                            
                        },
                        failure: function (response) {
                            alert("getConnectionPerDay failure:" + response);
//                            location.reload();
                        }
                    });
                }


                /**
                 * Grafico delle connessioni per mese
                 * @returns {NULL}
                 */
                function connectionsPerMonthGraph() {

                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: {"page": "index.php",
                            "action": "getConnectionPerMonth"},
                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                            //alert("getConnectionPerMonth success:" + response);
                            var connectionPerMonth = jQuery.parseJSON(response);
                            var arr = [[]];
                            var labels = [];
                            for (key in connectionPerMonth) {
                                var connessioni = parseInt(connectionPerMonth[key].connessioni);
                                var mese = connectionPerMonth[key].mese;
                                var anno = connectionPerMonth[key].anno;
                                arr.push([anno + "/" + mese, connessioni]);
                                labels[key] = connessioni;
//                                alert(arr[key]);
                            }
                            $('#connectionsPerMonthGraph').jqplot([arr], {
                                title: 'Login / Mese',
                                seriesDefaults: {
                                    renderer: $.jqplot.BarRenderer,
                                    pointLabels: {show: true, stackedValue: true, labels: labels},
                                    rendererOptions: {
                                        // Set the varyBarColor option to true to use different colors for each bar.
                                        // The default series colors are used.
                                        barMargin: 25,
                                        varyBarColor: true
                                    }
                                },
                                axes: {
                                    xaxis: {
                                        renderer: $.jqplot.CategoryAxisRenderer
                                    }
                                }
                            });
//                            
                        },
                        failure: function (response) {
                            alert("getConnectionPerMonth failure:" + response);
//                            location.reload();
                        }
                    });
                }

                /**
                 * Grafico delle statistiche ...
                 * @returns {undefined}
                 */
                function applicationStatsGraph() {
                    var s1 = [200, 600, 700, 1000];
                    var s2 = [460, -210, 690, 820];
                    var s3 = [-260, -440, 320, 200];
                    // Can specify a custom tick Array.
                    // Ticks should match up one for each y value (category) in the series.
                    var ticks = ['May', 'June', 'July', 'August'];
                    var plot1 = $.jqplot('applicationStatsGraph', [s1, s2, s3], {
                        title: "Statistiche",
                        // The "seriesDefaults" option is an options object that will
                        // be applied to all series in the chart.
                        seriesDefaults: {
                            renderer: $.jqplot.BarRenderer,
                            rendererOptions: {fillToZero: true}
                        },
                        // Custom labels for the series are specified with the "label"
                        // option on the series option.  Here a series option object
                        // is specified for each series.
                        series: [
                            {label: 'Hotel'},
                            {label: 'Event Regristration'},
                            {label: 'Airfare'}
                        ],
                        // Show the legend and put it outside the grid, but inside the
                        // plot container, shrinking the grid to accomodate the legend.
                        // A value of "outside" would not shrink the grid and allow
                        // the legend to overflow the container.
                        legend: {
                            show: true,
                            placement: 'outsideGrid'
                        },
                        axes: {
                            // Use a category axis on the x axis and use our custom ticks.
                            xaxis: {
                                renderer: $.jqplot.CategoryAxisRenderer,
                                ticks: ticks
                            },
                            // Pad the y axis just a little so bars can get close to, but
                            // not touch, the grid boundaries.  1.2 is the default padding.
                            yaxis: {
                                pad: 1.05,
                                tickOptions: {formatString: '$%d'}
                            }
                        }
                    });
                }

                /**
                 * FUNZIONI TABS IN index.php
                 * @returns {undefined}
                 */
                $(function () {

                    $.jqplot.config.enablePlugins = true;
                    $("#tabs").tabs({
//                        active: 1 
//                        ,show: { effect: "blind", duration: 400 }
                        create: function (event, ui) {
                            // Do stuff here
//                            alert('create');
                            connectionsPerMonthGraph();
                        }
                    });

                    $("#tabs").tabs({
                        activate: function (event, ui) {
                            // Do stuff here
                            switch (ui.newTab.index()) {
                                case 0:
                                    connectionsPerMonthGraph();
                                    break;
                                case 1:
                                    connectionsPerDayGraph();
                                    break;
                                case 2:
                                    applicationStatsGraph();
                                    break;
                                case 3:
                                    test();
                                    break;
                            }
                        },
                        create: function (event, ui) {
                            // Do stuff here
                            alert('create');
//                            connectionsPerMonthGraph();
                        }
                    });

                });



            });
        </script>
    </head>

    <body>
        <div id="tabs">
            <ul>
                <li><a href="#connectionsPerMonthGraph"><span>Login / Mese</span></a></li>
                <li><a href="#connectionsPerDayGraph"><span>Login / Giorno</span></a></li>
                <li><a href="#applicationStatsGraph"><span>Statistiche</span></a></li>
                <li><a href="#chart2"><span>Test</span></a></li>
            </ul>

            <div id="connectionsPerMonthGraph" style="height:200px;"></div>

            <div id="connectionsPerDayGraph" style="height:200px;"></div>

            <div id="applicationStatsGraph" style="height:200px;"></div>

            <div id="chart2" style="height:200px;"></div>

        </div>
    </body>
</html>