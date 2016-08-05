@extends('layout.admin')

@section('styles')
  <style type="text/css">
    .chart-legend li span{
    display: inline-block;
    width: 12px;
    height: 12px;
    margin-right: 5px;
}
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
      <li><a href="{{ route('marketing.report.get') }}?begin={{ $begin->format('Y-m-d') }}&end={{ $end->format('Y-m-d') }}">Daily Report</a></li>
      <li><a href="{{ route('marketing.report.branch.get') }}?b={{ $branch_name }}&begin={{ $begin->format('Y-m-d') }}&end={{ $end->format('Y-m-d') }}">{{ $branch_name }}</a></li>
      <li>{{ $sales_name }}</li>
    </ol>
  </section>
@stop

@section('content')
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

          <p>{{ $sales_name }} Total's</p>
        </div>
        <div class="icon">
          <i class="fa fa-line-chart" aria-hidden="true"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-navy">
        <div class="inner">
          <h3>
            @if ($vs_total_m1)
              {{ substr((($vs_total / $vs_total_m1) - 1) * 100, 0,5) }}
            @else
              0
            @endif
            <sup style="font-size: 20px">%</sup>
          </h3>

          <p>{{ $sales_name }} Growth's</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-maroon">
        <div class="inner">
          <h3>{{ $vs_total_branch }}</h3>

          <p>Total {{ $branch_name }}</p>
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
            @if ($vs_total_branch_m1)
              {{ substr((($vs_total_branch / $vs_total_branch_m1) - 1) * 100, 0,5) }}
            @else
              0
            @endif
            <sup style="font-size: 20px">%</sup>
          </h3>

          <p>Growth {{ $branch_name }}</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.Small boxes (Stat box) -->

  <div class="row">
    <!-- BAR CHART -->
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{ $sales_name }} Chart's</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="salesChart" style="height:230px"></canvas>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
  <!-- Table M -->
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">
            Sales Data Table
            @if ($begin->format('Y-m') == $end->format('Y-m'))
              "{{ $begin->format('F Y') }}"
            @endif
          </h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="tableSales" class="table table-bordered table-hover">
            <thead>
              <tr>
                <?php $dateno = 0;?>
                @foreach ($daterange as $date)
                  <th>{{ $date->format('d') }}</th>
                  <?php $dateno+=1;?>
                @endforeach
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <tr style="background-color: #485563;color: #fff">
                @foreach ($vs as $v)
                  <td>{{ $v->total_sales }}</td>
                @endforeach
                <td>{{ $vs_total }}</td>
              </tr>
              <tr style="background-color:#EB3349;color:#fff">
                <?php $nom1 = 0;?>
                @foreach ($vs_m1 as $vm1)
                  <td>{{ $vm1->total_sales }}</td>
                  <?php $nom1+=1;?>
                @endforeach
                @if ($dateno != $nom1)
                  <td>0</td>
                @endif
                <td>{{ $vs_total_m1 }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Table M -->
  <div class="row">
    <div class="col-md-12">
      <div class="col-xs-12 col-md-6">
            <!-- DONUT CHART -->
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Leasing Chart</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <canvas id="leasingChart" height="230px"></canvas>
                <div id="js-legend-leasing" class="chart-legend"></div>
              <!-- /.box-body -->
              </div>
            </div>
            <!-- /.box -->
      </div>
      <div class="col-xs-12 col-md-6">
            <!-- DONUT CHART -->
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Cash/Credit Chart</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <canvas id="typeChart" height="230px"></canvas>
                <div id="js-legend-type-sales" class="chart-legend"></div>
              <!-- /.box-body -->
              </div>
            <!-- /.box -->
            </div>
      </div>
    </div>
  </div>
@stop

@section('scripts')
  <script type="text/javascript">
  var salesChartData = {
      labels: [@foreach ($daterange as $date)
                "{{ $date->format('d') }}",
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
    //-------------
    //- BAR CHART pic-
    //-------------
    var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
    var salesChart = new Chart(salesChartCanvas);
    var salesChartData = salesChartData;
    salesChartData.datasets[1].fillColor = "#485563";
    salesChartData.datasets[1].strokeColor = "#485563";
    salesChartData.datasets[1].pointColor = "#485563";
    var salesChartOptions = {
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

    salesChartOptions.datasetFill = false;
    salesChart.Bar(salesChartData, salesChartOptions);

    //-------------
    //- LEASING PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var leasingChartCanvas = $("#leasingChart").get(0).getContext("2d");
    var leasingData = [
      @foreach ($tableSales as $ts)
        {
        value: @if ($ts->total_leasing_adira){{ $ts->total_leasing_adira }}@else " "@endif,
        color: "#f1c40f",
        highlight: "#f1c40f",
        label: "ADIRA"
      },
      {
        value: @if ($ts->total_leasing_csf){{ $ts->total_leasing_csf }}@else " "@endif,
        color: "#00a65a",
        highlight: "#00a65a",
        label: "CSF"
      },
      {
        value: @if ($ts->total_leasing_fif){{ $ts->total_leasing_fif }}@else " "@endif,
        color: "#3498db",
        highlight: "#3498db",
        label: "FIF"
      },
      {
        value: @if ($ts->total_leasing_wom){{ $ts->total_leasing_wom }}@else " "@endif,
        color: "#8e44ad",
        highlight: "#8e44ad",
        label: "WOM"
      },
      {
        value: @if ($ts->total_leasing_oto){{ $ts->total_leasing_oto }}@else " "@endif,
        color: "#2c3e50",
        highlight: "#2c3e50",
        label: "OTO"
      },
      {
        value: @if ($ts->total_leasing_other){{ $ts->total_leasing_other }}@else " "@endif,
        color: "#e74c3c",
        highlight: "#e74c3c",
        label: "OTHER"
      }
      @endforeach
    ];
    var leasingOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: '<ul>' + '<% for (var i=0; i<segments.length; i++) { %>' + '<li>' + '<span style=\"background-color:<%=segments[i].fillColor%>\"></span>' + '<% if (segments[i].label) { %><%= segments[i].label %><% } %>' + '</li>' + '<% } %>' + '</ul>'
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var leasingChart = new Chart(leasingChartCanvas).Doughnut(leasingData, leasingOptions);
    document.getElementById("js-legend-leasing").innerHTML = leasingChart.generateLegend();

    //-------------
    //- LEASING PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var typeChartCanvas = $("#typeChart").get(0).getContext("2d");
    var typeData = [
      @foreach ($tableSales as $ts)
        {
        value: @if ($ts->total_cash){{ $ts->total_cash }}@else " "@endif,
        color: "#f1c40f",
        highlight: "#f1c40f",
        label: "Cash"
      },
      {
        value: @if ($ts->total_credit){{ $ts->total_credit }}@else " "@endif,
        color: "#00a65a",
        highlight: "#00a65a",
        label: "Credit"
      },
      {
        value: @if ($ts->total_tempo){{ $ts->total_tempo }}@else " "@endif,
        color: "#e67e22",
        highlight: "#e67e22",
        label: "Tempo"
      }
      @endforeach
    ];
    var typeOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: '<ul>' + '<% for (var i=0; i<segments.length; i++) { %>' + '<li>' + '<span style=\"background-color:<%=segments[i].fillColor%>\"></span>' + '<% if (segments[i].label) { %><%= segments[i].label %><% } %>' + '</li>' + '<% } %>' + '</ul>'
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var typeChart = new Chart(typeChartCanvas).Doughnut(typeData, typeOptions);
    document.getElementById("js-legend-type-sales").innerHTML = typeChart.generateLegend();

    $('#reportrange').daterangepicker({
      buttonClasses: ['btn', 'btn-sm'],
      applyClass: 'btn-success',
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
      window.location="{{  request()->url() }}?s={{ $sales }}&begin="+ start.format('Y-MM-DD') +"&end=" + end.format('Y-MM-DD');

    });

    $('#tableSales').DataTable({
      "sorting":false,
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "scrollX": "100%",
      "scrollCollapse": true,
    })
  </script>
@stop