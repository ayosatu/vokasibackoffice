<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Student extends REST_Controller
{

    public function __construct($config = 'rest')
    {
        parent::__construct($config);

        $this->load->database();
    }

    function index_get()
    {
        $id = $this->get('id');
        if ($id == '') {
            # code...
            $account = $this->db->get('student')->result();
        } else {
            # code...
            $this->db->where('student_id', $id);
            $account = $this->db->get('student')->result();
        }

        if ($account) {
            # code...
            $this->response(
                [
                    'status' => true,
                    'data' => $account
                ],
                REST_Controller::HTTP_OK
            );
        } else {
            # code...
            $this->response(
                [
                    'status' => false,
                    'data' => 'data not found'
                ],
                REST_Controller::HTTP_NOT_FOUND
            );
        }
    }

    function index_put()
    {
        $id = $this->put('id');

        $arrdata = [
            'generation_unit_id' => $this->put('generation_unit_id'),
            'majors_id2' => $this->put('majors_id2'),
            'name' => $this->put('name'),
            // 'nim' => $this->put('nim'),
            // 'email' => $this->put('email'),
            // 'birth_date' => $this->put('birth_date'),
            // 'birth_place' => $this->put('birth_place'),
            // 'nik' => $this->put('nik'),
            // 'address' => $this->put('address'),
            // 'no_tlp' => $this->put('no_tlp'),
            // 'no_hp' => $this->put('no_hp'),
            // 'img_path' => $this->put('img_path'),
            // 'created_date' => $this->put('created_date'),
            // 'update_date' => $this->put('update_date'),
            // 'created_by' => $this->put('created_by'),
            // 'update_by' => $this->put('update_by'),
            // 'result_id' => $this->put('result_id'),
            // 'start_date' => $this->put('start_date'),
            // 'end_date' => $this->put('end_date'),
            // 'gender_id' => $this->put('gender_id'),
            // 'religion_id' => $this->put('religion_id')

        ];

        $account = $this->db->update('student', $arrdata, ['student_id' => $id]);

        if ($account) {
            $this->response(
                [
                    'status' => true,
                    'data' => 'Data Updated.'
                ],
                REST_Controller::HTTP_OK
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'data' => 'Bad Request.'
                ],
                REST_Controller::HTTP_BAD_REQUEST
            );
        }
    }

    function index_delete()
    {
        $id = $this->delete('id');
        if ($id == '') {
            # code...
            $this->response(
                [
                    'status' => false,
                    'data' => 'Key missed'
                ],
                REST_Controller::HTTP_BAD_REQUEST
            );
        } else {
            # code...
            $this->db->where('student_id', $id);
            $student = $this->db->delete('student');
        }

        if ($student) {
            # code...
            $this->response(
                [
                    'status' => true,
                    'data' => 'Data Deleted'
                ],
                REST_Controller::HTTP_OK
            );
        } else {
            # code...
            $this->response(
                [
                    'status' => false,
                    'data' => 'Data not found'
                ],
                REST_Controller::HTTP_NOT_FOUND
            );
        }
    }

    function index_post()
    {
        $arrdata = [
            'generation_unit_id' => $this->input->post('generation_unit_id'),
            'majors_id2' => $this->input->post('majors_id2'),
            'name' => $this->input->post('name'),
            'nim' => $this->input->post('nim'),
            'email' => $this->input->post('email'),
            'birth_date' => $this->input->post('birth_date'),
            'birth_place' => $this->input->post('birth_place'),
            'nik' => $this->input->post('nik'),
            'address' => $this->input->post('address'),
            'no_tlp' => $this->input->post('no_tlp'),
            'no_hp' => $this->input->post('no_hp'),
            'img_path' => $this->input->post('img_path'),
            'created_date' => $this->input->post('created_date'),
            'update_date' => $this->input->post('update_date'),
            'created_by' => $this->input->post('created_by'),
            'update_by' => $this->input->post('update_by'),
            'result_id' => $this->input->post('result_id'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'gender_id' => $this->input->post('gender_id'),
            'religion_id' => $this->input->post('religion_id')
        ];
        $this->db->set('student_id', '(select coalesce(max(student_id),0) + 1 from student)', false);
        $student = $this->db->insert('student', $arrdata);

        if ($student) {
            # code...
            $this->response(
                [
                    'status' => true,
                    'data' => 'Data Inserted'
                ],
                REST_Controller::HTTP_OK
            );
        } else {
            # code...
            $this->response(
                [
                    'status' => false,
                    'data' => 'Bad Request'
                ],
                REST_Controller::HTTP_BAD_REQUEST
            );
        }
    }
}
