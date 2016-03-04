<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>autoNumeric</title>
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>

        <script type="text/javascript" src="module/lap_penjualan/highchart.js"></script>
        <script type="text/javascript" src="module/lap_penjualan/exporting.js"></script>

    <body>
        <?php
        include './koneksi.php';
        $no = 0;
        $menu = array();
        $nama = array();
//        $sql = "SELECT inv_status_bayar, COUNT(inv_status_bayar) as itung FROM mst_inv GROUP BY inv_status_bayar";
        $sql = "SELECT DISTINCT (SELECT count(inv_status_bayar) from mst_inv where inv_status_bayar = 'BELUM LUNAS' GROUP BY inv_status_bayar) as itung , 
(SELECT count(inv_status_bayar) from mst_inv where inv_status_bayar = 'LUNAS' GROUP BY inv_status_bayar) as ngitung
FROM mst_inv GROUP BY inv_status_bayar";
        $qry = mysql_query($sql);
        while ($row = mysql_fetch_assoc($qry)) {
            $menu = $row['itung'];
            $nama = $row['ngitung'];
        }

//        $aray = join(" ,", $menu);
//        $aray_name = join(",", $nama);
        ?>
        <script type="text/javascript">
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container',
                        zoomType: 'xy'
                    },
                    title: {
                        text: 'Grafik'
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: [{
                            categories: ['Lunas', 'Belum Lunas']
                        }],
                    yAxis: [{// Primary yAxis
                            labels: {
                                formatter: function() {
                                    return this.value + '';
                                },
                                style: {
                                    color: '#89A54E'
                                }
                            },
                            title: {
                                text: 'Lunas',
                                style: {
                                    color: '#4572A7'
                                }
                            }
                        },
                        {
                            title: {
                                text: 'Prosentasi Status Tagihan',
                                style: {
                                    color: '#4572A7'
                                }
                            },
                            labels: {
//                                formatter: function() {
//                                    return this.value + '';
//                                },
                                style: {
                                    color: '#4572A7'
                                }
                            },
                            opposite: true
                        }],
//                    tooltip: {
//                        formatter: function() {
//                            return '' +
//                                    this.x + ': ' + this.y +
//                                    (this.series.name === '' ? 'Lunas' : 'Belum Lunas');
//                        }
//                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                format: '<b>{series.name}</b>: {point.percentage:.0f} %',
                                enabled: true,
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                }
                            },
                            showInLegend: true
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'left',
                        x: 100,
                        verticalAlign: 'top',
                        y: 0,
                        floating: true,
                        backgroundColor: '#FFFFFF'
                    },
                    series: [
                        {
                            name: 'Total',
                            color: '#4572A7',
//                            type: 'spline',
                            type: 'pie',
                            yAxis: 0,
                            data: [
                                ['Lunas', <?php echo $nama; ?>],
                                ['Belum Lunas', <?php echo $menu; ?>]
                            ]
                        }
                    ]
                });
            });

        </script>
    </script>
    <div id="container"></div>
</body>
</html>