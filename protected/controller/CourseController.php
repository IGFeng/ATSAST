<?php
class CourseController extends BaseController
{
    public function actionIndex()
    {
        if (arg("cid")) {
            $this->jump("{$this->ATSAST_DOMAIN}/course/".arg("cid")."/detail");
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }
    public function actionDetail()
    {
        $this->url="course/detail";
        $this->title="课程详情";
        $this->bg="";

        if (arg("cid")) {
            $cid=arg("cid");
            if (is_numeric($cid)) {
                $this->cid=$cid;
                $db=new Model("courses");
                $organization=new Model("organization");
                $instructor=new Model("instructor");
                $course_details=new Model("course_details");
                $course_register=new Model("course_register");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                if (empty($result)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $details=$course_details->findAll(array("cid=:cid",":cid"=>$cid));
                $instructor_info=$instructor->query("select * from instructor as i left join users u on i.uid = u.uid where i.cid=:cid order by i.iid asc", array(":cid"=>$cid));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $this->result=$result;
                $this->site=$result["course_name"];
                $this->detail=$details;
                if ($this->islogin) {
                    $syllabus_info=$syllabus->query("select s.syid,s.cid,title,time,location,`desc`,signed,signid,script,homework,feedback,video from syllabus as s left join syllabus_sign u on s.syid = u.syid and u.uid=:uid where s.cid=:cid order by CONVERT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(time, '年', '-'), '月', '-'), '日', ''), '：', ':'), '开始', ':00'), datetime) ASC", array(":uid"=>$this->userinfo['uid'],":cid"=>$cid));
                } else {
                    $syllabus_info=$syllabus->findAll(array("cid=:cid",":cid"=>$cid)," CONVERT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(time, '年', '-'), '月', '-'), '日', ''), '：', ':'), '开始', ':00'), datetime) ASC ");
                }
                if ($this->islogin) {
                    $register_status=$course_register->find(array("cid=:cid and uid=:uid",":cid"=>$cid,":uid"=>$this->userinfo['uid']));
                }
                if (empty($register_status)) {
                    $this->register_status=0;
                } else {
                    $this->register_status=$register_status['status'];
                }
                // var_dump($details);
                $this->instructor=$instructor_info;
                $this->syllabus=$syllabus_info;
                // var_dump($syllabus_info);
                $this->cid=$cid;
            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionManage()
    {
        $this->url="course/manage";
        $this->title="课程管理";
        $this->bg="";

        if (arg("cid") && $this->islogin) {
            $cid=arg("cid");
            if (is_numeric($cid)) {
                $this->cid=$cid;
                $db=new Model("courses");
                $organization=new Model("organization");
                $instructor=new Model("instructor");
                $course_details=new Model("course_details");
                $course_register=new Model("course_register");
                $syllabus=new Model("syllabus");
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                if (empty($result) || empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $details=$course_details->findAll(array("cid=:cid",":cid"=>$cid));
                $instructor_info=$instructor->query("select * from instructor as i left join users u on i.uid = u.uid where i.cid=:cid order by i.iid asc", array(":cid"=>$cid));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $this->result=$result;
                $this->site=$result["course_name"];
                $this->detail=$details;
                $syllabus_info=$syllabus->query("select s.syid,s.cid,title,time,location,`desc`,signed,signid,script,homework,feedback,video from syllabus as s left join syllabus_sign u on s.syid = u.syid and u.uid=:uid where s.cid=:cid ORDER BY CONVERT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(time, '年', '-'), '月', '-'), '日', ''), '：', ':'), '开始', ':00'), datetime) ASC", array(":uid"=>$this->userinfo['uid'],":cid"=>$cid));
                // 关联查询sign的原因：历史遗留
                $this->instructor=$instructor_info;
                $this->syllabus=$syllabus_info;
                // var_dump($syllabus_info);
                $this->cid=$cid;
                $this->access_right=$access_right;
            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionRegister()
    {
        $this->url="course/register";
        $this->title="报名";

        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
        if (arg("cid")) {
            $cid=arg("cid");
            if (is_numeric($cid)) {
                $this->cid=$cid;
                $db=new Model("courses");
                $course_register=new Model("course_register");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                if (empty($result)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }
                $this->site=$result["course_name"];
                $register_status=$course_register->find(array("cid=:cid and uid=:uid",":cid"=>$cid,":uid"=>$this->userinfo['uid']));
                if (empty($register_status)) {
                    //报名
                    $newrow = array(
                        'uid' => $this->userinfo['uid'],
                        'cid' => $cid,
                        'status' => 1
                    );
                    $course_register->create($newrow);
                    $this->register_status=1;
                } else {
                    $this->register_status=0;
                }
                $this->cid=$cid;
            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionAdd()
    {
        $this->url="course/add";
        $this->title="新增课程";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionScript()
    {
        $this->url="course/script";
        $this->title="教学讲义";
        $this->bg="";

        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $script=new Model("syllabus_script");
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $course_register=new Model("course_register");
                if ($this->islogin) {
                    $register_status=$course_register->find(array("cid=:cid and uid=:uid",":cid"=>$cid,":uid"=>$this->userinfo['uid']));
                }
                if (empty($register_status)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/detail");
                }
                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));
                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }
                if($syllabus_info["script"]==0){
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/detail");
                }
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $result2=$script->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($result2)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }

                $this->result=$result;
                $this->site=$syllabus_info["title"];

                $result2['content_slashed'] = str_replace('\\', '\\\\', $result2['content']);
                $result2['content_slashed'] = str_replace("\r\n", "\\n", $result2['content_slashed']);
                $result2['content_slashed'] = str_replace("\n", "\\n", $result2['content_slashed']);
                $result2['content_slashed'] = str_replace("\"", "\\\"", $result2['content_slashed']);
                $result2['content_slashed'] = str_replace("<", "\<", $result2['content_slashed']);
                $result2['content_slashed'] = str_replace(">", "\>", $result2['content_slashed']);

                $this->script=$result2;
            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionHomework()
    {
        $this->url="course/homework";
        $this->title="作业提交";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $homework=new Model("homework");
                $homework_submit=new Model("homework_submit");
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $course_register=new Model("course_register");
                if ($this->islogin) {
                    $register_status=$course_register->find(array("cid=:cid and uid=:uid",":cid"=>$cid,":uid"=>$this->userinfo['uid']));
                }
                if (empty($register_status)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/detail");
                }
                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));
                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }
                if($syllabus_info["homework"]==0){
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/detail");
                }
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $homework_details=$homework->findAll(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));
                if (empty($homework_details)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }
                foreach ($homework_details as &$h) {
                    $h['homework_content_slashed'] = str_replace('\\', '\\\\', $h['homework_content']);
                    $h['homework_content_slashed'] = str_replace("\r\n", "\\n", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("\n", "\\n", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("\"", "\\\"", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("<", "\<", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace(">", "\>", $h['homework_content_slashed']);
                }
                $homework_submit_status=$homework_submit->findAll(array("cid=:cid and syid=:syid and uid=:uid",":cid"=>$cid,":syid"=>$syid,":uid"=>$this->userinfo['uid']));
                $this->result=$result;
                $this->site=$syllabus_info["title"];
                $this->syllabus_info=$syllabus_info;
                $this->homework=$homework_details;
                if (empty($homework_submit_status)) {
                    $this->homework_submit=array();
                } else {
                    $homework_submit_info=array();
                    foreach ($homework_submit_status as $r) {
                        $r['submit_content_slashed'] = str_replace('\\', '\\\\', $r['submit_content']);
                        $r['submit_content_slashed'] = str_replace("\r\n", "\\n", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace("\n", "\\n", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace("\"", "\\\"", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace("<", "\<", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace(">", "\>", $r['submit_content_slashed']);
                        $homework_submit_info[$r['hid']]=$r;
                    }
                    $this->homework_submit=$homework_submit_info;
                }

                if (arg("action")=="submit") {
                    $submit_time=date("Y-m-d H:i:s");
                    $newrow=array(
                        "cid"=>$cid,
                        "syid"=>$syid,
                        "uid"=>$this->userinfo['uid'],
                        "submit_content"=>arg("content"),
                        "submit_time"=>$submit_time,
                    );
                    $homework_submit->create($newrow);
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/detail");
                }
            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionSign()
    {
        $this->url="course/sign";
        $this->title="签到";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $sign=new Model("syllabus_sign");
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $course_register=new Model("course_register");
                if ($this->islogin) {
                    $register_status=$course_register->find(array("cid=:cid and uid=:uid",":cid"=>$cid,":uid"=>$this->userinfo['uid']));
                }
                if (empty($register_status)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/detail");
                }
                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));
                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }
                if($syllabus_info["signed"]==="0"){
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/detail");
                }
                $sign_status=$sign->find(array("cid=:cid and syid=:syid and uid=:uid",":cid"=>$cid,":syid"=>$syid,":uid"=>$this->userinfo['uid']));
                if (empty($sign_status)) {
                    $sign_status=0;
                } else {
                    return $this->sign_status=-1;
                }
                $this->sign_status=$sign_status;
                $this->site=$syllabus_info["title"];
                $this->syllabus=$syllabus_info;
            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }

            if (arg("password")) {
                $password=arg("password");
                $result=$syllabus->find(array("cid=:cid and syid=:syid and signed=:signed",":cid"=>$cid,":syid"=>$syid,":signed"=>$password));
                if (empty($result)) {
                    $sign_status=-2;
                } else {
                    $stime=date("Y-m-d H:i:s");
                    $sign->create(array(
                        "syid"=>$syid,
                        "cid"=>$cid,
                        "uid"=>$this->userinfo['uid'],
                        "stime"=>$stime
                    ));
                    $sign_status=1;
                }
                $this->sign_status=$sign_status;
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionView_Homework()
    {
        $this->url="course/view_homework";
        $this->title="查看作业提交";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $homework=new Model("homework");
                $homework_submit=new Model("homework_submit");
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/");
                }

                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }

                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $homework_details=$homework->findAll(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($homework_details)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/manage");
                }

                foreach ($homework_details as &$h) {
                    $h['homework_content_slashed'] = str_replace('\\', '\\\\', $h['homework_content']);
                    $h['homework_content_slashed'] = str_replace("\r\n", "\\n", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("\n", "\\n", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("\"", "\\\"", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("<", "\<", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace(">", "\>", $h['homework_content_slashed']);
                }
                
                $homework_submit_users=$homework_submit->query("SELECT DISTINCT(h.uid),u.SID,u.avatar,u.real_name from homework_submit as h left join users u on h.uid = u.uid where h.cid=:cid and h.syid=:syid",array(":cid"=>$cid,":syid"=>$syid));
                $this->result=$result;
                $this->site=$syllabus_info["title"];
                $this->syllabus_info=$syllabus_info;
                $this->homework=$homework_details;
                if (empty($homework_submit_users)) {
                    $this->homework_submit=array();
                } else {
                    $this->homework_submit=$homework_submit_users;
                }
            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionView_Homework_Details()
    {
        $this->url="course/view_homework_details";
        $this->title="查看作业提交详情";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid") && arg("uid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            $uid=arg("uid");
            if (is_numeric($cid) && is_numeric($syid) && is_numeric($uid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $users=new Model("users");
                $homework=new Model("homework");
                $homework_submit=new Model("homework_submit");
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $course_register=new Model("course_register");

                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));
                $this->user_details=$users->find(array("uid=:uid",":uid"=>$uid));

                if (empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/detail");
                }

                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $homework_details=$homework->findAll(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));
                if (empty($homework_details)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }
                foreach ($homework_details as &$h) {
                    $h['homework_content_slashed'] = str_replace('\\', '\\\\', $h['homework_content']);
                    $h['homework_content_slashed'] = str_replace("\r\n", "\\n", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("\n", "\\n", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("\"", "\\\"", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("<", "\<", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace(">", "\>", $h['homework_content_slashed']);
                }
                $homework_submit_status=$homework_submit->findAll(array("cid=:cid and syid=:syid and uid=:uid",":cid"=>$cid,":syid"=>$syid,":uid"=>$uid));
                $this->result=$result;
                $this->site=$syllabus_info["title"];
                $this->syllabus_info=$syllabus_info;
                $this->homework=$homework_details;
                if (empty($homework_submit_status)) {
                    $this->homework_submit=array();
                } else {
                    $homework_submit_info=array();
                    foreach ($homework_submit_status as $r) {
                        $r['submit_content_slashed'] = str_replace('\\', '\\\\', $r['submit_content']);
                        $r['submit_content_slashed'] = str_replace("\r\n", "\\n", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace("\n", "\\n", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace("\"", "\\\"", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace("<", "\<", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace(">", "\>", $r['submit_content_slashed']);
                        $homework_submit_info[$r['hid']]=$r;
                    }
                    $this->homework_submit=$homework_submit_info;
                }
            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionFeedBack()
    {
        $this->url="course/feedback";
        $this->title="课堂反馈";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $feedback=new Model("syllabus_feedback");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $course_register=new Model("course_register");
                if ($this->islogin) {
                    $register_status=$course_register->find(array("cid=:cid and uid=:uid",":cid"=>$cid,":uid"=>$this->userinfo['uid']));
                }
                if (empty($register_status)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/detail");
                }
                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));
                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }
                if($syllabus_info["feedback"]==0){
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/detail");
                }
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $feedback_submit_status=$feedback->find(array("cid=:cid and syid=:syid and uid=:uid",":cid"=>$cid,":syid"=>$syid,":uid"=>$this->userinfo['uid']));
                $this->feedback_submit_status=$feedback_submit_status;
                $this->result=$result;
                $this->site=$syllabus_info["title"];
                $this->syllabus_info=$syllabus_info;

            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionView_Sign()
    {
        $this->url="course/view_sign";
        $this->title="查看签到情况";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $homework=new Model("homework");
                $homework_submit=new Model("homework_submit");
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $sign=new Model("syllabus_sign");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/");
                }

                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }

                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                
                $sign_details=$sign->query("select * from syllabus_sign as s left join users u on s.uid = u.uid where s.cid=:cid and s.syid=:syid order by s.stime asc", array(":cid"=>$cid,":syid"=>$syid));
                $this->sign_details=$sign_details;
                $this->result=$result;
                $this->site=$syllabus_info["title"];
                $this->syllabus_info=$syllabus_info;

            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionView_Register()
    {
        $this->url="course/view_register";
        $this->title="查看报名情况";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            if (is_numeric($cid)) {
                $this->cid=$cid;
                $course_register=new Model("course_register");
                $organization=new Model("organization");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/");
                }

                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                
                $course_regisrter_details=$course_register->query("select * from course_register as c left join users u on c.uid = u.uid where c.cid=:cid order by c.rid asc", array(":cid"=>$cid));
                $this->regisrter_details=$course_regisrter_details;
                $this->result=$result;
                $this->site=$result["course_name"];

            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionAdd_Syllabus()
    {
        $this->url="course/add_syllabus";
        $this->title="新增课时";
        $this->bg="";
        
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            if (is_numeric($cid)) {
                $this->cid=$cid;
                $organization=new Model("organization");
                $sign=new Model("syllabus_sign");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/");
                }

                if (empty($result)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }

                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                
                $this->result=$result;
                $this->site=$result["course_name"];

            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionEdit_Sign()
    {
        $this->url="course/edit_sign";
        $this->title="设置签到";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $sign=new Model("syllabus_sign");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/");
                }

                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }

                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                
                $this->result=$result;
                $this->site=$syllabus_info["title"];
                $this->syllabus_info=$syllabus_info;

            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionEdit_Video()
    {
        $this->url="course/edit_video";
        $this->title="设置视频";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/");
                }

                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }

                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                
                $this->result=$result;
                $this->site=$syllabus_info["title"];
                $this->syllabus_info=$syllabus_info;

            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionEdit_Info()
    {
        $this->url="course/edit_info";
        $this->title="编辑课时信息";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/");
                }

                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }

                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                
                $this->result=$result;
                $this->site=$syllabus_info["title"];
                $this->syllabus_info=$syllabus_info;

            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionEdit()
    {
        $this->url="course/edit";
        $this->title="编辑课程信息";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            if (is_numeric($cid)) {
                $this->cid=$cid;
                $organization=new Model("organization");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/");
                }

                if (empty($result)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }

                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                
                $this->result=$result;
                $this->site=$result["course_name"];

            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionEdit_Script()
    {
        $this->url="course/edit_script";
        $this->title="编辑授课笔记";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $script=new Model("syllabus_script");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/");
                }

                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }

                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                
                $this->result=$result;
                $this->site=$syllabus_info["title"];
                $this->syllabus_info=$syllabus_info;

                $syllabus_script=$script->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                $syllabus_script['script_slashed'] = str_replace('\\', '\\\\', $syllabus_script['content']);
                $syllabus_script['script_slashed'] = str_replace("\r\n", "\\n", $syllabus_script['script_slashed']);
                $syllabus_script['script_slashed'] = str_replace("\n", "\\n", $syllabus_script['script_slashed']);
                $syllabus_script['script_slashed'] = str_replace("\"", "\\\"", $syllabus_script['script_slashed']);
                $syllabus_script['script_slashed'] = str_replace("<", "\<", $syllabus_script['script_slashed']);
                $syllabus_script['script_slashed'] = str_replace(">", "\>", $syllabus_script['script_slashed']);

                $this->syllabus_script=$syllabus_script;

            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionEdit_FeedBack()
    {
        $this->url="course/edit_feedback";
        $this->title="设置反馈";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/");
                }

                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }

                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                
                $this->result=$result;
                $this->site=$syllabus_info["title"];
                $this->syllabus_info=$syllabus_info;

            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionAdd_Homework()
    {
        $this->url="course/add_homework";
        $this->title="新建作业";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/");
                }

                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }

                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                
                $this->result=$result;
                $this->site=$syllabus_info["title"];
                $this->syllabus_info=$syllabus_info;

            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionEdit_Homework()
    {
        $this->url="course/edit_homework";
        $this->title="设置作业";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/");
                }

                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }

                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                
                $this->result=$result;
                $this->site=$syllabus_info["title"];
                $this->syllabus_info=$syllabus_info;

                $homework=new Model("homework");
                $homework_details=$homework->findAll(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                foreach ($homework_details as &$h) {
                    $h['homework_content_slashed'] = str_replace('\\', '\\\\', $h['homework_content']);
                    $h['homework_content_slashed'] = str_replace("\r\n", "\\n", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("\n", "\\n", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("\"", "\\\"", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("<", "\<", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace(">", "\>", $h['homework_content_slashed']);
                }

                $this->homework=$homework_details;

            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }

    public function actionView_FeedBack()
    {
        $this->url="course/view_feedback";
        $this->title="查看反馈";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $feedback=new Model("syllabus_feedback");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/course/$cid/");
                }

                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("{$this->ATSAST_DOMAIN}/courses");
                }

                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                
                $this->result=$result;
                $this->site=$syllabus_info["title"];
                $this->syllabus_info=$syllabus_info;

                $feedback_submit=$feedback->query("select * from syllabus_feedback s left join users u on s.uid = u.uid where s.cid=:cid and s.syid=:syid order by s.feedback_time asc", array(":cid"=>$cid,":syid"=>$syid));
                $this->feedback_submit=$feedback_submit;

            } else {
                $this->jump("{$this->ATSAST_DOMAIN}/courses");
            }
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}/courses");
        }
    }
}
