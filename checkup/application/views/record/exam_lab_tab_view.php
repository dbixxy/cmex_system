<div class="tab-pane fade" id="exam_lab_tab" role="tabpanel" aria-labelledby="custom-tabs-four-exam_lab_tab">
	<div class="card card-body row col-12" style="margin-left:0px; margin-right: 0px;">
		<h3 style="margin-top: 10px">สรุปผลการตรวจทางห้องปฏิบัติการ (Laboratory Result)</h3>
		
		<div class="mt-4">
			<div class="">
				<button type="button" class="form-control btn btn-success" onclick="save_tab_data('exam_lab_tab')">บันทึก</button>
			</div>
		</div>

		<div class="mt-4">
		
			<?php
				if(!empty($record_files)){
					echo '<p  align="center">';
					for($i=0;$i<sizeof($record_files);$i++){
						if($record_files[$i]->tab_id == 'lab'){
							echo '<a href="' . base_url() . 'uploads/lab/' . $record_files[$i]->file_name . '" target=:"_blank"> <img src="' . base_url() . 'uploads/lab/' . $record_files[$i]->file_name . '" style="width:45%;"></a>'; //40_60dd4705c2aa3.png
							// echo '<img src="' . $record_files[$i]->file_path . '" ><br>';
						}
					}
					echo '</p>';
				}
			?>
			<div class="form-group form-inline " style="display: block;">
				<div class="textarea-wrapper">
					<textarea id="exam_lab_detail" class="full-width textarea_white_space input_data" rows="10" cols="" alt="ผลการตรวจทางห้องปฏิบัติการ (Laboratory Result)"></textarea>
				</div>
			</div>
	
		</div>

		<div class="mt-4">
			<div class="">
				<button type="button" class="form-control btn btn-success" onclick="save_tab_data('exam_lab_tab')">บันทึก</button>
			</div>
		</div>

	</div>
</div>
