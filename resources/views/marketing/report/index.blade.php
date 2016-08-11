@extends('layout.admin')

@section('styles')
  <style type="text/css">
    /*#reportrange{
      background: #fff; 
      cursor: pointer; 
      padding: 7px; 
      border: 1px solid #00A65A;
      border-radius: 5px;
      color: #00A65A;
    }*/
  </style>
@stop
@section('content-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-bar-chart" aria-hidden="true"></i> Marketing Daily Report
      <small>Honda Prima Marketing Daily Report</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="/upload">Marketing</a></li>
      <li class="active"><a href="{{ route('marketing.report.get') }}">Daily Report</a></li>
    </ol>
  </section>
@stop

@section('content')
  {{-- get url control --}}
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header"></div>
        <div class="box-body">
          <button type="button" class="btn btn-red pull-right" id="reportrange">
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
            <span>
              @if ($begin)
                {{ $begin->format('F d, Y') }}
                -
                {{ $end->format('F d, Y') }}
              @endif
            </span>
            <b class="caret"></b>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-navy">
        <div class="inner">
          <h3>{{ $vs_total }}</h3>

          <p>Total PAR</p>
        </div>
        <div class="icon">
          <i class="fa fa-line-chart" aria-hidden="true"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-maroon">
        <div class="inner">
          <h3>
            @if ($vs_total_m1)
              {{ substr((($vs_total / $vs_total_m1) - 1) * 100, 0,5) }}
            @else
              0
            @endif
            <sup style="font-size: 20px">%</sup>
          </h3>

          <p>Growth PAR</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-navy">
        <div class="inner">
          <h3>{{ $vspma_total }}</h3>

          <p>Total PMA</p>
        </div>
        <div class="icon">
          <i class="fa fa-line-chart"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-maroon">
        <div class="inner">
          <h3>
            @if ($vspma_total_m1)
              {{ substr((($vspma_total / $vspma_total_m1) - 1) * 100, 0,5) }}
            @else
              0
            @endif
            <sup style="font-size: 20px">%</sup>
          </h3>

          <p>Growth PMA</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
  </div>

  <!-- BAR CHART -->
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">PT. Prima Anaga Raina</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="parChart" style="height:230px"></canvas>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
  <!-- /.box -->

  <!-- BAR CHART -->
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">PT. Prima Mustika Abadi</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="pmaChart" style="height:230px"></canvas>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
  <!-- /.box -->

  <div class="row">
    <div class="col-xs-12">
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">
            Sales Data Table
            @if ($begin->format('Y-m') == $end->format('Y-m'))
              "{{ $begin->format('F Y') }}"
            @endif
          </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="tableVSales" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="bg-primary">Rank</th>
                <th class="bg-primary">Sales</th>
                <th class="bg-primary">Today</th>
                <th class="bg-navy">M</th>
                <th class="bg-navy">-1</th>
                <th class="bg-navy">Growth</th>
                <th class="bg-orange">CS</th>
                <th class="bg-orange">Sales</th>
                <th class="bg-purple">Cub</th>
                <th class="bg-purple">At</th>
                <th class="bg-purple">Sport</th>
                <th class="bg-teal">Cash</th>
                <th class="bg-teal">Credit</th>
                <th class="bg-maroon">Tempo</th>
                <th class="bg-maroon">ADIRA</th>
                <th class="bg-maroon">CSF</th>
                <th class="bg-maroon">FIF</th>
                <th class="bg-maroon">OTO</th>
                <th class="bg-maroon">WOM</th>
                <th class="bg-maroon">OTHER</th>
              </tr>
            </thead>
            <tbody>
              <?php $rank=1; ?>
              @foreach ($tableSales as $t)
                <tr>
                  <td>{{ $rank++ }}</td>
                  <td>
                    <a href="{{ route('marketing.report.branch.get') }}?b={{ $t->name_branch }}&begin={{ $begin->format('Y-m-d') }}&end={{ $end->format('Y-m-d') }}">
                      {{ $t->name_branch }}
                    </a>
                  </td>
                  <td>{{ $t->total_today }}</td>
                  <td>{{ $t->total_month }}</td>
                  <td>{{ $t->total_month_m1 }}</td>
                  <td>
                    @if ($t->total_month_m1)
                      {{ substr((($t->total_month / $t->total_month_m1) - 1) * 100, 0,5) }} %
                    @endif
                  </td>
                  <td>{{ $t->total_cs }}</td>
                  <td>{{ $t->total_marketing + $t->total_spv + $t->total_rh + $t->total_bm }}</td>
                  
                  <td>{{ $t->total_cub_low_end + $t->total_cub_mid_end + $t->total_cub_high_end }}</td>
                  <td>{{ $t->total_at_low_end + $t->total_at_mid_end + $t->total_at_high_end }}</td>
                  <td>{{ $t->total_sport_low_end + $t->total_sport_mid_end + $t->total_sport_high_end }}</td>
                  <td>
                    @if ($t->total_cash)
                      {{ substr(($t->total_cash/$t->total_month) * 100, 0,5) }}
                    @else
                      0
                    @endif
                      %
                  </td>
                  <td>
                    @if ($t->total_credit)
                      {{ substr(($t->total_credit/$t->total_month) * 100, 0, 5) }}
                    @else
                      0
                    @endif
                      %
                  </td>
                  <td>{{ $t->total_tempo }}</td>
                  <td>{{ $t->total_leasing_adira }}</td>
                  <td>{{ $t->total_leasing_csf }}</td>
                  <td>{{ $t->total_leasing_fif }}</td>
                  <td>{{ $t->total_leasing_oto }}</td>
                  <td>{{ $t->total_leasing_wom }}</td>
                  <td>{{ $t->total_leasing_other }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        
      </div>
    </div>
  </div>

@stop

@section('scripts')
  <script type="text/javascript">
     var parChartData = {
      labels: [@foreach ($daterange as $date)
                "{{ $date->format('d M') }}",
              @endforeach],
      datasets: [
        {
          @if ($vs_m1)
          label: "{{ date('F', strtotime($begin->format('Y-m-d')."-1 month")) }}",
          fillColor: "rgba(235, 51, 73, 1)",
          strokeColor: "rgba(235, 51, 73, 1)",
          pointColor: "rgba(235, 51, 73, 1)",
          pointStrokeColor: "#EB3349",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(235, 51, 73,1)",
          data: [@foreach ($vs_m1 as $v)
                  {{ $v->total_sales }},
                @endforeach]
          @endif
        },
        {
          @if ($vs)
          label: "{{ $begin->format('F') }}",
          fillColor: "rgba(59,139,186,0.9)",
          strokeColor: "rgba(59,139,186,0.8)",
          pointColor: "#485563",
          pointStrokeColor: "rgba(59,139,186,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(59,139,186,1)",
          data: [@foreach ($vs as $vs)
                  {{ $vs->total_sales }},
                @endforeach]
          @endif
        }
      ]
    };

    var pmaChartData = {
      labels: [@foreach ($daterange as $date)
                "{{ $date->format('d M') }}",
              @endforeach],
      datasets: [
        {
          @if ($vspma_m1)
          label: "{{ date('F', strtotime($begin->format('Y-m-d')."-1 month")) }}",
          fillColor: "rgba(235, 51, 73, 1)",
          strokeColor: "rgba(235, 51, 73, 1)",
          pointColor: "rgba(235, 51, 73, 1)",
          pointStrokeColor: "#EB3349",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(235, 51, 73,1)",
          data: [@foreach ($vspma_m1 as $v)
            {{ $v->total_sales }},
          @endforeach]
          @endif
        },
        {
          @if ($vspma)
          label: "{{ $begin->format('F') }}",
          fillColor: "rgba(59,139,186,0.9)",
          strokeColor: "rgba(59,139,186,0.8)",
          pointColor: "#485563",
          pointStrokeColor: "rgba(59,139,186,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(59,139,186,1)",
          data: [@foreach ($vspma as $vs)
                  {{ $vs->total_sales }},
                @endforeach]
          @endif
        }
      ]
    };
    
    //-------------
    //- BAR CHART PAR-
    //-------------
    var parChartCanvas = $("#parChart").get(0).getContext("2d");
    var parChart = new Chart(parChartCanvas);
    var parChartData = parChartData;
    parChartData.datasets[1].fillColor = "#485563";
    parChartData.datasets[1].strokeColor = "#485563";
    parChartData.datasets[1].pointColor = "#485563";
    var parChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };
    parChartOptions.datasetFill = false;
    parChart.Bar(parChartData, parChartOptions);


    //-------------
    //- BAR CHART PMA-
    //-------------
    var pmaChartCanvas = $("#pmaChart").get(0).getContext("2d");
    var pmaChart = new Chart(pmaChartCanvas);
    var pmaChartData = pmaChartData;
    parChartData.datasets[1].fillColor = "#485563";
    parChartData.datasets[1].strokeColor = "#485563";
    parChartData.datasets[1].pointColor = "#485563";
    
    var pmaChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    pmaChartOptions.datasetFill = false;
    pmaChart.Bar(pmaChartData, pmaChartOptions);

    $('#tableVSales').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "scrollX": "100%",
      dom: 'Bfrtip',
        buttons: [
            'csv', 'excel'
        ]
    });
    $('#reportrange').daterangepicker({
      buttonClasses: ['btn', 'btn-sm'],
      applyClass: 'btn-red',
      cancelClass: 'btn-default',
      startDate: '{{ $begin->format('m/d/y') }}',
        endDate: '{{ $end->format('m/d/y') }}',
      locale: {
        applyLabel: 'Submit',
        cancelLabel: 'Cancel',
        fromLabel: 'From',
        toLabel: 'To',
      },
      ranges: {
         'Today': [moment(), moment()],
         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
         'This Month': [moment().startOf('month'), moment().endOf('month')],
         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    }, function(start, end, label){
      console.log(start.toISOString(), end.toISOString(), label);

      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      // alert("{{  request()->url() }}?begin="+ start.format('Y-MM-DD') +"&end=" + end.format('Y-MM-DD'));
      window.location="{{  request()->url() }}?begin="+ start.format('Y-MM-DD') +"&end=" + end.format('Y-MM-DD');

    });
  </script>
@stop