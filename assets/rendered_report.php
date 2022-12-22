<?php
    include 'db_connect.php';
?>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card_body">
                <div class="row justify-content-center pt-4">
                    <label for="" class="mt-2">Sinh viên</label>
                    <div class="col-sm-4">
                        <select name="" id="student_id" class="custom-select custom-select-sm select2" placeholder="Lựa chọn sinh viên">
                            <option value=""></option>
                                <?php 
                                $students = $conn->query("SELECT * FROM students order by name asc");
                                while($row=$students->fetch_assoc()):
                                ?>
                            <option value="<?php echo $row['id'] ?>" 
                                <?php echo isset($_GET['sid']) && $_GET['sid'] == $row['id'] ? "selected" : '' ?>>
                                <?php echo ucwords($row['name']).' ['.$row['id_no'].'] ' ?>
                            </option>
                        <?php endwhile; ?>
                        </select>
                    </div>
                </div>
            </div>
                
    <hr>
    <div class="col-md-12">
        <?php
            if(!isset($_GET['sid'])):
        ?>
        <center><h6>Vui lòng chọn 1 sinh viên</h6></center>
        <?php else: ?>
            <?php
                $s_query = $conn->query("SELECT s.*,c.course,co.name as cname from students s inner join courses c on c.id= s.course_id inner join companies co on co.id = s.company_id where s.id = {$_GET['sid']} ");
                foreach($s_query->fetch_array() as $k => $v){
                    $$k = $v;
                }
            ?> 
            <hr>
                <table class="table table-condensed table-bordered table-hover" id="report-list">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="">Ngày tháng</th>
                            <th class="">Nhận xét</th>
                            <th class="">Thời gian</th>
                            <th class="">Khoảng thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i = 1;
                            $sheet = $conn->query("SELECT * FROM timesheets where student_id = {$_GET['sid']} order by abs(id) desc");
                            $rendered = 0;
                            while($row=$sheet->fetch_assoc()):
                            $dif = 0;
                            if($row['timer_status'] == 0){
                                $dif = strtotime($row['date'].' '.$row['time_end']) - strtotime($row['date'].' '.$row['time_start']);
                                $rendered += abs($dif/(60*60));
                                $dif = abs($dif/(60*60));
                            }
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++ ?></td>
                                <td>
                                    <p> <b><?php echo date("M d,Y",strtotime($row['date'])) ?></b></p>
                                </td>
                                <td>
                                    <p><i><b><?php echo $row['remarks'] ?></b></i></p>
                                </td>
                                <td>
                                    <p> <b><?php echo date("h:i A",strtotime($row['date'].' '.$row['time_start'])).' - '.date("h:i A",strtotime($row['date'].' '.$row['time_end'])) ?></b></p>
                                </td>
                                <td>
                                    <p class="text-right"> <b><?php echo number_format($dif,2) ?> giờ</b></p>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">Tổng thời gian thực tập</th>
                            <th class="text-right"><b><?php echo number_format($rendered,2) ?> giờ</b></th>
                        </tr>
                        <tr>
                            <th colspan="4">Thời lượng bắt buộc</th>
                            <th class="text-right"><b><?php echo number_format($required_duration,2) ?> giờ</b></th>
                        </tr>
                            <tr>
                            <th colspan="4">Còn thiếu</th>
                            <th class="text-right"><b><?php echo number_format($required_duration - $rendered,2) ?> giờ</b></th>
                        </tr>
                    </tfoot>
                </table>
                <div class="col-md-12 mb-4">
                    <center>
                        <button class="btn btn-success btn-sm col-sm-3" type="button" id="print"><i class="fa fa-print"></i> In</button>
                    </center>
                </div>
                <?php endif; ?>
            </div>
            </div>
        </div>
    </div>
</div>
<noscript>
	<style>
		table#report-list{
			width:100%;
			border-collapse:collapse
		}
		table#report-list td,table#report-list th{
			border:1px solid
		}
        p{
            margin:unset;
        }
		.text-center{
			text-align:center
		}
        .text-right{
            text-align:right
        }
	</style>
    <table width="100%">
        <tr>
            <td width="50%">
                <table width="100%">
                    <tr>
                        <td width="35%">Mã sinh viên: </td>
                        <td width="65%"><?php echo isset($id_no) ? $id_no : '' ?></td>
                    </tr>
                    <tr>
                        <td>Tên sinh viên: </td>
                        <td><?php echo isset($name) ? $name : '' ?></td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table width="100%">
                    <tr>
                        <td width="35%">Khóa: </td>
                        <td width="65%"><?php echo isset($course) ? $course : '' ?></td>
                    </tr>
                    <tr>
                        <td>Công ty: </td>
                        <td><?php echo isset($cname) ? $cname : '' ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</noscript>
<script>
    $('#student_id').change(function()
    {
        location.replace('index.php?page=rendered_report&sid='+$(this).val())
    })
    $('#report-list').dataTable()
    $('#print').click(function(){
        $('#report-list').dataTable().fnDestroy()
        var _c = $('#report-list').clone();
        var ns = $('noscript').clone();
        ns.append(_c)
        var nw = window.open('','_blank','width=900,height=600')
        nw.document.write('<p class="text-center"><b>Internship Rendered Time report')
        nw.document.write(ns.html())
        nw.document.close()
        nw.print()
        setTimeout(() => {
            nw.close()
            $('#report-list').dataTable()
        }, 500);
    })
</script>