<table class="table table-striped detail-table" id="tableDetail">
  <thead>
    <th>Date</th>
    <th>Description</th>
    <th>Qty</th>
    <th>Amount</th>
    <th>Sub Total</th>
    <th>
      <button type="button" class="btn btn-success btn-md" onclick=addrow()>
        <i class="fa fa-plus-circle"></i>
      </button>
    </th>
  </thead>
  <tbody>
      <tr>
        <td>
          {!! Form::input('date','date_detail[]', null,['class'=> 'form-control date_detail detail-table','id'=>'date_detail', 'placeholder'=> 'Date']) !!}
        </td>
        <td>
          {!! Form::text('description[]', null,['class'=> 'form-control description_detail detail-table', 'id'=>'description_detail','placeholder'=> 'Description']) !!}
        </td>
        <td>
          {!! Form::text('qty[]', null,['class'=> 'form-control qty_detail detail-table','id'=>'qty_detail','placeholder'=> 'qty']) !!}
        </td>
        <td>
          {!! Form::text('sub_total_memo[]', null, ['class'=>'form-control amount_detail detail-table','id'=>'amount_detail',"onkeyup"=>"number(this)", "onkeypress"=>"number(this)"]) !!}
        </td>
        <td>
          {!! Form::text('subtotal[]', null,['class'=> 'form-control total_detail detail-table','id'=>'total_detail','disabled'=>'disabled']) !!}
        </td>
        <td>
            <a href="#" class="del_rinc"><i class="fa fa-times" style="color: red"></i></a>
          </td>
        </td>
      </tr>
  </tbody>
</table>

<div class="col-md-6 pull-right" style="margin-top: 25px;">
  <div class="form-group">
    {!! Form::label('subject_memo', 'Total', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
      {!! Form::text('all_total_detail', null, ['class'=>'form-control all_total_detail','id'=>'all_total_detail','disabled'=>'disabled']) !!}
    </div>
  </div>
</div>