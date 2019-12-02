@include('layouts._datepicker')

<script type="text/javascript">
  $(function () {
    $('#quote-dashboard-total-setting-from-date').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });
    $('#quote-dashboard-total-setting-to-date').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });

    $('#quote-dashboard-total-setting').change(function () {
      toggleWidgetQuoteDashboardTotalsDateRange($('#quote-dashboard-total-setting').val());
    });

    function toggleWidgetQuoteDashboardTotalsDateRange (val) {
      if (val == 'custom_date_range') {
        $('#div-quote-dashboard-totals-date-range').show();
      }
      else {
        $('#div-quote-dashboard-totals-date-range').hide();
      }
    }

    toggleWidgetQuoteDashboardTotalsDateRange($('#quote-dashboard-total-setting').val());
  });
</script>

<div class="form-group">
    <label>{{ trans('fi.dashboard_totals_option') }}: </label>
    {!! Form::select('setting[widgetQuoteSummaryDashboardTotals]', $dashboardTotalOptions, config('fi.widgetQuoteSummaryDashboardTotals'), ['class' => 'form-control', 'id' => 'quote-dashboard-total-setting']) !!}
</div>

<div class="row" id="div-quote-dashboard-totals-date-range">
    <div class="col-md-2">
        <label>{{ trans('fi.from_date') }} (yyyy-mm-dd):</label>
        {!! Form::text('setting[widgetQuoteSummaryDashboardTotalsFromDate]', config('fi.widgetQuoteSummaryDashboardTotalsFromDate'), ['class' => 'form-control', 'id' => 'quote-dashboard-total-setting-from-date']) !!}
    </div>
    <div class="col-md-2">
        <label>{{ trans('fi.to_date') }} (yyyy-mm-dd):</label>
        {!! Form::text('setting[widgetQuoteSummaryDashboardTotalsToDate]', config('fi.widgetQuoteSummaryDashboardTotalsToDate'), ['class' => 'form-control', 'id' => 'quote-dashboard-total-setting-to-date']) !!}
    </div>
</div>