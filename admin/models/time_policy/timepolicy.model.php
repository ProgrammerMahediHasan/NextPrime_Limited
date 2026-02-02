<?php
class TimePolicy extends Model implements JsonSerializable{
	public $id;
	public $name;
	public $policy_type;
	public $details;
	public $policy_highlights;
	public $approval_required;
	public $created_time;

	public function __construct(){
	}
	public function set($id,$name,$policy_type,$details,$policy_highlights,$approval_required,$created_time){
		$this->id=$id;
		$this->name=$name;
		$this->policy_type=$policy_type;
		$this->details=$details;
		$this->policy_highlights=$policy_highlights;
		$this->approval_required=$approval_required;
		$this->created_time=$created_time;

	}
	public function save(){
		global $db,$tx;
		$db->query("insert into {$tx}time_policy(name,policy_type,details,policy_highlights,approval_required,created_time)values('$this->name','$this->policy_type','$this->details','$this->policy_highlights','$this->approval_required','$this->created_time')");
		return $db->insert_id;
	}
	public function update(){
		global $db,$tx;
		$db->query("update {$tx}time_policy set name='$this->name',policy_type='$this->policy_type',details='$this->details',policy_highlights='$this->policy_highlights',approval_required='$this->approval_required',created_time='$this->created_time' where id='$this->id'");
	}
	public static function delete($id){
		global $db,$tx;
		$db->query("delete from {$tx}time_policy where id={$id}");
	}
	public function jsonSerialize(){
		return get_object_vars($this);
	}
	public static function all(){
		global $db,$tx;
		$result=$db->query("select id,name,policy_type,details,policy_highlights,approval_required,created_time from {$tx}time_policy");
		$data=[];
		while($timepolicy=$result->fetch_object()){
			$data[]=$timepolicy;
		}
			return $data;
	}
	public static function pagination($page=1,$perpage=10,$criteria=""){
		global $db,$tx;
		$top=($page-1)*$perpage;
		$result=$db->query("select id,name,policy_type,details,policy_highlights,approval_required,created_time from {$tx}time_policy $criteria limit $top,$perpage");
		$data=[];
		while($timepolicy=$result->fetch_object()){
			$data[]=$timepolicy;
		}
			return $data;
	}
	public static function count($criteria=""){
		global $db,$tx;
		$result =$db->query("select count(*) from {$tx}time_policy $criteria");
		list($count)=$result->fetch_row();
			return $count;
	}
	public static function find($id){
		global $db,$tx;
		$result =$db->query("select id,name,policy_type,details,policy_highlights,approval_required,created_time from {$tx}time_policy where id='$id'");
		$timepolicy=$result->fetch_object();
			return $timepolicy;
	}
	static function get_last_id(){
		global $db,$tx;
		$result =$db->query("select max(id) last_id from {$tx}time_policy");
		$timepolicy =$result->fetch_object();
		return $timepolicy->last_id;
	}
	public function json(){
		return json_encode($this);
	}
	public function __toString(){
		return "		Id:$this->id<br> 
		Name:$this->name<br> 
		Policy Type:$this->policy_type<br> 
		Details:$this->details<br> 
		Policy Highlights:$this->policy_highlights<br> 
		Approval Required:$this->approval_required<br> 
		Created Time:$this->created_time<br> 
";
	}

	//-------------HTML----------//

	static function html_select($name="cmbTimePolicy"){
		global $db,$tx;
		$html="<select id='$name' name='$name'> ";
		$result =$db->query("select id,name from {$tx}time_policy");
		while($timepolicy=$result->fetch_object()){
			$html.="<option value ='$timepolicy->id'>$timepolicy->name</option>";
		}
		$html.="</select>";
		return $html;
	}
	static function html_table($page = 1,$perpage = 10,$criteria="",$action=true){
		global $db,$tx,$base_url;
		$count_result =$db->query("select count(*) total from {$tx}time_policy $criteria ");
		list($total_rows)=$count_result->fetch_row();
		$total_pages = ceil($total_rows /$perpage);
		$top = ($page - 1)*$perpage;
		$result=$db->query("select id,name,policy_type,details,policy_highlights,approval_required,created_time from {$tx}time_policy $criteria limit $top,$perpage");
		$html="<table class='table'>";
			$html.="<tr><th colspan='3'>".Html::link(["class"=>"btn btn-success","route"=>"timepolicy/create","text"=>"New TimePolicy"])."</th></tr>";
		if($action){
			$html.="<tr><th>Id</th><th>Name</th><th>Policy Type</th><th>Details</th><th>Policy Highlights</th><th>Approval Required</th><th>Created Time</th><th>Action</th></tr>";
		}else{
			$html.="<tr><th>Id</th><th>Name</th><th>Policy Type</th><th>Details</th><th>Policy Highlights</th><th>Approval Required</th><th>Created Time</th></tr>";
		}
		while($timepolicy=$result->fetch_object()){
			$action_buttons = "";
			if($action){
				$action_buttons = "<td><div class='btn-group' style='display:flex;'>";
				$action_buttons.= Event::button(["name"=>"show", "value"=>"Show", "class"=>"btn btn-info", "route"=>"timepolicy/show/$timepolicy->id"]);
				$action_buttons.= Event::button(["name"=>"edit", "value"=>"Edit", "class"=>"btn btn-primary", "route"=>"timepolicy/edit/$timepolicy->id"]);
				$action_buttons.= Event::button(["name"=>"delete", "value"=>"Delete", "class"=>"btn btn-danger", "route"=>"timepolicy/confirm/$timepolicy->id"]);
				$action_buttons.= "</div></td>";
			}
			$html.="<tr><td>$timepolicy->id</td><td>$timepolicy->name</td><td>$timepolicy->policy_type</td><td>$timepolicy->details</td><td>$timepolicy->policy_highlights</td><td>$timepolicy->approval_required</td><td>$timepolicy->created_time</td> $action_buttons</tr>";
		}
		$html.="</table>";
		$html.= pagination($page,$total_pages);
		return $html;
	}
	static function html_row_details($id){
		global $db,$tx,$base_url;
		$result =$db->query("select id,name,policy_type,details,policy_highlights,approval_required,created_time from {$tx}time_policy where id={$id}");
		$timepolicy=$result->fetch_object();
		$html="<table class='table'>";
		$html.="<tr><th colspan=\"2\">TimePolicy Show</th></tr>";
		$html.="<tr><th>Id</th><td>$timepolicy->id</td></tr>";
		$html.="<tr><th>Name</th><td>$timepolicy->name</td></tr>";
		$html.="<tr><th>Policy Type</th><td>$timepolicy->policy_type</td></tr>";
		$html.="<tr><th>Details</th><td>$timepolicy->details</td></tr>";
		$html.="<tr><th>Policy Highlights</th><td>$timepolicy->policy_highlights</td></tr>";
		$html.="<tr><th>Approval Required</th><td>$timepolicy->approval_required</td></tr>";
		$html.="<tr><th>Created Time</th><td>$timepolicy->created_time</td></tr>";

		$html.="</table>";
		return $html;
	}
}
?>
