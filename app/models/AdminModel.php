<?php
class AdminModel extends Model {
    function createSlug($string, $separator = '-')
    {
        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $special_cases = array( '&' => 'and', "'" => '');
        $string = mb_strtolower( trim( $string ), 'UTF-8' );
        $string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
        $string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
        $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
        $string = preg_replace("/[$separator]+/u", "$separator", $string);
        return $string;
    }
    public function getQuizCount() {
        return $this->fetch("SELECT COUNT(id) as total_count from quizzes")["total_count"];
    }
    public function getQuizScoresCount() {
        return $this->fetch("SELECT COUNT(id) as total_count from quiz_scores")["total_count"];
    }
    public function get10DaysQuizStats() {
        return $this->fetchAll("SELECT cast(created_at as date) as date, count(id) as quiz_count FROM quizzes WHERE created_at > '".date("d-m-Y", strtotime(date("d-m-Y", strtotime("10 days ago"))))."' GROUP BY cast(created_at as date)");
    }
    public function getQuestions() {
        return $this->fetchAll("SELECT * from questions ORDER by id DESC");
    }
    public function getPages() {
        return $this->fetchAll("SELECT * from pages ORDER by id DESC");
    }
    public function getBlogs() {
        return $this->fetchAll("SELECT * from blogs ORDER by id DESC");
    }
    public function getContactMessages() {
        return $this->fetchAll("SELECT * from contact_messages ORDER by id DESC");
    }
    public function insertQuestion($text, $lang, $answers) {
        $this->query("INSERT INTO questions (text,answers,lang) VALUES (?, ?, ?)", [$text, $answers, $lang]);
        return $this->db->lastInsertId();
    }
    public function insertPage($title, $desc, $tags, $content) {
        $slug = $this->createSlug($title);
        $real_slug = $slug;
        $i = 0;
        if(in_array($slug, ['index', 'create-quiz', 'admin', 'contact', 'share', 'quiz'])) {
            $i = 1;
        }
        if($i != 0) {
            $slug .= "-".$i;
        }
        while(count($this->fetchAll("SELECT * from pages WHERE slug = '".$slug."'")) > 0) {
            $i++;
            $slug = $real_slug."-".$i;
        }
        $this->query("INSERT INTO pages (title,description,tags,slug,content) VALUES (?, ?, ?, ?, ?)", [$title, $desc, $tags, $slug, $content]);
        return [
            "success" => $this->db->lastInsertId() != 0,
            "slug" => $slug
        ];
    }
    public function insertBlog($title, $desc, $tags, $content) {
        $this->query("INSERT INTO blogs (title,description,tags,content) VALUES (?, ?, ?, ?)", [$title, $desc, $tags, $content]);
        return $this->db->lastInsertId();
    }
    public function updateConfig($name, $value) {
        $this->query("UPDATE configs SET value = ? WHERE name = ?", [$value, $name]);
    }
    public function updatePage($id, $title, $desc, $tags, $content) {
        $this->query("UPDATE pages SET title = ?, description = ?, tags = ?, content = ? WHERE id = ?", [$title, $desc, $tags, $content, $id]);
    }
    public function updateQuestion($id, $text, $lang, $answers) {
        $this->query("UPDATE questions SET text = ?, lang = ?, answers = ? WHERE id = ?", [$text, $lang, $answers, $id]);
    }
    public function updateBlog($id, $title, $desc, $tags, $content) {
        $this->query("UPDATE blogs SET title = ?, description = ?, tags = ?, content = ? WHERE id = ?", [$title, $desc, $tags, $content, $id]);
    }
    public function deletePage($id) {
        $this->query("DELETE from pages WHERE id = ?", [$id]);
    }
    public function deleteQuestion($id) {
        $this->query("DELETE from questions WHERE id = ?", [$id]);
    }
    public function deleteBlog($id) {
        $this->query("DELETE from blogs WHERE id = ?", [$id]);
    }
    public function deleteContactMessage($id) {
        $this->query("DELETE from contact_messages WHERE id = ?", [$id]);
    }
    public function seenContactMessage($id) {
        $this->query("UPDATE contact_messages SET seen = 1 WHERE id = ?", [$id]);
    }
    public function getPage($id) {
        return $this->fetch("SELECT * from pages WHERE id = ".$this->db->quote($id)."");
    }
    public function getQuestion($id) {
        return $this->fetch("SELECT * from questions WHERE id = ".$this->db->quote($id)."");
    }
    public function getBlog($id) {
        return $this->fetch("SELECT * from blogs WHERE id = ".$this->db->quote($id)."");
    }
 }
?>