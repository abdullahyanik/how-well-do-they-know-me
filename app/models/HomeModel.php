<?php
class HomeModel extends Model {
    function generateRandomString($length = 8) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    public function getRandomQuestions($limit, $lang) {
        return $this->fetchAll("SELECT * from questions WHERE lang = '".$lang."' ORDER by RAND() LIMIT ".$limit);
    }
    public function getQuestions($arr) {
        return $this->fetchAll("SELECT * from questions WHERE id IN ('".implode("','",$arr)."') ORDER BY FIELD(id,'".implode("','",$arr)."')");
    }
    public function getQuizByShortcode($shortcode) {
        return $this->fetch("SELECT * from quizzes WHERE shortcode = ".$this->db->quote($shortcode));
    }
    public function insertQuiz($username, $questions, $shortcode) {
        $this->query("INSERT INTO quizzes (username,questions,shortcode) VALUES (?, ?, ?)", [$username, $questions, $shortcode]);
        return $this->db->lastInsertId();
    }
    public function insertQuizScore($username, $score, $quiz_id) {
        $this->query("INSERT INTO quiz_scores (username,score,quiz) VALUES (?, ?, ?)", [$username, $score, $quiz_id]);
        return $this->db->lastInsertId();
    }
    public function getQuizScores($quiz_id) {
        return $this->fetchAll("SELECT * from quiz_scores WHERE quiz = ".$quiz_id." ORDER BY score DESC");
    }
    public function insertContactMessage($name, $email, $subject, $message) {
        $this->query("INSERT INTO contact_messages (name,email,subject,message) VALUES (?, ?, ?, ?)", [$name, $email, $subject, $message]);
        return $this->db->lastInsertId();
    }
    public function getPageBySlug($slug) {
        return $this->fetch("SELECT * from pages WHERE slug = ".$this->db->quote($slug)."");
    }
    public function getBlogsCount() {
        return intval($this->fetch("SELECT COUNT(*) as count from blogs")["count"]);
    }
    public function getPages() {
        return $this->fetchAll("SELECT * from pages ORDER BY id DESC");
    }
    public function getBlogs($start, $limit) {
        return $this->fetchAll("SELECT * from blogs ORDER BY id DESC LIMIT ".$start.", ".$limit);
    }
    public function getRandomBlogs($limit) {
        return $this->fetchAll("SELECT * from blogs ORDER BY RAND() DESC LIMIT ".$limit);
    }
    public function getBlog($id) {
        return $this->fetch("SELECT * from blogs WHERE id = ".$id);
    }
}
?>