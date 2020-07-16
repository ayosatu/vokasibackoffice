<?php

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

class school_years extends REST_Controller
{
    function __construct($config = 'rest'){
        parent::__construct($config);
        $this->load->database();
    }
    
    function index_get(){

        $id = $this->get('id');
        if ($id == ''){
            $school_years = $this->db->get('school_years')->result();
        }else{
            $this->db->where('sch_years_id', $id);
            $school_years = $this->db->get('school_years')->result();
        }

        if($school_years){
            $this->response(['status' == true,
            'data' => $school_years], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => false, 
            'data' => $school_years], REST_Controller::HTTP_NOT_FOUND);
        }

    }

    function index_put(){
        $id = $this->put('id');

        $arrdata = ['code' => $this->put('code'),
        'description' => $this->put('description')
        // 'update_date' => 'now()',
        // 'update_by' => 'Admin',
        // 'end_period' => $this->put('end_period'),
        // 'result_id' => $this->put('result_id'),
        // 'start_period' => $this->put('start_period')
        ];

        $school_years = $this->db->update('school_years',$arrdata,['sch_years_id' => $id]);

        if($school_years){
            $this->response(['status' => true,
            'data' => 'Data Update.'
        ], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => false, 
            'data' => 'Bad Request'
        ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function index_delete()
    {
        // $school_years = false;
        // $id = $this->input->post('id');
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
            $this->db->where('sch_years_id', $id);
            $school_years = $this->db->delete('school_years');
        }

        if ($school_years) {
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

    
    function index_post(){
        $arrdata = ['code' => $this->post('code'),
        'description' => $this->post('description'),
        'created_date' => $this->post('created_date'),
        'created_by' => $this->post('created_by'),
        'update_by' => $this->post('update_by'),
        'end_period' => $this->post('end_period'),
        'result_id' => $this->post('result_id'),
        'start_period' => $this->post('start_period')

        ];

        $this->db->set('sch_years_id', '(select coalesce(max(sch_years_id),0) + 1 from school_years)', false);
        $school_years = $this->db->insert('school_years', $arrdata);
    
        if($school_years){
            $this->response(['status' == true,
            'data' => 'Data Inserted'
        ], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => false, 
            'data' => 'Bad Request'
        ], REST_Controller::HTTP_NOT_FOUND);
        }

    }
}
?>