<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Questions_model extends CI_Model {

  public $topicsTable = "oes_topics";
  public $questionsTable = "oes_questions";
  public $choicesTable = "oes_choices";
  public $answersTable = "oes_answers";
  public $examinersTable = "oes_examiners";
  public $usersTable = "users";
  public $recordsTable = "oes_records";
  public $sectionTable="oes_sections";
  public $totsubmitTable='oes_total_submit';

  function autocompleteSearch($term) {
    $autocompleteSearch = $this->db
      ->select('topic_id AS id, topic_title AS title, topic_date_added AS dateAdded, topic_status AS status')
      ->from($this->topicsTable)
      ->like('topic_title', $term)
      ->limit(10)
      ->get()
      ->result();
    return $autocompleteSearch;
  }

  function examinerAutocompleteSearch($term, $id) {
    $autocompleteSearch = $this->db
      ->query("SELECT DISTINCT topic_id AS id, topic_title AS title, topic_date_added AS dateAdded, topic_status AS status
      FROM oes_topics AS t INNER JOIN oes_examiners AS e ON t.topic_id = e.examiner_topics WHERE t.topic_title LIKE '%".$term."%'  && e.examiner_id = $id")
      ->result();
    return $autocompleteSearch;
  }

  function ifExisting($term) {
    $ifExisting = $this->db
      ->select('topic_title AS title')
      ->from($this->topicsTable)
      ->where('topic_title', $term)
      ->get();
    return $ifExisting;
  }

  function ifQuestionExist($data) {
    $ifQuestionExist = $this->db
      ->select('question_question AS question')
      ->from($this->questionsTable)
      ->where('question_question', $data['term'])
      ->where('question_id', $data['hiddenID'])
      ->get();
    return $ifQuestionExist;
  }

  function ifTitleExist($data) {
    $ifTitleExist = $this->db
      ->select('topic_title AS title')
      ->from($this->topicsTable)
      ->where('topic_title', $data['term'])
      ->where('topic_title !=', $data['oldTitle'])
      ->get();
    return $ifTitleExist;
  }

  function ifChoiceExist($data = []) {
    $ifChoiceExist = $this->db
      ->select('choice_text AS choice')
      ->from($this->choicesTable)
      ->where('choice_text', $data['choiceTerm'])
      ->where('choice_id', $data['hiddenID'])
      ->where('question_no', $data['hiddenQuestionID'])
      ->get();
    return $ifChoiceExist;
  }

  function searchTopics($term, $page, $limit) {
    $searchTopics = $this->db
      ->limit($limit, $page)
      ->select('topic_id AS id, topic_title AS title, topic_date_added AS dateAdded, topic_status AS status')
      ->from($this->topicsTable)
      ->like('topic_slug', $term)
      ->get();
    return $searchTopics;
  }

  function countSearchTopics($term) {
    $searchTopics = $this->db
      ->like('topic_slug', $term)
      ->get($this->topicsTable);
    return $searchTopics;
  }


   function searchTopics2($term, $page, $limit, $id) {
    $searchTopics2 = $this->db
      ->query("SELECT
        t.topic_id AS id,
        e.examiner_topic_date_taken AS dateTaken,
        e.examiner_score AS escore,
        e.examiner_status AS estat,
        e.examiner_topics AS topics,
        t.topic_titLe AS title,
        e.examiner_status AS status
        FROM oes_examiners AS e
        JOIN oes_topics AS t
        ON e.examiner_topics = t.topic_id
        WHERE t.topic_slug LIKE '%".$term."%' && e.examiner_id = $id
        LIMIT $page, $limit
      ");
    return $searchTopics2;
  }

  function countSearchTopics2($term, $id) {
    $countSearchTopics2 = $this->db
      ->query("SELECT
        DISTINCT 
        e.examiner_topics AS topics,
        t.topic_titLe AS title
        FROM oes_examiners AS e
        JOIN oes_topics AS t
        ON e.examiner_topics = t.topic_id
        WHERE t.topic_slug LIKE '%".$term."%' && e.examiner_id = $id
      ");
    return $countSearchTopics2;
  }


  function getAllSections($id)
  {
     return $this->db->where('topic',$id)->get('oes_sections')->result();
  }


  function getAllTopics($page, $limit) {
  	$getAllTopics = $this->db
  		->limit($limit, $page)
      ->DISTINCT()
      ->select('t.topic_id AS id, t.topic_title AS title, t.topic_date_added AS dateAdded, t.topic_status AS status, e.examiner_status AS eStatus')
      ->group_by('t.topic_id')
      ->from($this->topicsTable . ' AS t')
      ->join($this->examinersTable. ' AS e', 'e.examiner_topics = t.topic_id', 'left')
      ->order_by('topic_id', 'DESC')
      ->get();
    return $getAllTopics;
  }

  function getAllTopicsById($page, $limit, $id) {

    $getAllTopics = $this->db
      //->limit($limit, $page)
      ->select('users.id as user_id,t.topic_id AS id, t.topic_title AS title, t.topic_date_added AS dateAdded, t.topic_status AS status, e.examiner_topics AS topics, e.examiner_topic_date_taken AS dateTaken, e.examiner_score AS escore, e.examiner_status AS estat')
      ->from($this->topicsTable . ' AS t')
      ->join($this->examinersTable. ' AS e', 'e.examiner_topics = t.topic_id')
      ->join($this->usersTable, 'users.id = e.examiner_id')
      ->where('users.id',$id)
      ->get();
    return $getAllTopics;
  }

  function countAllTopics() {
  	$countAllTopics = $this->db
      ->get($this->topicsTable);
    return $countAllTopics;
  }

  function countAllTopics2($id) {
    $countAllTopics2 = $this->db
    ->where('examiner_id', $id)
    ->get($this->examinersTable);
    return $countAllTopics2;
  }

  function getQuestionsById($id) {
    $getQuestionsById = $this->db
      ->query("SELECT DISTINCT t.topic_id AS id,
        t.topic_title AS title,
        t.topic_date_added AS dateAdded,
        t.topic_status AS status,
        q.question_no AS no,
        q.question_question AS questions,
        q.question_status AS qstat,
        c.choice_choice AS choices,
        c.choice_type AS type,
        c.choice_text AS choicesText,
        a.answer_answer AS answer
        FROM $this->topicsTable AS t
        LEFT JOIN $this->questionsTable AS q ON t.topic_id = q.question_id
        LEFT JOIN $this->choicesTable AS c ON q.question_no = c.question_no
        LEFT JOIN $this->answersTable AS a ON c.question_no = a.question_no
        WHERE t.topic_id = $id")
      ->result();

    return $getQuestionsById;
  }



  function getSectionQuestions($section){
    $getQuestionsById = $this->db
      ->query("SELECT DISTINCT t.topic_id AS id,
        t.topic_title AS title,
        t.topic_date_added AS dateAdded,
        t.topic_status AS status,
        q.question_no AS no,
        q.question_question AS questions,
        q.question_status AS qstat,
        c.choice_choice AS choices,
        c.choice_type AS type,
        c.choice_text AS choicesText,
        a.answer_answer AS answer
        FROM $this->topicsTable AS t
        LEFT JOIN $this->questionsTable AS q ON t.topic_id = q.question_id
        LEFT JOIN $this->choicesTable AS c ON q.question_no = c.question_no
        LEFT JOIN $this->answersTable AS a ON c.question_no = a.question_no
        WHERE q.section_id = $section")
      ->result();

    return $getQuestionsById;



  }



  function ifAlreadyTaken($topicId, $userId) {
    $ifAlreadyTaken = $this->db
      ->where('examiner_topics', $topicId)
      ->where('examiner_id', $userId)
      ->where('examiner_score !=', "")
      ->get($this->examinersTable)
      ->num_rows();
    return $ifAlreadyTaken;
  }

  function ifAlreadyTaken2($topicId, $userId) {
    $ifAlreadyTaken = $this->db
      ->where('examiner_topics', $topicId)
      ->where('examiner_id', $userId)
      ->get($this->examinersTable)
      ->num_rows();
    return $ifAlreadyTaken;
  }

  function addAllToExam($id) {
    $selectAll = $this->db
      ->query("SELECT id AS uid FROM $this->usersTable
        WHERE id
        NOT IN (SELECT examiner_id FROM $this->examinersTable) ")    ///&& user_position = 1
      ->result();
    foreach($selectAll as $all) {
      $rows[] = $all->uid;
    }
    
    if(isset($rows) ) {
      $setData = [];
      foreach($rows as $key => $row) {
        $set = [
          'examiner_id' =>  $row,
          'examiner_topics' =>  $id
        ];
        array_push($setData, $set);
      }
      $addAllToExam = $this->db->insert_batch($this->examinersTable, $setData);
      return $addAllToExam;
    }
  }

  function removeAllToExam($id) {
    $selectAll = $this->db
      ->query("SELECT id AS uid FROM $this->usersTable
        WHERE user_id
        NOT IN (SELECT examiner_id FROM $this->examinersTable WHERE examiner_topic_date_taken IS NOT NULL) ")  // && user_position = 1
      ->result();
    foreach($selectAll as $all) {
      $rows[] = $all->uid;
    }
  
    if(isset($rows) ) {
     
      foreach($rows as $key => $row) {
        $set = [
          'examiner_id' =>  $row,
          'examiner_topics' =>  $id
        ];
        $addAllToExam = $this->db->delete($this->examinersTable, $set);
      }
      
      return $addAllToExam;
    }
  }


  function getQuestionsByIdAndUserId($id, $userId) {
    $getQuestionsById = $this->db
      ->query("SELECT DISTINCT t.topic_id AS id,
        t.topic_title AS title,
        t.topic_date_added AS dateAdded,
        t.topic_status AS status,
        t.per_ques_mark AS pqm,
        q.question_no AS no,
        q.question_question AS questions,
        q.question_status AS qstat,
        c.choice_choice AS choices,
        c.choice_type AS type,
        c.choice_text AS choicesText,
        a.answer_answer AS answer,
        r.record_answer AS recordAnswer
        FROM $this->topicsTable AS t
        LEFT JOIN $this->questionsTable AS q ON t.topic_id = q.question_id
        LEFT JOIN $this->choicesTable AS c ON q.question_no = c.question_no
        LEFT JOIN $this->answersTable AS a ON c.question_no = a.question_no
        LEFT JOIN $this->recordsTable AS r ON c.question_no = r.record_id
        WHERE t.topic_id = $id AND r.record_user_id = $userId AND c.choice_text != '' AND r.record_topic_id = $id")
      ->result();
//print_r($this->db->last_query());
    return $getQuestionsById;
  }

  function getTopicHistoryById($id, $userId) {
    $getTopicHistoryById = $this->db
      ->query("SELECT DISTINCT t.topic_id AS id,
        t.topic_title AS title,
        t.topic_date_added AS dateAdded,
        t.topic_status AS status,
        q.question_no AS no,
        q.question_question AS questions,
        q.question_status AS qstat,
        c.choice_choice AS choices,
        c.choice_type AS type,
        c.choice_text AS choicesText,
        a.answer_answer AS answer,
        r.record_answer AS recordAnswer,
        u.first_name AS userName
        FROM $this->topicsTable AS t
        LEFT JOIN $this->questionsTable AS q ON t.topic_id = q.question_id
        LEFT JOIN $this->choicesTable AS c ON q.question_no = c.question_no
        LEFT JOIN $this->answersTable AS a ON c.question_no = a.question_no
        LEFT JOIN $this->recordsTable AS r ON c.question_no = r.record_id
        LEFT JOIN $this->usersTable AS u ON u.id = r.record_user_id
        WHERE r.record_user_id = $userId AND r.record_topic_id = $id ")
      ->result();

    return $getTopicHistoryById;
  }

  

  function getQuestionsByIdByExaminer($id, $limit, $page) {
   if (!isset($_SESSION['hiddenNo'])) {
      $_SESSION['hiddenNo']=array();
   }
    $getQuestionsByIdByExaminer = $this->db
      ->query("SELECT DISTINCT t.topic_id AS id, t.topic_title AS title,
        t.topic_date_added AS dateAdded,
        t.topic_status AS status,
        q.question_no AS no,
        q.question_question AS questions,
        q.question_status AS qstat,
        c.choice_choice AS choices,
        c.choice_type AS type,
        e.examiner_topic_date_taken AS dateTaken,
        c.choice_text AS choicesText,
        a.answer_answer AS answer
        FROM oes_topics AS t
        LEFT JOIN oes_questions AS q ON t.topic_id = q.question_id
        LEFT JOIN oes_choices AS c ON q.question_no = c.question_no
        LEFT JOIN oes_answers AS a ON c.question_no = a.question_no
        LEFT JOIN oes_examiners AS e ON t.topic_id = e.examiner_id
        WHERE q.question_no NOT IN ('".implode("','",$_SESSION['hiddenNo'])."') && q.question_id = $id && q.question_status = 1 && c.choice_id = $id GROUP BY q.question_question ORDER BY RAND() LIMIT $page, $limit")
      ->result();

    return $getQuestionsByIdByExaminer;
  }

  function getQuestionsByIdByExaminer3($id, $no, $limit, $page) {
      if (!isset($_SESSION['hiddenNo'])) {
      $_SESSION['hiddenNo']=array();
   }
    $getQuestionsByIdByExaminer = $this->db
      ->query("SELECT DISTINCT t.topic_id AS id, t.topic_title AS title,
        t.topic_date_added AS dateAdded,
        t.topic_status AS status,
        q.question_no AS no,
        q.question_question AS questions,
        q.question_status AS qstat,
        c.choice_choice AS choices,
        c.choice_type AS type,
        e.examiner_topic_date_taken AS dateTaken,
        c.choice_text AS choicesText,
        a.answer_answer AS answer
        FROM oes_topics AS t
        LEFT JOIN oes_questions AS q ON t.topic_id = q.question_id
        LEFT JOIN oes_choices AS c ON q.question_no = c.question_no
        LEFT JOIN oes_answers AS a ON c.question_no = a.question_no
        LEFT JOIN oes_examiners AS e ON t.topic_id = e.examiner_id
        WHERE q.question_no NOT IN ('".implode("','",$_SESSION['hiddenNo'])."') && q.question_no = $no && q.question_id = $id && q.question_status = 1 && c.choice_id = $id GROUP BY q.question_question ORDER BY RAND()")
      ->result();

    return $getQuestionsByIdByExaminer;
  }

  function getQuestionsByIdByExaminer2($id) {
   
    $getQuestionsByIdByExaminer = $this->db
      ->query("SELECT DISTINCT t.topic_id AS id, t.topic_title AS title,
        t.topic_date_added AS dateAdded,
        t.topic_status AS status,
        q.question_no AS no,
        q.question_question AS questions,
        q.question_status AS qstat,
        c.choice_choice AS choices,
        c.choice_type AS type,
        e.examiner_topic_date_taken AS dateTaken,
        c.choice_text AS choicesText,
        a.answer_answer AS answer
        FROM oes_topics AS t
        LEFT JOIN oes_questions AS q ON t.topic_id = q.question_id
        LEFT JOIN oes_choices AS c ON q.question_no = c.question_no
        LEFT JOIN oes_answers AS a ON c.question_no = a.question_no
        LEFT JOIN oes_examiners AS e ON t.topic_id = e.examiner_id
        WHERE q.question_id = $id AND  q.question_status = 1 AND  c.choice_id = $id GROUP BY q.question_question ORDER BY RAND()")
      ->result();

    return $getQuestionsByIdByExaminer;
  }

  function countQuestionsByIdByExaminer($id) {

       if (!isset($_SESSION['hiddenNo'])) {
      $_SESSION['hiddenNo']=array();
   }

    $countQuestionsByIdByExaminer = $this->db
      ->query("SELECT DISTINCT t.topic_id AS id, t.topic_title AS title,
        t.topic_date_added AS dateAdded,
        t.topic_status AS status,
        q.question_no AS no,
        q.question_question AS questions,
        q.question_status AS qstat,
        c.choice_choice AS choices,
        c.choice_type AS type,
        e.examiner_topic_date_taken AS dateTaken,
        c.choice_text AS choicesText,
        a.answer_answer AS answer
        FROM oes_topics AS t
        LEFT JOIN oes_questions AS q ON t.topic_id = q.question_id
        LEFT JOIN oes_choices AS c ON q.question_no = c.question_no
        LEFT JOIN oes_answers AS a ON c.question_no = a.question_no
        LEFT JOIN oes_examiners AS e ON t.topic_id = e.examiner_id
        WHERE q.question_no NOT IN ('".implode("','",$_SESSION['hiddenNo'])."') && q.question_id = $id && q.question_status = 1 && c.choice_id = $id GROUP BY q.question_question ORDER BY q.question_no ASC")
      ->num_rows();

    return $countQuestionsByIdByExaminer;
  }


  function getQuestionsByQuestionID($id) {
    $getQuestionsByQuestionID = $this->db
      ->query("SELECT question_no AS no, choice_no AS cno, choice_choice AS choice, choice_text AS choices FROM oes_choices")
      ->result();

    return $getQuestionsByQuestionID;
  }

  function getTopicById($id) {
    $getTopicInfoById = $this->db
      ->select('topic_title AS title, is_section,topic_status AS status, topic_duration AS duration')
      ->from($this->topicsTable)
      ->where('topic_id', $id)
      ->get()
      ->row();
    return $getTopicInfoById;
  }

  function getTopicInfoById($id) {
    $getTopicInfoById = $this->db
      ->select('question_question AS questions')
      ->from($this->questionsTable)
      ->where('question_id', $id)
      ->get();
    return $getTopicInfoById;
  }


  function countQuestionsById($id) {
    $countQuestionsById = $this->db->get($this->topicsTable);
    return $countQuestionsById;
  }

  function add($data = array() ) {
    $setData = [
      'topic_title' => $data['term'],
      'is_section' => $data['is_section'],
      'topic_slug'  => str_replace(' ', '-', str_replace('+', 'plus', $data['term']) )
    ];
    $add = $this->db->insert($this->topicsTable, $setData);
    return $add;
  }

  function editQuestionInfoById($id, $no) {
    $editQuestionInfoById = $this->db
      ->query("SELECT DISTINCT t.topic_id AS id,
        t.topic_title AS title,
        t.topic_date_added AS dateAdded,
        t.topic_status AS status,
        q.question_no AS no,
        q.question_question AS questions,
        q.question_status AS questionStatus,
        c.choice_choice AS choices,
        c.choice_text AS choicesText,
        c.choice_type AS choiceType,
        a.answer_answer AS answer
        FROM $this->topicsTable AS t
        LEFT JOIN $this->questionsTable AS q ON t.topic_id = q.question_id
        LEFT JOIN $this->choicesTable AS c ON q.question_no = c.question_no
        LEFT JOIN $this->answersTable AS a ON c.question_no = a.question_no
        WHERE t.topic_id = $id && q.question_no = $no")
      ->result();

    return $editQuestionInfoById;
  }

  function add_question($data = [] ) {
    $section = NULL;
    if (isset($_POST['section_id'])) {
     $section = $this->input->post('section_id');  
    }
    $setData = [
      'question_question' => $data['term'],
      'question_id'  => $data['hiddenID'],
      'question_status'  => 1,
      'section_id'=>$section
    ];
    $add_question = $this->db->insert($this->questionsTable, $setData);
    return $add_question;
  }

  function updateQuestionInfo($data = []) {
    $setData = [
      'question_question' => $data['question'],
      'question_status' => $data['questionStatus']
    ];
    $updateQuestionInfo = $this->db
      ->where('question_id', $data['hiddenID'])
      ->where('question_no', $data['hiddenQuestionID'])
      ->update($this->questionsTable, $setData);
    return $updateQuestionInfo;
  }

  function updateAnswerInfo($data = []) {

    $setData = [
      'answer_answer' =>  $data['choice']
    ];
     $updateAnswerInfo = $this->db
      ->where('answer_id', $data['hiddenID'])
      ->where('question_no', $data['hiddenQuestionID'])
       ->update($this->answersTable, $setData);
     return $updateAnswerInfo;
  }

  function insertAnswerInfo($data = []) {

    $setData = [
      'answer_id' =>  $data['hiddenID'],
      'question_no' => $data['hiddenQuestionID'],
      'answer_answer' =>  $data['choice']
    ];
     $insertAnswerInfo = $this->db
       ->insert($this->answersTable, $setData);
     return $insertAnswerInfo;
  }

  function updateChoiceTxtInfo($setData = [], $where = []) {

    $updateChoiceTxtInfo = $this->db
      ->where($where)
      ->update($this->choicesTable, $setData);
    return $updateChoiceTxtInfo;
  }

  function add_choice($data = []) {
    if($data['choiceType'] == 3) {
       $data['hiddenChoice'] = "";
       $data['choiceType'] = 3;
    }
    $insertChoice = [
      'choice_id' =>  $data['hiddenID'],
      'question_no' =>  $data['hiddenQuestionID'],
      'choice_choice' =>  $data['hiddenChoice'],
      'choice_text' =>  $data['choiceTerm'],
      'choice_type' =>  $data['choiceType']
    ];
    $add_choice = $this->db->insert($this->choicesTable, $insertChoice);
    return $add_choice;
  }

  function changeAtatus($id, $newStatus) {
    $data = [
        'topic_status' => $newStatus
    ];
    $disableTopic = $this->db
      ->where('topic_id', $id)
      ->update($this->topicsTable, $data);
    return $disableTopic;
  }

  function insertExaminers($data = array(), $examiners = array()) {
    $set = array();
    if(isset($examiners) && $examiners != "") {
      for($x =0; $x < count($examiners); $x++ ) {
         $set[] = [
          'examiner_id'     =>  $examiners[$x],
          'examiner_topics' =>  $data['hiddenID']
        ];
      }
      $insertExaminers = $this->db->insert_batch($this->examinersTable, $set);
    }
  }

  function updateExaminersList($id) {
    $where = '';
    foreach($id as $ids) {
      $where = ['examiner_id' => $ids];

      $updateExaminersList = $this->db->delete($this->examinersTable, $where);
    }
    
  }

  function deleteAExaminersByTopic($data = []) {

      $where = [
        'examiner_topics' =>  $data['hiddenID']
      ];
   
    $updateExaminersList = $this->db->delete($this->examinersTable, $where);
  }

  function add_duration($data = []) {
    $set = [
      'topic_duration'  =>  $data['duration']
    ];
    $where = [
      'topic_id'  =>  $data['hiddenID']
    ];
    $add_duration = $this->db->where($where)->update($this->topicsTable, $set);

    return $add_duration;
  }

  function add_section_duration($data = []){

    $add_duration = $this->db->insert($this->sectionTable, $data);

    return $add_duration;
  }

  function updateExamDateTaken($topicId, $date, $userId) {
    $where =[
      'examiner_topics' =>  $topicId,
      'examiner_id' =>  $userId
    ];

    $set =[
      'examiner_topic_date_taken' =>  $date
    ];
    $updateExamDateTaken = $this->db->where($where)->update($this->examinersTable, $set);

    return $updateExamDateTaken;
  }

  function recordTempResponse($data){

    $this->db->insert('oes_temp_response',$data);

  }

  function recordExam($data = array(), $uri3, $key, $no) {
    error_reporting(1); //hide the last loop.

    $setDatas = array();
    for($x = 0; $x < count($data); $x++) {
      if($data[$x] != "") {
        $setData = [
          'record_id' =>  $key[$x],
          'record_user_id'  =>  $this->session->userdata('user_id'),
          'record_topic_id' =>  $uri3,
          'record_question_id'  =>  $no[$x],
          'record_answer' =>  $data[$x]
        ];
      }
      array_push($setDatas, $setData);
    }

    $getAnswers = $this->db
      ->where('answer_id', $uri3)
      ->get($this->answersTable)
      ->result();


    foreach($getAnswers as $keys => $answers) {
      if($setDatas[$keys]['record_answer'] == $answers->answer_answer) {
        $countCorrect[] = $answers->answer_answer;
      }
    }

    $score = count($countCorrect);

    $total = $this->session->userdata('hiddenTotal');
    $percentage = ($total * .8);
    if ($score >= $percentage) {
      $status = 1;
    } else {
      $status = 0;
    }


    $data_tot_submit = array(
      'total'=>$total,
      'score'=>$score,
      'percentage'=>$percentage,
      'topic'=>$uri3,
      'user_id'=>$this->session->userdata('user_id')
    );
    $this->insert_total_submit($data_tot_submit);


    $update = [
      'examiner_score'  =>  $score,
      'examiner_status'  =>  $status
    ];

    $record['update'] = $this->db
      ->where('examiner_id', $this->session->userdata('user_id') )
      ->where('examiner_topics', $uri3)
      ->update($this->examinersTable, $update);

    $record['exam'] = $this->db
      ->insert_batch($this->recordsTable, $setDatas);

    return $record;

  }

  function insert_total_submit($data){
    $this->db->insert($this->totsubmitTable,$data);
  }

  function getScores() {
    $getScores = $this->db
      ->select('examiner_status AS status, examiner_topics AS topic, examiner_score AS score')
      ->from($this->examinersTable)
      ->where('examiner_score !=', "")
      ->get()
      ->result();
    return $getScores;

  }

  function updateTitle($data = array() ) {
    $set = [
      'topic_title' =>  $data['title']
    ];
    $where =[
      'topic_id'  =>  $data['id']
    ];
    $updateTitle = $this->db->where($where)->update($this->topicsTable, $set);
    return $updateTitle;
  }


  function inserTimeElapsed(){

    $user_id = $this->session->userdata('user_id');
    $topicId=trim($_POST['topicId']);
    
    $sql="UPDATE oes_examiners SET time_elapsed=(time_elapsed+1) WHERE examiner_id=$user_id AND examiner_topics=$topicId";
    $this->db->query($sql);
    if ($this->db->affected_rows() > 0) {
      return TRUE;
    }else{
     return FALSE;
    }
  }


  function latestTopics(){

      $user_id =$this->session->userdata('user_id');
      $subquery = "SELECT examiner_topics FROM oes_examiners WHERE oes_examiners.examiner_id=".$user_id;
      $latestTopics = $this->db
      ->select('*')
      ->from($this->topicsTable)
      ->where('topic_status',1)
      ->where('topic_id NOT IN('.$subquery.')',NULL)
      ->get()
      ->result();
      //print_r($this->db->last_query()); exit;
    return $latestTopics;

  }

  function getQuestionCount($id){

    return $this->db->where("question_id",$id)->count_all_results("oes_questions");

  }





}