<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User_model extends Model {
	public function getUsers(){
        $this->call->database();
        return $this->db->table('users')->get_all();
    }

    public function insert($username, $email,$password){
        $bind = array(
            'username' => $username,
            'email' => $email,
            'password' => $password,
            );
        
        $this->db->table('users')->insert($bind);
    }

    public function delete($id){
        $this->db->table('users')->where('id', $id)->delete();
    }

    public function update($data,$id){
        $this->db->table('users')->where('id', $id)->update($data);
    }
}
?>
