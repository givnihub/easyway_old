<table class="table table-striped table-bordered table-hover example">
    <thead>
        <th>Id</th>
        <th>Amount</th>
        <th>PayMode</th>
        <th>Note</th>
        <th>Date</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach($list as $row)

        <tr>
            <td><?= $row->id ?></span>
            </td>

            <td>{{number_format($row->amount,2)}}
            </td>
            <td>{{$row->payment_mode_fee}}
            </td>
            <td>{{$row->fee_note}}
            </td>
            <td><?= date('d/m/Y H:i:s', strtotime($row->cdate)); ?>
            </td>
            <td>                                                              
            <a href="{{url('admin/allowed-courses-list?delid=')}}{{$row->id}}">  <button class="btn-primary pull-right btn-xs"><i class="fa fa-trash"></i> Delete</button></a>

            </td>

        </tr>
        @endforeach
    </tbody>
</table>