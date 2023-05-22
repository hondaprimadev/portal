<table class="table table-striped table-color detail-table" id="tableDetail">
      <thead>
        <th>Date</th>
        <th>Description</th>
        <th>Qty</th>
        <th>Amount</th>
        <th>Sub Total</th>
      </thead>
      <tbody>
        <?php $sum = 0;?>
        @foreach ($memo->details as $me)
          <tr>
            <td>{{ date('d/M/Y', strtotime($me->date)) }}</td>
            <td>{{ $me->description }}</td>
            <td>{{ $me->qty }}</td>
            <td>{{ number_format($me->total) }}</td>
            <td>{{ number_format($me->qty * $me->total) }}</td>
            <?php $sum += $me->qty * $me->total;?>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4">Total</td>
          <td style="text-align: left;">{{ number_format($sum) }}</td>
        </tr>
      </tfoot>
    </table>