<?php

class AuthApi extends Api{

    function __construct(){       
        
        // if(!$this->authenticated()){
        //      http_response_code(400);
        // }
    }
  //----Mange-----
    function index(){  
              
      //echo "Index";
     // view("system");
    }
    
    
   
    function valid($data){

        $jwt=new JWT();
        if($jwt->is_valid($data["token"])){
            echo "valid";
        }else{
            echo "invalid";
        }
    }

    function login($data){

        global $db;
        global $tx;
       
            $username=trim($data["username"]);
            $password=trim($data["password"]);
             $result=$db->query("select u.id,u.name,u.password,u.email,u.role_id,r.name role from {$tx}users u,{$tx}roles r where r.id=u.role_id and u.name='$username'");
                            
             $user=$result->fetch_object();
       
             if($user && password_verify($password,$user->password)){
               
                        $jwt=new JWT();
                        $jwt->min=50;
                        $payload=[
                            "id"=>$user->id,
                            "name"=>$user->name,
                            "role_id"=>$user->role_id,
                            "email"=>$user->email,
                            "ip"=>get_ip(),
                            "iss"=>"jwt.server",
                            "aud"=>"intels.co"
                        ];

                        $token= $jwt->generate($payload);
                        
                        echo json_encode(["success"=>1,"token"=>$token]);
                }else{
                        echo json_encode(["success"=>0,"username"=>$username,"password"=>$password]);
                }     

        

    }


    function usernameByRole($data){
        global $db, $tx;
        $role_id = isset($data["id"]) ? intval($data["id"]) : 0;
        if($role_id<=0){
            echo json_encode(["success"=>0]);
            return;
        }
        $stmt = $db->prepare("SELECT name FROM {$tx}users WHERE role_id=? AND status='Active' ORDER BY id ASC LIMIT 1");
        $stmt->bind_param("i", $role_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows===1){
            $row = $result->fetch_assoc();
            echo json_encode(["success"=>1,"username"=>$row["name"]]);
        }else{
            echo json_encode(["success"=>0]);
        }
        $stmt->close();
    }

}
