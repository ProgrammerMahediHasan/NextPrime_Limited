<?php
class AttendancePolicy extends Model implements JsonSerializable{
	public $id;
	public $name;
	public $description;
	public $key_highlights;
	public $effective_from;
	public $status;
	public $approval_required;
	public $created_by;

	public function __construct(){
	}
	public function set($id,$name,$description,$key_highlights,$effective_from,$status,$approval_required,$created_by){
		$this->id=$id;
		$this->name=$name;
		$this->description=$description;
		$this->key_highlights=$key_highlights;
		$this->effective_from=$effective_from;
		$this->status=$status;
		$this->approval_required=$approval_required;
		$this->created_by=$created_by;

	}
	public function save(){
		global $db,$tx;
		$db->query("insert into {$tx}attendance_policy(name,description,key_highlights,effective_from,status,approval_required,created_by)values('$this->name','$this->description','$this->key_highlights','$this->effective_from','$this->status','$this->approval_required','$this->created_by')");
		return $db->insert_id;
	}
	public function update(){
		global $db,$tx;
		$db->query("update {$tx}attendance_policy set name='$this->name',description='$this->description',key_highlights='$this->key_highlights',effective_from='$this->effective_from',status='$this->status',approval_required='$this->approval_required',created_by='$this->created_by' where id='$this->id'");
	}
	public static function delete($id){
		global $db,$tx;
		$db->query("delete from {$tx}attendance_policy where id={$id}");
	}
	public function jsonSerialize(){
		return get_object_vars($this);
	}
	public static function all(){
		global $db,$tx;
		$result=$db->query("select id,name,description,key_highlights,effective_from,status,approval_required,created_by from {$tx}attendance_policy");
		$data=[];
		while($attendancepolicy=$result->fetch_object()){
			$data[]=$attendancepolicy;
		}
			return $data;
	}
	public static function pagination($page=1,$perpage=10,$criteria=""){
		global $db,$tx;
		$top=($page-1)*$perpage;
		$result=$db->query("select id,name,description,key_highlights,effective_from,status,approval_required,created_by from {$tx}attendance_policy $criteria limit $top,$perpage");
		$data=[];
		while($attendancepolicy=$result->fetch_object()){
			$data[]=$attendancepolicy;
		}
			return $data;
	}
	public static function count($criteria=""){
		global $db,$tx;
		$result =$db->query("select count(*) from {$tx}attendance_policy $criteria");
		list($count)=$result->fetch_row();
			return $count;
	}
	public static function find($id){
		global $db,$tx;
		$result =$db->query("select id,name,description,key_highlights,effective_from,status,approval_required,created_by from {$tx}attendance_policy where id='$id'");
		$attendancepolicy=$result->fetch_object();
			return $attendancepolicy;
	}
	static function get_last_id(){
		global $db,$tx;
		$result =$db->query("select max(id) last_id from {$tx}attendance_policy");
		$attendancepolicy =$result->fetch_object();
		return $attendancepolicy->last_id;
	}
	public function json(){
		return json_encode($this);
	}
	public function __toString(){
		return "		Id:$this->id<br> 
		Name:$this->name<br> 
		Description:$this->description<br> 
		Key Highlights:$this->key_highlights<br> 
		Effective From:$this->effective_from<br> 
		Status:$this->status<br> 
		Approval Required:$this->approval_required<br> 
		Created By:$this->created_by<br> 
";
	}

	//-------------HTML----------//

	static function html_select($name="cmbAttendancePolicy"){
		global $db,$tx;
		$html="<select id='$name' name='$name'> ";
		$result =$db->query("select id,name from {$tx}attendance_policy");
		while($attendancepolicy=$result->fetch_object()){
			$html.="<option value ='$attendancepolicy->id'>$attendancepolicy->name</option>";
		}
		$html.="</select>";
		return $html;
	}
	static function html_table($page = 1,$perpage = 10,$criteria="",$action=true){
		global $db,$tx,$base_url;
		$count_result =$db->query("select count(*) total from {$tx}attendance_policy $criteria ");
		list($total_rows)=$count_result->fetch_row();
		$total_pages = ceil($total_rows /$perpage);
		$top = ($page - 1)*$perpage;
		$result=$db->query("select id,name,description,key_highlights,effective_from,status,approval_required,created_by from {$tx}attendance_policy $criteria limit $top,$perpage");
		$html="<table class='table'>";
			$html.="<tr><th colspan='3'>".Html::link(["class"=>"btn btn-success","route"=>"attendancepolicy/create","text"=>"New AttendancePolicy"])."</th></tr>";
		if($action){
			$html.="<tr><th>Id</th><th>Name</th><th>Description</th><th>Key Highlights</th><th>Effective From</th><th>Status</th><th>Approval Required</th><th>Created By</th><th>Action</th></tr>";
		}else{
			$html.="<tr><th>Id</th><th>Name</th><th>Description</th><th>Key Highlights</th><th>Effective From</th><th>Status</th><th>Approval Required</th><th>Created By</th></tr>";
		}
		while($attendancepolicy=$result->fetch_object()){
			$action_buttons = "";
			if($action){
				$action_buttons = "<td><div class='btn-group' style='display:flex;'>";
				$action_buttons.= Event::button(["name"=>"show", "value"=>"Show", "class"=>"btn btn-info", "route"=>"attendancepolicy/show/$attendancepolicy->id"]);
				$action_buttons.= Event::button(["name"=>"edit", "value"=>"Edit", "class"=>"btn btn-primary", "route"=>"attendancepolicy/edit/$attendancepolicy->id"]);
				$action_buttons.= Event::button(["name"=>"delete", "value"=>"Delete", "class"=>"btn btn-danger", "route"=>"attendancepolicy/confirm/$attendancepolicy->id"]);
				$action_buttons.= "</div></td>";
			}
			$html.="<tr><td>$attendancepolicy->id</td><td>$attendancepolicy->name</td><td>$attendancepolicy->description</td><td>$attendancepolicy->key_highlights</td><td>$attendancepolicy->effective_from</td><td>$attendancepolicy->status</td><td>$attendancepolicy->approval_required</td><td>$attendancepolicy->created_by</td> $action_buttons</tr>";
		}
		$html.="</table>";
		$html.= pagination($page,$total_pages);
		return $html;
	}
	static function html_row_details($id){
		global $db,$tx,$base_url;
		$result =$db->query("select id,name,description,key_highlights,effective_from,status,approval_required,created_by from {$tx}attendance_policy where id={$id}");
		$attendancepolicy=$result->fetch_object();
		$html="<table class='table'>";
		$html.="<tr><th colspan=\"2\">AttendancePolicy Show</th></tr>";
		$html.="<tr><th>Id</th><td>$attendancepolicy->id</td></tr>";
		$html.="<tr><th>Name</th><td>$attendancepolicy->name</td></tr>";
		$html.="<tr><th>Description</th><td>$attendancepolicy->description</td></tr>";
		$html.="<tr><th>Key Highlights</th><td>$attendancepolicy->key_highlights</td></tr>";
		$html.="<tr><th>Effective From</th><td>$attendancepolicy->effective_from</td></tr>";
		$html.="<tr><th>Status</th><td>$attendancepolicy->status</td></tr>";
		$html.="<tr><th>Approval Required</th><td>$attendancepolicy->approval_required</td></tr>";
		$html.="<tr><th>Created By</th><td>$attendancepolicy->created_by</td></tr>";

		$html.="</table>";
		return $html;
	}
}
?>
