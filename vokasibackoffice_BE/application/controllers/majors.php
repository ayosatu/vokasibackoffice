<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Majors extends REST_Controller
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
            $account = $this->db->get('majors')->result();
        } else {
            # code...
            $this->db->where('majors_id', $id);
            $account = $this->db->get('majors')->result();
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
            // 'code' => $this->put('code'),
            'description' => $this->put('description')
            // 'name' => $this->put('name'),
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

        $account = $this->db->update('majors', $arrdata, ['majors_id' => $id]);

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
            $this->db->where('majors_id', $id);
            $majors = $this->db->delete('majors');
        }

        if ($majors) {
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
            
            'created_date' => 'now()',
            'created_by' => $this->input->post('created_by'),
            'update_date' => 'now()',
            'update_by' => $this->input->post('update_by'),
            'code' => $this->input->post('code'),
            'description' => $this->input->post('description')
            
        ];
        $this->db->set('majors_id', '(select coalesce(max(majors_id),0) + 1 from majors)', false);
        $student = $this->db->insert('majors', $arrdata);

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
