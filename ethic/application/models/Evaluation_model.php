<?php

class Evaluation_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getEvaluation($evaluation_id) {

        $sql = "SELECT *
                    FROM qstn_evaluation e
                     JOIN qstn_form f ON e.form_id = f.form_id
                     JOIN qstn_category c ON f.form_id = c.form_id
                     JOIN qstn_question_group qg ON c.category_id = qg.category_id
                     JOIN qstn_question q ON qg.question_group_id = q.question_group_id
                     JOIN qstn_choice_group cg ON qg.choice_group_id = cg.choice_group_id
                     JOIN qstn_choice ch ON cg.choice_group_id = ch.choice_group_id
                    WHERE e.evaluation_id = '" . $evaluation_id . "'
                    ORDER BY CAST(c.category_number AS UNSIGNED), c.category_number ASC,
                            CAST(qg.question_group_number AS UNSIGNED), qg.question_group_number ASC,
                            CAST(q.question_number AS UNSIGNED), q.question_number ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    function getFormDetails($evaluation_id){
        $sql = "SELECT *
                    FROM qstn_evaluation e
                    JOIN qstn_form f ON e.form_id = f.form_id
                    JOIN qstn_form_detail fd ON f.form_id = fd.form_id
                    WHERE e.evaluation_id = '" . $evaluation_id . "'
                    ORDER BY CAST(fd.form_detail_number AS UNSIGNED), fd.form_detail_number ASC";
        $result = $this->db->query($sql)->result();
        return $result;            
    }

    function chkEvaluation($evaluation_id, $evaluater_id, $person_id){
        $sql = "SELECT a.evaluation_id, a.evaluater_id, a.person_id
                FROM ethc_answer a
                WHERE a.evaluation_id = '" . $evaluation_id . "'
                AND a.evaluater_id = '" . $evaluater_id . "' 
                AND a.person_id = '" . $person_id . "'"; 
        $result = $this->db->query($sql);

        if($result->num_rows()>0){
            return false;
        }else{
            return true;
        }
    }
}
