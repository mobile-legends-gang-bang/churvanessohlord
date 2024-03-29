<head>
	<title><?php echo $title?></title>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#score_subject, #class_grade, #quarter, #score_type').change(function(){
				var class_grade = $('#class_grade').val();
				var score_subject = $('#score_subject').val();
				var quarter = $('#quarter').val();
				var score_type = $('#score_type').val();
				$.ajax({
					url: '<?php echo base_url('grades_report/getscores')?>',
					method: 'post',
					// dataType: 'json',
					data: {class_grade:class_grade, score_subject:score_subject, quarter:quarter, score_type:score_type},
					success: function(data){
						$('#scorerecord').html(data);
					}
				});
			});
			$('#create_report').click(function(){
				var subject_id = $('#scoreform #subject_id2').val();
		      	var class_grade = $('#scoreform #class_grade2').val();
		      	var quarter = $('#scoreform #quarter').val();
				$.ajax({
					url: '<?php echo base_url('grades_report/action')?>',
					method: 'post',
					dataType: 'json',
					data: {class_grade2:class_grade, subject_id2:subject_id, quarter:quarter},
					success: function(data){
						console.log(data);
					}
				})
			});
			$('#subject_id2, #class_grade2, #quarter').change(function(){
		      var subject_id = $('#subject_id2').val();
		      var class_grade = $('#class_grade2').val();
		      var quarter = $('#quarter').val();
		      $.ajax({
		          url: '<?php echo base_url('student_record/getscores')?>',
		          method: 'post',
		          data: {class_grade2:class_grade, subject_id2:subject_id, quarter:quarter},
		          success: function(data){
		            $('#grade_tbody').html(data);
		          }
		        });
		    });
		});
	</script>
	<style>
		th { text-align: center !important; }
	</style>
</head>
<body>
	<div class="content-wrapper" style="margin-top: 100px!important; margin-left: 270px!important;">
		<form method="post" id="scoreform" action="<?php echo base_url();?>grades_report/action">
			<div class="row" style="padding: 10px;">
				<div class="col-md-2"> Subject</div>
				<div class="col-md-1">:</div>
				<div class="col-md-4">
					<select class="form-control" name="subject_id" id="subject_id2">
		                <option value=""></option>
		                <?php foreach($subjectlist as $s):?>
		                  <option value="<?php echo $s->subject_id?>"><?php echo $s->subject_name?></option>
		                <?php endforeach?>
		             </select>
				</div>
			</div>
			<div class="row" style="padding: 10px;">
				<div class="col-md-2">Class Section</div>
				<div class="col-md-1">:</div>
				<div class="col-md-4">
					<select class="form-control" name = "class_grade" id="class_grade2">
		                <?php foreach($uniqueclass as $c):?>
		                  <option><?php echo $c->class_name?></option>
		                <?php endforeach?>
		             </select>
				</div>
			</div>
			<div class="row" style="padding: 10px;">
				<div class="col-md-2">Quarter</div>
				<div class="col-md-1">:</div>
				<div class="col-md-4">
					<select class="form-control" id="quarter" name="quarter">
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>Whole Quarter</option>
					</select>
				</div>
			</div>
			<div class="card-body">
	              <div class="table-responsive">
	                <table class="table table-bordered" id="score" width="100%" cellspacing="0">
	                  <tbody id="grade_tbody">
	                  </tbody>
	                </table>
	              </div>
	        </div>
	        <input type="submit" name="export" class="btn btn-success"  value="Export">
		</form>
	</div>
</body>