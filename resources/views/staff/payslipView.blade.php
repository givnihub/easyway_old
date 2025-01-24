<div id="html-2-pdfwrapper">

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">

            <div class="">
                <table width="100%">
                    <tbody>
                        <tr>
                            <?php $row = DB::select('select name,surname,employee_id,designation,department from staff where id=' . $res[0]->staff_id); ?>

                            <td style="height: 100px;width: 850px;">
                                <div><img src="{{asset('public/uploads/print_headerfooter/staff_payslip/header_image.jpg')}}" style="height: 100px;width: 100%;"></div>

                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <h3 style="margin: 10px 0 20px;">Payslip for the period of <?= $res[0]->month ?> <?= $res[0]->year ?></h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="100%" class="paytable2">
                    <tbody>
                        <tr>
                            <th>Payslip #<?= $res[0]->id ?></th>
                            <td></td>
                            <th class="text-right"></th>
                            <th class="text-right">Payment Date: <?= date('d.m.Y', strtotime($res[0]->payment_date)); ?>
                            </th>

                        </tr>
                    </tbody>
                </table>
                <hr>
                <table width="100%" class="paytable2">

                    <tbody>
                        <tr>
                            <th width="25%">Staff ID</th>
                            <td width="25%"><?= $row[0]->employee_id ?></td>
                            <th width="25%">Name</th>
                            <td width="25%" style="text-transform: capitalize;"><?= $row[0]->name ?> <?= $row[0]->surname ?></td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td><?php
                                $run = DB::select('select department from department where id=' . $row[0]->department);
                                echo $run[0]->department

                                ?></td>

                            <th>Designation</th>
                            <td><?php
                                $run = DB::select('select designation from staff_designation where id=' . $row[0]->designation);
                                echo $run[0]->designation;

                                ?></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="earntable table table-striped table-responsive">
                    <tbody>
                        <tr>
                            <th width="19%">Earning</th>
                            <th width="16%" class="pttright reborder">Amount(₹)</th>
                            <th width="20%" class="pttleft">Deduction</th>
                            <th width="16%" class="text-right">Amount(₹)</th>
                        </tr>
                        <tr>

                            <td></td>
                            <td class="pttright reborder"><?= $res[0]->allowance_amount ?></td>
                            <td class="pttleft"></td>
                            <td class="text-right"><?= $res[0]->deduction_amount ?> </td>
                        </tr>
                        <tr>

                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <th>Total Earning</th>
                            <th class="pttright reborder"><?= $res[0]->total_allowance ?></th>
                            <th class="pttleft">Total Deduction</th>
                            <th class="text-right"><?= $res[0]->total_deduction?></th>
                        </tr>
                    </tbody>
                </table>

                <table class="totaltable table table-striped table-responsive">
                    <tbody>
                        <tr>
                            <th width="20%">Payment Mode</th>
                            <td class="text-right"><?= $res[0]->payment_mode ?></td>
                        </tr>
                        <tr>
                            <th width="20%">Basic Salary(₹)</th>
                            <td class="text-right"><?= $res[0]->basic ?></td>
                        </tr>

                        <tr>
                            <th width="20%">Gross Salary(₹)</th>
                            <td class="text-right"><?= $res[0]->gross_salary ?></td>
                        </tr>
                        <tr>
                            <th width="20%">Net Salary(₹)</th>
                            <td class="text-right"><?= $res[0]->net_salary ?> </td>
                        </tr>

                        <tr>


                            <td align="center">
                                <div style="position: absolute;left:15px">This payslip is computer generated hence no
                                    signature is required. <p></p>
                                </div>

                            </td>
                        </tr>
                        <tr class="noprint">


                            <td align="center">
                                <div style="position: absolute;left:15px;padding: 10px 0;">Payment Remarks :<?= $res[0]->remark ?> <p>
                                    </p>
                                </div>

                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
        <!--/.col (left) -->

    </div>
</div>