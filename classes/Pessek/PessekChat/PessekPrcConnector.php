<?php
namespace Pessek\PessekChat;
use Elgg\Hook;
use Elgg\Event;
use ElggMenuItem;
use Psr\Log\LogLevel;

use Elgg\Request;
use Elgg\Http\ResponseBuilder;

class PessekPrcConnector{
    
        private $rpc_server;
	private $rpc_port;
	private $admin_username;
	private $other_username;
	private $admin_password;
	private $password;
	private $newpass;
	private $admin_vhost;
	private $other_vhost;
	private $parms;
	private $method;
	private $usergroup;//Friends
	
	public function __construct($other_username = null, $usergroup = "Friends", $password = null, $newpass = null) {
	
		$this->setData($other_username, $usergroup, $password, $newpass);
		
	}
	
	protected function setData($other_username, $usergroup, $password, $newpass) {
	

		$this->rpc_server = trim(elgg_get_plugin_setting('ejabberdip', 'pessek_chat'));
		$this->rpc_port = trim(elgg_get_plugin_setting('xmlrpcport', 'pessek_chat'));
		$this->admin_vhost = trim(elgg_get_plugin_setting('adminxmppdomain', 'pessek_chat'));
		$this->admin_username = trim(elgg_get_plugin_setting('adminxmppusername', 'pessek_chat'));
		$this->admin_password = $this->clean_password(trim(elgg_get_plugin_setting('adminxmpppassword', 'pessek_chat')));
		$this->other_vhost = trim(elgg_get_plugin_setting('userxmppdomain', 'pessek_chat'));
		$this->other_username = $other_username;
		$this->usergroup = $usergroup;
		$this->password = $this->clean_password($password);
		$this->newpass = $this->clean_password($newpass); 
/*
		$this->rpc_server = $rpc_server;
		$this->rpc_port = $rpc_port;
		$this->admin_vhost = $admin_vhost;
		$this->other_vhost = $other_vhost;
		$this->admin_username = $admin_username;
		$this->admin_password = $this->clean_password($admin_password);
		$this->other_username = $other_username;
		$this->usergroup = $usergroup;
		$this->password = $this->clean_password($password);
		$this->newpass = $this->clean_password($newpass);
*/
		
	}
	
	protected function clean_password($password) {
		if (get_magic_quotes_gpc() === 1) {
			return stripslashes($password);
		}
		
		return $password;
	}
	
	protected function commit_rpc() {
		
                $param_auth=array("user"=>$this->admin_username, "server"=>$this->admin_vhost, "password"=>$this->admin_password);
                $param_comm = array("user"=>$this->other_username,"host"=>$this->other_vhost);
                
                $param=array($param_auth, $param_comm);
                
                $request = xmlrpc_encode_request($this->method, $param, (array('encoding' => 'utf-8')));

                $context = stream_context_create(array('http' => array(
                    'method' => "POST",
                    'header' => "User-Agent: XMLRPC::Client mod_xmlrpc\r\n" .
                                "Content-Type: text/xml\r\n" .
                                "Content-Length: ".strlen($request),
                    'content' => $request
                )));
                $val = "http://".$this->rpc_server.":".$this->rpc_port."/RPC2";
                $file = file_get_contents($val, false, $context);

                $response = xmlrpc_decode($file,"utf8");

                if (xmlrpc_is_fault($response)) {
                    //trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
		    elgg_log("xmlrpc: $response[faultString] ($response[faultCode])", LogLevel::ERROR);
                } else {
                    return $response;
                }
                
	}
	
	protected function commit_rpc_account_create() {
		
                $param_auth=array("user"=>$this->admin_username, "server"=>$this->admin_vhost, "password"=>$this->admin_password);
                $param_comm = array("user"=>$this->other_username,"host"=>$this->other_vhost, "password"=>$this->password);
     
                $param=array($param_auth, $param_comm);
                
                $request = xmlrpc_encode_request($this->method, $param, (array('encoding' => 'utf-8')));

                $context = stream_context_create(array('http' => array(
                    'method' => "POST",
                    'header' => "User-Agent: XMLRPC::Client mod_xmlrpc\r\n" .
                                "Content-Type: text/xml\r\n" .
                                "Content-Length: ".strlen($request),
                    'content' => $request
                )));
                $val = "http://".$this->rpc_server.":".$this->rpc_port."/RPC2";
                $file = file_get_contents($val, false, $context);

                $response = xmlrpc_decode($file,"utf8");

                if (xmlrpc_is_fault($response)) {
                    //trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
		    elgg_log("xmlrpc: $response[faultString] ($response[faultCode])", LogLevel::ERROR);
                } else {
                    return $response;
                }
                
	}
	
	protected function commit_rpc_account_delete() {
		
                $param_auth=array("user"=>$this->admin_username, "server"=>$this->admin_vhost, "password"=>$this->admin_password);
                $param_comm = array("user"=>$this->other_username,"host"=>$this->other_vhost);
     
                $param=array($param_auth, $param_comm);
                
                $request = xmlrpc_encode_request($this->method, $param, (array('encoding' => 'utf-8')));

                $context = stream_context_create(array('http' => array(
                    'method' => "POST",
                    'header' => "User-Agent: XMLRPC::Client mod_xmlrpc\r\n" .
                                "Content-Type: text/xml\r\n" .
                                "Content-Length: ".strlen($request),
                    'content' => $request
                )));
                $val = "http://".$this->rpc_server.":".$this->rpc_port."/RPC2";
                $file = file_get_contents($val, false, $context);

                $response = xmlrpc_decode($file,"utf8");

                if (xmlrpc_is_fault($response)) {
                    //trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
	            elgg_log("xmlrpc: $response[faultString] ($response[faultCode])", LogLevel::ERROR);
                } else {
                    //trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");//return $response;
		    elgg_log("xmlrpc: $response[faultString] ($response[faultCode])", LogLevel::ERROR);
                }
                
	}
	
	protected function commit_rpc_account_new_password() {
		
                $param_auth=array("user"=>$this->admin_username, "server"=>$this->admin_vhost, "password"=>$this->admin_password);
                $param_comm = array("user"=>$this->other_username,"host"=>$this->other_vhost, "newpass"=>$this->newpass);
     
                $param=array($param_auth, $param_comm);
                
                $request = xmlrpc_encode_request($this->method, $param, (array('encoding' => 'utf-8')));

                $context = stream_context_create(array('http' => array(
                    'method' => "POST",
                    'header' => "User-Agent: XMLRPC::Client mod_xmlrpc\r\n" .
                                "Content-Type: text/xml\r\n" .
                                "Content-Length: ".strlen($request),
                    'content' => $request
                )));
                $val = "http://".$this->rpc_server.":".$this->rpc_port."/RPC2";
                $file = file_get_contents($val, false, $context);

                $response = xmlrpc_decode($file,"utf8");

                if (xmlrpc_is_fault($response)) {
                    //trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
		    elgg_log("xmlrpc: $response[faultString] ($response[faultCode])", LogLevel::ERROR);
                } else {
                    return $response;
                }
                
	}
	
	public function check_account() {
		if ($this->is_value($this->admin_username) === false || $this->is_value($this->other_username) === false || $this->is_value($this->admin_vhost) === false || $this->is_value($this->other_vhost) === false) { return false; }
		$this->method = "check_account";
		
		$testval = array();
		$testval = $this->commit_rpc();
		
		
		if ($testval['res'] === 1) {
					
                    return false; //le compte n'exite pas
                }
                else{
                    return true; //le compte existe deja
				
                }
				
	}
	
	public function create_account() {
		if ($this->is_value($this->admin_username) === false || $this->is_value($this->other_username) === false || $this->is_value($this->admin_vhost) === false || $this->is_value($this->other_vhost) === false || $this->is_value($this->admin_password) === false || $this->is_value($this->password) === false) { return false; }
		
		if($this->check_account()){
                    return false;//le compte existe deja
		}else{
                    $this->method = "register";
                    $testval = array();
                    $testval = $this->commit_rpc_account_create();
                    if ($testval['res'] === 0) {
				
                        return true; //le compte a ete cree
                    }
                    else{
                        return false; //le compte n'a pas pu etre cree (erreur interne)
                                    
                    }
		}
				
	}
	
	public function delete_account() {
		if ($this->is_value($this->admin_username) === false || $this->is_value($this->other_username) === false || $this->is_value($this->admin_vhost) === false || $this->is_value($this->other_vhost) === false || $this->is_value($this->admin_password) === false || $this->is_value($this->password) === false) { return false; }
		
		if($this->check_account()){
                    $this->method = "unregister";
                    $testval = array();
                    $testval = $this->commit_rpc_account_delete();
		}
				
	}
	
	public function check_password() {
		if ($this->is_value($this->admin_username) === false || $this->is_value($this->other_username) === false || $this->is_value($this->admin_vhost) === false || $this->is_value($this->other_vhost) === false || $this->is_value($this->admin_password) === false || $this->is_value($this->password) === false) { return false; }
		$testval = array();
		if($this->check_account()){
                    //compte existe;
                    
                    $this->method = "check_password";
                    $testval = $this->commit_rpc_account_create();
                    
                    if ($testval['res'] === 1) {
				
                        return true; //le mot de passe est erroné. Donc on dois mettre à jour le mot de passe
                    }
                    else{
                        return false; //le mot de passe est conforme. Donc ne dois pas etre mis à jour
                                    
                    }
                    
                    
		}
		else {
                    
                    return false; // le compte n'existe pas
		}
				
	}
	
	public function change_password() {
		if ($this->is_value($this->admin_username) === false || $this->is_value($this->other_username) === false || $this->is_value($this->admin_vhost) === false || $this->is_value($this->other_vhost) === false || $this->is_value($this->admin_password) === false || $this->is_value($this->password) === false || $this->is_value($this->newpass) === false) { return false; }
		$testval = array();
		if($this->check_password()){
                    //le mot de passe est erroné. Donc on dois mettre à jour le mot de passe
                    
                    $this->method = "change_password";
                    $testval = $this->commit_rpc_account_new_password();
                    
                    if ($testval['res'] === 0) {//register_error("0000");
				
                        return true; //mot de passe Modifié
                    }
                    else{
                        return false;  //mot de passe non modifié (mot de passe conforme)
                                    
                    }
                   
                    
		}
		else {
                    
                    return false; //mot de passe conforme
		}
                        
	}

	public function changePassword() {
		if ($this->is_value($this->admin_username) === false || $this->is_value($this->other_username) === false || $this->is_value($this->admin_vhost) === false || $this->is_value($this->other_vhost) === false || $this->is_value($this->admin_password) === false || $this->is_value($this->password) === false || $this->is_value($this->newpass) === false) { return false; }
		$testval = array();
                    
                    $this->method = "change_password";
                    $testval = $this->commit_rpc_account_new_password();
                    
                    if ($testval['res'] === 0) {
				
                        return true; //mot de passe Modifié
                    }
                    else{
                        return false;  //mot de passe non modifié (mot de passe conforme)
                                    
                    }             
	}
	
	
	protected function is_value($value) {
		if($value === null) {
				return false;
			}
			elseif($value==""){
				return false;
			}
			else{
				return true;
		}
	}
	
	public function get($attr){
            return $this->$attr;
        }
	

}
