<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 09/08/15
 * Time: 12:19
 */
class commentform extends viewPlugin
{
    public $view;
    public $override = false;
    public $after = false;


    public function __construct($reg)
    {
        parent::__construct($reg);
        $this->view = __SITE_PATH . "/html/plugin/commentFormView.php";
    }
    public function install()
    {
        $sql = "CREATE TABLE CommentsData
                (
                    record int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    firstname VARCHAR (32) not null,
                    comment VARCHAR (255) not null
                )";

        try{
            $this->db->query($sql);
        }catch(PDOException $e)
        {
            new ErrorLog("Error in in commentForm plugin -> install : " . $e->getMessage());
            return false;
        }
        new Log("Successfully executed commentForm->install()");
        return true;
    }
    public function index()
    {
        $this->registry->view->model = $this->getComments();
        $this->registry->view->show(__CLASS__, 'index');
    }

    private function getComments()
    {
        $sql = "Select * from CommentsData";
        try{
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            new ErrorLog("unable to get commentsdata: " . $e->getMessage());
            return false;
        }
    }
}