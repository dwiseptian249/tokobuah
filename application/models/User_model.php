<?php

class User_model extends CI_Model
{
    private $_table = "users";

    public function doLogin(){
        $post = $this->input->post();

        // cari user berdasarkan email dan username
        $this->db->where('email', $post["email"])
                ->or_where('username', $post["email"]);
        $user = $this->db->get($this->_table)->row();

        // jika user terdaftar
        if($user){
            // periksa passwordnya
            $isPasswordTrue = password_verify($post["password"], $user->password);
            // periksa rolenya
            $isAdmin =$user->role == "admin";

            // jika password benar dan dia admin
            if($isPasswordTrue && $isAdmin){
                //login sukses
                $this->session->set_userdata(['user_logged' => $user]);
                $this->_updateLastLogin($user->user_id);
                return true;
            }
        }

        // jika login gagagl
        return false;
    }

    public function isNotLogin(){
        return $this->session->userdata('user_logged') === null;
    }

    private function _updateLastLogin($user_id){
    $sql = "UPDATE {$this->_table} SET last_login=now() WHERE user_id={$user_id}";
    $this->db->query($sql);
    }
}
?>