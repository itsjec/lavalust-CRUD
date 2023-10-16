<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User extends Controller {

    public function __construct(){
        parent::__construct();
        $this->call->model('User_model');
        $this->call->library('form_validation');
    }
    public function index(){
        $this->call->model('User_model');
        $data['users'] = $this->User_model->getUsers();
        $this->call->view('index', $data);
    }

    public function insert(){
        $this->call->library('form_validation');
        if($this->form_validation->submitted()){
            $this->form_validation
                ->name('username')
                ->required()
                ->min_length(5)
                ->max_length(20)
                ->name('email')
                ->valid_email()
                ->name('password')
                ->required()
                ->min_length(8)
                ->name('confirmpassword')
                ->matches('password')
                ->required()
                ->min_length(8);
            
            if ($this->form_validation->run())
            {
                $username = $this->io->post('username');
                $email = $this->io->post('email');
                $password = md5($this->io->post('password'));
                
                $this->User_model->insert($username, $email, $password);
                $data['users'] = $this->User_model->getUsers();
        
                $this->call->view('index', $data);
            }
            else
            {
                echo $this->form_validation->errors();
            }
        }
    }    

    public function delete($data){
        //var_dump($data);
        $this->User_model->delete($data);
    
        $usersData['users'] = $this->User_model->getUsers();
        $this->call->view('index', $usersData);
    }

    public function update(){
        if($this->form_validation->submitted()){
            $this->form_validation
                ->name('id')
                ->required()
                ->name('username')
                ->required()
                ->min_length(5)
                ->max_length(20)
                ->name('email')
                ->valid_email()
                ->name('password')
                ->required()
                ->min_length(8)
                ->name('confirmpassword')
                ->matches('password')
                ->required()
                ->min_length(8);
            
            if ($this->form_validation->run())
            {
                $data = [
                    'username' => $this->io->post('username'),
                    'email' => $this->io->post('email'),
                    'password' => md5($this->io->post('password'))
                ];
                $id = $this->io->post('id');
                
                $this->User_model->update($data,$id);

                $usersData['users'] = $this->User_model->getUsers();
                $this->call->view('index', $usersData);
            }
            else
            {
                echo $this->form_validation->errors();
            }
        }
    }
    
}
?>
