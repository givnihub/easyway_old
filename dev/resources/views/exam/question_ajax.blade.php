@php
$can_view= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id",
$perm_cat_id)->where("can_view", "1")->count();
$can_add= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id",
$perm_cat_id)->where("can_add", "1")->count();
$can_edit= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id",
$perm_cat_id)->where("can_edit", "1")->count();
$can_delete= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id",
$perm_cat_id)->where("can_delete", "1")->count();
@endphp
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover example">
        <thead>
            <tr>
                <th><input type="checkbox" id="mastercheck"></th>
                <th>Q.ID</th>
                <th>Trade Group</th>
                <th>Trade</th>
                <th>Subject</th>
                <th>Chapter</th>
                <th>Topic</th>
                <th>Question</th>
                <th class="text-right">
                    Action </th>
            </tr>
        </thead>
        <tbody>
            <div class="ajax_questions">
                @foreach($list as $row)

                <tr>
                    <td> <input type="checkbox" value="{{$row->id}}" class="checkboxids" name="checkboxid[]"></td>
                    <td>{{$row->id}}</td>
                    <td>
                        <?php $res = DB::table('tradegroup')->where("id", $row->tradegroup)->get()->first();
                        echo $res->name;
                        ?>

                    </td>
                    <td> <?php $res = DB::table('trade')->where("id", $row->trade)->get()->first();
                            echo $res->name;
                            ?> </td>
                    <td><?php $res = DB::table('subject')->where("id", $row->subject)->get()->first();
                        echo $res->name;
                        ?> </td>
                    <td><?php $res = DB::table('chapter')->where("id", $row->chapter)->get()->first();
                        echo $res->name;
                        ?></td>
                    <td><?php $res = DB::table('topics')->where("id", $row->topic)->get()->first();
                        echo $res->name;
                        ?></td>
                    <td>{!!substr($row->question,0,100)!!}....</td>
                    <td class="text-right">
                        @if($can_view>0)
                        <a target="_blank" href="{{url('exam/question/read')}}/{{$row->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="View">
                            <i class="fa fa-eye"></i></a>
                        @endif
                        @if($can_edit>0)
                        <a href="{{url('exam/addquestion')}}?qid={{$row->id}}" data-placement="left" class="btn btn-default btn-xs question-btn-edit" data-toggle="tooltip" id="load" data-recordid="58" title="Edit"><i class="fa fa-pencil"></i>

                        </a>
                        @endif
                        @if($can_delete>0)
                        <a data-placement="left" href="{{url('admin/question')}}?delid={{$row->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Delete Confirm?')"><i class="fa fa-remove"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </div>
        </tbody>

    </table><!-- /.table -->
    <div align="right" id="pagination_link">
        <ul class="pagination">{{$list->links()}}

        </ul>
    </div>
</div>
</div>