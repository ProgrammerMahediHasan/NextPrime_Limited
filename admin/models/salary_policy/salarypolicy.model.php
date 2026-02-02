<?php
class SalaryPolicy extends Model implements JsonSerializable{
	public $id;
	public $name;
	public $salary_type;
	public $description;
	public $status;
	public $key_points;
	public $effective_time;
	public $approval_required;
	public $created_by;

	public function __construct(){
	}
	public function set($id,$name,$salary_type,$description,$status,$key_points,$effective_time,$approval_required,$created_by){
		$this->id=$id;
		$this->name=$name;
		$this->salary_type=$salary_type;
		$this->description=$description;
		$this->status=$status;
		$this->key_points=$key_points;
		$this->effective_time=$effective_time;
		$this->approval_required=$approval_required;
		$this->created_by=$created_by;

	}
	public function save(){
		global $db,$tx;
		$db->query("insert into {$tx}salary_policy(name,salary_type,description,status,key_points,effective_time,approval_required,created_by)values('$this->name','$this->salary_type','$this->description','$this->status','$this->key_points','$this->effective_time','$this->approval_required','$this->created_by')");
		return $db->insert_id;
	}
	public function update(){
		global $db,$tx;
		$db->query("update {$tx}salary_policy set name='$this->name',salary_type='$this->salary_type',description='$this->description',status='$this->status',key_points='$this->key_points',effective_time='$this->effective_time',approval_required='$this->approval_required',created_by='$this->created_by' where id='$this->id'");
	}
	public static function delete($id){
		global $db,$tx;
		$db->query("delete from {$tx}salary_policy where id={$id}");
	}
	public function jsonSerialize(){
		return get_object_vars($this);
	}
	public static function all(){
		global $db,$tx;
		$result=$db->query("select id,name,salary_type,description,status,key_points,effective_time,approval_required,created_by from {$tx}salary_policy");
		$data=[];
		while($salarypolicy=$result->fetch_object()){
			$data[]=$salarypolicy;
		}
			return $data;
	}
	public static function pagination($page=1,$perpage=10,$criteria=""){
		global $db,$tx;
		$top=($page-1)*$perpage;
		$result=$db->query("select id,name,salary_type,description,status,key_points,effective_time,approval_required,created_by from {$tx}salary_policy $criteria limit $top,$perpage");
		$data=[];
		while($salarypolicy=$result->fetch_object()){
			$data[]=$salarypolicy;
		}
			return $data;
	}
	public static function count($criteria=""){
		global $db,$tx;
		$result =$db->query("select count(*) from {$tx}salary_policy $criteria");
		list($count)=$result->fetch_row();
			return $count;
	}
	public static function find($id){
		global $db,$tx;
		$result =$db->query("select id,name,salary_type,description,status,key_points,effective_time,approval_required,created_by from {$tx}salary_policy where id='$id'");
		$salarypolicy=$result->fetch_object();
			return $salarypolicy;
	}
	static function get_last_id(){
		global $db,$tx;
		$result =$db->query("select max(id) last_id from {$tx}salary_policy");
		$salarypolicy =$result->fetch_object();
		return $salarypolicy->last_id;
	}
	public function json(){
		return json_encode($this);
	}
	public function __toString(){
		return "		Id:$this->id<br> 
		Name:$this->name<br> 
		Salary Type:$this->salary_type<br> 
		Description:$this->description<br> 
		Status:$this->status<br> 
		Key Points:$this->key_points<br> 
		Effective Time:$this->effective_time<br> 
		Approval Required:$this->approval_required<br> 
		Created By:$this->created_by<br> 
";
	}

	//-------------HTML----------//

	static function html_select($name="cmbSalaryPolicy"){
		global $db,$tx;
		$html="<select id='$name' name='$name'> ";
		$result =$db->query("select id,name from {$tx}salary_policy");
		while($salarypolicy=$result->fetch_object()){
			$html.="<option value ='$salarypolicy->id'>$salarypolicy->name</option>";
		}
		$html.="</select>";
		return $html;
	}
	static function html_table($page = 1,$perpage = 10,$criteria="",$action=true){
		global $db,$tx,$base_url;
		$count_result =$db->query("select count(*) total from {$tx}salary_policy $criteria ");
		list($total_rows)=$count_result->fetch_row();
		$total_pages = ceil($total_rows /$perpage);
		$top = ($page - 1)*$perpage;
		$result=$db->query("select id,name,salary_type,description,status,key_points,effective_time,approval_required,created_by from {$tx}salary_policy $criteria limit $top,$perpage");
		$html="<table class='table'>";
			$html.="<tr><th colspan='3'>".Html::link(["class"=>"btn btn-success","route"=>"salarypolicy/create","text"=>"New SalaryPolicy"])."</th></tr>";
		if($action){
			$html.="<tr><th>Id</th><th>Name</th><th>Salary Type</th><th>Description</th><th>Status</th><th>Key Points</th><th>Effective Time</th><th>Approval Required</th><th>Created By</th><th>Action</th></tr>";
		}else{
			$html.="<tr><th>Id</th><th>Name</th><th>Salary Type</th><th>Description</th><th>Status</th><th>Key Points</th><th>Effective Time</th><th>Approval Required</th><th>Created By</th></tr>";
		}
		while($salarypolicy=$result->fetch_object()){
			$action_buttons = "";
			if($action){
				$action_buttons = "<td><div class='btn-group' style='display:flex;'>";
				$action_buttons.= Event::button(["name"=>"show", "value"=>"Show", "class"=>"btn btn-info", "route"=>"salarypolicy/show/$salarypolicy->id"]);
				$action_buttons.= Event::button(["name"=>"edit", "value"=>"Edit", "class"=>"btn btn-primary", "route"=>"salarypolicy/edit/$salarypolicy->id"]);
				$action_buttons.= Event::button(["name"=>"delete", "value"=>"Delete", "class"=>"btn btn-danger", "route"=>"salarypolicy/confirm/$salarypolicy->id"]);
				$action_buttons.= "</div></td>";
			}
			$html.="<tr><td>$salarypolicy->id</td><td>$salarypolicy->name</td><td>$salarypolicy->salary_type</td><td>$salarypolicy->description</td><td>$salarypolicy->status</td><td>$salarypolicy->key_points</td><td>$salarypolicy->effective_time</td><td>$salarypolicy->approval_required</td><td>$salarypolicy->created_by</td> $action_buttons</tr>";
		}
		$html.="</table>";
		$html.= pagination($page,$total_pages);
		return $html;
	}
	static function html_row_details($id){
		global $db,$tx,$base_url;
		$result =$db->query("select id,name,salary_type,description,status,key_points,effective_time,approval_required,created_by from {$tx}salary_policy where id={$id}");
		$salarypolicy=$result->fetch_object();
		$html="<table class='table'>";
		$html.="<tr><th colspan=\"2\">SalaryPolicy Show</th></tr>";
		$html.="<tr><th>Id</th><td>$salarypolicy->id</td></tr>";
		$html.="<tr><th>Name</th><td>$salarypolicy->name</td></tr>";
		$html.="<tr><th>Salary Type</th><td>$salarypolicy->salary_type</td></tr>";
		$html.="<tr><th>Description</th><td>$salarypolicy->description</td></tr>";
		$html.="<tr><th>Status</th><td>$salarypolicy->status</td></tr>";
		$html.="<tr><th>Key Points</th><td>$salarypolicy->key_points</td></tr>";
		$html.="<tr><th>Effective Time</th><td>$salarypolicy->effective_time</td></tr>";
		$html.="<tr><th>Approval Required</th><td>$salarypolicy->approval_required</td></tr>";
		$html.="<tr><th>Created By</th><td>$salarypolicy->created_by</td></tr>";

		$html.="</table>";
		return $html;
	}
}
?>
