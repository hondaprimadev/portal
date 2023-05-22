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
        <?php foreach($memo->details as $me): ?>
          <tr>
            <td><?php echo e(date('d/M/Y', strtotime($me->date))); ?></td>
            <td><?php echo e($me->description); ?></td>
            <td><?php echo e($me->qty); ?></td>
            <td><?php echo e(number_format($me->total)); ?></td>
            <td><?php echo e(number_format($me->qty * $me->total)); ?></td>
            <?php $sum += $me->qty * $me->total;?>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4">Total</td>
          <td style="text-align: left;"><?php echo e(number_format($sum)); ?></td>
        </tr>
      </tfoot>
    </table>