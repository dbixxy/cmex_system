<a href="<?php echo base_url() . "Record/recordFiles/" . $checkup_id; ?>">
    <button type="button" class="form-control btn btn-info">ย้อนกลับ</button>
</a>
<div class="row" style="padding: 20px">
    <div class="form-group" style="width:30%; margin:3px">
        <div class="form-inline" >
            <h3>ผล Lab</h3>
            <button type="button" class="btn btn-success" onclick="button_disable(this);upload_file_with_ajax('<?php echo $checkup_id; ?>','lab')">เพิ่ม</button>
        </div>
        <div id="div_lab_images" class="active border"  style="height: 250px;" contenteditable></div>
    </div>

    <div class="form-group" style="width:30%; margin:3px">
        <div class="form-inline">
            <h3>ผล X-ray</h3>
            <button type="button" class="btn btn-success" onclick="button_disable(this);upload_file_with_ajax('<?php echo $checkup_id; ?>','xray')">เพิ่ม</button>
        </div>
        <div id="div_xray_images" class="active border demo"  style="height: 250px;" contenteditable></div>
    </div>

    <div class="form-group" style="width:30%; margin:3px">
        <div class="form-inline">
            <h3>ผล EKG</h3>
            <button type="button" class="btn btn-success" onclick="button_disable(this);upload_file_with_ajax('<?php echo $checkup_id; ?>','ekg')">เพิ่ม</button>
        </div>
        <div id="div_ekg_images" class="active border demo"  style="height: 250px;" contenteditable></div>
    </div>
</div>