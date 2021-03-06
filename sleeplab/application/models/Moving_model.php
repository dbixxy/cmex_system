<?php

class Moving_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function updateMoving(){
        $username = $this->session->username;
        date_default_timezone_set('Asia/Bangkok');
        $update_time = date("Y-m-d h:i:s");
        $create_time_new = $update_time;

        $booking_id = $this->security->xss_clean($this->input->post('booking_id'));
        $patient_id = $this->security->xss_clean($this->input->post('patient_id'));
        $receiving_date = $this->security->xss_clean($this->input->post('receiving_date'));
        $booking_date_old = $this->security->xss_clean($this->input->post('booking_date_old'));
        $booking_date = $this->security->xss_clean($this->input->post('booking_date'));
        $doctor = $this->security->xss_clean($this->input->post('doctor'));
        $test_type = $this->security->xss_clean($this->input->post('test_type'));
        $operation_room = trim($this->security->xss_clean($this->input->post('operation_room')));
        $appointment_from = $this->security->xss_clean($this->input->post('appointment_from'));
        $channel = $this->security->xss_clean($this->input->post('channel'));

        $changed = $this->security->xss_clean($this->input->post('changed'));
        $change_reason = $this->security->xss_clean($this->input->post('change_reason'));
       
        $two_staff = $this->security->xss_clean($this->input->post('two_staff'));

        $booking_date_new = $this->security->xss_clean($this->input->post('booking_date_new'));
        $operation_room_new = trim($this->security->xss_clean($this->input->post('operation_room_new')));
        $note_new = $this->security->xss_clean($this->input->post('note_new'));

        

        if($changed == 2){ // Cancel
            $data = array(
                'changed' => $changed,
                'change_reason' => $change_reason,
                'update_by' => $username,
                'update_time' => $update_time,
            );
            $this->db->where('booking_id', $booking_id);
            $result = $this->db->update('sdc_booking', $data);
        }
        elseif($changed == 1){ // Move
            $sql = "SELECT *
                    FROM sdc_booking
                    WHERE booking_date = '" . $booking_date_new . "'
                    AND operation_room = '" . $operation_room_new . "' 
                    AND changed = 0
                    AND deleted = 0";
            $query = $this->db->query($sql);
            $result = $query->result();
            if($query->num_rows() == 0){
                $data = array(
                    'changed' => $changed,
                    'change_reason' => $change_reason,
                    'update_by' => $username,
                    'update_time' => $update_time,
                );
                $this->db->where('booking_id', $booking_id);
                $result = $this->db->update('sdc_booking', $data);
            

                
                $data = array(
                    'patient_id' => $patient_id,
                    'receiving_date' => $receiving_date,
                    'booking_date' => $booking_date_new,
                    'doctor' => $doctor,
                    'test_type' => $test_type,
                    'operation_room' => $operation_room_new,
                    'appointment_from' => $appointment_from,
                    'channel' => $channel,
                    'note' => $note_new,
                    'two_staff' => $two_staff,
                    'changed' => 0,
                    'create_by' => $username,
                    'create_time' => $create_time_new,
                    'deleted' => 0,
                );
                $result = $this->db->insert('sdc_booking', $data);

                //add Available
                $data = array(
                    'fname' => "available",
                    'lname' => "",
                    'hn' => "",
                    'birth_date' => "0000-00-00",
                    'tel_1' => "",
                    'tel_2' => "",
                    'create_by' => $username,
                    'create_time' => $create_time,
                    'deleted' => 0,
                );
                $result = $this->db->insert('sdc_patient', $data);
        
                if($result){
                    $patient_id = $this->db->insert_id();

                    $data = array(
                        'patient_id' => $patient_id,
                        'receiving_date' => "",
                        'booking_date' => $booking_date_old,
                        'doctor' => "",
                        'test_type' => "",
                        'operation_room' => "A",
                        'appointment_from' => "",
                        'channel' => "",
                        'note' => "",
                        'two_staff' => "",
                        'changed' => 0,
                        'create_by' => $username,
                        'create_time' => $create_time,
                        'deleted' => 0,
                    );
                    $result = $this->db->insert('sdc_booking', $data);
                }
            }
        }  
        return $result;
    }

}
