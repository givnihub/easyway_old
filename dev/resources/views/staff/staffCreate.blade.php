@include('admin.include.head');

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header');
        @include('admin.include.sidebar');
        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class="fa fa-sitemap"></i> Human Resource</h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        @if(session('success'))
                        <div class="alert alert-success">
                            <strong>Success!</strong> <?= @session('success') ?>.
                        </div>
                        @endif
                        @if(session('error'))
                        <div class="alert alert-danger">
                            <strong>Error!</strong> <?= @session('error') ?>.
                        </div>
                        @endif
                        <div class="box box-primary">
                            <?php if ($_GET['uid'] != '') {
                                $id = $_GET['uid'];
                            }

                            ?>
                            <form id="form1" action="{{url('admin/staff/create')}}" id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                <input type="hidden" name="uid" value="<?= $res[0]->id ?>">
                                <div class="box-body">
                                    <div class="alert alert-info">
                                        Staff email is their login username, password is generated automatically and
                                        send to staff email. Superadmin can change staff password on their staff profile
                                        page.

                                    </div>
                                    <div class="tshadow mb25 bozero">
                                        <!-- <div class="box-tools pull-right pt3">
                                            <a class="btn btn-sm btn-primary" href="{{url('')}}/admin/staff/import" autocomplete="off"><i class="fa fa-plus"></i> Import Staff</a>

                                        </div> -->
                                        <h4 class="pagetitleh2">Basic Information </h4>
                                        <div class="around10">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-3">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Role</label><small class="req">
                                                            *</small>

                                                        <select id="role" name="role" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach($role as $run)
                                                            <option value="<?= $run->id ?>" @if($run->id==$res[0]->role) selected @endif><?= $run->name ?></option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">@error('role'){{$message}}@enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Designation</label>

                                                        <select id="designation" name="designation" placeholder="" type="text" class="form-control">
                                                            <option value="">Select</option>
                                                            @foreach($designation as $run)
                                                            <option value="<?= $run->id ?>" @if($run->id==$res[0]->designation) selected @endif><?= $run->designation ?></option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Department</label>
                                                        <select id="department" name="department" placeholder="" type="text" class="form-control">
                                                            <option value="">Select</option>
                                                            @foreach($department as $run)
                                                            <option value="<?= $run->id ?>" @if($run->id==$res[0]->department) selected @endif><?= $run->department ?></option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">First Name</label><small class="req"> *</small>
                                                        <input id="name" name="name" placeholder="" type="text" class="form-control" value="<?=$res[0]->name?>" required />
                                                        <span class="text-danger">@error('name'){{$message}}@enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Last Name</label>
                                                        <input id="surname" name="surname" placeholder="" type="text" class="form-control" value="<?=$res[0]->surname?>" />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Father Name</label>
                                                        <input id="father_name" name="father_name" placeholder="" type="text" class="form-control" value="<?=$res[0]->father_name?>" />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Mother Name</label>
                                                        <input id="mother_name" name="mother_name" placeholder="" type="text" class="form-control" value="<?=$res[0]->mother_name?>" />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email (Login
                                                            Username)</label><small class="req"> *</small>
                                                        <input id="email" name="email" placeholder="" type="email" class="form-control" value="<?=$res[0]->email?>" required />
                                                        <span class="text-danger">@error('email'){{$message}}@enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile"> Gender</label><small class="req">
                                                            *</small>
                                                        <select class="form-control" name="gender" required>
                                                            <option value="">Select</option>
                                                            <option value="Male" @if($res[0]->gender=='Male') selected @endif>Male</option>
                                                            <option value="Female"  @if($res[0]->gender=='Female') selected @endif>Female</option>
                                                        </select>
                                                        <span class="text-danger">@error('gender'){{$message}}@enderror</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Date of Birth</label><small class="req"> *</small>
                                                        <input id="dob" name="dob" placeholder="" type="date" class="form-control" value="<?=$res[0]->dob?>" required />
                                                        <span class="text-danger">@error('dob'){{$message}}@enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Date Of Joining</label>
                                                        <input id="date_of_joining" name="date_of_joining" placeholder="" type="date" class="form-control" value="<?=$res[0]->date_of_joining?>" />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Phone</label>
                                                        <input id="mobileno" name="contactno" placeholder="" type="number" class="form-control" value="<?=$res[0]->contact_no?>"  />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Emergency Contact Number</label>
                                                        <input id="mobileno" name="emergency_no" placeholder="" type="number" class="form-control" value="<?=$res[0]->emergency_contact_no?>"  />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Marital Status</label>
                                                        <select class="form-control" name="marital_status">
                                                            <option value="">Select</option>
                                                            <option value="Single" <?php if($res[0]->marital_status=='Single'){echo 'selected';}?>>Single</option>
                                                            <option value="Married" <?php if($res[0]->marital_status=='Married'){echo 'selected';}?>>Married</option>
                                                            <option value="Widowed" <?php if($res[0]->marital_status=='Widowed'){echo 'selected';}?>>Widowed</option>
                                                            <option value="Separated" <?php if($res[0]->marital_status=='Seprated'){echo 'selected';}?>>Separated</option>
                                                            <option value="Not Specified" <?php if($res[0]->marital_status=='Not Specified'){echo 'selected';}?>>Not Specified</option>

                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Photo</label>
                                                        <div><input class="filestyle form-control" type='file' name='photo' id="file" size='20' />
                                                        </div>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Current Address</label>
                                                        <div><textarea name="address" class="form-control"><?=$res[0]->local_address?></textarea>
                                                        </div>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Permanent Address</label>
                                                        <div><textarea name="permanent_address" class="form-control"><?=$res[0]->permanent_address?></textarea>
                                                        </div>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Qualification</label>
                                                        <textarea id="qualification" name="qualification" placeholder="" class="form-control"><?=$res[0]->qualification?></textarea>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Work Experience</label>
                                                        <textarea id="work_exp" name="work_exp" placeholder="" class="form-control"><?=$res[0]->work_exp?></textarea>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Note</label>
                                                        <div><textarea name="note" class="form-control"><?=$res[0]->note?></textarea>
                                                        </div>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group"><label for="custom_fields[staff][1]" class="control-label">Commision</label><small class='req'>
                                                            *</small><input type="number" step="any" id="custom_fields[staff][1]" name="commision" class="form-control" value="<?=$res[0]->commision?>" > <span class="text-danger">@error('commision'){{$message}}@enderror</span></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group"><label for="custom_fields[staff][2]" class="control-label">Discount</label><small class='req'>
                                                            *</small><input type="number" step="any" id="custom_fields[staff][2]" name="discount" class="form-control" value="<?=$res[0]->discount?>" > <span class="text-danger">@error('discount'){{$message}}@enderror</span></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="box-group collapsed-box">
                                        <div class="panel box box-success collapsed-box">
                                            <div class="box-header with-border">
                                                <a data-widget="collapse" data-original-title="Collapse" class="collapsed btn boxplus">
                                                    <i class="fa fa-fw fa-plus"></i>Add More Details </a>
                                            </div>

                                            <div class="box-body">

                                                <div class="tshadow mb25 bozero">
                                                    <h4 class="pagetitleh2">Payroll </h4>

                                                    <div class="row around10">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">EPF No</label>
                                                                <input id="epf_no" name="epf_no" placeholder="" type="text" class="form-control" value="<?=$res[0]->epf_no?>" />
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Basic Salary</label>
                                                                <input type="any" class="form-control" name="basic_salary" value="<?=$res[0]->basic_salary?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Contract Type</label>
                                                                <select class="form-control" name="contract_type">
                                                                    <option value="">Select</option>
                                                                    <option value="permanent" <?php if($res[0]->contract_type=='permanent'){echo 'selected';}?>>Permanent</option>
                                                                    <option value="probation" <?php if($res[0]->contract_type=='probation'){echo 'selected';}?>>Probation</option>
                                                                </select>
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Work Shift</label>
                                                                <input id="shift" name="shift" placeholder="" type="text" class="form-control" value="<?=$res[0]->shift?>" />
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">

                                                                <label for="exampleInputEmail1">Location</label>
                                                                <input id="location" name="location" placeholder="" type="text" class="form-control" value="<?=$res[0]->location?>" />
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        @if($id!='')
                                                        <div class="col-md-4">
                                                            <div class="form-group">

                                                                <label for="exampleInputEmail1">Date Of Leaving</label>
                                                                <input id="location" name="date_of_leaving" placeholder="" type="date" class="form-control" value="<?=$res[0]->date_of_leaving?>" />
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="tshadow mb25 bozero">
                                                    <h4 class="pagetitleh2">Leaves </h4>
                                                    <div class="row around10">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Festival </label>

                                                                <input name="festival_leave" placeholder="Number of Leaves" type="number" class="form-control" value="<?=$res[0]->festival_leave?>"/>

                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Emergency</label>

                                                                <input name="emergency_leave" placeholder="Number of Leaves" type="number" class="form-control" value="<?=$res[0]->emergency_leave?>"/>

                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Regular </label>
                                                                <input name="regular_leave" placeholder="Number of Leaves" type="number" class="form-control" value="<?=$res[0]->regual_leave?>"/>

                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tshadow mb25 bozero">
                                                    <h4 class="pagetitleh2">Bank Account Details </h4>

                                                    <div class="row around10">

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Account Title</label>
                                                                <input id="account_title" name="account_title" placeholder="" type="text" class="form-control" value="<?=$res[0]->account_title?>" />
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Bank Account
                                                                    Number</label>
                                                                <input id="bank_account_no" name="bank_account_no" placeholder="" type="number" class="form-control" value="<?=$res[0]->bank_account_no?>" />
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Bank Name</label>
                                                                <input id="bank_name" name="bank_name" placeholder="" type="text" class="form-control" value="<?=$res[0]->bank_name?>" />
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">IFSC Code</label>
                                                                <input id="ifsc_code" name="ifsc_code" placeholder="" type="text" class="form-control" value="<?=$res[0]->ifsc_code?>" />
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Bank Branch Name</label>
                                                                <input id="bank_branch" name="bank_branch" placeholder="" type="text" class="form-control" value="<?=$res[0]->bank_branch?>" />
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="tshadow mb25 bozero">
                                                    <h4 class="pagetitleh2">Social Media Link </h4>

                                                    <div class="row around10">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Facebook URL</label>
                                                                <input id="bank_account_no" name="facebook" placeholder="" type="text" class="form-control" value="<?=$res[0]->facebook?>" />
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Twitter URL</label>
                                                                <input id="bank_account_no" name="twitter" placeholder="" type="text" class="form-control" value="<?=$res[0]->twitter?>" />
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Linkedin URL</label>
                                                                <input id="bank_name" name="linkedin" placeholder="" type="text" class="form-control" value="<?=$res[0]->linkedin?>" />
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Instagram URL</label>
                                                                <input id="instagram" name="instagram" placeholder="" type="text" class="form-control" value="<?=$res[0]->instagram?>" />

                                                            </div>
                                                        </div>

                                                    </div>


                                                </div>
                                                <div id='upload_documents_hide_show'>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="tshadow bozero">
                                                                <h4 class="pagetitleh2">Upload Documents</h4>

                                                                <div class="row around10">
                                                                    <div class="col-md-6">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th style="width: 10px">#</th>
                                                                                    <th>Title</th>
                                                                                    <th>Documents</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>1.</td>
                                                                                    <td>Resume</td>
                                                                                    <td>
                                                                                        <input class="filestyle form-control" type='file' name='resume' id="doc1">
                                                                                        <span class="text-danger"></span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>3.</td>
                                                                                    <td>Other Documents
                                                                                    </td>
                                                                                    <td>
                                                                                        <input class="filestyle form-control" type='file' name='other_doc' id="doc4">
                                                                                        <span class="text-danger"></span>
                                                                                    </td>
                                                                                </tr>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th style="width: 10px">#</th>
                                                                                    <th>Title</th>
                                                                                    <th>Documents</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>2.</td>
                                                                                    <td>Joining Letter</td>
                                                                                    <td>
                                                                                        <input class="filestyle form-control" type='file' name='joining_letter' id="doc2">
                                                                                        <span class="text-danger"></span>
                                                                                    </td>
                                                                                </tr>
                                                                                @if($id!='')
                                                                               
                                                                                <tr>
                                                                                    <td>4.</td>
                                                                                    <td>Resignation Letter</td>
                                                                                    <td>
                                                                                        <input class="filestyle form-control" type='file' name='resignation_letter' id="doc2">
                                                                                        <span class="text-danger"></span>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-info pull-right">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>
    @include('admin.include.footer');